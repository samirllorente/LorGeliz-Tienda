

const product = new Vue({
    el: '#venta_cliente',
    data: {
        
    }, 
    
    methods: {
        pdfVenta(id){
            window.open('/lorgeliz_tienda/public/pedidos/pdf/'+ id + ',' + '_blank');
            
        },
        
    },

});