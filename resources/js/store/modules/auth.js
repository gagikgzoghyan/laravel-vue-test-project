export default {
    state: {
        access_token: null,
        expires_at: null,
        is_logged: false
    },
    mutations: {
        setAccessToken(state, payload) {
            state.access_token = payload;
        },
        setExpiresAt(state, payload) {
            state.expires_at = payload;
        },
        setIsLogged(state, payload) {
            state.is_logged = payload;
        }
    },
    getters: {
        getAccessToken(state) {
            return state.access_token;
        },
        getExpiresAt(state) {
            return state.expires_at;
        },
        getIsLogged(state) {
            return state.is_logged;
        }
    }
};
