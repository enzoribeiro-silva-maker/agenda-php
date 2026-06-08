<?php

require_once 'models/ClienteDAO.php';

$clienteDAO = new ClienteDAO($pdo);
$clientes = $clienteDAO->obterClientes();

include 'views/cabecalho.php';
?>

<h1>Lista de Clientes</h1>

<a class="btn" href="index.php?pagina=form_cliente">Cadastrar Cliente</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Endereço</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>

    <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?= $cliente['id'] ?></td>
            <td><?= htmlspecialchars($cliente['nome']) ?></td>
            <td><?= htmlspecialchars($cliente['cpf']) ?></td>
            <td><?= htmlspecialchars($cliente['email']) ?></td>
            <td><?= htmlspecialchars($cliente['telefone']) ?></td>
            <td><?= htmlspecialchars($cliente['endereco']) ?></td>
            <td><a href="views/clientes/editar_cliente.php?id=<?= $cliente['id'] ?>">Editar</a></td>
            <td><a href="views/clientes/excluir_cliente.php?id=<?= $cliente['id'] ?>">Excluir</a></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>