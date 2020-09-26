

const checkout = new Vue({
    el: '#checkout',
    data: {
        carrito: '',
        total: ''
        
    }, 

    
    methods: {
        registrarventa(){

            let url = '/lorgeliz_tienda/public/admin/ventas/store';

            axios.post(url,{
                'carrito': this.carrito,
                'total': this.total,
            }).then(function (response) {
                swal(
                    'Pedido recibido!',
                    'Hemos recibido tu pedido. En breve empezaremos a alistarlo y nos pondremos en contacto contigo!',
                    'success'
                )
            }).catch(function (error) {
              console.log(error);
            }); 
        },

    },

    mounted(){
        this.carrito = data.datos.carrito;
        this.total = data.datos.total;
    }

});