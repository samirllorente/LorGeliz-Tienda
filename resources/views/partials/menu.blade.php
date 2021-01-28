
<div class="menu">

	<!-- Search -->
	<div class="menu_search">
		<form action="#" id="menu_search_form" class="menu_search_form">
			<input type="text" class="search_input" placeholder="Buscar" required="required">
			<button class="menu_search_button"><img src="{{asset('asset/images/search.png')}}" alt=""></button>
		</form>
	</div>
	<!-- Navigation -->
	
	<div class="menu_nav" id="app">
		<ul>
			{{--<li><a href="categorias?categoria=mujeres">Mujeres</a></li>
			<li><a href="categorias?categoria=hombres">Hombres</a></li>
			<li><a href="categorias?categoria=niños">Niños</a></li>	--}}
			<li><a href="" v-on:click.prevent="setCategory('mujeres')">Mujeres</a></li>
			{{--<li><a href="" v-on:click.prevent="redirect('Hombres')">Hombres</a></li>
			<li><a href="" v-on:click.prevent="redirect('Niños')">Niños</a></li>--}}	
		</ul>
	</div>

	<!-- Contact Info -->
	<div class="menu_contact">
		<div class="menu_phone d-flex flex-row align-items-center justify-content-start">
			<div><div><img src="{{asset('asset/images/phone.svg')}} " alt="https://www.flaticon.com/authors/freepik"></div></div>
			<div>+57 313-864-5929</div>
		</div>
		<div class="menu_social">
			<ul class="menu_social_list d-flex flex-row align-items-start justify-content-start">
				<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
			</ul>
		</div>
	</div>
</div>
