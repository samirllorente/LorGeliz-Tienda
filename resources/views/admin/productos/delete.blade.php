<form action="{{ route('product.destroy',  $producto) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger text-white"  title="eliminar producto">
        <i class="fas fa-trash"></i>
    </button>
</form>