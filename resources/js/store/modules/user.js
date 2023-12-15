export default {
    state: {
        user: null
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        }
    },
    getters: {
        getUser(state) {
            return state.user;
        }
    }
};
