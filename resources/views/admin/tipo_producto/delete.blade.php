<form action="{{ route('tipo.destroy',  $tipo->id) }}" method="POST">
	{{-- route('tipo.destroy',  $tipo) --}}
	@csrf
	@method('DELETE')
	<button type="submit" class="btn btn-danger text-white"  title="eliminar tipo">
		<i class="fas fa-trash"></i>
	</button>
</form>