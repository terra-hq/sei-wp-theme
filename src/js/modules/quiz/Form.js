class Form {
    constructor({ element, fields, submitButtonSelector = null, onSubmit = null, onComplete = null, onError = null }) {
        if (!element) throw new Error("A form element is required.");

        this.formElement = element; // Elemento del formulario
        this.fields = fields; // Configuración de los campos
        this.onSubmit = onSubmit; // Callback when attempting to submit
        this.onComplete = onComplete; // Callback when all fields are valid
        this.onError = onError; // Callback when there are errors
        this.submitButton = submitButtonSelector
            ? document.querySelector(submitButtonSelector)
            : null; // Botón de envío personalizado

        this.fieldListeners = [];
        this.submitButtonHandler = null;
        this.formSubmitHandler = null;

        // Configurar eventos para los campos y el botón de envío
        this.initializeFields();
        this.initializeSubmit();
    }

    initializeFields() {
        this.fields.forEach((field) => {
            const { element, validationFunction, config, on } = field;

            if (!element) throw new Error("Each field must have an element.");
            if (!validationFunction) throw new Error("A validation function is required.");

            const eventType = on || "blur";
            const handler = () => {
                const result = validationFunction({
                    element: element.value,
                    config,
                });

                this.updateFieldState(element, result);
            };

            // Guardamos los eventos para limpiarlos en destroy
            this.fieldListeners.push({ element, eventType, handler });
            element.addEventListener(eventType, handler);
        });
    }

    updateFieldState(element, result) {
        const wrapper = element.closest(".c--form-input-a");
        const formGroup = element.closest(".c--form-group-a"); // Buscar el grupo del formulario
        let errorSpan = formGroup?.querySelector(".c--form-error-a"); // Buscar un span existente

        // Crear el span de error dinámicamente si no existe
        if (!errorSpan && formGroup) {
            errorSpan = document.createElement("span");
            errorSpan.classList.add("c--form-error-a");
            errorSpan.style.display = "none"; // Ocultar inicialmente
            formGroup.appendChild(errorSpan); // Añadir al grupo del formulario
        }

        // Actualizar el estado del campo
        if (result.isValid) {
            wrapper?.classList.remove("c--form-input-a--error");
            wrapper?.classList.add("c--form-input-a--valid");
            if (errorSpan) {
                errorSpan.textContent = ""; // Limpiar el texto del mensaje
                errorSpan.style.display = "none"; // Ocultar el mensaje
            }
        } else {
            wrapper?.classList.add("c--form-input-a--error");
            wrapper?.classList.remove("c--form-input-a--valid");
            if (errorSpan) {
                errorSpan.textContent = result.errorMessage; // Mostrar el mensaje de error
                errorSpan.style.display = "block"; // Hacer visible el mensaje
            }
        }
    }

    validateField(field) {
        const { element, validationFunction, config } = field;
        const result = validationFunction({
            element: element.value,
            config,
        });

        this.updateFieldState(element, result);

        return result;
    }

    validateAllFields() {
        const invalidFields = [];
        this.fields.forEach((field) => {
            const { element, validationFunction, config } = field;
            const result = validationFunction({
                element: element.value,
                config,
            });

            this.updateFieldState(element, result);
            if (!result.isValid) {
                invalidFields.push({ element, errorMessage: result.errorMessage });
            }
        });

        return invalidFields;
    }

    initializeSubmit() {
        if (this.submitButton) {
            this.submitButtonHandler = (event) => {
                event.preventDefault();
                this.handleValidation();
            };
            this.submitButton.addEventListener("click", this.submitButtonHandler);
        }

        if (this.formElement) {
            this.formSubmitHandler = (event) => {
                event.preventDefault();
                this.handleValidation();
            };
            this.formElement.addEventListener("submit", this.formSubmitHandler);
        }
    }

    handleValidation() {
        // Ejecutar el callback `onSubmit`, si está definido
        if (this.onSubmit) {
            this.onSubmit();
        }

        const invalidFields = this.validateAllFields();

        if (invalidFields.length === 0) {
            // Todos los campos son válidos
            if (this.onComplete) {
                this.onComplete(); // Execute success callback
            }
        } else {
            // Hay errores en el formulario
            if (this.onError) {
                this.onError(invalidFields); // Execute error callback with details
            }
        }
    }

    destroy() {
        this.fieldListeners.forEach(({ element, eventType, handler }) => {
            if (element && handler) {
                element.removeEventListener(eventType, handler);
            }
        });
        this.fieldListeners = [];

        if (this.submitButton && this.submitButtonHandler) {
            this.submitButton.removeEventListener("click", this.submitButtonHandler);
            this.submitButtonHandler = null;
        }

        if (this.formElement && this.formSubmitHandler) {
            this.formElement.removeEventListener("submit", this.formSubmitHandler);
            this.formSubmitHandler = null;
        }

        this.formElement = null;
        this.fields = null;
        this.submitButton = null;
        this.onSubmit = null;
        this.onComplete = null;
        this.onError = null;
    }
}

export default Form;