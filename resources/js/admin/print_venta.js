

const product = new Vue({
    el: '#print_venta',
    data: {
        
    }, 
    
    methods: {
        pdfVenta(id){
            window.open('/lorgeliz_tienda/public/admin/ventas/pdf/'+ id + ',' + '_blank');
            
        },
        
    },

});