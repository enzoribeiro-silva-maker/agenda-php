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
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    if ($nome && $email) {
        $stmt = $pdo->prepare(
            'UPDATE contatos SET nome = ?, email = ?, telefone = ? WHERE id = ?'
        );

        $stmt->execute([$nome, $email, $telefone, $id]);

        header('Location: index.php');
        exit;
    }
}

?>

<h1>Editar Contato</h1>

<form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($contato['nome']) ?>">

    <label>E-mail:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($contato['email']) ?>">

    <label>Telefone:</label>
    <input type="text" name="telefone" value="<?= htmlspecialchars($contato['telefone']) ?>">

    <button type="submit">Salvar</button>
</form>

</body>
</html>