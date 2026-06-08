<?php

class ProdutoDAO {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function obterProdutos(): array {

        $stmt = $this->pdo->query(
            'SELECT * FROM produtos ORDER BY nome'
        );

        return $stmt->fetchAll();
    }
}