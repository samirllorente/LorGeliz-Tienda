@extends('layouts.store') 

@section('estilos')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/styles/cart.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('asset/styles/cart_responsive.css') }}">
    
@endsection

@section('content')

<div id="carrito">
	<div class="super_container_inner">
		<div class="super_overlay"></div>

		<!-- Home -->

		<div class="home">
			<div class="home_container d-flex flex-column align-items-center justify-content-end">
				<div class="home_content text-center">
					<div class="home_title">Carrito de Compras</div>
					<div class="breadcrumbs d-flex flex-column align-items-center justify-content-center">
						<ul class="d-flex flex-row align-items-start justify-content-start text-center">
							<li><a href="#">Inicio</a></li>
							<li>Mi Carrito</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- Cart -->

		<div class="cart_section">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="cart_container">
							
							<!-- Cart Bar -->
							<div class="cart_bar">
								<ul class="cart_bar_list item_list d-flex flex-row align-items-center justify-content-end">
									<li class="mr-auto">Producto</li>
									<li>Color</li>
									<li>Talla</li>
									<li>Precio</li>
									<li>Cantidad</li>
									<li>Total</li>
								</ul>
							</div>

							

							<!-- Cart Items -->
							<div class="cart_items">
								<ul class="cart_items_list">
									@foreach ($productos as $producto)

									<!-- Cart Item -->
									<li class="cart_item item_list d-flex flex-lg-row flex-column align-items-lg-center 		align-items-start justify-content-lg-end justify-content-start">
										<div class="product d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start mr-auto">
										<div><div class="product_number">{{ $producto->codigo}}</div></div>
											<div>
											    <div class="product_image">
													@foreach(\App\Imagene::where('imageable_type', 'App\ColorProducto')
													->where('imageable_id', $producto->cop)->pluck('url', 'id')->take(1) as $id => $imagen)    
													<img src="{{ url('storage/' . $imagen) }}" alt="">
													@endforeach
											    </div>
											</div>
											<div class="product_name_container">
											<div class="product_name"><a href="{{ route('producto.show', $producto->slug) }}">{{ $producto->nombre }}</a></div>
												<div class="product_text">Second line for additional info</div>
											</div>
										</div>
										<div class="product_color product_text">
											<span>Color: </span>
											{{ $producto->color}}
										</div>
										<div class="product_size product_text">
											<span>Talla: </span>{{ $producto->talla }}
										</div>
										<div class="product_price product_text"><span>Precio: </span>
											<div id="precio_{{ $producto->codigo}}">{{ floatval($producto->precio_actual) }}</div>
										</div>
										<div class="product_quantity_container">
											<div class="product_quantity ml-lg-auto mr-lg-auto text-center">
												<span class="product_text product_num" id="prod_{{ $producto->codigo}}">{{ $producto->cantidad}}</span>
												<div class="qty_sub qty_button trans_200 text-center">
													<span id="{{ $producto->codigo}}" class="disminiur">-</span>
												</div>
												<div class="qty_add qty_button trans_200 text-center">
													<span id="{{ $producto->codigo}}" class="aumentar">+</span>
												</div>
											</div>
										</div>
										
										<div class="product_total product_text">
											<span>Total: </span>
											<div id="total_{{ $producto->codigo}}">{{ floatval($producto->precio_actual * $producto->cantidad) }}</div> 
										</div>
									</li>
									@endforeach
								</ul>
							</div>

							<!-- Cart Buttons -->
							<div class="cart_buttons d-flex flex-row align-items-start justify-content-start">
								<div class="cart_buttons_inner ml-sm-auto d-flex flex-row align-items-start justify-content-start flex-wrap">
								<div class="button button_clear trans_200"><a href="{{-- route('cart.destroy', $producto->carrito)--}}">limpiar carrito</a></div>
									<div class="button button_continue trans_200"><a href="categories.html">continuar comprando</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row cart_extra_row">
					<div class="col-lg-6">
						<div class="cart_extra cart_extra_1">
							<div class="cart_extra_content cart_extra_coupon">
								<div class="cart_extra_title">Código de cupón</div>
								<div class="coupon_form_container">
									<form action="#" id="coupon_form" class="coupon_form">
										<input type="text" class="coupon_input" required="required">
										<button class="coupon_button">aplicar</button>
									</form>
								</div>
								<div class="coupon_text">Phasellus sit amet nunc eros. Sed nec congue tellus. Aenean nulla nisl, volutpat blandit lorem ut.</div>
								<div class="shipping">
									<div class="cart_extra_title">Método de Envío</div>
									<ul>
										<li class="shipping_option d-flex flex-row align-items-center justify-content-start">
											<label class="radio_container">
												<input type="radio" id="radio_1" name="shipping_radio" class="shipping_radio">
												<span class="radio_mark"></span>
												<span class="radio_text">Next day delivery</span>
											</label>
											<div class="shipping_price ml-auto">$4.99</div>
										</li>
										<li class="shipping_option d-flex flex-row align-items-center justify-content-start">
											<label class="radio_container">
												<input type="radio" id="radio_2" name="shipping_radio" class="shipping_radio">
												<span class="radio_mark"></span>
												<span class="radio_text">Standard delivery</span>
											</label>
											<div class="shipping_price ml-auto">$1.99</div>
										</li>
										<li class="shipping_option d-flex flex-row align-items-center justify-content-start">
											<label class="radio_container">
												<input type="radio" id="radio_3" name="shipping_radio" class="shipping_radio" checked>
												<span class="radio_mark"></span>
												<span class="radio_text">Personal Pickup</span>
											</label>
											<div class="shipping_price ml-auto">Free</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 cart_extra_col">
						<div class="cart_extra cart_extra_2">
							<div class="cart_extra_content cart_extra_total">
								<div class="cart_extra_title">Total Carrito</div>
								<ul class="cart_extra_total_list">
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_extra_total_title">Subtotal</div>
										<div class="cart_extra_total_value ml-auto" id="subtotal">{{ floatval($producto->total) }}</div>
									</li>
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_extra_total_title">Shipping</div>
										<div class="cart_extra_total_value ml-auto">Free</div>
									</li>
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_extra_total_title">Total</div>
										<div class="cart_extra_total_value ml-auto" id="neto">{{ floatval($producto->total) }}</div>
									</li>
								</ul>
								<div class="checkout_button trans_200"><a href={{ route('checkout')}}>proceder al pago</a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>  
</div>
	
@endsection

@section('scripts')
<script src="{{ asset('asset/js/cart.js') }}"></script>

<script>
	$(document).ready(function () {
		$('.aumentar').click(function (e) { 
			e.preventDefault();

			let id = $(this).attr('id');
			let cantidad = parseInt($('#prod_' + id).html()) + 1;
			let precio = parseInt($('#precio_' +id).html());
			let total = cantidad * precio;
			
			$('#total_' + id).html(total);

			let neto = parseInt($('#neto').html());
			let totalneto = neto + precio;

			$('#subtotal').html(totalneto);

			$('#neto').html(totalneto);
			
		});

		$('.disminuir').click(function (e) { 
			e.preventDefault();

			let id = $(this).attr('id');
			let cantidad = parseInt($('#prod_' + id).html()) - 1;
			let precio = parseInt($('#precio_' +id).html());
			let total = cantidad * precio;
			
			$('#total_' + id).html(total);
			
		});
	});
</script>
@endsection





		