<?php

require_once 'config.php';
include 'cabecalho.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID inválido.');
}

$stmt = $pdo->prepare('SELECT * FROM clientes WHERE id = ?');
$stmt->execute([$id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    die('Cliente não encontrado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('DELETE FROM clientes WHERE id = ?');
    $stmt->execute([$id]);

    header('Location: clientes.php');
    exit;
}

?>

<h1>Excluir Cliente</h1>

<p>Tem certeza que deseja excluir este cliente?</p>

<p><strong>Nome:</strong> <?= htmlspecialchars($cliente['nome']) ?></p>
<p><strong>CPF:</strong> <?= htmlspecialchars($cliente['cpf']) ?></p>

<form method="POST">
    <button type="submit">Confirmar Exclusão</button>
</form>

<a href="clientes.php">Cancelar</a>

</body>
</html>