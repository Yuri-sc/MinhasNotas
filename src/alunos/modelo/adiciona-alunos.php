<?php
 
 // Iremos conectar nossa função ao banco de dados
 include('../../conexao/conn.php');
 
 $nome = $_REQUEST['nome'];
 $curso = $_REQUEST['curso'];
 $senha = $_REQUEST['senha'];
 $senha = md5($senha);
 $tipo = $_REQUEST['tipo'];
 
 // Verificando se os campos foram preenchidos
 if(strlen($nome) == 0 || strlen($curso) == 0){
 $dados = array(
 'tipo' => 'alert-warning',
 'mensagem' => 'Por favor preencha todo o formulário!'
 );
 }else{

    $arquivo_tmp = $_FILES['foto']['tmp_name'];
    $nomeFoto = $_FILES['foto']['name'];

    // Pegar extensão do arquivo enviado
    $extensao = pathinfo($nomeFoto, PATHINFO_EXTENSION);
    // converter extensao para minúscula
    $extensao = strtolower($extensao);

    if(strstr('.jpg;.jpeg;.gif;.png', $extensao)){
        // criar nome unico para o arquivo
        $novoNome = uniqid(time()) . '.' . $extensao;
        // concatenar pasta onde será salvo o arquivo com o nome
        $destino = 'img/' . $novoNome;
        
        // tentar enviar arquivo para o servidor
        if(@move_uploaded_file($arquivo_tmp, $destino)){
             // Criaremos uma variável para receber os comandos SQL
            $sql = "INSERT INTO alunos (nome, curso, senha, tipo, foto) VALUES ('".$nome."', '".$curso."', '".$senha."', ".$tipo.", '".$novoNome."')";
            // Iremos testar a nossa linha SQL, diretamente no banco de dados
            if(mysqli_query($conecta, $sql)){
            $dados = array(
            'tipo' => 'alert-success',
            'mensagem' => 'O aluno '.$nome.', foi salvo com sucesso!'
            );
            }else{
            $dados = array(
            'tipo' => 'alert-danger',
            'mensagem' => 'Deu ruim....'.mysqli_error($conecta)
            );
            }

        }else{
            $dados = array(
                'tipo' => 'alert-warning',
                'mensagem' => 'Não foi posseivel salvar o arquivo no servidor!'
                );
        }
    }else{
        $dados = array(
            'tipo' => 'alert-warning',
            'mensagem' => 'Tipo de imagem não aceita pelo sistema!'
            );
    }

   
 }
 
 echo json_encode($dados);