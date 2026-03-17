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
                SELECT id, nombre, descripcion, estado, creado_en
                FROM categorias
                WHERE id = :id
            ");
            $stmt->execute([":id" => $id]);
            $row = $stmt->fetch();

            if (!$row) respond(false, null, "No existe la categoría", 404);
            respond(true, $row);
        }

        $stmt = $myPDO->prepare("
            SELECT id, nombre, descripcion, estado, creado_en
            FROM categorias
            ORDER BY id DESC
        ");
        $stmt->execute();
        respond(true, $stmt->fetchAll());
    }

    if ($method === "POST") {
        $nombre = trim($body["nombre"] ?? "");
        $descripcion = trim($body["descripcion"] ?? "");
        $estado = trim($body["estado"] ?? "Activo");

        if ($nombre === "") {
            respond(false, null, "El nombre es obligatorio", 400);
        }

        $stmt = $myPDO->prepare("
            INSERT INTO categorias (nombre, descripcion, estado)
            VALUES (:nombre, :descripcion, :estado)
        ");
        $stmt->execute([
            ":nombre" => $nombre,
            ":descripcion" => ($descripcion !== "" ? $descripcion : null),
            ":estado" => $estado
        ]);

        respond(true, ["id" => (int)$myPDO->lastInsertId()]);
    }

    if ($method === "PUT") {
        $id = (int)($body["id"] ?? 0);
        if ($id <= 0) respond(false, null, "ID inválido", 400);

        $nombre = trim($body["nombre"] ?? "");
        $descripcion = trim($body["descripcion"] ?? "");
        $estado = trim($body["estado"] ?? "Activo");

        if ($nombre === "") {
            respond(false, null, "El nombre es obligatorio", 400);
        }

        $stmt = $myPDO->prepare("
            UPDATE categorias
            SET nombre = :nombre,
                descripcion = :descripcion,
                estado = :estado
            WHERE id = :id
        ");
        $stmt->execute([
            ":nombre" => $nombre,
            ":descripcion" => ($descripcion !== "" ? $descripcion : null),
            ":estado" => $estado,
            ":id" => $id
        ]);

        respond(true, ["updated" => $stmt->rowCount()]);
    }

    if ($method === "DELETE") {
        $id = (int)($body["id"] ?? 0);
        if ($id <= 0) respond(false, null, "ID inválido", 400);

        $stmt = $myPDO->prepare("DELETE FROM categorias WHERE id = :id");
        $stmt->execute([":id" => $id]);

        respond(true, ["deleted" => $stmt->rowCount()]);
    }

    respond(false, null, "Método no soportado", 405);

} catch (PDOException $e) {
    respond(false, null, $e->getMessage(), 500);
}