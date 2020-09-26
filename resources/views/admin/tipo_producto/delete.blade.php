<form action="{{ route('tipo.destroy',  $tipo) }}" method="POST">
	@csrf
	@method('DELETE')
	<button type="submit" class="btn btn-danger text-white"  title="eliminar tipo">
		<i class="fas fa-trash"></i>
	</button>
</form>