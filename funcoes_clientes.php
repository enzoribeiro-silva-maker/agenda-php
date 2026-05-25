<?php

function obterClientes(PDO $pdo): array {

    $stmt = $pdo->query(
        'SELECT * FROM clientes ORDER BY nome'
    );

    return $stmt->fetchAll();
}

function exibirTabelaClientes(array $clientes): void {

    echo '<table border="1" cellpadding="10">';

    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nome</th>';
    echo '<th>CPF</th>';
    echo '<th>Email</th>';
    echo '<th>Telefone</th>';
    echo '<th>Endereço</th>';
    echo '<th>Editar</th>';
    echo '<th>Excluir</th>';
    echo '</tr>';

    foreach ($clientes as $cliente) {

        echo '<tr>';

        echo '<td>' . $cliente['id'] . '</td>';
        echo '<td>' . htmlspecialchars($cliente['nome']) . '</td>';
        echo '<td>' . htmlspecialchars($cliente['cpf']) . '</td>';
        echo '<td>' . htmlspecialchars($cliente['email']) . '</td>';
        echo '<td>' . htmlspecialchars($cliente['telefone']) . '</td>';
        echo '<td>' . htmlspecialchars($cliente['endereco']) . '</td>';

        echo '<td>
                <a href="editar_cliente.php?id=' . $cliente['id'] . '">
                    Editar
                </a>
              </td>';

        echo '<td>
                <a href="excluir_cliente.php?id=' . $cliente['id'] . '">
                    Excluir
                </a>
              </td>';

        echo '</tr>';
    }

    echo '</table>';
}