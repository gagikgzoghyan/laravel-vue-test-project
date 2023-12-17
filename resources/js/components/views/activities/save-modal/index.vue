<template>

    <el-dialog
        v-model="visible"
        @close="close"
    >
        <template #header>
            {{ item.id ? 'Update' : 'Create' }}
            Activity
        </template>

        <el-form
            ref="form"
            status-icon label-position="top"
            :model="activity"
            :rules="rules"
            v-loading="loading"
        >
            <el-form-item label="Scheduled Date" prop="scheduledAt">
                <el-date-picker
                    v-model="activity.scheduledAt"
                    type="date" size="default"
                    placeholder="Pick a day for Activity"
                    format="YYYY/MM/DD"
                    value-format="YYYY-MM-DD"
                />
            </el-form-item>

            <el-form-item label="Name" prop="name">
                <el-input placeholder="Name" v-model="activity.name"/>
            </el-form-item>

            <el-form-item label="Description" prop="description">
                <el-input placeholder="Description" type="textarea" v-model="activity.description"/>
            </el-form-item>

            <el-form-item label="Image" prop="uploadImage">
                <el-upload
                    v-model:file-list="activity.uploadImage"
                    class="image-upload"
                    drag :limit="1"
                    :auto-upload="false"
                >
                    <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                    <div class="el-upload__text">
                        Drop file here or <em>click to upload</em>
                    </div>
                </el-upload>
            </el-form-item>
        </el-form>

        <template #footer>
            <el-button type="default" @click="close">
                Cancel
            </el-button>

            <el-button type="primary" @click="validate">
                {{ item.id ? 'Update' : 'Create' }}
            </el-button>
        </template>
    </el-dialog>

</template>

<script type="text/babel">
    import apiActivities from '@/api/activities'
    import handleApiMixin from '@/mixins/handle-api-mixin'
    import { UploadFilled } from '@element-plus/icons-vue'

    import validation from './validation.js'
    import _ from 'lodash'

    export default {
        name: 'save-modal',
        mixins: [handleApiMixin],
        components: {
            UploadFilled
        },
        data() {
            return {
                loading: false,
                visible: true,
                activity: {}
            }
        },
        props: {
            item: {
                type: Object,
                default: () => {
                    return {}
                }
            },
            user: {
                type: Object,
                default: () => {
                    return {}
                }
            },
        },
        created() {
            if (this.item.id) {
                this.initData()
            }
        },
        computed: {
            rules() {
                return validation
            }
        },
        methods: {
            close() {
                this.$emit('close')
            },
            validate() {
                return this.$refs.form.validate()
                    .then(() => this.save())
                    .catch(() => {})
            },
            initData() {
                this.loading = true

                return apiActivities
                    .get(this.item)
                    .then(response => {
                        this.activity = response.data
                        this.loading = false
                    })
                    .catch(response => {
                        this.handleMessage('error', response)
                        this.loading = false
                    })
            },
            save() {
                this.loading = true

                let data = _.cloneDeep(this.activity)

                if (data.uploadImage) {
                    data.uploadImage = data.uploadImage[0].raw
                }

                if (this.user.id) {
                    data.users = [this.user.id]

                    if (this.item.id) {
                        delete data.id
                    }
                }

                return apiActivities
                    .save({item: data, data: data})
                    .then(response => {
                        this.handleMessage('success', response)
                        this.loading = false

                        this.$emit('saved')
                        this.close()
                    })
                    .catch(response => {
                        this.handleMessage('error', response)
                        this.loading = false
                    })
            },
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .el-form {
        .image-upload {
            width: 100%;
        }
    }
</style>
