<template>

    <el-card>
        <template #header>
            <h3>Register</h3>
        </template>

        <el-form
            ref="form"
            status-icon label-position="top"
            :model="user"
            :rules="rules"
        >
            <el-form-item label="First Name" prop="firstName">
                <el-input placeholder="First Name" v-model="user.firstName"/>
            </el-form-item>

            <el-form-item label="Last Name" prop="lastName">
                <el-input placeholder="lastName" v-model="user.lastName"/>
            </el-form-item>

            <el-form-item label="Email" prop="email">
                <el-input placeholder="Email" v-model="user.email"/>
            </el-form-item>

            <el-form-item label="Password" prop="password">
                <el-input placeholder="Password" type="password" autocomplete="off" v-model="user.password"/>
            </el-form-item>
        </el-form>

        <template #footer>
            <el-button type="primary" @click="validate">
                Register
            </el-button>

            <span>Already have an account?</span>
            <router-link :to="{name: 'login'}">Sign In</router-link>
        </template>
    </el-card>

</template>

<script type="text/babel">
    import apiAuth from '@/api/auth'
    import handleApiMixin from '@/mixins/handle-api-mixin'
    import validation from './validation.js'

    export default {
        name: 'register',
        mixins: [handleApiMixin],
        data() {
            return {
                user: {}
            }
        },
        computed: {
            rules() {
                return validation
            }
        },
        methods: {
            validate() {
                return this.$refs.form.validate()
                    .then(() => this.register())
                    .catch(() => {})
            },
            register() {
                return apiAuth
                    .register({data: this.user})
                    .then(response => {
                        this.$store.commit('setAccessToken', response.data.accessToken)
                        this.$store.commit('setIsLogged', true)
                        this.$store.commit('setUser', response.data.user)
                        this.$router.push({name: 'main'})
                    })
                    .catch(response => {
                        this.handleMessage('error', response)
                    })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .el-card {
        display: flex;
        flex-direction: column;
        width: 50%;
        margin: 200px auto;

        &__footer {
            .el-button {
                margin-right: 20px;
            }

            span {
                margin-right: 5px;
            }
        }
    }
</style>
