<?php

require_once 'config.php';
include 'cabecalho.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID inválido.');
}

$stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = ?');
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    die('Produto não encontrado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($produto['imagem']) && file_exists('uploads/' . $produto['imagem'])) {
        unlink('uploads/' . $produto['imagem']);
    }

    $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = ?');
    $stmt->execute([$id]);

    header('Location: produtos.php');
    exit;
}

?>

<h1>Excluir Produto</h1>

<p>Tem certeza que deseja excluir este produto?</p>

<p><strong>Nome:</strong> <?= htmlspecialchars($produto['nome']) ?></p>
<p><strong>Preço:</strong> R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>

<form method="POST">
    <button type="submit">Confirmar Exclusão</button>
</form>

<br>

<a href="produtos.php">Cancelar</a>

</body>
</html>