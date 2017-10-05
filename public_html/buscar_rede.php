    <?php

    date_default_timezone_set('America/Sao_Paulo'); // atualizado em 19/08/2013

    $base = __FILE__;
    include_once "script/configs.php";


    require_once("scripts/Classes/connection/connect.php");
    $pdo =new Connection();
    $pdo->Connect();


    $id = $_GET['id'];
    $perna = $_GET['perna'];
    echo "<ul>";
    $query = $pdo->pdo->query("SELECT *,p.name as name_kit FROM rede_binaria INNER JOIN dados_acesso_usuario ON dados_acesso_usuario.personal_id = rede_binaria.indicado_id INNER JOIN  financeiro as f INNER JOIN plan as p ON dados_acesso_usuario.personal_id=f.personal_id AND f.plan=p.id  WHERE rede_binaria.personal_id = '$id' and log_perna = '$perna' ");
    if($query->rowCount() >= 1){
        $res = $query->fetch(PDO::FETCH_OBJ);
        if($res->status == "Ativo"){
            $img = "ativo.png";
        }else{

            $img = "inativo.png";
        }
        $username = $res->username;
        $pacote = $res->package;
            echo "<li class='buscar' id='".$res->indicado_id."'><a ><b>$username ID: $res->personal_id </b><br><img src='binario/$img' style='width:50px;' /> <br>$res->name_kit</a>".buscarPernas($res->indicado_id)."</li>";



    }else{
        echo "<li><a >$perna</a><ul><li><a >esquerda</a></li><li><a >direita</a></li></ul></li>";
    }
    echo "</ul>";

    function buscarPernas($id){
        $pdo =new Connection();
        $pdo->Connect();
        $ret = "";
        $ret .= "<ul>";
        $query = $pdo->pdo->query("SELECT *,p.name as name_kit FROM rede_binaria INNER JOIN dados_acesso_usuario ON dados_acesso_usuario.personal_id = rede_binaria.indicado_id INNER JOIN  financeiro as f INNER JOIN plan as p ON dados_acesso_usuario.personal_id=f.personal_id AND f.plan=p.id  WHERE rede_binaria.personal_id = '$id' and log_perna = 'esquerda' ");
            if($query->rowCount() >= 1){
                $res2 = $query->fetch(PDO::FETCH_OBJ);
                if($res2->status == "Ativo"){
                    $img = "ativo.png";
                }else{

                    $img = "inativo.png";
                }
                $username = $res2->username;
                $pacote = $res2->package;

                    $ret .= "<li class='buscar2' id='".$res2->indicado_id."'><a rel='".$res2->indicado_id."'>$username -ID : $res2->personal_id<br><img src='binario/$img' style='width:50px;' /><br>$res2->name_kit</a></li>";


            }else{
                $ret .= "<li><a >esquerda</a></li>";
            }
        $query = $pdo->pdo->query("SELECT *,p.name as name_kit FROM rede_binaria INNER JOIN dados_acesso_usuario ON dados_acesso_usuario.personal_id = rede_binaria.indicado_id INNER JOIN  financeiro as f INNER JOIN plan as p ON dados_acesso_usuario.personal_id=f.personal_id AND f.plan=p.id  WHERE rede_binaria.personal_id = '$id' and log_perna = 'direita' ");
        if($query->rowCount() >= 1){
            $res = $query->fetch(PDO::FETCH_OBJ);
            if($res->status == "Ativo"){
                $img = "ativo.png";
            }else{

                $img = "inativo.png";
            }
            $username = $res->username;
            $pacote = $res->package;

            $ret .= "<li class='buscar2' id='".$res->indicado_id."'><a rel='".$res->indicado_id."'>$username -  ID :$res->personal_id <br><img src='binario/$img' style='width:50px;' /><br>$res->name_kit</a></li>";


        }else{
                $ret .=  "<li><a >direita</a></li>";
            }
        $ret .=  "</ul>";
        return $ret;




    }
    ?>

