<?php

require_once 'config.php';
include 'cabecalho.php';
include_once 'funcoes_clientes.php';

$clientes = obterClientes($pdo);

?>

<h1>Lista de Clientes</h1>

<a class="btn" href="cadastro_cliente.php">Cadastrar Cliente</a>

<?php exibirTabelaClientes($clientes); ?>

</body>
</html>