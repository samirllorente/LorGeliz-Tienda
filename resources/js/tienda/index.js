

const user_cart = new Vue({
    el: '#inicio',
    data: {
        productoSlider: [],
        productoNuevo: [],
        productoPopular: [],
        productoVendido: [],
        productoOferta: []
    }, 
    
    methods: {
        getProductos(){
            let url = '/lorgeliz_tienda/public/index';

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