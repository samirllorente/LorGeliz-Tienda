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
                <li class="active"><a href="#">Mujeres</a></li>
                <li><a href="#">Hombres</a></li>
                <li><a href="#">Niños</a></li>					
            </ul>
        </nav>
        <div class="header_right d-flex flex-row align-items-center justify-content-start ml-auto">
            <!-- Search -->
            <div class="header_search">
                <form action="#" id="header_search_form">
                    <input type="text" class="search_input" placeholder="Buscar" required="required">
                    <button class="header_search_button"><img src="{{ asset('asset/images/search.png') }}" alt=""></button>
                </form>
            </div>
            <!-- User -->
            @include('partials.navigations.logged')
            
            <!-- Cart -->
            <div class="cart"><a href="{{ route('store.cart')}}"><div><img class="svg" src="{{ asset('asset/images/cart.svg') }}" alt="https://www.flaticon.com/authors/freepik"><div>1</div></div></a></div>
            <!-- Phone -->
            <div class="header_phone d-flex flex-row align-items-center justify-content-start">
                <div><div><img src="{{ asset('asset/images/phone.svg') }}" alt="https://www.flaticon.com/authors/freepik"></div></div>
                <div>+1 912-252-7350</div>
            </div>
        </div>
    </div>
</header>