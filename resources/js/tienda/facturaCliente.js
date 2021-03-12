

const product = new Vue({
    el: '#venta_cliente',
    data: {
        
    }, 
    
    methods: {
        pdfVenta(id){
            window.open('http://lorgeliz.nathasoft.com/pedidos/factura/'+ id + ',' + '_blank');
            
        },
        
    },

});