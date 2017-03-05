<?php

require_once '../controle/Usuario.php';

if ($_POST['tipo'] == 'cadastro') {
    Cadastrar();
}
if ($_POST['tipo'] == 'listar') {
    ListarTodos();
}
if ($_POST['tipo'] == 'buscarId') {
    ListarId();
}

if ($_POST['tipo'] == 'delete') {
    Delete();
}

function Delete() {

    if (!empty($_POST['id'])) {
        $usuarioDao = UsuarioDao::getInstance();
        $usuarioDao = $usuarioDao->Deletar($_POST['id']);
        if ($usuarioDao == 1) {
            $retorno = (array("ok" => "erro", "mensagem" => "Registro Apagado com Sucesso"));
        } else {
            $retorno = (array("erro" => "erro", "mensagem" => "Registro não apagado"));
        }
    } else {
        $retorno = (array("erro" => "erro", "mensagem" => "Nenhum Registo escolhido para apagar"));
    }
    die(json_encode($retorno));
}

function Cadastrar() {
    if ((!empty($_POST['nome']) && (!empty($_POST['sobrenome']) && (!empty($_POST['endereco']))))) {
        $usuario = new Usuario();
        $usuario->setNome(strtoupper($_POST['nome']));
        $usuario->setSobreNome(strtoupper($_POST['sobrenome']));
        $usuario->setEndereco(strtoupper($_POST['endereco']));
        if ($_POST['id']) {
            $usuario->setId($_POST['id']);
            $usuarioDao = UsuarioDao::getInstance();
            $usuarioDao = $usuarioDao->Editar($usuario);
        } else {
            $usuarioDao = UsuarioDao::getInstance();
            $usuarioDao = $usuarioDao->Inserir($usuario);
        }
        if ($usuarioDao == 1) {
            $retorno = (array("ok" => "ok", "mensagem" => "Cadastro Efetuado"));
        } else {
            $retorno = (array("erro" => "erro", "mensagem" => "Cadastro não realizado"));
        }
    } else {
        $retorno = (array("erro" => "erro", "mensagem" => "Favor Inserir Item para Cadastro"));
    }
    die(json_encode($retorno));
}

function ListarTodos() {

    $usuarioDao = new Usuario;
    $usuarioDao = $usuarioDao->ListasTodos();
    $lista = array();
    $i = 0;
    foreach ($usuarioDao as $usr) {
        $lista[$i]['id'] = $usr->getId();
        $lista[$i]['nome'] = $usr->getNome();
        $lista[$i]['sobrenome'] = $usr->getSobreNome();
        $lista[$i]['endereco'] = $usr->getEndereco();
        $i++;
    }
    echo(json_encode($lista));
    die;
}

function ListarId() {

    $usuario = new Usuario;

    $usuario = $usuario->ListaPorId($_POST['id']);
    $i = 0;
    $lista = array();
    $lista[$i]['id'] = $usuario->getId();
    $lista[$i]['nome'] = $usuario->getNome();
    $lista[$i]['sobrenome'] = $usuario->getSobreNome();
    $lista[$i]['endereco'] = $usuario->getEndereco();

    echo(json_encode($lista));
}
