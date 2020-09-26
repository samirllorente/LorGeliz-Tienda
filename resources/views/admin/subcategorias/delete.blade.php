<form action="{{ route('subcategory.destroy',  $subcategoria) }}" method="POST">
	@csrf
	@method('DELETE')
	<button type="submit" class="btn btn-danger text-white"  title="eliminar categoría">
		<i class="fas fa-trash"></i>
	</button>
</form>