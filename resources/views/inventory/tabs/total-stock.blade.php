<!-- Pestaña de Stock Total -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-pie-chart me-2"></i> Stock Total por Producto</h5>
    </div>
    <div class="card-body">
        <!-- Filtro de Producto -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4">
                <form method="GET" action="{{ route('inventory.index') }}" id="product-filter-form" class="d-flex align-items-end">
                    <input type="hidden" name="tab" value="total-stock">
                    <div class="form-group me-2 flex-grow-1">
                        <label for="product_filter" class="form-label">
                            <i class="fas fa-box me-1"></i>Filtrar por Producto
                        </label>
                        <select name="product_filter" id="product_filter" class="form-control">
                            <option value="">Todos los productos</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_filter') == $product->id ? 'selected' : '' }}>
                                    {{ $product->sku }} - {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Stock por Producto -->
        <div class="table-responsive stock-percentage-table">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th>Stock Total</th>
                        <th>Porcentaje</th>
                        <th>Distribución Visual</th>
                        <th>Estado General</th>
                    </tr>
                </thead>
                <tbody>
                    @if(request()->has('product_filter') && request('product_filter') != '')
                        @php
                            $selectedProduct = $products->firstWhere('id', request('product_filter'));
                            $productName = $selectedProduct ? $selectedProduct->name : 'Seleccionado';
                            $productSku = $selectedProduct ? $selectedProduct->sku : '';
                        @endphp
                        <tr class="table-info">
                            <td colspan="6" class="fw-bold">
                                <i class="fas fa-filter me-1"></i>Mostrando información del producto: {{ $productName }} ({{ $productSku }})
                            </td>
                        </tr>
                    @endif

                    @forelse ($stockByProduct as $stock)
                        @php
                            $percentage = $totalStock > 0 ? round(($stock->total_stock / $totalStock) * 100, 2) : 0;
                            $minBarWidth = max($percentage, 2); // Mínimo 2% de ancho visible
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ Str::limit($stock->product_name, 40) }}</strong>
                            </td>
                            <td>
                                <span class="product-sku">{{ $stock->product_sku }}</span>
                            </td>
                            <td>
                                <h5 class="mb-0">
                                    <span class="badge bg-primary">{{ $stock->total_stock }} unidades</span>
                                </h5>
                            </td>
                            <td>
                                <span class="percentage-value">{{ $percentage }}%</span>
                            </td>
                            <td>
                                <div class="percentage-display">
                                    <div class="progress percentage-bar">
                                        <div class="progress-bar" 
                                             style="width: {{ $minBarWidth }}%;" 
                                             data-percentage="{{ $percentage }}%">
                                            @if($percentage >= 3)
                                                {{ $percentage }}%
                                            @endif
                                        </div>
                                    </div>
                                    @if($percentage < 3)
                                        <small class="text-muted">{{ $percentage }}%</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($stock->total_stock > 50)
                                    <span class="text-success"><i class="fas fa-thumbs-up me-1"></i>Excelente</span>
                                @elseif($stock->total_stock > 20)
                                    <span class="text-info"><i class="fas fa-info-circle me-1"></i>Bueno</span>
                                @elseif($stock->total_stock > 10)
                                    <span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Regular</span>
                                @else
                                    <span class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>Crítico</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-chart-line fa-3x mb-3"></i>
                                <br>No hay datos de stock disponibles
                                @if(request()->has('product_filter') && request('product_filter') != '')
                                    para el producto seleccionado
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Detalles por almacén cuando se filtra por producto -->
        @if(request()->has('product_filter') && request('product_filter') != '' && $productStockByWarehouse->count() > 0)
            <div class="mt-4">
                <h5 class="mb-3"><i class="fas fa-cubes me-2"></i>Distribución por Almacén</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Almacén</th>
                                <th>Código</th>
                                <th>Stock en Ubicación</th>
                                <th>% del Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalProductStock = $productStockByWarehouse->sum('warehouse_stock');
                            @endphp
                            
                            @foreach($productStockByWarehouse as $warehouseStock)
                                @php
                                    $warehousePercentage = $totalProductStock > 0 ? round(($warehouseStock->warehouse_stock / $totalProductStock) * 100, 2) : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $warehouseStock->warehouse_name }}</strong>
                                    </td>
                                    <td>
                                        <span class="warehouse-code">{{ $warehouseStock->warehouse_code }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $warehouseStock->warehouse_stock > 20 ? 'bg-success' : ($warehouseStock->warehouse_stock > 5 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $warehouseStock->warehouse_stock }} unidades
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{ $warehousePercentage }}%;">
                                                {{ $warehousePercentage }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                            <!-- Fila de total -->
                            <tr class="table-secondary">
                                <td colspan="2" class="text-end fw-bold">Total:</td>
                                <td>
                                    <span class="badge bg-primary">{{ $totalProductStock }} unidades</span>
                                </td>
                                <td>100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>