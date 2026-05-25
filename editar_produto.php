
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

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;
    $imagem = $produto['imagem'];

    if (!$nome) {
        $erro = 'Nome é obrigatório.';
    } elseif ($preco <= 0) {
        $erro = 'Preço deve ser positivo.';
    } elseif ($estoque < 0) {
        $erro = 'Estoque não pode ser negativo.';
    } else {
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (!empty($_FILES['imagem']['name'])) {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array(strtolower($extensao), $permitidos)) {
                $erro = 'Tipo de imagem não permitido.';
            } else {
                if (!empty($produto['imagem']) && file_exists('uploads/' . $produto['imagem'])) {
                    unlink('uploads/' . $produto['imagem']);
                }

                $nomeArquivo = uniqid('prod_') . '.' . $extensao;
                move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $nomeArquivo);
                $imagem = $nomeArquivo;
            }
        }

        if (!$erro) {
            $stmt = $pdo->prepare(
                'UPDATE produtos SET nome = ?, descricao = ?, preco = ?, estoque = ?, imagem = ? WHERE id = ?'
            );

            $stmt->execute([$nome, $descricao, $preco, $estoque, $imagem, $id]);

            header('Location: produtos.php');
            exit;
        }
    }
}

?>

<h1>Editar Produto</h1>

<?php if ($erro): ?>
    <p style="color: red;"><?= $erro ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>">

    <label>Descrição:</label>
    <textarea name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea>

    <label>Preço:</label>
    <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>">

    <label>Estoque:</label>
    <input type="number" name="estoque" value="<?= htmlspecialchars($produto['estoque']) ?>">

    <label>Imagem:</label>
    <input type="file" name="imagem">

    <button type="submit">Salvar</button>
</form>

<br>

<a href="produtos.php">Voltar</a>

</body>
</html>