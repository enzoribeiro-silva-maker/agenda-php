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
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    $stmt = $pdo->prepare(
        'UPDATE clientes SET nome = ?, cpf = ?, email = ?, telefone = ?, endereco = ? WHERE id = ?'
    );

    $stmt->execute([$nome, $cpf, $email, $telefone, $endereco, $id]);

    header('Location: clientes.php');
    exit;
}

?>

<h1>Editar Cliente</h1>

<form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>">

    <label>CPF:</label>
    <input type="text" name="cpf" value="<?= htmlspecialchars($cliente['cpf']) ?>">

    <label>E-mail:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>">

    <label>Telefone:</label>
    <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>">

    <label>Endereço:</label>
    <input type="text" name="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>">

    <button type="submit">Salvar</button>
</form>

</body>
</html>