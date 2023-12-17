<template>

    <el-card v-loading="loading">
        <template #header>Users</template>

        <el-table :data="data" style="width: 100%">
            <el-table-column prop="id" label="Id"/>

            <el-table-column prop="fullName" label="Full Name"/>

            <el-table-column prop="email" label="Email"/>

            <el-table-column fixed="right" label="Actions">
                <template #default="scope">
                    <el-button type="primary" size="small" @click="viewActivities(scope.row)">
                        View Activities
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <view-activities-modal
            v-if="showViewActivitiesModal"
            :user="editingItem"
            @saved="initData"
            @close="showViewActivitiesModal = false"
        />
    </el-card>

</template>

<script type="text/babel">
    import ViewActivitiesModal from './ViewActivitiesModal.vue'
    import apiUsers from '@/api/users'
    import handleApiMixin from '@/mixins/handle-api-mixin'

    export default {
        name: 'users',
        mixins: [handleApiMixin],
        components: {
            ViewActivitiesModal
        },
        data() {
            return {
                loading: false,
                showViewActivitiesModal: false,
                editingItem: {},
                data: []
            }
        },
        created() {
            this.initData()
        },
        methods: {
            initData() {
                this.loading = true

                return apiUsers
                    .get()
                    .then(response => {
                        this.data = response.data
                        this.loading = false
                    })
                    .catch(response => {
                        this.handleMessage('error', response)
                        this.loading = false
                    })
            },
            viewActivities(item) {
                this.editingItem = item
                this.showViewActivitiesModal = true
            },
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .el-card {
        margin-top: 79px;
        margin-left: 370px;
        padding: 25px;

        :deep(.el-table) .el-table__cell {
            position: unset;
        }
    }
</style>
