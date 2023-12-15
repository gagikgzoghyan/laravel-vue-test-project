<script>
    import {ElFormItem} from 'element-plus'
    delete ElFormItem.beforeDestroy

    export default {
        name: 'el-form-item',
        extends: ElFormItem,
        data() {
            return {
                $_vw: null
            }
        },
        created() {
            if (this.prop) {
                this.$_vw = this.$watch('$v', ($v) => {
                    this.validate$($v)
                }, { deep: true })

                // reset validation state when created
                // it is required for avoid bug when parent component already in $touch() mode
                // and this new created form item is not show validation state correctly
                if (this.$v && !_.isEmpty(this.$v)) {
                    this.$v.$reset()
                }
            }
        },
        mounted() {
            this.$on('el.form.blur', this.onFieldBlur)
            this.$on('el.form.change', this.onFieldChange)
        },
        beforeDestroy() {
            if (this.prop) {
                this.$_vw()
            }

            try {
                this.dispatch('ElForm', 'el.form.removeField', [this])
            } catch (error) {
            }
        },
        computed: {
            $v() {
                let $v = _.get(this, `form.$v.model.${this.prop}`, {})
                return $v
            },
            isRequired() {
                return this.$v.required !== undefined
            }
        },
        methods: {
            validate(event) {
                if (this.prop && !_.isEmpty(this.$v)) {
                    this.$v.$touch()
                    this.validate$(this.$v)
                }
            },
            validate$($v, prop, messages) {
                if (!$v) return

                prop = prop || this.prop
                messages = messages || this.form.$messages

                let propMessages = _.get(messages, prop)
                let errorRule = _.findKey($v, (value, key) => {
                    if ([
                        '$error',
                        '$dirty',
                        '$invalid',
                        '$pending',
                        '$params',
                        '$anyError',
                        '$anyDirty',
                        '$model'
                    ].indexOf(key) !== -1) {
                        return false
                    }

                    if (!value && $v.$dirty) {
                        this.validateState = 'error'
                        if (propMessages && propMessages[key]) {
                            this.validateMessage = propMessages[key]
                        }
                        return true
                    }

                    if (_.isFunction(value.$touch)) {
                        return !this.validate$(value, key, propMessages)
                    }

                    return false
                })

                if (!errorRule && $v.$dirty) {
                    this.validateState = 'success'
                    this.validateMessage = ''
                }

                if (!errorRule && !$v.$dirty) {
                    this.validateState = ''
                    this.validateMessage = ''
                }

                return !(errorRule)
            }
        }
    }
</script>
