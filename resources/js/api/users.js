import {$http} from './api.js'

export default {
    get(item) {
        let url = 'api/users'

        if (item !== undefined) {
            url += `/${item.id}`
        }

        return $http().get(url)
    },
    account() {
        return $http().get('api/users/account')
    },
}
