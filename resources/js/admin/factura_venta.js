

const product = new Vue({
    el: '#factura_venta',
    data: {
        venta: 0
    }, 
    
    methods: {
        facturaVenta(id){
            window.open('/lorgeliz_tienda/public/admin/ventas/factura/'+ id + ',' + '_blank');
            
        },
        
    },

});