const store = new Vuex.Store({
    state: {
        numero: 0,
        providers: []
    },
    mutations: {
        Ejemplo(state) {
            state.numero++;
        },
        llenarProviders(state, data) {
            state.providers = data;
        }
    },
    actions: {
        getProviders: ({ commit }) => {
            axios.get('BLL/listProviders.php')
                .then(function (response) {
                    // console.log(response.data);
                    commit('llenarProviders', response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
});