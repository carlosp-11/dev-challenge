<!-- Pestaña de Nuevo Almacén -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-warehouse me-2"></i> Registrar Nuevo Almacén</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('warehouses.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="code_warehouse" class="form-label">
                            <i class="fas fa-qrcode"></i>&nbsp;&nbsp;Código del Almacén *
                        </label>
                        <input type="text" 
                                name="code" 
                                id="code_warehouse" 
                                class="form-control" 
                                value="{{ old('code') }}" 
                                placeholder="Ej: MAD-01, BAR-02" 
                                required>
                        <small class="form-text text-muted">
                            Código único del almacén (se convertirá a mayúsculas)
                        </small>
                    </div>

                    <div class="form-group mb-4">
                        <label for="name_warehouse" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;Nombre del Almacén *
                        </label>
                        <input type="text" 
                                name="name" 
                                id="name_warehouse" 
                                class="form-control" 
                                value="{{ old('name') }}" 
                                placeholder="Ej: Madrid Central, Barcelona Norte" 
                                required>
                        <small class="form-text text-muted">
                            Nombre descriptivo de la ubicación
                        </small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="alert alert-info">
                        <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Información</h5>
                        <p>Los almacenes son las ubicaciones físicas donde se almacenan los productos.</p>
                        <hr>
                        <p class="mb-0">Una vez creado, podrás gestionar el inventario en esta ubicación.</p>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-secondary btn-lg btn-block">
                            <i class="fas fa-save"></i>&nbsp;&nbsp;Registrar Almacén
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5><i class="fas fa-list me-2"></i>Almacenes Existentes</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warehouses as $warehouse)
                        <tr>
                            <td>{{ $warehouse->id }}</td>
                            <td><span class="badge bg-secondary">{{ $warehouse->code }}</span></td>
                            <td>{{ $warehouse->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="fas fa-warehouse fa-3x mb-3"></i>
                                <br>No hay almacenes registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
