const messages = {
    required: 'This field is required.',
}

const rules = {
    scheduledAt: [
        { required: true, message: messages.required, trigger: 'blur' },
    ],
    name: [
        { required: true, message: messages.required, trigger: 'blur' },
    ],
    description: [
        { required: true, message: messages.required, trigger: 'blur' },
    ],
}

export default rules
