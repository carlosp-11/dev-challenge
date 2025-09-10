<!-- Pestaña de Movimientos -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-filter me-2"></i>Filtros de Búsqueda</h5>
    </div>
    <div class="card-body filters-section">
        <form method="GET" action="{{ route('inventory.index') }}">
            <div class="row">
                <div class="col-lg-2 col-md-4 mb-3">
                    <label class="form-label">Producto</label>
                    <select name="product_id" class="form-control">
                        <option value="">Todos los productos</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->sku }} - {{ Str::limit($product->name, 30) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 mb-3">
                    <label class="form-label">Almacén</label>
                    <select name="warehouse_id" class="form-control">
                        <option value="">Todos los almacenes</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 mb-3">
                    <label class="form-label">Tipo</label>
                    <select name="type" class="form-control">
                        <option value="">Todos los tipos</option>
                        <option value="IN" {{ request('type') == 'IN' ? 'selected' : '' }}>Entrada</option>
                        <option value="OUT" {{ request('type') == 'OUT' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-lg-2 col-md-12 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="btn-group-vertical w-100" role="group">
                        <button type="submit" class="btn btn-primary mb-2">
                            <i class="fas fa-search"></i>&nbsp;&nbsp;Filtrar
                        </button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>&nbsp;&nbsp;Limpiar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5><i class="fas fa-list me-2"></i>Historial de Movimientos ({{ $movements->total() }} registros)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th>Almacén</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Referencia</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movements as $movement)
                        <tr>
                            <td>
                                <small class="text-muted">
                                    {{ $movement->moved_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td>
                                <strong>{{ Str::limit($movement->product->name, 40) }}</strong>
                            </td>
                            <td>
                                <span class="product-sku">{{ $movement->product->sku }}</span>
                            </td>
                            <td>
                                <span class="warehouse-badge">{{ $movement->warehouse->name }}</span>
                            </td>
                            <td>
                                @if($movement->type === 'IN')
                                    <span class="badge bg-success">
                                        <i class="fas fa-arrow-down me-1"></i>ENTRADA
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-arrow-up me-1"></i>SALIDA
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong class="{{ $movement->type === 'IN' ? 'movement-type-in' : 'movement-type-out' }}">
                                    {{ $movement->type === 'IN' ? '+' : '-' }}{{ $movement->quantity }}
                                </strong>
                            </td>
                            <td>
                                <small>{{ $movement->reference ?: 'Sin referencia' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <br>No se encontraron movimientos con los filtros aplicados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($movements->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $movements->links() }}
            </div>
        @endif
    </div>
</div>
