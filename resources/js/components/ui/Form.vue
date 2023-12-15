<script>
    import {ElForm} from 'element-plus'

    export default {
        name: 'el-form',
        extends: ElForm,
        components: {},
        props: {
            $rules: {
                default()  {
                    return {}
                }
            },
            $messages: {
                default() {
                    return {}
                }
            }
        },
        validations() {
            return this.$rules
        },
        data() {
            return {}
        },
        created() {
            this.$watch('$v.$anyError', ($anyerror) => {
                if ($anyerror) {
                    this.$emit('$validation', false)
                } else {
                    this.$emit('$validation', true)
                }
            })
            this.$watch('$v.$invalid', ($invalid) => {
                if ($invalid) {
                    this.$emit('$invalid', true)
                } else {
                    this.$emit('$invalid', false)
                }
            })
        },
        methods: {
            validate(touch = true) {
                if (touch) {
                    this.$v.$touch()
                } else {
                    return !this.$v.$invalid
                }

                return !this.$v.$anyError
            },
            resetValidation() {
                this.$v.$reset()
            }
        }
    }
</script>
