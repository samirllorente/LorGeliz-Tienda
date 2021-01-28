

const checkout = new Vue({
    el: '#pedidos',
    data: {
        devolucion: ''
    }, 

    methods: {
      imprimir(id){
        window.open('/lorgeliz_tienda/public/pedidos/show/pdf/' + id + ',' + '_blank');

      }

    },

    mounted(){
        
    }

});