<template>

    <div>
        <app-header v-if="isLogged"/>
        <app-sidebar v-if="isLogged" />
        <router-view/>
    </div>

</template>

<script type="text/babel">
    import AppHeader from '@/components/layout/Header.vue'
    import AppSidebar from '@/components/layout/Sidebar.vue'

    export default {
        components: { AppHeader, AppSidebar },
        data() {
            return {}
        },
        computed: {
            isLogged() {
                return this.$store.getters.getIsLogged && ['login', 'register'].indexOf(this.$route.name) === -1
            },
        },
        methods: {}
    }
</script>
