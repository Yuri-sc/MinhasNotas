<?php

    //Incluindo autoload DOM PDF
    require_once '../../../libs/dompdf/autoload.inc.php';

    //Instancia DOM PDF CRIADO
    //Criar namespace evitando erros
    use Dompdf\Dompdf;

    //intanciar a classe DOM PDF
    $dompdf = new Dompdf();

    //bloco de consulta ao bd pra impressao
    include('../../conexao/conn.php');

    session_start();

    // Criar uma query de consulta ao banco de dados =-=-=-=-=-=-=-=-=-=-=-=-=-=
    $sql = "SELECT * FROM disciplinas WHERE id_alunos = ".$_SESSION['id']."";

    $resultado = mysqli_query($conecta, $sql);

    if($resultado && mysqli_num_rows($resultado)>0){

        $imprimir='
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col" class="text-center">ID</th>
                                        <th scope="col">DISCIPLINA</th>
                                        <th scope="col">PROFESSOR</th>
                                        <th scope="col" class="text-center">NOTA</th>
                                        <th scope="col" class="text-center">AÇÕES</th>
                                    </tr>
                                </thead>
                                <tbody>

        ';

        while($print=mysqli_fetch_array($resultado)){
            //Cod html tranformado em pdf
            // $imprimir = $imprimir.'<p>'.$print['nome'].' - '.$print['professor'].' - '.$print['nota'].'</p>';
            
            $imprimir= $imprimir.'
            <tr>
            <td class="text-center">'.$print['id'].'</td>
            <td>'.$print['nome'].'</td>
            <td>'.$print['professor'].'</td>
            <td class="text-center">'.$print['nota'].'</td>
            </tr>
            ';
        }
        $imprimir= $imprimir.'
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }else{
        $dados = array('erro' => 'Não foi possível buscar resultados');
    }

    //cabou =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

    $dompdf->loadHtml($imprimir);

    //Define o tipo de papel pra impressao
    //tamanhos (A4,A3,A2,etc) e tipos do papel: portrait(de pé) ou ;landscape(deitado)
    $dompdf -> setPaper('A4', 'portrait');

    //renderizar html como pdf
    $dompdf->render();

    $dompdf->stream("boletim.pdf", array(true));