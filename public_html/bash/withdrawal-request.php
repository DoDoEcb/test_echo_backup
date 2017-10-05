    <?php
    require_once("class/DAO/Structure.Class.php");
    require_once("logicas.php");
    $Structure = new Structure;
    //Busca valores da moeda atual
    function currency($icoin2, $icoin1, $value=1) {
        $coin1 = strtoupper($icoin1);
        $coin2 = strtoupper($icoin2);
        $coin1 = preg_replace("/[^A-Z{3}]/", null, $coin1);
        $coin2 = preg_replace("/[^A-Z{3}]/", null, $coin2);
        $currency = 'BTCBRL=X",3450.9539,"1/5/2017","6:44pm",3450.9539,3118.2104';
        $currency = explode(",", $currency);
        $value = (float)($currency[1]*$value);
        return $value;
    }

    //Variaveis para ativaçao visual dos links.
    $dropUm = ""; $dropDois = ""; $dropTres = "active open";
    $linkUm = ""; $linkDois = ""; $linkTres = ""; $linkQuatro = ""; $linkCinco = "";
    $linkSeis = ""; $linkSete = ""; $linkOito = ""; $linkNove = ""; $linkDez = "active"; $linkOnze = "";
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <title>Matrix Admin</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/fullcalendar.css" />
        <link rel="stylesheet" href="css/matrix-style.css" />
        <link rel="stylesheet" href="css/matrix-media.css" />
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/jquery.gritter.css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    </head>
    <script>
        function cont(){
            var conteudo = document.getElementById('print').innerHTML,
                tela_impressao = window.open('about:blank');
            tela_impressao.document.write(conteudo);
            tela_impressao.window.print();
            tela_impressao.window.close();

        }
    </script>
    <body>

    <?php

                        $sql = $pdo->pdo->query("SELECT SUM(valor) as total_saque FROM withdraw WHERE status='Pending' ");

                        if($sql->rowCount()>0) {
                            $res2 = $sql->fetch(PDO::FETCH_OBJ);
                        }
                        $total_saque = $res2->total_saque;

    // Chamando funçao com o cabeçalho e o painel lateral da pagina.
    $Structure->Navigator($dropUm, $dropDois, $dropTres, $linkUm, $linkDois, $linkTres, $linkQuatro, $linkCinco, $linkSeis, $linkSete, $linkOito, $linkNove, $linkDez, $linkOnze);
    ?>
    <!--main-container-part-->
    <div id="content">
        <!--breadcrumbs-->
        <div id="content-header">
            <div id="breadcrumb"><a href="index.php" title="Voltar ao início" class="tip-bottom"><i class="icon-home"></i> Início</a></div>
            <h1>Solicitaçao de saque</h1>
        </div>
        <!--End-breadcrumbs-->


        <!--Chart-box-->
        <div class="container-fluid">
            <hr/>
            <div class="row-fluid">
                <?php

                $total_saque_reais =  currency('BTC', 'BRL', $total_saque);
                ?>
                <center><b style="color: red">TOTAL EM SAQUE : <?php echo number_format($total_saque_reais,2,",",".")?></b></center>
                <?php

                $sql = $pdo->pdo->query("SELECT SUM(valor) as somatotal FROM withdraw WHERE status='Pending' ");

                if($sql->rowCount()>0) {
                    $res = $sql->fetch(PDO::FETCH_OBJ);
                   // echo "TOTAL EM SAQUE :<span style='font-size: 20px;color: red'>".number_format($res->somatotal,8,".",".")."</span>";
                }
                ?>
                <!--End-Chart-box-->

                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Static table</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div id="print" class="conteudo">
                            <input type="button" onclick="cont();" value="Imprimir Div separadamente">


                            <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Login de usuario</th>
                                <th>Nome Completo</th>
                                <th>Carteira</th>
                                <th>Valor à Pagar</th>
                                <th>Açao</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                    $sql = $pdo->pdo->query("SELECT * FROM withdraw WHERE status='Pending' ORDER BY id ASC ");

                            if($sql->rowCount()>0) {
                            $res = $sql->fetchAll(PDO::FETCH_OBJ);

                            foreach ($res as $row) {
                                $DolartoBtc =  currency('BTC', 'BRL', $row->valor);
                                $solicitado =  currency('BTC', 'BRL', $row->valor_solicitado);

                            ?>

                            <tr class="odd gradeX">
                                <td><?php echo $row->pedido?></td>
                                <td><?php echo $row->data?></td>
                                <td><?php echo $row->username?></td>
                                <?php
                                $valors = $row->valor_solicitado;
                                $sql = $pdo->pdo->query("SELECT * FROM usuarios WHERE username='$row->username' ");

                                if($sql->rowCount()>0) {
                                    $res2 = $sql->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($res2 as $row2) {

                                    ?>

                                    <td><?php echo $row2->name?></td>
                                    <td><?php echo $row2->wallet?></td>
                                    <?php
                                }
                                }else{
                                        ?>
                                    }
                                <?php

                                }
                                    ?>
                                <td style="color: green; font-size: 15pt;"><?php echo  number_format($row->valor,8,".",".");?></td>
                                <td width="25%"><a href="withdrawal-request?payfor=<?php echo $row->id?>&pedido=<?php echo $row->pedido?>&username=<?php echo $row->username?>&valor=<?php echo $row->valor?>"><button class="btn btn-success">Pagar</button></a>
                               <td><form method="post"><button class="btn btn-info" name="estorna" value="<?php echo $row->pedido?>">Estornar Saque</button> <input type="text" name="Motivo" class="form-control" placeholder="Motivo"></form></td>

                            </tr>
                            <?php
                                if(isset($_POST['descricao'])){

                                    ?>
                            <script>window.location='withdrawal-request?stornfor=<?php echo $row->id?>&username=<?php echo $row->username?>&valor=<?php echo $valors?>&pedido=<?php echo $row->pedido?>&&descricao=<?php echo $_POST['descricao']?>'</script>
                                    <?php

                                }
                            }
                            }

                            ?>
                            </tbody>
                        </table>
