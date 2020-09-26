

const checkout = new Vue({
    el: '#categoria',
    data: {
        categoria: '',
        arrayProductos: [],
    }, 

    
    methods: {
        getproductos(){

            let url = '/lorgeliz_tienda/public/categorias/productos';

            axios.get(url).then(response => {
                this.arrayProductos = response.data.productos;
            }); 

        },

    },

    mounted(){
        this.getproductos();
    }

});