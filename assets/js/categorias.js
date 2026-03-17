const API_C = "api/categorias.php";
let categorias = [];

const tbodyC = document.getElementById("tbodyCategorias");
const qC = document.getElementById("busquedaCategorias");
const modalC = $("#modalCategoria");

document.addEventListener("DOMContentLoaded", async () => {
  await cargarC();

  qC.addEventListener("input", filtrarC);

  document.getElementById("btnLimpiarCategorias").addEventListener("click", () => {
    qC.value = "";
    pintarC(categorias);
  });

  document.getElementById("btnNuevaCategoria").addEventListener("click", () => {
    document.getElementById("tituloCategoria").textContent = "Nueva categoría";
    limpiarFormC();
    modalC.modal("show");
  });

  document.getElementById("btnGuardarCategoria").addEventListener("click", guardarC);
});

async function cargarC() {
  try {
    const res = await fetch(API_C, { cache: "no-store" });
    const json = await res.json();

    if (!json.ok) {
      alert(json.error || "Error al cargar categorías");
      categorias = [];
    } else {
      categorias = json.data || [];
    }

    pintarC(categorias);
  } catch (e) {
    console.error(e);
    alert("No se pudieron cargar las categorías");
  }
}

function pintarC(lista) {
  tbodyC.innerHTML = lista.map(c => `
    <tr>
      <td>${c.id}</td>
      <td>${esc(c.nombre)}</td>
      <td>${esc(c.descripcion || "")}</td>
      <td>${esc(c.estado)}</td>
      <td>
        <button class="btn btn-sm btn-outline-primary" onclick="editarC(${c.id})">Editar</button>
        <button class="btn btn-sm btn-outline-danger" onclick="borrarC(${c.id})">Eliminar</button>
      </td>
    </tr>
  `).join("");
}

function filtrarC() {
  const term = norm(qC.value);
  if (!term) return pintarC(categorias);

  const f = categorias.filter(c =>
    norm(`${c.nombre} ${c.descripcion || ""} ${c.estado}`).includes(term)
  );
  pintarC(f);
}

async function editarC(id) {
  try {
    const res = await fetch(`${API_C}?id=${id}`, { cache: "no-store" });
    const json = await res.json();

    if (!json.ok) return alert(json.error || "Error al cargar categoría");

    const c = json.data;
    document.getElementById("tituloCategoria").textContent = `Editar #${c.id}`;
    document.getElementById("c_id").value = c.id;
    document.getElementById("c_nombre").value = c.nombre || "";
    document.getElementById("c_descripcion").value = c.descripcion || "";
    document.getElementById("c_estado").value = c.estado || "Activo";

    modalC.modal("show");
  } catch (e) {
    console.error(e);
    alert("No se pudo cargar la categoría");
  }
}

async function guardarC() {
  const data = {
    id: document.getElementById("c_id").value ? Number(document.getElementById("c_id").value) : null,
    nombre: document.getElementById("c_nombre").value.trim(),
    descripcion: document.getElementById("c_descripcion").value.trim(),
    estado: document.getElementById("c_estado").value
  };

  const method = data.id ? "PUT" : "POST";

  try {
    const res = await fetch(API_C, {
      method,
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    });

    const json = await res.json();
    if (!json.ok) return alert(json.error || "Error al guardar categoría");

    modalC.modal("hide");
    await cargarC();
    filtrarC();
  } catch (e) {
    console.error(e);
    alert("No se pudo guardar la categoría");
  }
}

async function borrarC(id) {
  if (!confirm("¿Eliminar categoría?")) return;

  try {
    const res = await fetch(API_C, {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id })
    });

    const json = await res.json();
    if (!json.ok) return alert(json.error || "Error al eliminar categoría");

    await cargarC();
    filtrarC();
  } catch (e) {
    console.error(e);
    alert("No se pudo eliminar la categoría");
  }
}

function limpiarFormC() {
  document.getElementById("c_id").value = "";
  document.getElementById("c_nombre").value = "";
  document.getElementById("c_descripcion").value = "";
  document.getElementById("c_estado").value = "Activo";
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