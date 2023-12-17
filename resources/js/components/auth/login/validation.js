const messages = {
    required: 'This field is required.',
    email: 'Enter valid Email Address.'
}

const rules = {
    email: [
        { required: true, message: messages.required, trigger: 'blur' },
        { type: 'email', message: messages.email, trigger: 'blur' },
    ],
    password: [
        { required: true, message: messages.required, trigger: 'blur' },
    ],
}

export default rules
