<!-- Pestaña de Stock por Almacén -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-chart-bar me-2"></i> Stock por Producto y Almacén</h5>
    </div>
    <div class="card-body">
        <!-- Filtro de Almacén -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4">
                <form method="GET" action="{{ route('inventory.index') }}" id="warehouse-filter-form" class="d-flex align-items-end">
                    <input type="hidden" name="tab" value="stock">
                    <div class="form-group me-2 flex-grow-1">
                        <label for="warehouse_filter" class="form-label">
                            <i class="fas fa-warehouse me-1"></i>Filtrar por Almacén
                        </label>
                        <select name="warehouse_filter" id="warehouse_filter" class="form-control">
                            <option value="">Todos los almacenes</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ request('warehouse_filter') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                 
                </form>
            </div>
            <div class="col-md-6 col-lg-8 d-flex align-items-end">
                @if(request()->has('warehouse_filter') && request('warehouse_filter') != '')
                    <div class="ms-auto">
                        <a href="{{ route('inventory.index', ['tab' => 'stock']) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Limpiar filtro
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th>Almacén</th>
                        <th>Stock Disponible</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @if(request()->has('warehouse_filter') && request('warehouse_filter') != '')
                        @php
                            $selectedWarehouse = $warehouses->firstWhere('id', request('warehouse_filter'));
                            $warehouseName = $selectedWarehouse ? $selectedWarehouse->name : 'Seleccionado';
                        @endphp
                        <tr class="table-info">
                            <td colspan="5" class="fw-bold">
                                <i class="fas fa-filter me-1"></i>Mostrando productos en almacén: {{ $warehouseName }}
                            </td>
                        </tr>
                    @endif

                    @forelse ($stockByProductWarehouse as $stock)
                        <tr>
                            <td>
                                <strong>{{ Str::limit($stock->product_name, 40) }}</strong>
                            </td>
                            <td>
                                <span class="product-sku">{{ $stock->product_sku }}</span>
                            </td>
                            <td>
                                <span class="warehouse-badge">{{ $stock->warehouse_name }}</span>
                                <small class="text-muted d-block">{{ $stock->warehouse_code }}</small>
                            </td>
                            <td>
                                <h5 class="mb-0">
                                    <span class="badge {{ $stock->stock > 20 ? 'bg-success' : ($stock->stock > 5 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $stock->stock }} unidades
                                    </span>
                                </h5>
                            </td>
                            <td>
                                @if($stock->stock > 20)
                                    <span class="stock-high"><i class="fas fa-check-circle me-1"></i>Stock Alto</span>
                                @elseif($stock->stock > 5)
                                    <span class="stock-medium"><i class="fas fa-exclamation-triangle me-1"></i>Stock Medio</span>
                                @else
                                    <span class="stock-low"><i class="fas fa-exclamation-circle me-1"></i>Stock Bajo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-3x mb-3"></i>
                                <br>No hay productos con stock disponible
                                @if(request()->has('warehouse_filter') && request('warehouse_filter') != '')
                                    en el almacén seleccionado
                                @endif
                            </td>
                        </tr>
                    @endforelse

                    @if($stockByProductWarehouse->count() > 0)
                        <tr class="table-secondary">
                            <td colspan="3" class="text-end fw-bold">Total de unidades:</td>
                            <td colspan="2">
                                <span class="badge bg-primary">{{ $stockByProductWarehouse->sum('stock') }} unidades</span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>