import { ElNotification } from 'element-plus'
import _ from 'lodash'

export default {
    data() {
        return {}
    },
    methods: {
        handleMessage(type, response, options = {}) {
            let message = _.get(response, 'data.message') || _.get(response, 'response.data.message') || _.get(response, 'message')

            if (Array.isArray(message)) {
                message = message.join('<br/>')
            }

            let defaultOptions = {
                message: message,
                type: type,
                title: type.charAt(0).toUpperCase() + type.slice(1),
                dangerouslyUseHTMLString: true
            }

            ElNotification(Object.assign(defaultOptions, options))
        }
    }
}
