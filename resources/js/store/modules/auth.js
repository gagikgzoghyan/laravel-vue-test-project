export default {
    state: {
        accessToken: null,
        isLogged: false
    },
    mutations: {
        setAccessToken(state, payload) {
            state.accessToken = payload;
        },
        setIsLogged(state, payload) {
            state.isLogged = payload;
        }
    },
    getters: {
        getAccessToken(state) {
            return state.accessToken;
        },
        getIsLogged(state) {
            return state.isLogged;
        }
    }
};
