<?php
require_once("class/DAO/Structure.Class.php");
require_once("logicas.php");
$Structure = new Structure;

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
        <h1>Usuarios Bloqueados</h1>
    </div>
    <!--End-breadcrumbs-->


    <!--Chart-box-->
    <div class="container-fluid">
        <hr/>
        <div class="row-fluid">

            <!--End-Chart-box-->

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                    <h5>USUARIOS BLOQUEADO</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Login de usuario</th>
                            <th>Nome completo</th>
                            <th>IP</th>
                            <th>Status</th>
                            <th>Data da Ativaçao</th>
                            <th>Data da Renovação</th>
                            <th>WALLET</th>
                            <th>Açao</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = $pdo->pdo->query("SELECT * FROM usuarios as u INNER JOIN  financeiro as f INNER JOIN  renovacao as r  on u.id=f.personal_id AND r.personal_id=u.id WHERE f.block='Bloqueado'");
                        if($sql->rowCount()>0){
                            $res = $sql->fetchAll(PDO::FETCH_OBJ);

                            foreach($res as $row){
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row->username?></td>
                                    <td><?php echo $row->name?></td>
                                    <td><?php echo $row->adress_ip?></td>
                                    <td style="color: orange">Bloqueado</td>
                                    <td class="center"> <?php echo $row->data?></td>
                                    <td class="center"> <?php echo $row->data_renovar?></td>
                                    <td class="center"><b><?php echo $row->wallet?></b></td>
                                    <td class="center">

                                    <td class="center">
                                        <a href="profile?edit_user=<?php echo $row->username?>"> <button class="btn btn-info">Editar</button></a>
                                        <a href="profile?Unblock_user=<?php echo $row->username?>"> <button class="btn btn-default">Desbloquear</button></a>
                                        <a href="profile?del_user=<?php echo $row->username?>"><button class="btn btn-warning">Excluir</button></a>
                                    </td>
                                    </td>
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
