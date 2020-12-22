

const checkout = new Vue({
    el: '#categoria',
    data: {
        active: '',
        arrayProductos: [],
        criterio: '',
        genero: '',
        pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
        },
        offset : 3,
        listar: 1,
        value: 0,
        tipo: '',
        estado: 0
    },

    computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        //Calcula los elementos de la paginación
        pagesNumber: function() {
            if(!this.pagination.to) {
                return [];
            }
            
            var from = this.pagination.current_page - this.offset; 
            if(from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2); 
            if(to >= this.pagination.last_page){
                to = this.pagination.last_page;
            }  

            var pagesArray = [];
            while(from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    }, 
    
    methods: {
        getproductos(page){

            this.listar = 7;
            let url = '/lorgeliz_tienda/public/categorias/productos?page=' + page;

            axios.get(url).then(response => {
                var respuesta = response.data;
                this.arrayProductos = respuesta.productos.data;
                this.pagination = respuesta.pagination;
                this.active = 0;
            }); 

        },

        getProductByState(page,estado){
            
            this.listar = 6; 
            this.estado = estado;

            let url = '/lorgeliz_tienda/public/categorias/productos/estado?page=' + page + '&estado='  + this.estado;
            axios.get(url).then(response => {
                var respuesta = response.data;
                this.arrayProductos = respuesta.productos.data;
                this.pagination = respuesta.pagination;
            }); 

        },

        saleProductos(page){
            
            this.listar = 5;

            let url = '/lorgeliz_tienda/public/categorias/productos/vendidos?page=' + page;

            axios.get(url).then(response => {
                var respuesta = response.data;
                this.arrayProductos = respuesta.productos.data;
                this.pagination = respuesta.pagination;
            }); 

        },

        hotProducts(page){

            this.listar = 4;

            let url = '/lorgeliz_tienda/public/categorias/productos/vistos?page=' + page;

            axios.get(url).then(response => {
                var respuesta = response.data;
                this.arrayProductos = respuesta.productos.data;
                this.pagination = respuesta.pagination;
            }); 
        },

        getProductsByOrder(page,orden){

            this.listar = 3;
            this.orden = orden;

            if (orden==1) {
                this.criterio='precio_actual';
            }
            else{
                this.criterio='nombre'; 
            }

            let url = '/lorgeliz_tienda/public/categorias/productos/orden?page=' + page + '&criterio=' + this.criterio ;

            axios.get(url).then(response => {
                var respuesta = response.data;
                this.arrayProductos = respuesta.productos.data;
                this.pagination = respuesta.pagination;
            }); 
        },

        getProductByTipo(page,tipo){
           
            this.listar = 2;
            this.tipo = tipo;

            let url = '/lorgeliz_tienda/public/categorias/productos/tipo?page=' + page + '&tipo=' + this.tipo;

            axios.get(url).then(response => {
                var respuesta = response.data;
                this.arrayProductos = respuesta.productos.data;
                this.pagination = respuesta.pagination;
            }); 
        },

        getProductByGenre(page,value){
           
           this.listar = 1;
           this.value = value;

           if (this.value==1) {
               this.genero = 'hombres';
           }
           
           if (this.value==2) {
                this.genero = 'mujeres';
           }

           if (this.value==3) {
                this.genero = 'niños';
            }
            
           let url = '/lorgeliz_tienda/public/categorias/productos/genero?page=' + page + '&genero=' + this.genero;
           
            axios.get(url).then(response => {
                var respuesta = response.data;
                this.arrayProductos = respuesta.productos.data;
                this.pagination = respuesta.pagination;
            }); 
        },

        getQueryParam(param) {
            location.search.substr(1)
                .split("&")
                .some(function (item) { // returns first occurence and stops
                    return item.split("=")[0] == param && (param = item.split("=")[1])
                })
            return param
        },

        cambiarPagina(page){
            //Actualiza la página actual
            
            this.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página

            if (this.listar == 1) {
                this.getProductByGenre(page, this.value);
            }

            if (this.listar == 2) {
                this.getProductByTipo(page, this.tipo);
            }

            if (this.listar == 3) {
                this.getProductsByOrder(page, this.orden);
            }

            if (this.listar == 4) {
                this.hotProducts(page);
            }
            
            if (this.listar == 5) {
                this.saleProductos(page);
            }

            if (this.listar == 6) {
                this.getProductByState(page, this.estado);
            }
           
            if (this.listar == 7) {
                this.getproductos(page);
            }
        },
    },

    mounted(){
        //this.getproductos();
        var categoria = this.getQueryParam('ref');

        if (categoria == "Hombres") {
            this.getProductByGenre(1,1);
        } 
        
        if (categoria == "Mujeres") {
            this.getProductByGenre(1,2);
        } 

        if (categoria == "Niños") {
            this.getProductByGenre(1,3);
        } 

        if (categoria == "nuevos") {
            this.getProductByState(1,1);
        } 

        if (categoria == "ofertas") {
            this.getProductByState(1,2);
        } 
        
        if (!isNaN(categoria)) {
            if (categoria == 1) {
                this.getProductByTipo(1,"camisetas")
            }
            if (categoria == 2) {
                this.getProductByTipo(1,"vestidos")
            }
            if (categoria == 3) {
                this.getProductByTipo(1,"zapatos")
            }
            if (categoria == 4) {
                this.getProductByTipo(1,"blusas")
            }
            if (categoria == 5) {
                this.getProductByTipo(1,"abrigos")
            }
        }
    }

});