<?php

require_once 'models/ContatoDAO.php';

$busca = $_GET['busca'] ?? '';
$paginaAtual = isset($_GET['pagina_num']) ? (int) $_GET['pagina_num'] : 1;
$porPagina = 10;

$contatoDAO = new ContatoDAO($pdo);

$contatos = $contatoDAO->obterContatos($busca, $paginaAtual, $porPagina);
$total = $contatoDAO->contarContatos($busca);
$totalPaginas = ceil($total / $porPagina);

include 'views/cabecalho.php';
?>

<h1>Lista de Contatos</h1>

<a class="btn" href="index.php?pagina=form_contato">Cadastrar Contato</a>

<form method="GET">
    <input type="hidden" name="pagina" value="contatos">
    <input type="text" name="busca" placeholder="Buscar por nome ou email" value="<?= htmlspecialchars($busca) ?>">
    <button type="submit">Buscar</button>
</form>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>

    <?php foreach ($contatos as $contato): ?>
        <tr>
            <td><?= $contato['id'] ?></td>
            <td><?= htmlspecialchars($contato['nome']) ?></td>
            <td><?= htmlspecialchars($contato['email']) ?></td>
            <td><?= htmlspecialchars($contato['telefone']) ?></td>
            <td><a href="views/contatos/editar_contato.php?id=<?= $contato['id'] ?>">Editar</a></td>
            <td><a href="views/contatos/excluir_contato.php?id=<?= $contato['id'] ?>">Excluir</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<div>
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="index.php?pagina=contatos&busca=<?= urlencode($busca) ?>&pagina_num=<?= $i ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>

</body>
</html>