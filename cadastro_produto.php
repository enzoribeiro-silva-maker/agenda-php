<?php

require_once 'config.php';
include 'cabecalho.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;
    $imagem = null;

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
                $nomeArquivo = uniqid('prod_') . '.' . $extensao;
                move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $nomeArquivo);
                $imagem = $nomeArquivo;
            }
        }

        if (!$erro) {
            $stmt = $pdo->prepare(
                'INSERT INTO produtos (nome, descricao, preco, estoque, imagem) VALUES (?, ?, ?, ?, ?)'
            );

            $stmt->execute([$nome, $descricao, $preco, $estoque, $imagem]);

            header('Location: produtos.php');
            exit;
        }
    }
}

?>

<h1>Cadastrar Produto</h1>

<?php if ($erro): ?>
    <p class="erro"><?= $erro ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nome:</label>
    <input type="text" name="nome">

    <label>Descrição:</label>
    <textarea name="descricao"></textarea>

    <label>Preço:</label>
    <input type="number" step="0.01" name="preco">

    <label>Estoque:</label>
    <input type="number" name="estoque">

    <label>Imagem:</label>
    <input type="file" name="imagem">

    <button type="submit">Cadastrar</button>
</form>

</body>
</html>