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
                                    <h5 class="breadcrumbs-title">Extrato</h5>
                                    <ol class="breadcrumbs">
                                        <li><a href="index.php">Escritorio</a></li>
                                        <li><a href="extract.php">Extrato</a></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--breadcrumbs end-->


                    <!--start container-->
                    <div class="container">
                        <div class="section">

                            <div class="divider"></div>

                            <!--Borderless Table-->
                            <div class="card__body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>ID</th>
                                            <th>Descrição</th>
                                            <th class="numeric">Usuário</th>
                                            <th class="numeric">Valor</th>
                                            <th class="numeric">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql = $pdo->pdo->query("SELECT * FROM extrato WHERE personal_id='$row->personal_id' ORDER by id DESC");
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
                    <!--chart dashboard end-->

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