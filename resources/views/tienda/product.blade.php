@extends('layouts.store')

@section('estilos')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/plugins/flexslider/flexslider.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('asset/styles/product.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('asset/styles/product_responsive.css') }}">
@endsection

@section('content')

<div id="product_cart">
    <div class="super_container_inner">
        <div class="super_overlay"></div>
    
        <!-- Home -->
    
        <div class="home">
            <div class="home_container d-flex flex-column align-items-center justify-content-end">
                <div class="home_content text-center">
                    <div class="home_title">Página del Producto </div>
                    <div class="breadcrumbs d-flex flex-column align-items-center justify-content-center">
                        <ul class="d-flex flex-row align-items-start justify-content-start text-center">
                        <li><a href="{{ route('mi.cuenta')}}">Inicio</a></li>
                            <li><a href="category.html">{{ $producto->tipo->subcategoria->categoria->nombre }}</a></li>
                            <li><a href="subcategory.html">{{ $producto->tipo->subcategoria->nombre }}</a></li>
                            <li>New Products</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Product -->
    
        <div class="product">
            <div class="container">
                <div class="row">
    
                    <!-- Product Image -->
                    <div class="col-lg-6">
                        <div class="product_image_slider_container">
                            <span class="badge-new"><b> Nuevo</b></span>
                            <span class="badge-offer"><b> - 50%</b></span>
                            <div id="slider" class="flexslider">
                                <ul class="slides">

                                    @foreach(\App\Imagene::where('imageable_type', 'App\ColorProducto')
                                    ->where('imageable_id', $producto->cop)->pluck('url', 'id') as $id => $imagen) 
                                    <li>
                                        <img src="{{ url('storage/' . $imagen) }}" alt="" >
                                    </li>   
                                    
                                    @endforeach
    
                                </ul>
                            </div>
                            <div class="carousel_container">
                                <div id="carousel" class="flexslider">
                                    <ul class="slides">
    
                                        @foreach(\App\Imagene::where('imageable_type', 'App\ColorProducto')
                                        ->where('imageable_id', $producto->cop)->pluck('url', 'id') as $id => $imagen) 
                                        <li>
                                            <div>
                                                <img src="{{ url('storage/' . $imagen) }}" alt="" >
                                            </div>     
                                        </li>   
                                        @endforeach
                                        
                                    </ul>
                                </div>
                                <div class="fs_prev fs_nav disabled"><i class="fa fa-chevron-up" aria-hidden="true"></i>
                                </div>
                                <div class="fs_next fs_nav"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        
                    </div>
    
                    <!-- Product Info -->
                    <div class="col-lg-6 product_col">
                    <div class="product_info info" id="{{ $producto->id}}">
                            <div class="product_name">{{ $producto->nombre }}</div>
                            <div class="product_category">In <a href="category.html">Category</a></div>
    
                    <div class="product_price">${{ floatval($producto->precio_actual)}}<del class="price-old"> $1980.00</del></div>
    
                            <div class="product_text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec consequat lorem.
                                    Maecenas elementum at diam consequat bibendum. Mauris iaculis fringilla ex, sit amet
                                    semper libero facilisis sit amet. Nunc ut aliquet metus. Praesent pulvinar justo sed
                                    velit tempus bibendum. Quisque dictum lorem id mi viverra, in auctor justo laoreet. Nam
                                    at massa malesuada, ullamcorper metus vel, consequat risus. Phasellus ultricies velit
                                    vel accumsan porta.</p>
                            </div>
    
                            <div class="product_text">
                            <span style="color: black; font-weight: bold;" value="{{ $producto->cop}}" class="producto">Cantidad</span>
                                <input class="form-number form-control" type="number" id="cantidad" name="cantidad"
                                    value="1" step="1" min="0" placeholder="" v-model="cantidad">
                            </div>
                           
                            <div class="product_text">
                                <span style="color: black; font-weight: bold;">Talla</span>
                                <select name="talla" id="talla" class="form-control" v-model="talla">
                                    <option value="0" selected>Seleccione una talla</option>
                                    <option v-for="talla in arrayTallas" :key="talla.id" :value="talla.id" v-text="talla.nombre"></option>
                                </select>
                            </div>

                            <div class="product_buttons">
                                <div class="text-right d-flex flex-row align-items-start justify-content-start">
                                    <div
                                        class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
                                        <div>
                                            <div id="cart" v-on:click.prevent="getCarrito()"><img src="{{ asset('asset/images/cart.svg') }}" class="svg" alt="">
                                                <div>+</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
        <!--
    tab info
    -->
        <div class="tabinfo">
            <div class="container">
    
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#descripcion" class="nav-link active" data-toggle="tab">Descripción</a>
                    </li>
                    <li class="nav-item">
                        <a href="#especificaciones" class="nav-link" data-toggle="tab">Especificaciones</a>
                    </li>
                    <li class="nav-item">
                        <a href="#datosinteres" class="nav-link" data-toggle="tab">Datos de interés</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="descripcion">
    
                        <h3>Descripción</h3>
                        <p>
                        </p>
                        <div class="field field--name-body field--type-text-with-summary field--label-hidden field--item">
                            <p>varios colores</p>
    
                            <p>En stock.<br>
                                • Este reloj cronógrafo deportivo es bueno para cualquier regalo: el reloj tiene una función
                                de calendario: fecha, agujas luminiscentes del cronómetro<br>
                                • Material de la pulsera de acero inoxidable: longitud: 19 cm, ancho: 22 mm<br>
                                • Diámetro de la carcasa: 42,5 mm, altura de la carcasa: 11 mm; Impermeable 30 M - Peso: 108
                                gramos<br>
                                • Embalaje entregado en una elegante caja de regalo<br>
                                • Producto &nbsp;desde: 4 de enero de 2018<br>
                                • Valoración media de los clientes: Sé el primero en opinar sobre este producto<br>
                                • Clasificación en los más vendidos : nº43.429 en Relojes (Ver el Top 100 en Relojes)<br>
                                n.° 22647 en Relojes &gt; Hombre &gt; Relojes de pulsera
                            </p>
                        </div>
    
                    </div>
                    <div class="tab-pane fade" id="especificaciones">
                        <h3>Especificaciones</h3>
                        <ol>
                            <li>Color: JHH</li>
                            <li>Información Del Reloj</li>
                            <li>Marca&nbsp;&nbsp; &nbsp;JEDIR</li>
                            <li>Referencia del fabricante&nbsp;&nbsp; &nbsp;2011G</li>
                            <li>Forma del producto&nbsp;&nbsp; &nbsp;Redondo</li>
                            <li>Visualización﻿&nbsp;&nbsp; &nbsp;Cronógrafo</li>
                            <li>Grosor de la caja﻿&nbsp;&nbsp; &nbsp;11 milímetros</li>
                            <li>Anchura de la correa&nbsp;&nbsp; &nbsp;22 milímetros</li>
                            <li>Peso&nbsp;&nbsp; &nbsp;95 gramos</li>
                            <li>Movimiento&nbsp;&nbsp; &nbsp;cuarzo</li>
                            <li>Detalles del producto</li>
                            <li>Color: JHH</li>
                            <li>Peso del producto: 95,3 g</li>
                            <li>Referencia del fabricante: 2011G</li>
                            <li>ASIN: B07868NYGM</li>
                        </ol>
                    </div>
                    <div class="tab-pane fade" id="datosinteres">
                        <p>Otros datos de interes</p>
                    </div>
                </div>
    
            </div>
    
    
        </div>
    
    
        <!-- Boxes -->
    
        <div class="boxes">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="box d-flex flex-row align-items-center justify-content-start">
                            <div class="mt-auto">
                                <div class="box_image"><img src="{{ asset('asset/images/boxes_1.png') }}" alt=""></div>
                            </div>
                            <div class="box_content">
                                <div class="box_title">Size Guide</div>
                                <div class="box_text">Phasellus sit amet nunc eros sed nec tellus.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 box_col">
                        <div class="box d-flex flex-row align-items-center justify-content-start">
                            <div class="mt-auto">
                                <div class="box_image"><img src="{{ asset('asset/images/boxes_2.png') }}" alt=""></div>
                            </div>
                            <div class="box_content">
                                <div class="box_title">Shipping</div>
                                <div class="box_text">Phasellus sit amet nunc eros sed nec tellus.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</div>

@endsection

@section('scripts')
    <script>
    window.data = {
        datos: {
            "producto": "{{$producto->cop}}",
        }
    }
    </script>
    <script src="{{ asset('asset/plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
    <script src="{{ asset('asset/plugins/flexslider/jquery.flexslider-min.js') }}"></script>
    <script src="{{ asset('asset/js/product.js') }}"></script>
@endsection




   
    
    