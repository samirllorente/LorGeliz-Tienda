<template>
    <div v-text="productos"></div>
</template>

<script>
    export default {
        props: {
            user_id: {
                type: Number,
                required: true
            }
        },
        data (){
            return {
                productos: 0,
            }
		},

        methods : {
            carritoUser(){
                let url = '/lorgeliz_tienda/public/cart/products';

                axios.get(url).then(response => {
                    this.productos = response.data.cantidad;
                }); 
               
            },
        },

        mounted() {
            
            let url = '/lorgeliz_tienda/public/cart/products';

            axios.get(url).then(response => {
                this.productos = response.data.cantidad;
            }); 

            window.Echo.private(`cart-updated.${this.user_id}`).listen('UserCart', (e) => {
                let cart = e.cart;
                console.log(cart);
                this.productos = cart;
            });
        }
    }
</script>
