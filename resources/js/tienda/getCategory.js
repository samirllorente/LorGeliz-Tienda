const menu = new Vue({
    el: '#menu',
    data: {
        categoria: '',
    }, 
    
    methods: {
        setCategory(categoria){
            let url = 'http://lorgeliz.nathasoft.com/categorias?categoria=' + categoria;

            axios.get(url).then(response => {
               
            }); 
        }
    },
    
});