

const user_cart = new Vue({
    el: '#user_cart',
    data: {
        productos: 0,
        //arrayNotifications: [],
        //notifications: []
    }, 

    computed:{
        /*listar : function(){
            //this.arrayNotifications = Object.values(this.notifications[0]);
            if (this.notifications == '') {
                return this.arrayNotifications = [];
            }
            else{
                this.arrayNotifications = Object.values(this.notifications[0]);
                if (this.arrayNotifications.length > 3) {
                    return this.arrayNotifications[4];
                   
                } else {
                    return this.arrayNotifications[0];
                }
            }
            
        }*/
    },
    
    methods: {
        carritoUser(){
            let url = '/lorgeliz_tienda/public/cart/products';

            axios.get(url).then(response => {
                this.productos = response.data;
            }); 
            
        },

    },

    mounted() {
        this.carritoUser();

        /*axios.get('/lorgeliz_tienda/public/notification/cart/client').then(response => {
            this.notifications=response.data;
        }).catch(function(error){
            console.log(error)
        });
    
        var clienteId = $('meta[name="clienteId"]').attr('content');
    
        Echo.private('App.Cliente.' + clienteId).notification((notification) => {
            $this.notifications.unshift(notification);
        });*/
    }
});
