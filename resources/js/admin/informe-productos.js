

const product = new Vue({
    el: '#informeproducto',
    data: {
        
    }, 
    
    methods: {
        pdfInformeProductos(){
            window.open('/lorgeliz_tienda/public/admin/informes/pdf/productos');
            
        },
        
    },

});