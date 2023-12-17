<template>

    <el-dialog
        v-model="visible"
        :width="1300"
    >
        <template #header>{{ user.fullName }} Activities</template>

        <activities
            style="margin: 0"
            :user="user"
        />
    </el-dialog>

</template>

<script type="text/babel">
    import Activities from '@/components/views/activities/index.vue'

    export default {
        name: 'view-activities-modal',
        components: {
            Activities
        },
        data() {
            return {
                loading: false,
                visible: true,
                activity: {}
            }
        },
        props: {
            user: {
                type: Object,
                required: true
            }
        },
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>

</style>
