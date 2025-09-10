@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/inventory-tabs.js') }}"></script>
<script>
    $(document).ready(function() {
        // Activar la pestaña especificada por el controlador o por parámetros de URL
        @if(isset($activeTab) || request()->has('tab'))
            var tabToActivate = '{{ $activeTab ?? request('tab') }}';
            $('#inventoryTabs a[href="#' + tabToActivate + '"]').tab('show');
        @endif
        
        // Aplicar filtro automáticamente cuando cambia el select de almacén
        $('#warehouse_filter').on('change', function() {
            $('#warehouse-filter-form').submit();
        });
        
        // Aplicar filtro automáticamente cuando cambia el select de producto
        $('#product_filter').on('change', function() {
            $('#product-filter-form').submit();
        });
    });
</script>
@endsection

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
                    <a class="nav-link {{ (!isset($activeTab) && !request()->has('tab')) ? 'active' : '' }}" data-toggle="tab" href="#movements">
                        <i class="fas fa-list me-2"></i>Movimientos de Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (isset($activeTab) && $activeTab == 'stock') || request('tab') == 'stock' ? 'active' : '' }}" data-toggle="tab" href="#stock">
                        <i class="fas fa-chart-bar me-2"></i>Stock por Almacén
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (isset($activeTab) && $activeTab == 'total-stock') || request('tab') == 'total-stock' ? 'active' : '' }}" data-toggle="tab" href="#total-stock">
                        <i class="fas fa-pie-chart me-2"></i>Stock Total por Producto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (isset($activeTab) && $activeTab == 'new-movement') || request('tab') == 'new-movement' ? 'active' : '' }}" data-toggle="tab" href="#new-movement">
                        <i class="fas fa-plus me-2"></i>Nuevo Movimiento
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (isset($activeTab) && $activeTab == 'new-product') || request('tab') == 'new-product' ? 'active' : '' }}" data-toggle="tab" href="#new-product">
                        <i class="fas fa-box-open me-2"></i>Nuevo Producto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (isset($activeTab) && $activeTab == 'new-warehouse') || request('tab') == 'new-warehouse' ? 'active' : '' }}" data-toggle="tab" href="#new-warehouse">
                        <i class="fas fa-warehouse me-2"></i>Nuevo Almacén
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Pestaña de Movimientos -->
                <div class="tab-pane fade {{ (!isset($activeTab) && !request()->has('tab')) ? 'show active' : '' }}" id="movements">
                    @include('inventory.tabs.movements')
                </div>

                <!-- Pestaña de Stock por Almacén -->
                <div class="tab-pane fade {{ (isset($activeTab) && $activeTab == 'stock') || request('tab') == 'stock' ? 'show active' : '' }}" id="stock">
                    @include('inventory.tabs.stock')
                </div>

                <!-- Pestaña de Stock Total -->
                <div class="tab-pane fade {{ (isset($activeTab) && $activeTab == 'total-stock') || request('tab') == 'total-stock' ? 'show active' : '' }}" id="total-stock">
                    @include('inventory.tabs.total-stock')
                </div>

                <!-- Pestaña de Nuevo Movimiento -->
                <div class="tab-pane fade {{ (isset($activeTab) && $activeTab == 'new-movement') || request('tab') == 'new-movement' ? 'show active' : '' }}" id="new-movement">
                    @include('inventory.tabs.new-movement')
                </div>

                <!-- Pestaña de Nuevo Producto -->
                <div class="tab-pane fade {{ (isset($activeTab) && $activeTab == 'new-product') || request('tab') == 'new-product' ? 'show active' : '' }}" id="new-product">
                    @include('inventory.tabs.new-product')
                </div>

                <!-- Pestaña de Nuevo Almacén -->
                <div class="tab-pane fade {{ (isset($activeTab) && $activeTab == 'new-warehouse') || request('tab') == 'new-warehouse' ? 'show active' : '' }}" id="new-warehouse">
                    @include('inventory.tabs.new-warehouse')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection