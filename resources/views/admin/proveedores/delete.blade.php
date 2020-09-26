<form action="{{ route('proveedor.destroy', $proveedor)}}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger text-white"  title="eliminar proveedor">
        Eliminar
    </button>
</form>