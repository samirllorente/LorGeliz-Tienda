

const checkout = new Vue({
    el: '#pedidos',
    data: {
        devolucion: ''
    }, 

    methods: {
      imprimir(id){
        window.open('http://lorgeliz.nathasoft.com/pedidos/show/pdf/' + id + ',' + '_blank');

      }

    },

    mounted(){
        
    }

});