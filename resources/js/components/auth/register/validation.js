const messages = {
    required: 'This field is required.',
    email: 'Enter valid Email Address.',
    passwordMin: 'Min length for password should be 8.'
}

const rules = {
    firstName: [
        { required: true, message: messages.required, trigger: 'blur' },
    ],
    lastName: [
        { required: true, message: messages.required, trigger: 'blur' },
    ],
    email: [
        { required: true, message: messages.required, trigger: 'blur' },
        { type: 'email', message: messages.email, trigger: 'blur' },
    ],
    password: [
        { required: true, message: messages.required, trigger: 'blur' },
        { min: 8, message: messages.passwordMin, trigger: 'blur' },
    ],
}

export default rules
