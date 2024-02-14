<?php
class Conexao{
    private $host = "127.0.0.1";
    private $usuario = "root";
    private $senha = "";
    private $banco = "projeto_login";
    private $conexao;

    public function __construct() {
        $this->conexao = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);
        if ($this->conexao->connect_error) {
            die("Erro na conexão com o banco de dados: " . $this->conexao->connect_error);
        }
        $this->conexao->set_charset("utf8");
    }

    public function executar($sql, $data) {
        $stmt = $this->conexao->prepare($sql);

        if ($stmt) {
            $types = str_repeat('s', count($data));

            $stmt->bind_param($types, ...$data);

            $stmt->execute();

            return $stmt->affected_rows;
        } else {
            throw new Exception("Erro na preparação da consulta.");
            return 0;
        }

    }

    public function getConexao() {
        return $this->conexao;
    }
}