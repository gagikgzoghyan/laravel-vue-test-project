<template>

    <el-card v-loading="loading">
        <template #header>
            <div class="el-card-header">
                <div>
                    <span style="margin-right: 20px">Activities</span>

                    <el-date-picker
                        v-model="scheduledAtRange"
                        type="daterange"
                        range-separator="To"
                        start-placeholder="Start date"
                        end-placeholder="End date"
                        format="YYYY/MM/DD"
                        value-format="YYYY-MM-DD"
                        @change="initData"
                    />
                </div>

                <el-button v-if="isAdmin" type="primary" @click="addActivity">
                    Add Activity
                </el-button>
            </div>
        </template>

        <el-table :data="data" style="width: 100%">
            <el-table-column prop="id" label="Id"/>

            <el-table-column prop="imagePath" label="Image">
                <template #default="scope">
                    <el-image
                        style="width: 100px; height: 100px"
                        :src="scope.row.imagePath"
                        :preview-src-list="[scope.row.imagePath]"
                        fit="contain"
                    />
                </template>
            </el-table-column>

            <el-table-column prop="name" label="Name"/>

            <el-table-column prop="description" label="Description"/>

            <el-table-column prop="scheduledAt" label="Scheduled Date"/>

            <el-table-column v-if="isAdmin" fixed="right" label="Actions">
                <template #default="scope">
                    <el-button type="primary" size="small" @click="update(scope.row)">
                        Update
                    </el-button>

                    <el-popconfirm title="Are you sure to delete this?" @confirm="destroy(scope.row)">
                        <template #reference>
                            <el-button type="danger" size="small">Delete</el-button>
                        </template>
                    </el-popconfirm>
                </template>
            </el-table-column>
        </el-table>

        <save-modal
            v-if="showSaveModal"
            :item="editingItem"
            :user="user"
            @saved="initData"
            @close="showSaveModal = false"
        />
    </el-card>

</template>

<script type="text/babel">
    import SaveModal from './save-modal/index.vue'
    import apiActivities from '@/api/activities'
    import handleApiMixin from '@/mixins/handle-api-mixin'

    export default {
        name: 'activities',
        mixins: [handleApiMixin],
        components: {
            SaveModal
        },
        data() {
            return {
                loading: false,
                showSaveModal: false,
                editingItem: {},
                data: [],
                scheduledAtRange: []
            }
        },
        props: {
            user: {
                type: Object,
                default: () => {
                    return {}
                }
            }
        },
        created() {
            this.initData()
        },
        computed: {
            isAdmin() {
                let user = this.$store.getters.getUser

                if (!user) return false

                return user.roles.some(role => role.name === 'admin')
            }
        },
        methods: {
            initData() {
                this.loading = true

                let params = {}

                if (this.user.id) {
                    params.userId = this.user.id
                }

                if (this.scheduledAtRange && this.scheduledAtRange.length > 0) {
                    params.scheduledAt = this.scheduledAtRange
                }

                return apiActivities
                    .get(undefined, params)
                    .then(response => {
                        this.data = response.data
                        this.loading = false
                    })
                    .catch(response => {
                        this.handleMessage('error', response)
                        this.loading = false
                    })
            },
            update(item) {
                this.editingItem = item
                this.showSaveModal = true
            },
            destroy(item) {
                this.loading = true

                return apiActivities
                    .delete({item: item})
                    .then(response => {
                        this.initData()
                        this.handleMessage('success', response)
                    })
                    .catch(response => {
                        this.handleMessage('error', response)
                        this.loading = false
                    })
            },
            addActivity() {
                this.editingItem = {}
                this.showSaveModal = true
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .el-card {
        margin-top: 79px;
        margin-left: 370px;
        padding: 25px;

         .el-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        :deep(.el-table) .el-table__cell {
            position: unset;
        }
    }
</style>
