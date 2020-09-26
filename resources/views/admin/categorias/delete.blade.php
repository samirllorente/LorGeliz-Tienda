<form action="{{ route('category.destroy',  $categoria) }}" method="POST">
	@csrf
	@method('DELETE')
	<button type="submit" class="btn btn-danger text-white"  title="eliminar categoría">
		<i class="fas fa-trash"></i>
	</button>
</form>