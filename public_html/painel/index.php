<?php
include_once("head.php");
?>
<body>
<!-- Start Page Loading -->

<!-- End Page Loading -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
<?php
include_once("header.php");
$dolar = "3.14";
?>
<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- START MAIN -->
<div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">
        <?php
        include_once('sidebar.php');
        ?>
        <!-- START CONTENT -->
        <section id="content">

            <!--start container-->
            <div class="container">
                <!--chart dashboard start-->
                <div id="chart-dashboard">
                    <div class="row">
                        <?php
                        if($row->status == "Renovar"){
                        ?>
                        <center>
                            <div id="card-alert" class="card red">
                                <div>
                                    <div class="panel-title">Renovar</div>
                                </div>
                                <!-- panel body -->
                                <div class="panel-body">
                                    <b>Sua conta está prestes a bater o valor para renovar! Não vá sem ganhar renovar sua conta!</b><br>
                                    <form method="post">
                                        <br>
                                        <center><button type="submit" class="btn btn-info" name="renovar">Gerar Fatura</button>
                                    </form>
                                </div>
                            </div>
                        </center>
                        <?php
                        }
                        ?>
                        <!--card stats start-->
                        <div id="card-alert" class="card light-blue">
                            <div class="card-content white-text">
                                 <p><i class="mdi-social-person-add"></i> Referência : <a href="http://www.impactusbit.com/register.php?ref=<?php print $row->username ?>" target="_blank" style="color: #f5f5f5">http://www.impactusbit.com/<?php echo $row->username?></a> </p>
                            </div>
                        </div>
                        <div id="card-stats">
                            <div class="row">
                                <div class="col s12 m6 l3">
                                    <div class="card">
                                        <div class="card-content  green white-text">
                                            <p class="card-stats-title"><i class="fa fa-dollar"> </i> Saldo Disponivel</p>
                                            <h4 class="card-stats-number"><i class="fa fa-btc"></i> <?php echo number_format($row->saldo,8,".",".")?></h4>
                                           <br>
                                        </div>
                                        <div class="card-action  green darken-2">
                                            <div id="clients-bar" class="center-align"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l3">
                                 <div id="result"></div>
                                </div>
                                <div class="col s12 m6 l3">
                                    <div class="card">
                                        <div class="card-content blue-grey white-text">
                                            <p class="card-stats-title"><i class="mdi-action-trending-up"></i> Meus Indicados</p>
                                            <h4 class="card-stats-number"><i class="fa fa-users"></i> <?php echo $c_patrocinador?></h4>
<br>
                                        </div>
                                        <div class="card-action blue-grey darken-2">
                                            <div id="profit-tristate" class="center-align"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col s12 m6 l3">
                                    <div class="card">
                                        <div class="card-content purple white-text">
                                            <p class="card-stats-title"><i class="mdi-editor-attach-money"></i>Total de ganhos</p>
                                            <h4 class="card-stats-number"><i class="btc"></i> <?php echo number_format($row->renovar_saldo,8,".",".")?></h4>
                                            <br>
                                        </div>
                                        <div class="card-action purple darken-2">
                                            <div id="sales-compositebar" class="center-align"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--card stats end-->
                        <div>
                            <div class="card">
                                <div class="card-move-up waves-effect waves-block waves-light">
                                    <div class="move-up cyan darken-1">
                                        <div>
                                            <span class="chart-title white-text">Desempenho Atual</span>

                                            <td><a class="waves-effect waves-light btn modal-trigger " href="#modal1"  style="background-color: #0069a2;font-size: 7pt;" data-toggle="modal">Solicitar novo Plano </button></a>
                                        <div class="chart-revenue cyan darken-2 white-text">
                                            <p class="chart-revenue-total">Meu Plano : <?php echo $kit->name ?></p>
                                            <p class="chart-revenue-total">Valor do Plano : <?php echo  number_format($kit->price_btc,8,".","."); ?></p>
                                        </div>                                      </div>
                                        <div class="trending-line-chart-wrapper">
                                            <canvas id="trending-line-chart" height="70"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <a class="btn-floating btn-move-up waves-effect waves-light darken-2 right"><i class="mdi-content-add activator"></i></a>
                                   </div>

                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">Extrato<i class="mdi-navigation-close right"></i></span>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>ID</th>
                                                <th>Descrição</th>
                                                <th class="numeric">Nome de Usuario</th>
                                                <th class="numeric">Valor</th>
                                                <th class="numeric">Situação</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql = $pdo->pdo->query("SELECT * FROM extrato WHERE personal_id='$row->personal_id' AND descricao='Daily Mining' ORDER by id ");
                                            if($sql->rowCount() >0){
                                                $res = $sql->fetchAll(PDO::FETCH_OBJ);
                                                foreach($res as $ref){
                                                    if($ref->status == "Pending"){
                                                        $sts = "red";
                                                        $or = 'Pendente';
                                                    }elseif($ref->status == "Analyzing"){

                                                        $sts =  'orange  ';
                                                        $or = 'Analizando';
                                                    }elseif($ref->status == "Estornado"){
                                                        $sts =  'orange';
                                                        $or = 'Estornado';

                                                    }else{
                                                        $sts =  '#50FF7D';
                                                        $or = 'Pago';

                                                    }
                                                    ?>

                                                    <tr>
                                                        <td><?php echo $ref->data?></td>
                                                        <td><?php echo $ref->pedido_id?></td>
                                                        <td><?php echo $ref->descricao?></td>
                                                        <td><?php echo $ref->username?></td>
                                                        <td><?php echo number_format($ref->valor,8,".",".")?> / BTC</td>
                                                        <td class="numeric" style="color: <?php echo $sts ?>"><?php echo $or?></td>

                                                    </tr>

                                                <?php

                                                }
                                            }
                                            ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
                <!--chart dashboard end-->

                <!-- /////////////////////////////////////////////////////////////////////////// -->

    </div>
    <!-- END WRAPPER -->

</div>
<!-- END MAIN -->



<!-- //////////////////////////////////////////////////////////////////////////// -->

<?php
include_once("footer.php");
include_once("javascript.php");
?>

    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel">Pagar sua fatura </h4>
            </div>

                <center> <div class="modal-body">
                        <form method="post">
                            <center>  <select class="form-control" name="up_kit" style="color: #ffc54a;font-size: 12pt;font-family: bold;" >
                                    <?php
                                    $sql = $pdo->pdo->prepare("SELECT * FROM plan where id>:plan");
                                    $smtm = array(
                                        "plan" => $kit->id
                                    );
                                    $sql->execute($smtm);
                                    if($sql->rowCount()>0){
                                        $res = $sql->fetchAll(PDO::FETCH_OBJ);
                                        foreach($res as $row){

                                            ?>
                                            <option value="<?php echo $row->name ?>"><b><?php echo $row->name ?> | <?php echo number_format($row->price_btc,8,".",".")?>  BTC </option>
                                        <?php
                                        }
                                    }

                                    ?>
                                </select></center><br>
                            <button class="btn btn-success" name="set-upgrade">Confimar</button>

                        </form>
                    </div></center>

        </div>
    </div>
</body>

</html>