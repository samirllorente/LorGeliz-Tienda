

const product = new Vue({
    el: '#carrito',
    data: {
        carrito: 0,
        arrayProductos: []
    }, 

    methods: {

        remove(producto){
           
            let url = 'http://lorgeliz.nathasoft.com/cart/remove/'+producto;
    
            axios.delete(url).then(response => {
                location.reload();
            });
        },
        
        limpiarCarrito(carrito){
            this.carrito = carrito;
            let url = 'http://lorgeliz.nathasoft.com/cart/delete/'+carrito;
    
            axios.delete(url).then(response => {

                swal(
                    'Haz limpiado tu carrito!',
                    'Tu carrito de compras está vacío!',
                    'success'
                )
                window.location.href = `http://lorgeliz.nathasoft.com/`;
            });
        }
    },

    mounted(){
        
    }

});