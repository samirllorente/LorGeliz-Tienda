const menu = new Vue({
    el: '#menu',
    data: {
        categoria: '',
    }, 
    
    methods: {
        redirect(name){
            this.categoria = name;
            window.location.href = `/lorgeliz_tienda/public/categorias?ref=` + this.categoria;
        }
        
    },
    
});