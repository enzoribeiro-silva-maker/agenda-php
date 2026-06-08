<?php

require_once 'config/database.php';

$pagina = $_GET['pagina'] ?? 'contatos';

switch ($pagina) {

    case 'clientes':
        require 'views/clientes/lista.php';
        break;

    case 'produtos':
        require 'views/produtos/lista.php';
        break;

    case 'contatos':
    default:
        require 'views/contatos/lista.php';
        break;
}