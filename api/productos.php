<?php
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../config/connectdb.php";

$method = $_SERVER["REQUEST_METHOD"];
$raw = file_get_contents("php://input");
$body = json_decode($raw, true);
if (!is_array($body)) $body = [];

function respond($ok, $data = null, $error = null, $code = 200){
    http_response_code($code);
    echo json_encode([
        "ok" => $ok,
        "data" => $data,
        "error" => $error
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    if ($method === "GET") {
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];

            $stmt = $myPDO->prepare("
                SELECT 
                    p.id,
                    p.sku,
                    p.nombre,
                    p.marca,
                    p.categoria_id,
                    c.nombre AS categoria_nombre,
                    p.descripcion,
                    p.precio,
                    p.stock,
                    p.garantia_meses,
                    p.estado,
                    p.creado_en
                FROM productos_tecnologia AS p
                LEFT JOIN categorias AS c ON c.id = p.categoria_id
                WHERE p.id = :id
            ");
            $stmt->execute([":id" => $id]);
            $row = $stmt->fetch();

            if (!$row) respond(false, null, "No existe el producto", 404);
            respond(true, $row);
        }

        $stmt = $myPDO->prepare("
            SELECT 
                p.id,
                p.sku,
                p.nombre,
                p.marca,
                p.categoria_id,
                c.nombre AS categoria_nombre,
                p.descripcion,
                p.precio,
                p.stock,
                p.garantia_meses,
                p.estado,
                p.creado_en
            FROM productos_tecnologia AS p
            LEFT JOIN categorias AS c ON c.id = p.categoria_id
            ORDER BY p.id DESC
        ");
        $stmt->execute();
        respond(true, $stmt->fetchAll());
    }

    if ($method === "POST") {
        $sku = trim($body["sku"] ?? "");
        $nombre = trim($body["nombre"] ?? "");
        $marca = trim($body["marca"] ?? "");
        $categoria_id = (int)($body["categoria_id"] ?? 0);
        $descripcion = trim($body["descripcion"] ?? "");
        $precio = $body["precio"] ?? null;
        $stock = (int)($body["stock"] ?? 0);
        $garantia = (int)($body["garantia_meses"] ?? 12);
        $estado = trim($body["estado"] ?? "Activo");

        if (
            $sku === "" ||
            $nombre === "" ||
            $marca === "" ||
            $categoria_id <= 0 ||
            !is_numeric($precio) ||
            $precio < 0
        ) {
            respond(false, null, "Faltan campos obligatorios o precio inválido", 400);
        }

        $stmt = $myPDO->prepare("
            INSERT INTO productos_tecnologia
            (sku, nombre, marca, categoria_id, descripcion, precio, stock, garantia_meses, estado)
            VALUES
            (:sku, :nombre, :marca, :categoria_id, :descripcion, :precio, :stock, :garantia, :estado)
        ");
        $stmt->execute([
            ":sku" => $sku,
            ":nombre" => $nombre,
            ":marca" => $marca,
            ":categoria_id" => $categoria_id,
            ":descripcion" => ($descripcion !== "" ? $descripcion : null),
            ":precio" => $precio,
            ":stock" => $stock,
            ":garantia" => $garantia,
            ":estado" => $estado
        ]);

        respond(true, ["id" => (int)$myPDO->lastInsertId()]);
    }

    if ($method === "PUT") {
        $id = (int)($body["id"] ?? 0);
        if ($id <= 0) respond(false, null, "ID inválido", 400);

        $sku = trim($body["sku"] ?? "");
        $nombre = trim($body["nombre"] ?? "");
        $marca = trim($body["marca"] ?? "");
        $categoria_id = (int)($body["categoria_id"] ?? 0);
        $descripcion = trim($body["descripcion"] ?? "");
        $precio = $body["precio"] ?? null;
        $stock = (int)($body["stock"] ?? 0);
        $garantia = (int)($body["garantia_meses"] ?? 12);
        $estado = trim($body["estado"] ?? "Activo");

        if (
            $sku === "" ||
            $nombre === "" ||
            $marca === "" ||
            $categoria_id <= 0 ||
            !is_numeric($precio) ||
            $precio < 0
        ) {
            respond(false, null, "Faltan campos obligatorios o precio inválido", 400);
        }

        $stmt = $myPDO->prepare("
            UPDATE productos_tecnologia
            SET sku = :sku,
                nombre = :nombre,
                marca = :marca,
                categoria_id = :categoria_id,
                descripcion = :descripcion,
                precio = :precio,
                stock = :stock,
                garantia_meses = :garantia,
                estado = :estado
            WHERE id = :id
        ");
        $stmt->execute([
            ":sku" => $sku,
            ":nombre" => $nombre,
            ":marca" => $marca,
            ":categoria_id" => $categoria_id,
            ":descripcion" => ($descripcion !== "" ? $descripcion : null),
            ":precio" => $precio,
            ":stock" => $stock,
            ":garantia" => $garantia,
            ":estado" => $estado,
            ":id" => $id
        ]);

        respond(true, ["updated" => $stmt->rowCount()]);
    }

    if ($method === "DELETE") {
        $id = (int)($body["id"] ?? 0);
        if ($id <= 0) respond(false, null, "ID inválido", 400);

        $stmt = $myPDO->prepare("DELETE FROM productos_tecnologia WHERE id = :id");
        $stmt->execute([":id" => $id]);

        respond(true, ["deleted" => $stmt->rowCount()]);
    }

    respond(false, null, "Método no soportado", 405);

} catch (PDOException $e) {
    respond(false, null, $e->getMessage(), 500);
}