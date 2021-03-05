

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

        getResponse(ref_payco){

            //let url = "https://secure.epayco.co/validation/v1/reference/" + ref_payco;

            //axios.get(url).then(response => {
                //if (response.success) {
                    //this.x_transaction_date = response.data.x_transaction_date;
                    //this.x_amount = response.data.x_amount;
                    //this.x_response = response.data.x_response;
                    //this.x_response_reason_text = response.data.x_response_reason_text;
                    //this.x_cod_response = response.data.x_cod_response;
                    //this.x_transaction_id = response.data.x_transaction_id;
                //}
            //}); 

            this.abrirModal();
        },

        cerrarModal(){
            this.modal=0;
        }, 

        abrirModal(){               
            this.modal = 1;
        },
        
    },

    mounted(){


    }

});