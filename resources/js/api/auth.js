import {$http} from './api.js'

export default {
    login({data}) {
        return $http().post('api/login', data)
    },
    register({data}) {
        return $http().post('api/register', data)
    },
    logout() {
        return $http().post('api/logout', {})
    }
}
