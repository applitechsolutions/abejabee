const store = new Vuex.Store({
    state: {
        numero: 0,
        providers: [],
        products: []
    },
    mutations: {
        Ejemplo(state) {
            state.numero++;
        },
        llenarProviders(state, data) {
            state.providers = data;
        },
        llenarProducts(state, data) {
            state.products = data;
        },
        pushProduct(state, payload) {

            const index = state.products.findIndex(e => e.idProduct === payload.idProduct)
            if (index > -1) {
                state.products.splice(index, {})
            }
        },
    },
    actions: {
        getProviders: function ({
            commit
        }) {
            axios.get('BLL/listProviders.php')
                .then(function (response) {
                    // console.log(response.data);
                    commit('llenarProviders', response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getProducts: function ({
            commit
        }) {
            commit('llenarProducts', []);
            axios.get('BLL/listProducts.php')
                .then((response) => {
                    // console.log(response.data);
                    commit('llenarProducts', response.data);
                    Vue.nextTick(() => {
                        // DOM updated
                        $('#registros').DataTable({
                            "order": [],
                            "columnDefs": [{
                                "targets": 'no-sort',
                                "orderable": false,
                            }],
                            'paging': true,
                            'lengthChange': true,
                            "aLengthMenu": [
                                [10, 25, 50, -1],
                                [10, 25, 50, "Todos"]
                            ],
                            'searching': true,
                            'ordering': true,
                            'info': true,
                            'autoWidth': true,
                            'language': {
                                paginate: {
                                    next: 'Siguiente',
                                    previous: 'Anterior',
                                    first: 'Primero',
                                    last: 'Último'
                                },
                                info: 'Mostrando _START_-_END_ de _TOTAL_ registros',
                                empyTable: 'No hay registros',
                                infoEmpty: '0 registros',
                                lengthChange: 'Mostrar ',
                                infoFiltered: "(Filtrado de _MAX_ total de registros)",
                                lengthMenu: "Mostrar _MENU_ registros",
                                loadingRecords: "Cargando...",
                                processing: "Procesando...",
                                search: "Buscar:",
                                zeroRecords: "Sin resultados encontrados"
                            }
                        });
                    });
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        editCostProduct: function ({
            commit
        }, product) {
            const formData = new FormData();
            formData.append('producto', 'actualizarCosto');
            formData.append('id_producto', product.idProduct);
            formData.append('cost', product.cost);
            axios.post('BLL/product', formData)
                .then(function (response) {
                    commit('pushProduct', product)
                    toastr.success(response.data.mensaje)
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        editPricesProduct: function ({
            commit
        }, product) {
            const formData = new FormData();
            formData.append('priceSale', 'editar');
            formData.append('id_product', product.idProduct);
            formData.append('id_price', product.id_price);
            formData.append('price', product.price);
            axios.post('BLL/priceSale.php', formData)
                .then(function (response) {
                    console.log("response", response)
                    commit('pushProduct', product)
                    toastr.success(response.data.mensaje)
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
});