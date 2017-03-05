<?php

require_once '../controle/UsuarioDao.php';

class Usuario {

    private $id;
    private $nome;
    private $sobrenome;
    private $endereco;

    /**
     *
     * gets and sets
     */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getSobreNome() {
        return $this->sobrenome;
    }

    public function setSobreNome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function ListasTodos() {

        $usrDao = UsuarioDao::getInstance();
        $usrDao = $usrDao->BuscarTodos();

        return $usrDao;
    }

    public function ListaPorId($id) {

        $usrDao = UsuarioDao::getInstance();
        $usrDao = $usrDao->BuscarPorId($id);
        return $usrDao;
    }

}
