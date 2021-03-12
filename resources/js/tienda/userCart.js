

const user_cart = new Vue({
    el: '#user_cart',
    data: {
        productos: 0,
    }, 

    computed:{
        
    },
    
    methods: {
        carritoUser(){
            let url = 'http://lorgeliz.nathasoft.com/cart/products';

            axios.get(url).then(response => {
                this.productos = response.data;
            }); 
            
        },

    },

    mounted() {
        this.carritoUser();

        var userId = $('meta[name="userId"]').attr('content');

        //window.Echo.private(`cart-updated.${this.user_id}`).listen('UserCart', (e) => {
        //window.Echo.private('cart-updated.' + userId).listen('UserCart', (e) => {
            //let cart = e.cart;
            //this.productos = cart;
        //});

    }
});
