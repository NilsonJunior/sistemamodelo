<?php

require_once '../db/conexao.class.php';

class UsuarioDao {

    public static $instance;

    private function __construct() {
        //
    }

    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new UsuarioDao();

        return self::$instance;
    }

    public function getNextID() {
        try {
            $sql = "SELECT Auto_increment FROM information_schema.tables WHERE table_name='usuario'";
            $result = Conexao::getInstance()->query($sql);
            $final_result = $result->fetch(PDO::FETCH_ASSOC);
            return $final_result['Auto_increment'];
        } catch (Exception $e) {
            print $e;
        }
    }

    public function Inserir(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuario (
                  nome,
                  sobrenome,
                  endereco
                  )
                  VALUES (
                  :nome,
                  :sobrenome,
                  :endereco
                  )";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":sobrenome", $usuario->getSobreNome());
            $p_sql->bindValue(":endereco", $usuario->getEndereco());


            return $p_sql->execute();
        } catch (Exception $e) {
            print $e;
        }
    }

    public function Editar(Usuario $usuario) {
        try {
            $sql = "UPDATE usuario set
                    nome = :nome,
                    sobrenome = :sobrenome,
                    endereco = :endereco
                    WHERE id = :id";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":sobrenome", $usuario->getSobreNome());
            $p_sql->bindValue(":endereco", $usuario->getEndereco());
            $p_sql->bindValue(":id", $usuario->getId());

            return $p_sql->execute();
        } catch (Exception $e) {
            print $e;
        }
    }

    public function Deletar($id) {
        try {
            $sql = "DELETE FROM usuario WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);

            return $p_sql->execute();
        } catch (Exception $e) {
            print $e;
        }
    }

    public function BuscarPorId($id) {

        try {
            $sql = "SELECT * FROM usuario WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();
            return $this->ListarUsuario($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print $e;
        }
    }

    public function BuscarTodos() {
        try {
            $sql = "SELECT * FROM usuario order by nome";
            $result = Conexao::getInstance()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_lista = array();
            foreach ($lista as $l) {
                $f_lista[] = $this->ListarUsuario($l);
            }

            return $f_lista;
        } catch (Exception $e) {
            print $e;
        }
    }

    private function ListarUsuario($row) {
        $usuario = new Usuario;
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setSobreNome($row['sobrenome']);
        $usuario->setEndereco($row['endereco']);
        return $usuario;
    }

}
