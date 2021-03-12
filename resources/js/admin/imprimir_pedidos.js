

const product = new Vue({
    el: '#imprimir_pedidos',
    data: {
        
    }, 
    
    methods: {
        pdfInformePedidos(){
            window.open('http://lorgeliz.nathasoft.com/admin/pedidos/listado/pdf');
        },

        imprimir(id){
            window.open('http://lorgeliz.nathasoft.com/admin/pedidos/pedido/pdf/'+ id + ',' + '_blank');
        },
        
    },

});