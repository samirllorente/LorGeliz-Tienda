

const product = new Vue({
    el: '#infventashow',
    data: {
        mes: ''
    }, 
    
    methods: {
        pdfInformeVentas(){
            window.open('http://lorgeliz.nathasoft.com/admin/informes/pdf/ventas/mes?mes='+this.mes);
        },
        
    },

    mounted(){

        this.mes = data.datos.ventames;
    }

});