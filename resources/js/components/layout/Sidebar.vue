<template>

    <div class="sidebar scroll-green">
        <div class="sidebar-items">
            <router-link
                v-for="item in menuItems"
                :to="{name: item.route}"
                class="sidebar-item"
                :class="{'active': isActive(item)}"
                tag="div"
            >
                <i class="el-icon-s-home"></i>
                <div class="sidebar-item-name">{{ item.title }}</div>
            </router-link>
        </div>
    </div>

</template>

<script type="text/babel">
    export default {
        name: 'app-sidebar',
        components: {},
        data() {
            return {}
        },
        computed: {
            menuItems() {
                let menuItems = [
                    {
                        route: 'main',
                        title: 'Activities'
                    }
                ]

                let user = this.$store.getters.getUser

                if (user && user.roles.some(role => role.name === 'admin')) {
                    menuItems.push({
                        route: 'users',
                        title: 'Users',
                    })
                }

                return menuItems
            }
        },
        methods: {
            isActive(item) {
                return this.$route.name === item.route
            },
        },
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .sidebar {
        width: 320px;
        height: calc(100vh - 79px);
        background: #ebeefd;
        box-shadow: inset -7px 5px 9px -7px rgba(0, 0, 0, 0.4);
        padding: 55px 25px;
        direction: ltr;
        position: fixed;
        z-index: 1;
        top: 79px;
        overflow-y: auto;

        &-item {
            display: flex;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
            height: 56px;
            padding: 0 15px;
            border-radius: 7px;
            margin: 5px 0;

            i {
                font-size: 20px;
                color: #5f9ea0;
            }

            &-name {
                margin-left: 15px;
                font-weight: normal;
                line-height: 23px;
                letter-spacing: 0.69px;
                font-size: 14px;
                color: #5f9ea0;
            }

            &:hover, &.active {
                background: #5f9ea0;

                i, .sidebar-item-name {
                    color: white !important;
                }
            }
        }
    }
</style>
