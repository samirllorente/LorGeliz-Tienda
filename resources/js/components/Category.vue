<template>
	<main>
	
    <div class="products" id="">
		<div class="container">
			<div class="row products_bar_row">
				<div class="col">
					<div class="products_bar d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-start justify-content-center">
						<div class="products_bar_links">
							<ul class="d-flex flex-row align-items-start justify-content-start">
								<li :class="listar == 7 ? 'active' : ''"><a href="" v-on:click.prevent="getproductos(1)">Todos</a></li>
								<li :class="listar == 4 ? 'active' : ''"><a href="" v-on:click.prevent="hotProducts(1)">Populares</a></li>
								<li :class="listar == 6 && estado == 1 ? 'active' : ''"><a href="" v-on:click.prevent="getProductByState(1,1)">Nuevos</a></li>
								<li :class="listar == 5 ? 'active' : ''"><a href="" v-on:click.prevent="saleProductos(1)">Más Vendidos</a></li>
								<li :class="listar == 6 && estado == 2 ? 'active' : ''"><a href="" v-on:click.prevent="getProductByState(1,2)">Ofertas</a></li>
							</ul>
							
						</div>
						<div class="products_bar_side d-flex flex-row align-items-center justify-content-start ml-lg-auto">
							<div class="products_dropdown product_dropdown_sorting">
								<div class="isotope_sorting_text"><span>Ordenar Por</span><i class="fa fa-caret-down" aria-hidden="true"></i></div>
								<ul>
									<li class="item_sorting_btn" v-on:click.prevent="getproductos(1)">Default</li>
									<li class="item_sorting_btn" v-on:click.prevent="getProductsByOrder(1,1)">Precio</li>
									<li class="item_sorting_btn" v-on:click.prevent="getProductsByOrder(1,2)">Nombre</li>
								</ul>
							</div>

							
							<div class="products_dropdown text-right product_dropdown_filter">
								<div class="isotope_filter_text"><span>Género</span><i class="fa fa-caret-down" aria-hidden="true"></i></div>
								<ul>
									<li class="item_filter_btn" v-on:click.prevent="getProductByGenre(1,1)">Masculino</li>
									<li class="item_filter_btn" v-on:click.prevent="getProductByGenre(1,2)">Femenino</li>
									<li class="item_filter_btn" v-on:click.prevent="getProductByGenre(1,3)">Niños</li>
									
								</ul>
							</div>
							<div class="products_dropdown text-right product_dropdown_filter">
								<div class="isotope_filter_text"><span>Filtrar</span><i class="fa fa-caret-down" aria-hidden="true"></i></div>
								<ul>
									<li class="item_filter_btn" v-on:click.prevent="getproductos(1)">Todos</li>
									<li class="item_filter_btn" v-on:click.prevent="hotProducts(1)">Populares</li>
									<li class="item_filter_btn" v-on:click.prevent="getProductByState(1,1)">Nuevos</li>
									<li class="item_filter_btn" v-on:click.prevent="saleProductos(1)">Más Vendidos</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div
				v-if="arrayProductos.length == 0"
				class="col-md-2 offset-5"
			>
				<a href="#">
					<img src="img/preloader.gif" />
				</a>
    		</div>

			<div style="padding-bottom: 0px">
				<div class="row products_row products_container grid">
						
					<div v-for="producto in arrayProductos" :key="producto.cop" class="col-xl-4 col-md-6 grid-item">
						
						<div class="product">
							<span class="badge-new" v-show="producto.estado==1"><b v-text="'Nuevo'"></b></span>
							<span class="badge-offer"><b v-text="'-' + producto.porcentaje_descuento +'%'" v-show="producto.porcentaje_descuento>0"></b></span>
							<div class="product_image">
								<a :href="'product/' + producto.slug">
									<!--<img :src="'storage/' + producto.url" alt="producto">!-->
									<img :src="producto.url" alt="producto">
								</a>
							</div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
										<div class="product_name"><a :href="'product/' + producto.slug" v-text="producto.nombre + '-' + producto.color"></a></div>
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">En <a href="" v-text="producto.tipo"  v-on:click.prevent="getProductByTipo(1,producto.tipo_id)"></a></div>
										<div class="product_price text-right" v-text="'$'+producto.precio_actual"><span></span></div>
										<del class="price-old text-right" v-show="producto.precio_actual<producto.precio_anterior" v-text="'$'+producto.precio_anterior" style="font-size: 17px"></del>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="asset/images/cart.svg" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				
				</div>	
			</div>
					
			<div class="row page_nav_row">
				<div class="col">
					<div class="page_nav">
						
						<ul class="d-flex flex-row align-items-start justify-content-center">
							<li class="" v-if="pagination.current_page > 1">
								<a href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
							</li>
							<li v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
								<a href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
							</li>
							<li v-if="pagination.current_page < pagination.last_page">
								<a class="" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
							</li>
						</ul>
                        
					</div>
				</div>
			</div>
		</div>
	</div>
    </main>
    
</template>

<script>
    export default {
		props : ['categoria','subcategoria'],
        data (){
            return {
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
                listar: 0,
                value: 0,
                tipo: '',
                estado: 0,
                //categoria: '',
                //subcategoria: ''

            }
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
        methods : {
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
        mounted() {
			
		   if (this.categoria == "hombres" && this.subcategoria == '') {
            	this.getProductByGenre(1,1);
			} 
			
			if (this.categoria == "mujeres" && this.subcategoria == '') {
				this.getProductByGenre(1,2);
			} 

			if (this.categoria == "niños" && this.subcategoria == '') {
				this.getProductByGenre(1,3);
			} 

			if (this.categoria == "nuevos" && this.subcategoria == '') {
            	this.getProductByState(1,1);
       		} 

			if (this.categoria == "ofertas" && this.subcategoria == '') {
				this.getProductByState(1,2);
			} 
			
			if (this.categoria == '' && this.subcategoria == '') {
				this.getproductos(1);
			} 

			if (this.subcategoria != '') {
				this.getProductByTipo(1,this.subcategoria)
			}
        }
    }
</script>
