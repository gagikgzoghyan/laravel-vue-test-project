<template>

    <el-card>
        <template #header>
            <h3>Login</h3>
        </template>

        <el-form
            ref="form"
            status-icon label-position="top"
            :model="user"
            :rules="rules"
        >
            <el-form-item label="Email" prop="email">
                <el-input placeholder="Email" v-model="user.email"/>
            </el-form-item>

            <el-form-item label="Password" prop="password">
                <el-input placeholder="Password" type="password" autocomplete="off" v-model="user.password"/>
            </el-form-item>
        </el-form>

        <template #footer>
            <el-button type="primary" @click="validate">
                Log In
            </el-button>

            <span>Don't have an account yet?</span>
            <router-link :to="{name: 'register'}">Register now</router-link>
        </template>
    </el-card>

</template>

<script type="text/babel">
    import apiAuth from '@/api/auth'
    import handleApiMixin from '@/mixins/handle-api-mixin'
    import validation from './validation.js'

    export default {
        name: 'login',
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
                     .then(() => this.login())
                     .catch(() => {})
            },
            login() {
                return apiAuth
                    .login({data: this.user})
                    .then(response => {
                        this.$router.push({name: 'main'})
                        this.$store.commit('setAccessToken', response.data.accessToken)
                        this.$store.commit('setIsLogged', true)
                        this.$store.commit('setUser', response.data.user)
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