</div>
                    </div>

                </div>

            </div>
            <hr/>

        </div>
    </div>

    <!--end-main-container-part-->

    <!--Footer-part-->

    <div class="row-fluid">
        <div id="footer" class="span12"> Todos os direitos reservados <a href="http://themedesigner.in">Mocha Desenvolvimentos</a>&copy; 2016 </div>
    </div>

    <!--end-Footer-part-->

    <script src="js/excanvas.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.ui.custom.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.flot.min.js"></script>
    <script src="js/jquery.flot.resize.min.js"></script>
    <script src="js/jquery.peity.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <script src="js/matrix.js"></script>
    <script src="js/matrix.dashboard.js"></script>
    <script src="js/jquery.gritter.min.js"></script>
    <script src="js/matrix.interface.js"></script>
    <script src="js/matrix.chat.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/matrix.form_validation.js"></script>
    <script src="js/jquery.wizard.js"></script>
    <script src="js/jquery.uniform.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/matrix.popover.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/matrix.tables.js"></script>

    <script type="text/javascript">
        // This function is called from the pop-up menus to transfer to
        // a different page. Ignore if the value returned is a null string:
        function goPage (newURL) {

            // if url is empty, skip the menu dividers and reset the menu selection to default
            if (newURL != "") {

                // if url is "-", it is this page -- reset the menu:
                if (newURL == "-" ) {
                    resetMenu();
                }
                // else, send page to designated URL
                else {
                    document.location.href = newURL;
                }
            }
        }

        // resets the menu selection upon entry to this page:
        function resetMenu() {
            document.gomenu.selector.selectedIndex = 2;
        }
    </script>
    </body>
    </html>
