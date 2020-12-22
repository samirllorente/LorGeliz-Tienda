@extends('layouts.store')

@section('estilos')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/styles/checkout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('asset/styles/checkout_responsive.css') }}">
@endsection

@section('content')

<div class="super_container_inner">
<div id="">
	{{--<div class="super_container_inner">--}}
		<div class="super_overlay"></div>

		<!-- Home -->

		<div class="home">
			<div class="home_container d-flex flex-column align-items-center justify-content-end">
				<div class="home_content text-center">
					<div class="home_title">Pagar Pedido</div>
					<div class="breadcrumbs d-flex flex-column align-items-center justify-content-center">
						<ul class="d-flex flex-row align-items-start justify-content-start text-center">
						<li><a href="{{ route('home')}}">Inicio</a></li>
							<li>Pagar Pedido</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- Checkout -->

		<div class="checkout">
			<div class="container">
				<div class="row">
					
					<!-- Billing -->
					<div class="col-lg-6">
						<div class="billing">
							<div class="checkout_title">Información de Pago</div>
							<div class="checkout_form_container">
								<form action="#" id="checkout_form" class="checkout_form">
									<div class="row">
										<div class="col-lg-6">
											<!-- Name -->
										<input type="text" id="checkout_name" class="checkout_input" placeholder="Nombres" required="required" value="{{ $carrito->cliente->user->nombres}}">
										</div>
										<div class="col-lg-6">
											<!-- Last Name -->
											<input type="text" id="checkout_last_name" class="checkout_input" placeholder="Apellidos" required="required" value="{{ $carrito->cliente->user->apellidos}}">
										</div>
									</div>
									<div>
										<!-- Company -->
										<input type="text" id="checkout_company" placeholder="Empresa" class="checkout_input">
									</div>
									<div>
										<!-- Country -->
										<select name="checkout_country" id="checkout_country" class="dropdown_item_select checkout_input" require="required">
											<option>País</option>
											<option>Colombia</option>
										</select>
									</div>
									<div>
										<!-- Province -->
										<select name="checkout_province" id="checkout_province" class="dropdown_item_select checkout_input" require="required">
											<option>Departamento</option>
											<option>Córdoba</option>
											<option>Province</option>
											<option>Province</option>
											<option>Province</option>
										</select>
									</div>
									<div>
										<!-- City / Town -->
										<select name="checkout_city" id="checkout_city" class="dropdown_item_select checkout_input" require="required">
											<option>Ciudad</option>
											<option>Montería</option>
											<option>City</option>
											<option>City</option>
											<option>City</option>
										</select>
									</div>
									<div>
										<!-- Address -->
										<input type="text" id="checkout_address" class="checkout_input" placeholder="Dirección" required="required" value="{{ $carrito->cliente->user->direccion}}">
										<input type="text" id="checkout_address_2" class="checkout_input checkout_address_2" placeholder="Dirección 2" required="required">
									</div>
									<div>
										<!-- Zipcode -->
										<input type="text" id="checkout_zipcode" class="checkout_input" placeholder="Código postal" required="required">
									</div>
									<div>
										<!-- Phone no -->
										<input type="phone" id="checkout_phone" class="checkout_input" placeholder="Teléfono" required="required" value="{{ $carrito->cliente->user->telefono}}">
									</div>
									<div>
										<!-- Email -->
										<input type="phone" id="checkout_email" class="checkout_input" placeholder="Email" required="required" value="{{ $carrito->cliente->user->email}}">
									</div>
									<div class="checkout_extra">
										<ul>
											<li class="billing_info d-flex flex-row align-items-center justify-content-start">
												<label class="checkbox_container">
													<input type="checkbox" id="cb_1" name="billing_checkbox" class="billing_checkbox">
													<span class="checkbox_mark"></span>
													<span class="checkbox_text">Términos y condiciones</span>
												</label>
											</li>
											{{--<li class="billing_info d-flex flex-row align-items-center justify-content-start">
												<label class="checkbox_container">
													<input type="checkbox" id="cb_2" name="billing_checkbox" class="billing_checkbox">
													<span class="checkbox_mark"></span>
													<span class="checkbox_text">Crear una cuenta</span>
												</label>
											</li>--}}
											<li class="billing_info d-flex flex-row align-items-center justify-content-start">
												<label class="checkbox_container">
													<input type="checkbox" id="cb_3" name="billing_checkbox" class="billing_checkbox">
													<span class="checkbox_mark"></span>
													<span class="checkbox_text">Suscríbete a nuestro boletín</span>
												</label>
											</li>
										</ul>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- Cart Total -->
					<div class="col-lg-6 cart_col">
						<div class="cart_total">
							<div class="cart_extra_content cart_extra_total">
								<div class="checkout_title">Total carrito</div>
								<ul class="cart_extra_total_list">
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_extra_total_title">Subtotal</div>
										<div class="cart_extra_total_value ml-auto">${{ floatval($carrito->total)}}</div>
									</li>
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_extra_total_title">Envío</div>
										<div class="cart_extra_total_value ml-auto">Gratis</div>
									</li>
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_extra_total_title">Total</div>
										<div class="cart_extra_total_value ml-auto">${{ floatval($carrito->total)}}</div>
									</li>
								</ul>
								<div class="payment_options">
									<div class="checkout_title">Método de Pago</div>
									<ul>
										{{--<li class="shipping_option d-flex flex-row align-items-center justify-content-start">
											<label class="radio_container">
												<input type="radio" id="radio_1" name="payment_radio" class="payment_radio">
												<span class="radio_mark"></span>
												<span class="radio_text">Paypal</span>
											</label>
										</li>--}}
										<li class="shipping_option d-flex flex-row align-items-center justify-content-start">
											<label class="radio_container">
												<input type="radio" id="radio_2" name="payment_radio" class="payment_radio">
												<span class="radio_mark"></span>
												<span class="radio_text">Pagar contra entrega</span>
											</label>
										</li>
										<li class="shipping_option d-flex flex-row align-items-center justify-content-start">
											<label class="radio_container">
												<input type="radio" id="radio_3" name="payment_radio" class="payment_radio">
												<span class="radio_mark"></span>
												<span class="radio_text">Pagar con epayco</span>
											</label>
										</li>
									</ul>
								</div>
								<div class="cart_text">
									<p>Puedes pagar contra entrega o a tráves de epayco. Aceptamos todas las tarjetas, efecty, pse, daviplata y otros medios</p>
								</div>
								<div class="checkout_button trans_200">
									<a href="" id="btnCheckout">realizar pedido</a>
									{{--<a href="" v-on:click.prevent="registrarventa()">realizar pedido</a>--}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    
</div>
	
@endsection

@section('scripts')
<script src="{{ asset('asset/js/checkout.js') }}"></script>

<script>
	window.data = {
        datos: {
            "carrito": "{{$carrito->id}}",
            "total": "{{$carrito->total}}"
        }
    }
</script>

<script> 
$(document).ready(function () {

	$("#btnCheckout").click(function (e) { 
		e.preventDefault();
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $("input[name= _token]").val()
			}
		});

		$.ajax({
			type: "GET",
			url: "{{ route('stock.verificar') }}",
			data:{},
			dataType: 'json',
			success: function (response) {
				if (response.data == 'success') {
					
					if($("#radio_2").is(':checked',true))
					{

						$.ajax({
							type: "POST",
							url: "{{ route('venta.store') }}",
							data:{},
							dataType: 'json',
							success: function (response) {
								if (response.data == 'success') {
									var pedido = response.pedido;
									swal(
										'Pedido recibido!',
										'Hemos recibido tu pedido. En breve empezaremos a alistarlo y nos pondremos en contacto contigo!',
										'success'
									)
									window.location.href = `/lorgeliz_tienda/public/pedidos/` + pedido;
								}
							}

						});
					}

					if($("#radio_3").is(':checked',true))
					{
						var handler = ePayco.checkout.configure({
							key: '12d3b45147fae13431996471aa5966af',
							test: true
						})  

						var data={
						//Parametros compra (obligatorio)
						name: "Artículos de moda",
						description: "Pedidos realizados en Lorgeliz Shopp",
						invoice: "1234",
						currency: "cop",
						amount: "{{floatval($carrito->total)}}",
						tax_base: "0",
						tax: "0",
						country: "co",
						lang: "es",

						//Onpage="false" - Standard="true"
						external: "false",


						//Atributos opcionales
						//extra1: "extra1",
						//extra2: "extra2",
						//extra3: "extra3",
						//confirmation: "http://localhost/lorgeliz_tienda/public/epaycoConfirm.php",
						response: "http://localhost/lorgeliz_tienda/public/payments/epayco/response",
						p_confirm_method: "POST",

						//Atributos cliente
						name_billing: "{{$carrito->nombres}} {{$carrito->apellidos}}",
						address_billing: "{{$carrito->direccion}}",
						type_doc_billing: "cc",
						mobilephone_billing: "{{$carrito->telefono}}",
						number_doc_billing: "{{$carrito->identificacion}}"

						}
						handler.open(data)
					}
				}
				else{
					swal(
						'Uno de tus productos está agotado!',
						'Te informamos que uno de los productos que pusiste en el carrito se agotó!',
						'error'
					)
					setTimeout(() => {
						window.location.href = `/lorgeliz_tienda/public/cart`;
					}, 4000);
				}
			}

		});

	});
});
</script>

<script type="text/javascript" src="https://checkout.epayco.co/checkout.js">
</script>

@endsection

