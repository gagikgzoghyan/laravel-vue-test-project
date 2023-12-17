import axios from 'axios'
import store from '../store/index.js'
import convertKeys from '@/helpers/convert-keys'

export const $http = () => {
    axios.defaults.headers['common']['Accept'] = 'application/json'
    axios.defaults.headers['common']['Authorization'] = 'Bearer ' + store.getters.getAccessToken
    axios.defaults.headers['common']['Content-Type'] = 'multipart/form-data'

    // convert to snakeCase when browser request
    axios.interceptors.request.use(request => {
        request.params = convertKeys.toSnake(request.params)
        // request.body = convertKeys.toSnake(request.body)
        request.data = convertKeys.toSnake(request.data)

        return request
    })

    // convert to camelcase when browser receive
    axios.interceptors.response.use(response => {
        response.body = convertKeys.toCamel(response.body)
        response.data = convertKeys.toCamel(response.data)

        return response
    })

    return axios;
};
