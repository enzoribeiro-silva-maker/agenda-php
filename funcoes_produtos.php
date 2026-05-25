<?php

function obterProdutos(PDO $pdo): array {
    $stmt = $pdo->query('SELECT * FROM produtos ORDER BY nome');
    return $stmt->fetchAll();
}

function exibirTabelaProdutos(array $produtos): void {
    echo '<table border="1" cellpadding="10">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nome</th>';
    echo '<th>Descrição</th>';
    echo '<th>Preço</th>';
    echo '<th>Estoque</th>';
    echo '<th>Imagem</th>';
    echo '<th>Editar</th>';
    echo '<th>Excluir</th>';
    echo '</tr>';

    foreach ($produtos as $produto) {
        echo '<tr>';
        echo '<td>' . $produto['id'] . '</td>';
        echo '<td>' . htmlspecialchars($produto['nome']) . '</td>';
        echo '<td>' . htmlspecialchars($produto['descricao']) . '</td>';
        echo '<td>R$ ' . number_format($produto['preco'], 2, ',', '.') . '</td>';
        echo '<td>' . $produto['estoque'] . '</td>';

        if (!empty($produto['imagem'])) {
            echo '<td><img src="uploads/' . htmlspecialchars($produto['imagem']) . '" width="80"></td>';
        } else {
            echo '<td>Sem imagem</td>';
        }

        echo '<td><a href="editar_produto.php?id=' . $produto['id'] . '">Editar</a></td>';
        echo '<td><a href="excluir_produto.php?id=' . $produto['id'] . '">Excluir</a></td>';
        echo '</tr>';
    }

    echo '</table>';
}