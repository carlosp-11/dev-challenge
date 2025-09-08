# Laravel Inventory Management Challenge (Base incluida)

Este repositorio ya viene con una base de **Laravel 6** y autenticación lista para usar, además de modelos, rutas, un servicio y una vista inicial. Tu objetivo es **completar lo pendiente** para listar movimientos de inventario, calcular stock y registrar nuevos movimientos.

> ⏱ **Tiempo orientativo:** 60 minutos. Si no llegas, sube lo que tengas y deja notas breves de lo pendiente.

---

## 🧩 Qué ya viene hecho en el repositorio

- **Auth y layout** (Bootstrap cargado vía CDN en `resources/views/layouts/app.blade.php`).
- **Rutas** en `routes/web.php` (protegidas por `auth`):
  - `GET /home` → `InventoryController@index`
  - `POST /inventory/move` → `InventoryController@store`
- **Modelos Eloquent**:
  - `App\Models\Product` (relación `hasMany` con movimientos)
  - `App\Models\Warehouse` (relación `hasMany` con movimientos)
  - `App\Models\InventoryMovement` (fillable, casts y belongsTo)
- **Servicio**: `App\Services\InventoryService` con método `registerMovement(...)`.
- **Vista**: `resources/views/inventory.blade.php`.
- **Migraciones** de `products`, `warehouses`, `inventory_movements` con inserciones/semillas mínimas esbozadas.
- **Front**: assets básicos ya generados en `public/`.

---

## 🛠️ Lo que debes implementar

### 1) `InventoryController@index`
- Consultar movimientos paginados con `with(['product','warehouse'])`.
- (Opcional) Filtros por producto, almacén, tipo y rango de fechas.
- Calcular stock agregado por producto/almacén y total por producto (puede ser con una query agregada o un servicio).
- Pasar los datos a la vista `inventory.blade.php`.

### 2) `resources/views/inventory.blade.php`
- Renderizar **tabla de movimientos**.
- Renderizar **tabla de stock** por producto/almacén (y total por producto).

### 3) Migraciones/semillas mínimas
- Ya tienes las migraciones con datos de pruebas

---

## 🧮 Sugerencia de query para stock

```sql
SELECT
  im.product_id,
  im.warehouse_id,
  SUM(CASE WHEN im.type = 'IN'  THEN im.quantity ELSE 0 END)
  - SUM(CASE WHEN im.type = 'OUT' THEN im.quantity ELSE 0 END) AS stock
FROM inventory_movements im
GROUP BY im.product_id, im.warehouse_id;
```

> Puedes encapsularla en un servicio/repositorio o usar `selectRaw` con Eloquent.

---

## 🚀 Puesta en marcha

1. **Requisitos**: **PHP 7.2+**, Composer, una BD (SQL Server).
2. **Configura entorno**:
   ```bash
   # Encontrarás el fichero .env en el escritorio del ordenador ya configurado.*
   composer install
   php artisan migrate
   npm install
   npm run dev
   php artisan serve
   ```
3. **Usuario de acceso**:
   ```
   Correo: admin@example.com
   Contraseña: password
   ```
4. **Entrar a la app**:
   - Accede a `/home` (requiere login).
5. **Acceso a la base de datos (SQL Server)**:
   ```
   Host: dev.dormiwin.com
   Base de datos: DEV_TEST
   Usuario: dev_test
   Contraseña: password@2025
   ```

---

## 🖥️ UI/UX esperado

- Bootstrap (ya está incluido en el layout).
- Tabla de **movimientos** con paginación y, si te da tiempo, filtros.
- Sección de **stock** por producto/almacén y total por producto.
- Formulario de alta de movimiento en la misma página.
- **Opcional**: CRUD básico de datos maestros (productos y almacenes).

---

## 🧪 Pruebas (opcionales)

- Feature tests para `POST /inventory/move` (IN/OUT y negativo).
- Cálculo de stock correcto con combinaciones IN/OUT.
- Filtros en el listado.

---

## 📦 Entregables

- Commit de los cambios realizados.
- Crear un Pull Request en una rama nueva con tu nombre y apellidos, con el siguiente formato de ejemplo: `(christian_gomez)`.

---

## ℹ️ Dudas

- Cualquier duda, puedes plantearlas a **Christian Gómez**.
- Puedes usar cualquier tipo de información de Internet.
- **No está permitido** usar herramientas de inteligencia artificial durante el desarrollo del ejercicio.

---

¡Listo! Completa los puntos marcados y deja la vista funcional. ¡Suerte! 🚀
