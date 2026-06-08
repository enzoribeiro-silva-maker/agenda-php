<?php

require_once 'config.php';
include 'cabecalho.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    if (!$nome || !$cpf) {
        $erro = 'Nome e CPF são obrigatórios.';
    } elseif (strlen($cpf) !== 14) {
        $erro = 'CPF deve estar no formato 000.000.000-00.';
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO clientes (nome, cpf, email, telefone, endereco) VALUES (?, ?, ?, ?, ?)'
        );

        $stmt->execute([$nome, $cpf, $email, $telefone, $endereco]);

        header('Location: clientes.php');
        exit;
    }
}

?>

<h1>Cadastrar Cliente</h1>

<?php if ($erro): ?>
    <p class="erro"><?= $erro ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome">

    <label>CPF:</label>
    <input type="text" name="cpf" placeholder="000.000.000-00">

    <label>E-mail:</label>
    <input type="email" name="email">

    <label>Telefone:</label>
    <input type="text" name="telefone">

    <label>Endereço:</label>
    <input type="text" name="endereco">

    <button type="submit">Cadastrar</button>
</form>

</body>
</html>