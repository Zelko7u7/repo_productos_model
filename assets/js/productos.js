const API = "api/productos.php";
const API_CAT = "api/categorias.php";

let productos = [];
let categorias = [];

const tbody = document.getElementById("tbodyProductos");
const q = document.getElementById("busquedaProductos");
const modal = $("#modalProducto");

document.addEventListener("DOMContentLoaded", async () => {
  await cargarCategorias();
  await cargar();

  q.addEventListener("input", filtrar);

  document.getElementById("btnLimpiarProductos").addEventListener("click", () => {
    q.value = "";
    pintar(productos);
  });

  document.getElementById("btnNuevoProducto").addEventListener("click", async () => {
    await cargarCategorias();
    document.getElementById("tituloProducto").textContent = "Nuevo producto";
    limpiarForm();
    modal.modal("show");
  });

  document.getElementById("btnGuardarProducto").addEventListener("click", guardar);
});

async function cargarCategorias() {
  try {
    const res = await fetch(API_CAT, { cache: "no-store" });
    const json = await res.json();

    if (!json.ok) {
      alert(json.error || "Error al cargar categorías");
      categorias = [];
    } else {
      categorias = json.data || [];
    }

    const sel = document.getElementById("p_categoria");
    sel.innerHTML =
      '<option value="">Seleccione una categoría</option>' +
      categorias.map(c => `<option value="${c.id}">${esc(c.nombre)}</option>`).join("");
  } catch (e) {
    console.error(e);
    alert("No se pudieron cargar las categorías");
  }
}

async function cargar() {
  try {
    const res = await fetch(API, { cache: "no-store" });
    const json = await res.json();

    if (!json.ok) {
      alert(json.error || "Error al cargar productos");
      productos = [];
    } else {
      productos = json.data || [];
    }

    pintar(productos);
  } catch (e) {
    console.error(e);
    alert("No se pudieron cargar los productos");
  }
}

function pintar(lista) {
  tbody.innerHTML = lista.map(p => `
    <tr>
      <td>${p.id}</td>
      <td>${esc(p.sku)}</td>
      <td>${esc(p.nombre)}</td>
      <td>${esc(p.marca)}</td>
      <td>${esc(p.categoria_nombre || "")}</td>
      <td class="text-right">$ ${isNaN(Number(p.precio)) ? "0.00" : Number(p.precio).toFixed(2)}</td>
      <td class="text-right">${p.stock}</td>
      <td>${esc(p.estado)}</td>
      <td>
        <button class="btn btn-sm btn-outline-primary" onclick="editar(${p.id})">Editar</button>
        <button class="btn btn-sm btn-outline-danger" onclick="borrar(${p.id})">Eliminar</button>
      </td>
    </tr>
  `).join("");
}

function filtrar() {
  const term = norm(q.value);
  if (!term) return pintar(productos);

  const f = productos.filter(p =>
    norm(`${p.sku} ${p.nombre} ${p.marca} ${p.categoria_nombre || ""} ${p.estado}`).includes(term)
  );
  pintar(f);
}

async function editar(id) {
  try {
    await cargarCategorias();

    const res = await fetch(`${API}?id=${id}`, { cache: "no-store" });
    const json = await res.json();

    if (!json.ok) return alert(json.error || "Error al cargar producto");

    const p = json.data;
    document.getElementById("tituloProducto").textContent = `Editar #${p.id}`;
    document.getElementById("p_id").value = p.id;
    document.getElementById("p_sku").value = p.sku || "";
    document.getElementById("p_nombre").value = p.nombre || "";
    document.getElementById("p_marca").value = p.marca || "";
    document.getElementById("p_categoria").value = String(p.categoria_id || "");
    document.getElementById("p_estado").value = p.estado || "Activo";
    document.getElementById("p_descripcion").value = p.descripcion || "";
    document.getElementById("p_precio").value = p.precio || "";
    document.getElementById("p_stock").value = p.stock || 0;
    document.getElementById("p_garantia").value = p.garantia_meses || 12;

    modal.modal("show");
  } catch (e) {
    console.error(e);
    alert("No se pudo cargar el producto");
  }
}

async function guardar() {
  const precioTxt = document.getElementById("p_precio").value.trim();

  const data = {
    id: document.getElementById("p_id").value ? Number(document.getElementById("p_id").value) : null,
    sku: document.getElementById("p_sku").value.trim(),
    nombre: document.getElementById("p_nombre").value.trim(),
    marca: document.getElementById("p_marca").value.trim(),
    categoria_id: Number(document.getElementById("p_categoria").value),
    estado: document.getElementById("p_estado").value,
    descripcion: document.getElementById("p_descripcion").value.trim(),
    precio: precioTxt === "" ? null : Number(precioTxt),
    stock: Number(document.getElementById("p_stock").value || 0),
    garantia_meses: Number(document.getElementById("p_garantia").value || 12)
  };

  const method = data.id ? "PUT" : "POST";

  try {
    const res = await fetch(API, {
      method,
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    });

    const json = await res.json();
    if (!json.ok) return alert(json.error || "Error al guardar");

    modal.modal("hide");
    await cargarCategorias();
    await cargar();
    filtrar();
  } catch (e) {
    console.error(e);
    alert("No se pudo guardar el producto");
  }
}

async function borrar(id) {
  if (!confirm("¿Eliminar producto?")) return;

  try {
    const res = await fetch(API, {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id })
    });

    const json = await res.json();
    if (!json.ok) return alert(json.error || "Error al eliminar");

    await cargar();
    filtrar();
  } catch (e) {
    console.error(e);
    alert("No se pudo eliminar el producto");
  }
}

function limpiarForm() {
  ["p_id", "p_sku", "p_nombre", "p_marca", "p_descripcion", "p_precio"].forEach(id => {
    document.getElementById(id).value = "";
  });

  document.getElementById("p_categoria").value = "";
  document.getElementById("p_estado").value = "Activo";
  document.getElementById("p_stock").value = 0;
  document.getElementById("p_garantia").value = 12;
}

function norm(s) {
  return (s || "").toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim();
}

function esc(s) {
  return String(s ?? "")
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}