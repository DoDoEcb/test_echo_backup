<?php
include_once("head.php");
?>
<body>
<!-- Start Page Loading -->
<!-- End Page Loading -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
<?php
include_once("header.php");
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
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <h5 class="breadcrumbs-title">Rede </h5>
                                    <ol class="breadcrumbs">
                                        <li><a href="index.php">Escritorio</a></li>
                                        <li><a href="network.php">Rede</a></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--breadcrumbs end-->


                    <!--start container-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-box clearfix">
                                <div class="main-box-body clearfix">
                                    <div class="table-responsive">
                                        <form method="post" style="margin-top: -23px;">

                                            <?php
                                            $user_binario = base64_encode("hexa".$row->personal_id);
                                            ?>
                                            <div class=" the-box">
                                                <br>
                                                <br>
                                                <div class="panel panel-default">
                                                   <center> <div class="panel-heading">Escolha sua perna para trabalho    <div class="button-min">
                                                            <i class="icon-minus"></i>
                                                        </div></center>
                                                    </div>

                                                    <div class="panel-body minizend">

                                                        <center><form id="form-escolher-perna" name="Perna" method="post" style="margin-top: -23px;">
                                                                <br>

                                                                &nbsp;&nbsp;
                                                                <input name="Perna[]" id="test1" type="radio" value="esquerda" <?php echo ($row2->direcao == 'esquerda') ? 'checked' : '' ?>>
                                                                <label for="test1"><?php echo ($row2->direcao == 'esquerda')?> Esquerda</label>
                                                                 &nbsp;&nbsp;
                                                                <input name="Perna[]" id="test2" type="radio" value="direita" <?php echo ($row2->direcao == 'direita') ? 'checked' : '' ?>>
                                                                <label for="test2"><?php echo ($row2->direcao == 'esquerda')?> Direita</label>

                                                                &nbsp;&nbsp;
                                                                <input type="submit" value="Salvar" class="btn btn-success">
                                                            </form></center>
                                                    </div>
                                                </div>
                                               <center> <div class="panel-heading ui-draggable-handle">
                                                    <h3 class="panel-title" style="font-size:1em;"><span class="fa fa-sitemap"></span> Rede Binária - (Pontos equiparados <?php $valor = $Binario->equiparados; if(empty($valor)){ echo '0';}else{ echo $valor;} ?> Pontos) - (Plano de carreira <?php echo $Binario->planoDeCarreira;?> Pontos)</h3>
                                                </div></center>
                                               <center><div class="main-box">
                                                      <span class="headline"><b>Status do Binário :<b style="color : <?= $color_binario ?>"> <?php echo $qualificado?></b></span></center>



                                            <div class="row">
                                                <div class="col s12 m6 l3">
                                                    <div class="card">
                                                        <div class="card-content  green white-text">
                                                            <p class="card-stats-title"><i class="mdi-social-group-add"></i>Equipe Esquerda</p>
                                                            <h4 class="card-stats-number"><?php echo $equie?></h4>

                                                            </p>
                                                        </div>
                                                        <div class="card-action  green darken-2">
                                                            <div id="clients-bar" class="center-align"><canvas style="display: inline-block; width: 227px; height: 25px; vertical-align: top;" width="227" height="25"></canvas></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col s12 m6 l3">
                                                    <div class="card">
                                                        <div class="card-content purple white-text">
                                                            <p class="card-stats-title"><i class="mdi-editor-attach-money"></i>Pontos</p>
                                                            <h4 class="card-stats-number"><?php echo $pontos_esquerda?></h4>

                                                            </p>
                                                        </div>
                                                        <div class="card-action purple darken-2">
                                                            <div id="sales-compositebar" class="center-align"><canvas style="display: inline-block; width: 214px; height: 25px; vertical-align: top;" width="214" height="25"></canvas></div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col s12 m6 l3">
                                                    <div class="card">
                                                        <div class="card-content blue-grey white-text">
                                                            <p class="card-stats-title"><i class="mdi-action-trending-up"></i>Equipe Direita</p>
                                                            <h4 class="card-stats-number"><?php echo $equid?></h4>

                                                            </p>
                                                        </div>
                                                        <div class="card-action blue-grey darken-2">
                                                            <div id="profit-tristate" class="center-align"><canvas style="display: inline-block; width: 227px; height: 25px; vertical-align: top;" width="227" height="25"></canvas></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col s12 m6 l3">
                                                    <div class="card">
                                                        <div class="card-content deep-purple white-text">
                                                            <p class="card-stats-title"><i class="mdi-editor-insert-drive-file"></i> Pontos</p>
                                                            <h4 class="card-stats-number"><?php echo $pontos_direita?></h4>

                                                            </p>
                                                        </div>
                                                        <div class="card-action  deep-purple darken-2">
                                                            <div id="invoice-line" class="center-align"><canvas style="display: inline-block; width: 224px; height: 25px; vertical-align: top;" width="224" height="25"></canvas></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div> <div class="clearfix">
                                                            <br>
                                                    </div>
                                                <br>
                                                <br>
                                                <!--<center> <form method="post"> <input type="text" name="usuario"><button class="btn btn-success" name="buscar">Buscar no Binario </button></form></center>-->

                                                <?php
                                                if(isset($_POST['buscar'])){

                                                    $sql = $pdo->pdo->query("SELECT * FROM usuarios where username='$_POST[usuario]' AND id>='$row->personal_id'");
                                                    if($sql->rowCount()>0){
                                                        $res = $sql->fetch(PDO::FETCH_OBJ);
                                                        $usuario = $res->id;

                                                    }else{
                                                        $usuario = $row->personal_id;
                                                    }
                                                    ?>
                                                    <iframe src="../rede_binaria.php?get=<?php echo $usuario;?>" style="height:600px;width:100%;border: none"></iframe>
                                                <?php
                                                }else {

                                                    ?>
                                                    <iframe src="../rede_binaria.php?get=<?php echo $user_binario;?>"
                                                            style="height:600px;width:100%;border: none"></iframe>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- //////////////////////////////////////////////////////////////////////////// -->
                </div>
                <!-- END WRAPPER -->

            </div>
            <!-- END MAIN -->



            <!-- //////////////////////////////////////////////////////////////////////////// -->

            <?php
            include_once("footer.php");
            include_once("javascript.php");
            ?>


</body>

</html>