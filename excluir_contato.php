<?php

require_once 'config.php';
include 'cabecalho.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID inválido.');
}

$stmt = $pdo->prepare('SELECT * FROM contatos WHERE id = ?');
$stmt->execute([$id]);
$contato = $stmt->fetch();

if (!$contato) {
    die('Contato não encontrado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('DELETE FROM contatos WHERE id = ?');
    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
}

?>

<h1>Excluir Contato</h1>

<p>Tem certeza que deseja excluir este contato?</p>

<p><strong>Nome:</strong> <?= htmlspecialchars($contato['nome']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($contato['email']) ?></p>

<form method="POST">
    <button type="submit">Confirmar Exclusão</button>
</form>

<a href="index.php">Cancelar</a>

</body>
</html>