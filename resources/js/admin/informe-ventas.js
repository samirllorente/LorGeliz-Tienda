

const product = new Vue({
    el: '#informeventa',
    data: {
        
    }, 
    
    methods: {
        pdfInformeVentas(){
            window.open('/lorgeliz_tienda/public/admin/informes/pdf/ventas');
            
        },
        
    },

});