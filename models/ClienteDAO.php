<?php

class ClienteDAO {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function obterClientes(): array {

        $stmt = $this->pdo->query(
            'SELECT * FROM clientes ORDER BY nome'
        );

        return $stmt->fetchAll();
    }
}