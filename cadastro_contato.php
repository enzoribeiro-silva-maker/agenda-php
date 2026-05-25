<?php

require_once 'config.php';
include 'cabecalho.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    if ($nome && $email) {
        $stmt = $pdo->prepare(
            'INSERT INTO contatos (nome, email, telefone) VALUES (?, ?, ?)'
        );

        $stmt->execute([$nome, $email, $telefone]);

        header('Location: index.php');
        exit;
    } else {
        $erro = 'Nome e e-mail são obrigatórios.';
    }
}

?>

<h1>Cadastrar Contato</h1>

<?php if ($erro): ?>
    <p class="erro"><?= $erro ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome">

    <label>E-mail:</label>
    <input type="email" name="email">

    <label>Telefone:</label>
    <input type="text" name="telefone">

    <button type="submit">Cadastrar</button>
</form>

</body>
</html>