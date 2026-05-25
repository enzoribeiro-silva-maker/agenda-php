<?php

function obterContatos(PDO $pdo, string $busca = '', int $pagina = 1, int $porPagina = 10): array {
    $offset = ($pagina - 1) * $porPagina;
    $termo = '%' . $busca . '%';

    $stmt = $pdo->prepare(
        'SELECT * FROM contatos
         WHERE nome LIKE ? OR email LIKE ?
         ORDER BY nome
         LIMIT ? OFFSET ?'
    );

    $stmt->bindValue(1, $termo);
    $stmt->bindValue(2, $termo);
    $stmt->bindValue(3, $porPagina, PDO::PARAM_INT);
    $stmt->bindValue(4, $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}

function contarContatos(PDO $pdo, string $busca = ''): int {
    $termo = '%' . $busca . '%';

    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM contatos
         WHERE nome LIKE ? OR email LIKE ?'
    );

    $stmt->execute([$termo, $termo]);

    return (int) $stmt->fetchColumn();
}

function exibirTabelaContatos(array $contatos): void {
    echo '<table border="1" cellpadding="10">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nome</th>';
    echo '<th>Email</th>';
    echo '<th>Telefone</th>';
    echo '<th>Editar</th>';
    echo '<th>Excluir</th>';
    echo '</tr>';

    foreach ($contatos as $contato) {
        echo '<tr>';
        echo '<td>' . $contato['id'] . '</td>';
        echo '<td>' . htmlspecialchars($contato['nome']) . '</td>';
        echo '<td>' . htmlspecialchars($contato['email']) . '</td>';
        echo '<td>' . htmlspecialchars($contato['telefone']) . '</td>';
        echo '<td><a href="editar_contato.php?id=' . $contato['id'] . '">Editar</a></td>';
        echo '<td><a href="excluir_contato.php?id=' . $contato['id'] . '">Excluir</a></td>';
        echo '</tr>';
    }

    echo '</table>';
}