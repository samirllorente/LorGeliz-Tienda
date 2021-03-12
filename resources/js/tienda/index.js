

const user_cart = new Vue({
    el: '#inicio',
    data: {
        productoSlider: [],
        productoNuevo: [],
        productoPopular: [],
        productoVendido: [],
        productoOferta: [],
        cantidad: 0
    }, 
    
    methods: {
        getProductos(){
            this.cantidad++;
            let url = 'http://lorgeliz.nathasoft.com/index?cantidad=' + this.cantidad;

            axios.get(url).then(response => {
                //this.productoSlider = response.data.slider;
                this.productoNuevo = response.data.nuevos;
                //this.productoPopular = response.data.populares;
                //this.productoVendido = response.data.vendidos;
                //this.productoOferta = response.data.ofertas;
            }); 
            
        },
        
    },

    created() {
        this.getProductos();
    }
});