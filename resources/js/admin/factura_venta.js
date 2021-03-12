

const product = new Vue({
    el: '#factura_venta',
    data: {
        venta: 0
    }, 
    
    methods: {
        facturaVenta(id){
            window.open('http://lorgeliz.nathasoft.com/admin/ventas/factura/'+ id + ',' + '_blank');
            
        },
        
    },

});