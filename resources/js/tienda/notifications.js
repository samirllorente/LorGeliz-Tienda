
const app = new Vue({
    el: '#clientNotification',
    data: {
        notifications: [], 
    },

    computed:{
        
    },
    methods:{
        readNotification(id,ruta){
            let url = 'http://lorgeliz.nathasoft.com/notification/client/read/'+id;
            axios.put(url).then(response => {
                window.location.href = ruta;
            });   
        }
    },
    created() {
        axios.get('http://lorgeliz.nathasoft.com/notification/client').then(response => {
          this.notifications=response.data;
        }).catch(function(error){
           console.log(error)
        });

        var clienteId = $('meta[name="clienteId"]').attr('content');

        Echo.private('App.Cliente.' + clienteId).notification((notification) => {
            this.notifications.unshift(notification);
        });
    }

});