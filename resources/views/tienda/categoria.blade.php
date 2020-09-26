
@extends('layouts.store')

@section('estilos')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('asset/plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('asset/plugins/OwlCarousel2-2.2.1/animate.css') }}">


<link rel="stylesheet" type="text/css" href="{{ asset('asset/styles/category.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('asset/styles/category_responsive.css') }}">

@endsection

@section('content')
<div id="categoria">
	<div class="super_container_inner">
		<div class="super_overlay"></div>

		<!-- Home -->

		<div class="home">
			<div class="home_container d-flex flex-column align-items-center justify-content-end">
				<div class="home_content text-center">
					<div class="home_title">Página de Categorías</div>
					<div class="breadcrumbs d-flex flex-column align-items-center justify-content-center">
						<ul class="d-flex flex-row align-items-start justify-content-start text-center">
							<li><a href="{{ route('home')}}">Inicio</a></li>
							<li><a href="category.html">Woman</a></li>
							<li>New Products</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- Products -->

		<div class="products">
			<div class="container">
				<div class="row products_bar_row">
					<div class="col">
						<div class="products_bar d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-lg-start justify-content-center">
							<div class="products_bar_links">
								<ul class="d-flex flex-row align-items-start justify-content-start">
									<li><a href="#">Todos</a></li>
									<li><a href="#">Populares</a></li>
									<li class="active"><a href="#">Nuevos</a></li>
									<li><a href="#">Más Vendidos</a></li>
								</ul>
							</div>
							<div class="products_bar_side d-flex flex-row align-items-center justify-content-start ml-lg-auto">
								<div class="products_dropdown product_dropdown_sorting">
									<div class="isotope_sorting_text"><span>Default Sorting</span><i class="fa fa-caret-down" aria-hidden="true"></i></div>
									<ul>
										<li class="item_sorting_btn" data-isotope-option='{ "sortBy": "original-order" }'>Default</li>
										<li class="item_sorting_btn" data-isotope-option='{ "sortBy": "price" }'>Precio</li>
										<li class="item_sorting_btn" data-isotope-option='{ "sortBy": "name" }'>Nombre</li>
									</ul>
								</div>
								<div class="product_view d-flex flex-row align-items-center justify-content-start">
									<div class="view_item active"><img src="{{ asset('asset/images/view_1.png') }}" alt=""></div>
									<div class="view_item"><img src="{{ asset('asset/images/view_2.png') }}" alt=""></div>
									<div class="view_item"><img src="{{ asset('asset/images/view_3.png') }}" alt=""></div>
								</div>
								<div class="products_dropdown text-right product_dropdown_filter">
									<div class="isotope_filter_text"><span>Filtrar</span><i class="fa fa-caret-down" aria-hidden="true"></i></div>
									<ul>
										<li class="item_filter_btn" data-filter="*">Todos</li>
										<li class="item_filter_btn" data-filter=".hot">Populares</li>
										<li class="item_filter_btn" data-filter=".new">Nuevos</li>
										<li class="item_filter_btn" data-filter=".sale">Más Vendidos</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row products_row products_container grid">
					{{--<products-category></products-category>--}}
					<!-- Product -->
					<div  v-for="(item, index) in arrayProductos" :key="item.cop" class="col-xl-4 col-md-6 grid-item new">
						<div class="product">
							<div class="product_image">
								<img src="{{ asset('asset/images/product_1.jpg') }}" alt="">
							</div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html" v-text="item.nombre"></a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Product -->
					{{--<div class="col-xl-4 col-md-6 grid-item hot">
						<div class="product">
							<div class="product_image"><img src="{{ asset('asset/images/product_2.jpg') }}" alt=""></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html">Cool Clothing with Brown Stripes</a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Product -->
					<div class="col-xl-4 col-md-6 grid-item sale">
						<div class="product">
							<div class="product_image"><img src="{{ asset('asset/images/product_3.jpg') }}" alt=""></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html">Cool Clothing with Brown Stripes</a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Product -->
					<div class="col-xl-4 col-md-6 grid-item sale">
						<div class="product">
							<div class="product_image"><img src="{{ asset('asset/images/product_4.jpg') }}" alt=""></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html">Cool Clothing with Brown Stripes</a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Product -->
					<div class="col-xl-4 col-md-6 grid-item hot">
						<div class="product">
							<div class="product_image"><img src="{{ asset('asset/images/product_5.jpg') }}" alt=""></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html">Cool Clothing with Brown Stripes</a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Product -->
					<div class="col-xl-4 col-md-6 grid-item new">
						<div class="product">
							<div class="product_image"><img src="{{ asset('asset/images/product_6.jpg') }}" alt=""></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html">Cool Clothing with Brown Stripes</a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Product -->
					<div class="col-xl-4 col-md-6 grid-item sale">
						<div class="product">
							<div class="product_image"><img src="{{ asset('asset/images/product_7.jpg') }}" alt=""></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html">Cool Clothing with Brown Stripes</a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Product -->
					<div class="col-xl-4 col-md-6 grid-item new">
						<div class="product">
							<div class="product_image"><img src="{{ asset('asset/images/product_8.jpg') }}" alt=""></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html">Cool Clothing with Brown Stripes</a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Product -->
					<div class="col-xl-4 col-md-6 grid-item sale">
						<div class="product">
							<div class="product_image"><img src="{{ asset('asset/images/product_9.jpg') }}" alt=""></div>
							<div class="product_content">
								<div class="product_info d-flex flex-row align-items-start justify-content-start">
									<div>
										<div>
											<div class="product_name"><a href="product.html">Cool Clothing with Brown Stripes</a></div>
											
										</div>
									</div>
									<div class="ml-auto text-right">
										<div class="product_category">In <a href="category.html">Category</a></div>
										<div class="product_price text-right">$3<span>.99</span></div>
									</div>
								</div>
								<div class="product_buttons">
									<div class="text-right d-flex flex-row align-items-start justify-content-start">										
										<div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
											<div><div><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt=""><div>+</div></div></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>--}}

				</div>
				<div class="row page_nav_row">
					<div class="col">
						<div class="page_nav">
							<ul class="d-flex flex-row align-items-start justify-content-center">
								<li class="active"><a href="#">01</a></li>
								<li><a href="#">02</a></li>
								<li><a href="#">03</a></li>
								<li><a href="#">04</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

</div>
	

@endsection

@section('scripts')
<script src="{{ asset('asset/plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
<script src="{{ asset('asset/plugins/progressbar/progressbar.min.js') }}"></script>
<script src="{{ asset('asset/plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('asset/plugins/Isotope/fitcolumns.js') }}"></script>
<script src="{{ asset('asset/js/category.js') }}"></script>
@endsection
