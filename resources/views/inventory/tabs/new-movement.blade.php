<!-- Pestaña de Nuevo Movimiento -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-plus me-2"></i> Registrar Nuevo Movimiento</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="product_id" class="form-label">
                            <i class="fas fa-box"></i>&nbsp;&nbsp;Producto *
                        </label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            <option value="">Selecciona un producto...</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->sku }} - {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="warehouse_id" class="form-label">
                            <i class="fas fa-warehouse"></i>&nbsp;&nbsp;Almacén *
                        </label>
                        <select name="warehouse_id" id="warehouse_id" class="form-control" required>
                            <option value="">Selecciona un almacén...</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="type" class="form-label">
                            <i class="fas fa-exchange-alt"></i>&nbsp;&nbsp;Tipo de Movimiento *
                        </label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="">Selecciona el tipo...</option>
                            <option value="IN" {{ old('type') == 'IN' ? 'selected' : '' }}>ENTRADA</option>
                            <option value="OUT" {{ old('type') == 'OUT' ? 'selected' : '' }}>SALIDA</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="quantity" class="form-label">
                            <i class="fas fa-hashtag"></i>&nbsp;&nbsp;Cantidad *
                        </label>
                        <input type="number" name="quantity" id="quantity" class="form-control" 
                               min="1" value="{{ old('quantity') }}" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="reference" class="form-label">
                            <i class="fas fa-sticky-note"></i>&nbsp;&nbsp;Referencia
                        </label>
                        <input type="text" name="reference" id="reference" class="form-control" 
                               value="{{ old('reference') }}" placeholder="Descripción del movimiento...">
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-dormitorum btn-lg btn-block">
                            <i class="fas fa-save"></i>&nbsp;&nbsp;Registrar Movimiento
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
