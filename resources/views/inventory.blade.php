@extends('layouts.app')

@section('content')
<div class="container-fluid inventory-dashboard">
    <div class="row">
        <div class="col-12">
            <div class="header-brand fade-in">
                <i class="fas fa-warehouse"></i>Sistema de Gestión de Inventario
            </div>

        @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Errores de validación:</h5>
                    <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('ok'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('ok') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

            <!-- Estadísticas Generales -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card stats-card bg-primary text-white slide-in">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h4>{{ $totalProducts }}</h4>
                                <span>Productos</span>
                            </div>
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stats-card bg-secondary text-white slide-in" style="animation-delay: 0.1s">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h4>{{ $totalWarehouses }}</h4>
                                <span>Almacenes</span>
                            </div>
                            <i class="fas fa-warehouse fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stats-card bg-success text-white slide-in" style="animation-delay: 0.2s">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h4>{{ $totalMovements }}</h4>
                                <span>Movimientos</span>
                            </div>
                            <i class="fas fa-exchange-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stats-card bg-warning text-white slide-in" style="animation-delay: 0.3s">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h4>{{ $totalStock }}</h4>
                                <span>Stock Total</span>
                            </div>
                            <i class="fas fa-cubes fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs de Navegación -->
            <ul class="nav nav-tabs mb-4" id="inventoryTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#movements">
                        <i class="fas fa-list me-2"></i>Movimientos de Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#stock">
                        <i class="fas fa-chart-bar me-2"></i>Stock por Almacén
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#total-stock">
                        <i class="fas fa-pie-chart me-2"></i>Stock Total por Producto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#new-movement">
                        <i class="fas fa-plus me-2"></i>Nuevo Movimiento
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Pestaña de Movimientos -->
                <div class="tab-pane fade show active" id="movements">
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
                </div>

                <!-- Pestaña de Stock por Almacén -->
                <div class="tab-pane fade" id="stock">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-bar me-2"></i>Stock por Producto y Almacén</h5>
                        </div>
                        <div class="card-body">
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
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña de Stock Total -->
                <div class="tab-pane fade" id="total-stock">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-pie-chart me-2"></i>Stock Total por Producto</h5>
                        </div>
                        <div class="card-body">
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
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña de Nuevo Movimiento -->
                <div class="tab-pane fade" id="new-movement">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus me-2"></i>Registrar Nuevo Movimiento</h5>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
