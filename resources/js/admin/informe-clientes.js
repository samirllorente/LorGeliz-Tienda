

const product = new Vue({
    el: '#informecliente',
    data: {
        
    }, 
    
    methods: {
        pdfInformeClientes(){
            window.open('/lorgeliz_tienda/public/admin/informes/pdf/clientes');
            
        },
        
    },

});