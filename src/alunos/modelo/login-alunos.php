<?php

    
    include('../../conexao/conn.php');

    $id = $_REQUEST['id'];
    $senha = $_REQUEST['senha'];
    $senha = md5($senha);

     // Criar uma query de consulta ao banco de dados
     $sql = "SELECT * FROM alunos WHERE id = ".$id." AND senha = '".$senha."'";

     // Agora iremos executar nossa query SQL
     $resultado = mysqli_query($conecta, $sql);

     if($resultado && mysqli_num_rows($resultado)>0){
         $dados = array('result'  => true);
     }else{
         $dados = array('result' => false);
     }

     echo json_encode($dados);