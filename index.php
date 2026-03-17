<?php
$page = $_GET["page"] ?? "productos";
$valid = ["productos", "categorias"];
if (!in_array($page, $valid)) $page = "productos";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel | Productos & Categorías</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php?page=productos" class="nav-link">Inicio</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link text-muted">Zelko APP</span>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php?page=productos" class="brand-link">
      <span class="brand-text font-weight-light">Mi Panel</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="index.php?page=productos" class="nav-link <?php echo $page === 'productos' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-box"></i>
              <p>Productos</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="index.php?page=categorias" class="nav-link <?php echo $page === 'categorias' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tags"></i>
              <p>Categorías</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1 class="m-0 text-dark"><?php echo ucfirst($page); ?></h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">

        <?php if ($page === "productos"): ?>

          <div class="card">
            <div class="card-header">
              <button class="btn btn-primary btn-sm" id="btnNuevoProducto">
                <i class="fas fa-plus"></i> Nuevo
              </button>

              <div class="card-tools" style="width: 260px;">
                <div class="input-group input-group-sm">
                  <input type="text" id="busquedaProductos" class="form-control" placeholder="Buscar...">
                  <div class="input-group-append">
                    <button class="btn btn-default" type="button" id="btnLimpiarProductos">
                      <i class="fas fa-eraser"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Categoría</th>
                    <th class="text-right">Precio</th>
                    <th class="text-right">Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody id="tbodyProductos"></tbody>
              </table>
            </div>
          </div>

          <div class="modal fade" id="modalProducto" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="tituloProducto">Producto</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">
                  <form id="formProducto">
                    <input type="hidden" id="p_id">

                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label>SKU*</label>
                        <input class="form-control" id="p_sku" required>
                      </div>

                      <div class="form-group col-md-8">
                        <label>Nombre*</label>
                        <input class="form-control" id="p_nombre" required>
                      </div>

                      <div class="form-group col-md-4">
                        <label>Marca*</label>
                        <input class="form-control" id="p_marca" required>
                      </div>

                      <div class="form-group col-md-4">
                        <label>Categoría*</label>
                        <select class="form-control" id="p_categoria" required>
                          <option value="">Seleccione una categoría</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4">
                        <label>Estado</label>
                        <select class="form-control" id="p_estado">
                          <option>Activo</option>
                          <option>Inactivo</option>
                        </select>
                      </div>

                      <div class="form-group col-12">
                        <label>Descripción</label>
                        <textarea class="form-control" id="p_descripcion" rows="2"></textarea>
                      </div>

                      <div class="form-group col-md-4">
                        <label>Precio*</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="p_precio" required>
                      </div>

                      <div class="form-group col-md-4">
                        <label>Stock</label>
                        <input type="number" min="0" class="form-control" id="p_stock" value="0">
                      </div>

                      <div class="form-group col-md-4">
                        <label>Garantía</label>
                        <input type="number" min="0" class="form-control" id="p_garantia" value="12">
                      </div>
                    </div>
                  </form>
                </div>

                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button class="btn btn-primary" id="btnGuardarProducto">Guardar</button>
                </div>
              </div>
            </div>
          </div>

        <?php else: ?>

          <div class="card">
            <div class="card-header">
              <button class="btn btn-primary btn-sm" id="btnNuevaCategoria">
                <i class="fas fa-plus"></i> Nueva
              </button>

              <div class="card-tools" style="width: 260px;">
                <div class="input-group input-group-sm">
                  <input type="text" id="busquedaCategorias" class="form-control" placeholder="Buscar...">
                  <div class="input-group-append">
                    <button class="btn btn-default" type="button" id="btnLimpiarCategorias">
                      <i class="fas fa-eraser"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody id="tbodyCategorias"></tbody>
              </table>
            </div>
          </div>

          <div class="modal fade" id="modalCategoria" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="tituloCategoria">Categoría</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">
                  <form id="formCategoria">
                    <input type="hidden" id="c_id">

                    <div class="form-group">
                      <label>Nombre*</label>
                      <input class="form-control" id="c_nombre" required>
                    </div>

                    <div class="form-group">
                      <label>Descripción</label>
                      <input class="form-control" id="c_descripcion">
                    </div>

                    <div class="form-group">
                      <label>Estado</label>
                      <select class="form-control" id="c_estado">
                        <option>Activo</option>
                        <option>Inactivo</option>
                      </select>
                    </div>
                  </form>
                </div>

                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button class="btn btn-primary" id="btnGuardarCategoria">Guardar</button>
                </div>
              </div>
            </div>
          </div>

        <?php endif; ?>

      </div>
    </section>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<?php if ($page === "productos"): ?>
  <script src="assets/js/productos.js?v=1"></script>
<?php else: ?>
  <script src="assets/js/categorias.js?v=1"></script>
<?php endif; ?>

</body>
</html>