Vue.component('providers', {
    template: /*html*/ `
        <div class="col-lg-4">
            <div class="form-group">
                <span class="text-danger text-uppercase">*</span>
                <label>Proveedor</label>
                <select name="provider" class="form-control select2"
                    style="width: 100%;">
                    <option value="" selected>Seleccione un proveedor</option>
                    <option v-for="provider of providers"  value="provider.idProvider">{{provider.providerName  }}</option>
                </select>
            </div>
        </div>
        `,
    data() {
        return {

        };
    },
    computed: {
        ...Vuex.mapState(['providers'])
    },
    methods: {
        ...Vuex.mapActions(['getProviders'])
    },
    mounted() {
        this.getProviders()
        $('.select2').select2()
    }
});
