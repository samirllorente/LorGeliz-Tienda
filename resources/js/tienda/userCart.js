

const user_cart = new Vue({
    el: '#user_cart',
    data: {
        productos: 0,
    }, 
    
    methods: {
        carritoUser(){
            let url = '/lorgeliz_tienda/public/cart/products';

            axios.get(url).then(response => {
                this.productos = response.data;
            }); 
            
        },
        
    },

    created() {
        this.carritoUser();
    }
});