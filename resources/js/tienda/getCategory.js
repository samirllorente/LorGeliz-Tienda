const menu = new Vue({
    el: '#menu',
    data: {
        categoria: '',
    }, 
    
    methods: {
        setCategory(categoria){
            let url = '/lorgeliz_tienda/public/categorias?categoria=' + categoria;

            axios.get(url).then(response => {
               
            }); 
        }
    },
    
});