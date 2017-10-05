    <?php
    /**
     * Created by PhpStorm.
     * User: elifas
     * Date: 07/11/16
     * Time: 23:53
     */


    if($row->status != "Renovar"){
    if($total_ganho > $valor_renovar){
        $sql = $pdo->pdo->query("UPDATE financeiro set status='Renovar' where username='$row->username'");
    }
    }