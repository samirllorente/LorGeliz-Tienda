

const checkout = new Vue({
    el: '#pedidos',
    data: {
        devolucion: ''
    }, 

    
    methods: {
        getdevolucion(producto, venta){


            let url = '/lorgeliz_tienda/public/devoluciones/producto?producto=' + producto + '&venta=' + venta;

            axios.get(url).then(response => {
                this.devolucion = response.data.devolucion;
            }); 

            if (this.devolucion > 0) {
                swal(
                    'Acción cancelada!',
                    'Ya haz solicitado!',
                    'success'
                )
            }
            else{
                return false;
            }

        },

    },

    mounted(){
        
    }

});