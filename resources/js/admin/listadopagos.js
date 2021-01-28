

const payments = new Vue({
    el: '#payments',
    data: {
       
    }, 
    
    methods: {
        pdfListPagos(){
            window.open('/lorgeliz_tienda/public/admin/payments/list');
        },

        imprimirPago(id){
            window.open('/lorgeliz_tienda/public/admin/payments/payment/'+ id + ',' + '_blank');
            
        },
        
    },

    mounted(){


    }

});