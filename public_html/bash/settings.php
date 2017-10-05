<?php
    require_once("class/DAO/Structure.Class.php");
require_once("logicas.php");
    $Structure = new Structure;

    //Variaveis para ativaçao visual dos links.
    $dropUm = ""; $dropDois = ""; $dropTres = "";
    $linkUm = ""; $linkDois = ""; $linkTres = ""; $linkQuatro = ""; $linkCinco = "";
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
                <h1>Configuraçãoes</h1>
            </div>
            <!--End-breadcrumbs-->
            
            
            <!--Chart-box-->
            <div class="container-fluid">
                <hr/>
                <div class="row-fluid">
                    
                    <div class="span6">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-cogs"></i> </span>
                                <h5>Configuraçoes do fluxo do sistema</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <form action="#" method="get" class="form-horizontal">
                                    <div class="control-group">
                                        <label class="control-label">Liberar Saque :</label>
                                        <div class="controls">
                                            <select>
                                                <option>LIBERAR</option>
                                                <option>BLOQUEAR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Hora :</label>
                                        <div class="controls">

                                           DE : <input class="span11" placeholder="First name" style="width:30%;" type="text">
                                            <div class="controls" style="margin-left: -7%;">

                                            ATÉ  ÀS : <input class="span11" placeholder="First name" style="width:30%;" type="text">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>                       
                    </div>
                    
                    <div class="span6">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-cogs"></i> </span>
                                <h5>Configuraçao de informaçoes do Plano</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <form action="#" method="get" class="form-horizontal">
                                    <div class="control-group">
                                        <label class="control-label">Plano 1 :</label>
                                        <div class="controls">
                                            <input class="span11" placeholder="First name" type="text">
                                            <input class="span11" placeholder="First name" type="text">
                                            <input class="span11" placeholder="First name" type="text">
                                            <input class="span11" placeholder="First name" type="text">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Plano 2 :</label>
                                        <div class="controls">
                                            <input class="span11" placeholder="Last name" type="text">
                                            <input class="span11" placeholder="Last name" type="text">
                                            <input class="span11" placeholder="Last name" type="text">
                                            <input class="span11" placeholder="Last name" type="text">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Plano 3 :</label>
                                        <div class="controls">
                                            <input class="span11" placeholder="Enter Password" type="password">
                                            <input class="span11" placeholder="Enter Password" type="password">
                                            <input class="span11" placeholder="Enter Password" type="password">
                                            <input class="span11" placeholder="Enter Password" type="password">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Plano 4 :</label>
                                        <div class="controls">
                                            <input class="span11" placeholder="Company name" type="text">
                                            <input class="span11" placeholder="Company name" type="text">
                                            <input class="span11" placeholder="Company name" type="text">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Plano 5 :</label>
                                        <div class="controls">
                                            <input class="span11" type="text">
                                            <input class="span11" type="text">
                                            <input class="span11" type="text">
                                            <span class="help-block">Plano 6 :</span> </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Titulo Do Site :</label>
                                        <div class="controls">
                                            <input class="span11" placeholder="First name" type="text">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Nome do Site :</label>
                                        <div class="controls">
                                            <input class="span11" placeholder="Last name" type="text">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Minimo para saque em BTC</label>
                                        <div class="controls">
                                            <input class="span11" placeholder="Enter Password" type="password">
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>                       
                    </div>
                </div>
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
