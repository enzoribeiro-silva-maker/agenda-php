<?php

require_once 'config.php';
include 'cabecalho.php';
include_once 'funcoes.php';

$busca = $_GET['busca'] ?? '';
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$porPagina = 10;

$contatos = obterContatos($pdo, $busca, $pagina, $porPagina);
$total = contarContatos($pdo, $busca);
$totalPaginas = ceil($total / $porPagina);

?>

<h1>Lista de Contatos</h1>

<a class="btn" href="cadastro_contato.php">Cadastrar Contato</a>

<form method="GET">
    <input type="text" name="busca" placeholder="Buscar por nome ou email" value="<?= htmlspecialchars($busca) ?>">
    <button type="submit">Buscar</button>
</form>

<?php exibirTabelaContatos($contatos); ?>

<div>
    <?php if ($pagina > 1): ?>
        <a href="?busca=<?= urlencode($busca) ?>&pagina=<?= $pagina - 1 ?>">Anterior</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="?busca=<?= urlencode($busca) ?>&pagina=<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($pagina < $totalPaginas): ?>
        <a href="?busca=<?= urlencode($busca) ?>&pagina=<?= $pagina + 1 ?>">Próximo</a>
    <?php endif; ?>
</div>

</body>
</html>