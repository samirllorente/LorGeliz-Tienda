<form action="{{ route('category.destroy',  $categoria->id) }}" method="POST"> 
	{{-- route('category.destroy',  $categoria) --}}
	@csrf
	@method('DELETE')
	<button type="submit" class="btn btn-danger text-white"  title="eliminar categoría">
		<i class="fas fa-trash"></i>
	</button>
</form>