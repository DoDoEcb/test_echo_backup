           <?php
        require_once("class/DAO/Structure.Class.php");
        require_once("logicas.php");
        $Structure = new Structure;
        function currency($icoin2, $icoin1, $value=1) {
            $coin1 = strtoupper($icoin1);
            $coin2 = strtoupper($icoin2);
            $coin1 = preg_replace("/[^A-Z{3}]/", null, $coin1);
            $coin2 = preg_replace("/[^A-Z{3}]/", null, $coin2);
            $currency = "BTCBRL=X,2652.8982, 12/20/2016,8:24pm,2652.8982,2653.0596 2652.8982";
            $currency = explode(",", $currency);
            $value = (float)($currency[1]*$value);
            return $value;
        }
        //Variaveis para ativaçao visual dos links.
        $dropUm = "active open"; $dropDois = ""; $dropTres = "";
        $linkUm = ""; $linkDois = ""; $linkTres = ""; $linkQuatro = "active"; $linkCinco = "";
        $linkSeis = ""; $linkSete = ""; $linkOito = ""; $linkNove = ""; $linkDez = ""; $linkOnze = "";
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
        <body>

        <?php
        // Chamando funçao com o cabeçalho e o painel lateral da pagina.
        $Structure->Navigator($dropUm, $dropDois, $dropTres, $linkUm, $linkDois, $linkTres, $linkQuatro, $linkCinco, $linkSeis, $linkSete, $linkOito, $linkNove, $linkDez, $linkOnze);
        ?>
        <!--main-container-part-->
        <div id="content">
            <!--breadcrumbs-->
            <div id="content-header">
                <div id="breadcrumb"><a href="index.php" title="Voltar ao início" class="tip-bottom"><i class="icon-home"></i> Início</a></div>
                <h1>Usuarios A Renovar</h1>
            </div>
            <!--End-breadcrumbs-->


            <!--Chart-box-->
            <div class="container-fluid">
                <hr/>
                <div class="row-fluid">

                    <!--End-Chart-box-->

                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                            <h5>USUARIOS A Renovar</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Login de usuario</th>
                                    <th>Nome completo</th>
                                    <th>Status</th>
                                    <th>Data da Ativaçao</th>
                                    <th>Data da Renovação</th>
                                    <th>VALOR JÁ GANHO</th>
                                    <th>VALOR TOTAL </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $sql = $pdo->pdo->query("SELECT *,price_btc as valortotal,u.username as usernames,r.data as data_ativo FROM usuarios as u INNER JOIN  financeiro as f INNER JOIN  renovacao as r INNER JOIN plan as p  INNER JOIN withdraw as w  on f.plan=p.id AND u.id=f.personal_id AND r.personal_id=u.id  AND w.personal_id=f.personal_id WHERE f.status!='Renovar' AND w.valor>0 ORDER BY r.data_renovar DESC");
                                if($sql->rowCount()>0){
                                    $res = $sql->fetchAll(PDO::FETCH_OBJ);

                                    foreach($res as $row){
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $row->usernames?></td>
                                            <td><?php echo $row->name?></td>
                                            <td><?php echo $row->status?></td>
                                            <td class="center"> <?php echo $row->data_ativo?></td>
                                            <td class="center" style="font-size: 18pt;color:red"><b> <?php echo $row->data_renovar?></b></td>
                                            <?php

                                            $sql =$pdo->pdo->query("SELECT SUM(valor) as subvalor FROM withdraw WHERE username='$row->username' AND status!='reversed'  ");

                                            $res = $sql->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($res as $row2) {

                                                if($row2->subvalor > $row->valortotal){
                                                    $sts ='green';
                                                }
                                                $valorGanho =  currency('BTC', 'BRL', $row2->subvalor);
                                                $valorRenovar =  currency('BTC', 'BRL', $row->valortotal);
                                                ?>

                                                <td><?php echo  number_format($valorGanho,2,",",".")?></td>
                                                <td style="color: <?php echo $sts?>"><?php echo  number_format($valorRenovar*2,2,",",".")?></td>
                                            <?php
                                            }

                                            ?>



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
