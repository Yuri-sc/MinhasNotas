<!--Conn é a abreviatura de connection -->
<?php

    // Demonstre todos os erros e alertas existentes quanto ao meu codigo e interação com o B.D
    // Os dois comandos a seguir tem por finalidade a forçar uma configurção no servidor APACHE
    ini_set('display_erros', true);
    error_reporting(E_ALL);

    // Criação de variavel para acesso ao BD
    $hostname = "localhost";
    $database = "minhanota";
    $username = "root";
    $password = "";

    if($conecta = mysqli_connect($hostname, $username, $password, $database)){
       // echo "Conexão com o banco de dados ".$database.", efetuado com sucesso!";
    }else{
        echo "Erro: ".mysqli_connect_error();
    }