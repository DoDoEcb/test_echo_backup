<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
    require_once("class/DAO/Structure.Class.php");
require_once("logicas.php");

    $Structure = new Structure;

    //Variaveis para ativaçao visual dos links.
    $dropUm = ""; $dropDois = ""; $dropTres = "";
    $linkUm = "active"; $linkDois = ""; $linkTres = ""; $linkQuatro = ""; $linkCinco = "";
    $linkSeis = ""; $linkSete = ""; $linkOito = ""; $linkNove = ""; $linkDez = ""; $linkOnze = "";
    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> Admin</title>
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
                <h1>Dashboard</h1>
            </div>
            <!--End-breadcrumbs-->
            
            
            <!--Chart-box-->
            <div class="container-fluid">
                <hr/>
                <div class="row-fluid">
                    <div class="widget-box">
                        
                        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                            <h5>Analise do site</h5>
                        </div>

                        <div class="widget-content" >
                            <div class="row-fluid">
                                <div class="span12">
                                    <form method="post">
                                    <center><p style="font-size: 20pt">O saque está <b><?php echo $admin->saque?></b></p></center>
                                    <center><button type="submit" class="btn btn-success" name="saque" value="Liberado">Saque Liberado </button> </center>
                                    <center><button type="submit" name="saque" class="btn btn-danger" value="Bloqueado">Saque Bloqueado </button> </center>
                                    </form>
                                    <br>
                                        <ul class="site-stats">

                                  <!--  <li class="bg_lh"><i class="icon-money"></i> <strong><?php echo number_format($N_users_Entrada_dolar,2,".",".")?></strong> <small>Total de Entrada em Dolar</small></li>
                                    <li class="bg_lh"><i class="icon-money"></i> <strong><?php echo number_format($N_users_Entrada_btc,8,".",".")?></strong> <small>Total de Entrada em Bitcoin</small></li>-->
                                        <li class="bg_lh"><i class="icon-money"></i> <strong><?php echo number_format($N_users_Retirada_Pago,8,".",".")?></strong> <small>Total de Saida Paga</small></li>
                                        <li class="bg_lh"><i class="icon-money"></i> <strong><?php echo number_format($N_users_Retirada_Pendente,8,".",".")?></strong> <small>Total de Saida Pendente</small></li>
                                       <!-- <li class="bg_lh"><i class="icon-user"></i> <strong><?php echo $N_users_ativo?></strong> <small>Total de Cadastros Agora</small></li>
                                        <li class="bg_lh"><i class="icon-dashboard"></i> <strong><?php echo $N_users_Online?></strong> <small>Usuarios Online</small></li>
                                        <li class="bg_lh"><i class="icon-dashboard"></i> <strong><?php echo $N_plan_b?></strong> <small>Total Bronze</small></li>
                                        <li class="bg_lh"><i class="icon-dashboard"></i> <strong><?php echo $N_plan_p?></strong> <small>Total Prata</small></li>
                                        <li class="bg_lh"><i class="icon-dashboard"></i> <strong><?php echo $N_plan_o?></strong> <small>Total Ouro</small></li>
                                        <li class="bg_lh"><i class="icon-dashboard"></i> <strong><?php echo $N_plan_e?></strong> <small>Usuarios Esmeralda</small></li>
                                        <li class="bg_lh"><i class="icon-dashboard  "></i> <strong><?php echo $N_plan_d?></strong> <small>Usuarios Diamante</small></li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--End-Chart-box--> 
                    <hr/>
                    
                   <!-- <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                            <h5>Static table</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td>Trident</td>
                                        <td>Internet
                                            Explorer 4.0</td>
                                        <td>Win 95+</td>
                                        <td class="center"> 4</td>
                                        <td class="center">X</td>
                                    </tr>
                                    <tr class="even gradeC">
                                        <td>Trident</td>
                                        <td>Internet
                                            Explorer 5.0</td>
                                        <td>Win 95+</td>
                                        <td class="center">5</td>
                                        <td class="center">C</td>
                                    </tr>
                                    <tr class="odd gradeA">
                                        <td>Trident</td>
                                        <td>Internet
                                            Explorer 5.5</td>
                                        <td>Win 95+</td>
                                        <td class="center">5.5</td>
                                        <td class="center">A</td>
                                    </tr>
                                    <tr class="even gradeA">
                                        <td>Trident</td>
                                        <td>Internet
                                            Explorer 6</td>
                                        <td>Win 98+</td>
                                        <td class="center">6</td>
                                        <td class="center">A</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>-->
            <hr/>
                
            </div>
        </div>
        
        <!--end-main-container-part-->
        
        <!--Footer-part-->
        
        <div class="row-fluid">
            <div id="footer" class="span12"> Todos os direitos reservados <a href="http://lionbitcoin.com" target="_blank">LionBitcoin Desenvolvimentos</a>&copy; 2016 </div>
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
