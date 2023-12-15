<template>

    <div class="login">
        <el-form
            ref="form" size="small"
            status-icon label-position="top"
        >
            <el-form-item label="Email" prop="email">
                <el-input placeholder="Name" v-model="user.email"></el-input>
            </el-form-item>
        </el-form>
    </div>

</template>

<script type="text/babel">
    import ElForm from 'components/ui/Form.vue'
    import ElFormItem from 'components/ui/FormItem.vue'
    import {
        ElInput
    } from 'element-plus'

    export default {
        name: 'login',
        components: {
            ElForm, ElFormItem, ElInput
        },
        data() {
            return {
                user: {}
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>

</style>
