<?php

require_once 'models/ProdutoDAO.php';

$produtoDAO = new ProdutoDAO($pdo);
$produtos = $produtoDAO->obterProdutos();

include 'views/cabecalho.php';
?>

<h1>Lista de Produtos</h1>

<a class="btn" href="index.php?pagina=form_produto">Cadastrar Produto</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Imagem</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>

    <?php foreach ($produtos as $produto): ?>
        <tr>
            <td><?= $produto['id'] ?></td>
            <td><?= htmlspecialchars($produto['nome']) ?></td>
            <td><?= htmlspecialchars($produto['descricao']) ?></td>
            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
            <td><?= $produto['estoque'] ?></td>

            <td>
                <?php if (!empty($produto['imagem'])): ?>
                    <img src="uploads/<?= htmlspecialchars($produto['imagem']) ?>" width="80">
                <?php else: ?>
                    Sem imagem
                <?php endif; ?>
            </td>

            <td>
                <a href="views/produtos/editar_produto.php?id=<?= $produto['id'] ?>">
                    Editar
                </a>
            </td>

            <td>
                <a href="views/produtos/excluir_produto.php?id=<?= $produto['id'] ?>">
                    Excluir
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>