import {$http} from './api.js'

export default {
    get(item, params) {
        let url = 'api/activities'

        if (item !== undefined) {
            url += `/${item.id}`
        }

        return $http().get(url, {params})
    },
    save({item, data}) {
        let url = 'api/activities'

        if (item.id) {
            url += `/${item.id}`
            if (data instanceof FormData) data.append('_method', 'put')
            else data._method = 'put'
        }

        return $http().post(url, item)
    },
    delete({item}) {
        return $http().delete('api/activities/' + item.id)
    },
}
