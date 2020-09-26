var app = new Vue({
    el: '#app',

    data: {
        product: '',
        cantidad: 0,
        total: 0
    },

    methods: {

        carritoCliente(producto){

            let url = '/cart/buscarCarrito';

            axios.get(url).then(function (response){

                var respuesta = response.data;
                this.product = producto;
                console.log(respuesta);
                console.log(this.product);

            });
        }

    }

})
