<?php

class ContatoDAO {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function obterContatos(string $busca = '', int $pagina = 1, int $porPagina = 10): array {

        $offset = ($pagina - 1) * $porPagina;
        $termo = '%' . $busca . '%';

        $stmt = $this->pdo->prepare(
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

    public function contarContatos(string $busca = ''): int {

        $termo = '%' . $busca . '%';

        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM contatos
             WHERE nome LIKE ? OR email LIKE ?'
        );

        $stmt->execute([$termo, $termo]);

        return (int) $stmt->fetchColumn();
    }
}