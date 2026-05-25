<?php

require_once 'config.php';
include 'cabecalho.php';
include_once 'funcoes_produtos.php';

$produtos = obterProdutos($pdo);

?>

<h1>Lista de Produtos</h1>

<a class="btn" href="cadastro_produto.php">Cadastrar Produto</a>

<?php exibirTabelaProdutos($produtos); ?>

</body>
</html>