<!-- Header -->

<header class="header">
    <div class="header_overlay"></div>
    <div class="header_content d-flex flex-row align-items-center justify-content-start">
        <div class="logo">
            <a href="{{ route('home')}}">
                <div class="d-flex flex-row align-items-center justify-content-start">
                    <div><img src="{{ asset('asset/images/logo_1.png') }}" alt=""></div>
                    <div>Lorgeliz Shop</div>
                </div>
            </a>	
        </div>
        <div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>
        <nav class="main_nav">
            <ul class="d-flex flex-row align-items-start justify-content-start">
                <li class="active"><a href="categorias?categoria=mujeres">Mujeres</a></li>
                <li><a href="categorias?categoria=hombres">Hombres</a></li>
                <li><a href="categorias?categoria=niños">Niños</a></li>					
            </ul>
        </nav>
        <div class="header_right d-flex flex-row align-items-center justify-content-start ml-auto">
            <!-- Search -->
            <div class="header_search" id="search" id="search_box">
                <form action="#" id="header_search_form">
                    <input type="text" class="search_input" placeholder="Buscar" required="required">
                    <button class="header_search_button"><img src="{{ asset('asset/images/search.png') }}" alt=""></button>
                </form>
            </div>
            <!-- User -->
            @include('partials.navigations.logged')
            
            <!-- Cart -->
            <div class="cart" id="user_cart"><a href="{{ route('cart.index')}}" title="ir al carrito"><div><img class="svg" src="{{ asset('asset/images/cart.svg') }}" alt="https://www.flaticon.com/authors/freepik"><div>{{--<user-cart></user-cart>--}}<div v-text="productos.data"></div></div></div></a></div>

            {{--<div v-if="notifications.length"><div v-for="item in listar" :key="item.id"><div v-text="item.datos.notificacion.productos"></div></div></div><div v-else><div v-text="0"></div></div>--}}
            <!-- Phone -->
            <div class="header_phone d-flex flex-row align-items-center justify-content-start">
                <div><div><img src="{{ asset('asset/images/phone.svg') }}" alt="https://www.flaticon.com/authors/freepik"></div></div>
                <div>+57 313-864-5929</div>
            </div>
        </div>
    </div>
</header>
