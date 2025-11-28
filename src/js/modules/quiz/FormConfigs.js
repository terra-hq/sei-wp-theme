import { isEmail, isString, isSelect } from "@andresclua/validate";

export default function FormConfigs() {
    return [
        {
            element: document.querySelector("#quiz-company"),
            validationFunction: isString,
            config: {
                required: true,
                minLength: 3,
                customMessage: {
                    required: "Company name is required.",
                    minLength: "Company name must be at least 3 characters long.",
                },
            },
            on: "blur",
        },
        {
            element: document.querySelector("#quiz-email"),
            validationFunction: isEmail,
            config: {
                required: true,
                customMessage: {
                    invalid: "Please enter a valid email address.",
                    required: "Email is required.",
                },
            },
            on: "blur",
        },
        {
            element: document.querySelector("#quiz-role"),
            validationFunction: isSelect,
            config: {
                required: true,
                customMessage: {
                    required: "Please select your role",
                },
            },
            on: "blur",
        },
        {
            element: document.querySelector("#quiz-industry"),
            validationFunction: isSelect,
            config: {
                required: true,
                customMessage: {
                    required: "Please select your industry",
                },
            },
            on: "blur",
        },
        {
            element: document.querySelector("#quiz-journey"),
            validationFunction: isSelect,
            config: {
                required: true,
                customMessage: {
                    required: "Please select where you are in your AI transformation journey",
                },
            },
            on: "blur",
        },
        {
            element: document.querySelector("#quiz-message"),
            validationFunction: isString,
            config: {
                required: false,
                customMessage: {},
            },
            on: "blur",
        },
    ];
}