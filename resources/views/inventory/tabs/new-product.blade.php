<!-- Pestaña de Nuevo Producto -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-box-open me-2"></i> Registrar Nuevo Producto</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="sku_product" class="form-label">
                            <i class="fas fa-barcode"></i>&nbsp;&nbsp;SKU del Producto *
                        </label>
                        <input type="text" 
                                name="sku" 
                                id="sku_product" 
                                class="form-control" 
                                value="{{ old('sku') }}" 
                                placeholder="Ej: COL-001, ALM-002" 
                                required>
                        <small class="form-text text-muted">
                            Código único del producto (se convertirá a mayúsculas)
                        </small>
                    </div>

                    <div class="form-group mb-4">
                        <label for="name_product" class="form-label">
                            <i class="fas fa-tag"></i>&nbsp;&nbsp;Nombre del Producto *
                        </label>
                        <input type="text" 
                                name="name" 
                                id="name_product" 
                                class="form-control" 
                                value="{{ old('name') }}" 
                                placeholder="Ej: Colchón Memory Foam Premium" 
                                required>
                        <small class="form-text text-muted">
                            Nombre descriptivo del producto
                        </small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="alert alert-info">
                        <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Información</h5>
                        <p>Los productos son utilizados para gestionar el inventario en todos los almacenes.</p>
                        <hr>
                        <p class="mb-0">Una vez creado, podrás registrar movimientos de entrada y salida para este producto.</p>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-save"></i>&nbsp;&nbsp;Registrar Producto
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5><i class="fas fa-list me-2"></i>Productos Existentes</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><span class="badge bg-secondary">{{ $product->sku }}</span></td>
                            <td>{{ $product->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-3x mb-3"></i>
                                <br>No hay productos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
