<template>

    <div class="header">
        <router-link :to="{name: 'main'}">
            {{ appName }}
        </router-link>

        <div class="header-actions">
            <span>{{ user.fullName }}</span>

            <el-button type="primary" @click="logout">
                Logout
            </el-button>
        </div>
    </div>

</template>

<script type="text/babel">
    import apiAuth from '@/api/auth'
    import handleApiMixin from '@/mixins/handle-api-mixin'

    export default {
        name: 'app-header',
        mixins: [handleApiMixin],
        computed: {
            appName() {
                return document.title
            },
            user() {
                return this.$store.getters.getUser
            },
        },
        methods: {
            logout() {
                return apiAuth
                    .logout()
                    .then(response => {
                        this.clearStorage();
                    })
                    .catch(response => {
                        this.clearStorage();
                        this.handleMessage('error', response)
                    });
            },
            clearStorage() {
                this.$store.commit('setAccessToken', null)
                this.$store.commit('setIsLogged', false)
                this.$store.commit('setUser', null)
                this.$router.push({name: 'login'})
            },

        },
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        width: -webkit-fill-available;
        height: 79px;
        padding: 0 20px;
        top: 0;
        left: 0;
        z-index: 1;
        background: #ffffff;
        box-shadow: 0 7px 9px -7px rgba(0, 0, 0, 0.4);

        a {
            text-decoration: none;
            color: #323232;
        }

        .header-actions {
            display: flex;
            align-items: center;

            span {
                margin-right: 20px;
            }
        }
    }
</style>
