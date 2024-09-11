<template>
    <div>
        <TFormGroup formClass="g--form-group-01">
        <TLabel forId="firstName" labelClass="g--form-label-01" textLabel="First Name" />

        <THint :hintMessage="hintMessage" hintClass="g--form-hint-01" />

        <TInputField
            type="text"
            v-model="firstName"
            id="firstName"
            inputClass="g--form-input-01"
            placeholder="First Name"
            :error="error"
            :required="required"
            :maxlength="8"
            :disabled="disabled"
            :extraAttrs="{ 'aria-label': 'something here '}"
        />

        <TError :errorMessage="errorMessage" errorClass="g--form-error-01" />
    </TFormGroup>
    </div>
   
</template>

<script setup>
const firstName = ref("")
const error = ref(false)
const required = ref(true)
const disabled = ref(false)
const hintMessage = ref("")
const errorMessage = ref("Debes completar todos los campos requeridos")
</script>
