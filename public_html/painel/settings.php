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
                                    <h5 class="breadcrumbs-title">Configurações</h5>
                                    <ol class="breadcrumbs">
                                        <li><a href="index.php">Escritorio</a></li>
                                        <li><a href="settings.php">Configurações</a></li>
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
                           <center> <form method="POST">
                                <div class="col-md-12  text-center">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <div class="form-group">
                                            <input class="form-control"  value="<?php echo $row->name?>" placeholder="" type="user"  style="width: 30%;font-size: 13pt;text-align: center; color:black" disabled>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <div class="form-group">
                                            <input class="form-control"  value="<?php echo $row->email?>"  placeholder="" type="email"  style="width: 30%;font-size: 13pt;text-align: center ; color:black" disabled>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-btc"></i></span>
                                        <div class="form-group">
                                            <input class="form-control"  value="<?php echo $row->wallet?>" name="wallet" placeholder="Carteira" style="width: 30%;font-size: 13pt;text-align: center; color:black" >
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <br>

                                    <div class=" text-center">
                                        <span class="fa fa-lock" style="font-size: 50px;"></span>
                                        <label>&nbsp; &nbsp;Digite sua Senha</label><br><input type="password" class="control-control" placeholder="Sua Senha" name="password" style="width: 15%;font-size: 12pt;text-align: center" required="">     <button class="btn btn-info" name="set-settings" type="submit">SAVE <i class="fa fa-lock" style="font-size: 25px;"></i></button>
                                    </div>
                                </div>
                        </div>

                        </form></center>
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