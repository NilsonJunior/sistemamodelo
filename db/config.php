<?php

if ($_SERVER["HTTP_HOST"] == "localhost") {
    define('USUARIO', 'root');
    define('SENHA', '123456');
    define('SERVIDOR', 'localhost');
    define('BASE', 'cadastro');
    define('PORTA', '5432');
} else {
    //Online
    define('USUARIO', 'root-tarefa');
    define('SENHA', 'm1S012016-tar');
    define('SERVIDOR', 'mysql873.umbler.com');
    define('BASE', 'aluno');
    define('PORTA', '41890');
}
?>

