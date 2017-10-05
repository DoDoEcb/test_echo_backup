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
                                    <h5 class="breadcrumbs-title">Segurança</h5>
                                    <ol class="breadcrumbs">
                                        <li><a href="index.php">Escritorio</a></li>
                                        <li><a href="secury.php">Segurança</a></li>
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
                                <div class="row">
                                    <div class="col-md-12  text-center">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="Senha Atual" size="10" style="width: 30%;text-align: center; color:black" required="">
                                                <i class="form-group__bar"></i>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="newpass" placeholder="Nova Senha" size="10" style="width: 30%;text-align: center; color:black" required="">
                                                <i class="form-group__bar"></i>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="cpass" placeholder="Confirmar nova Senha" size="10" style="width: 30%;text-align: center; color:black" required="">
                                                <i class="form-group__bar"></i>
                                            </div>
                                        </div>
                                        <br>
                                        <div class=" text-center">
                                            <button class="btn btn-success" name="set-newpass">Confirmar <i class="fa fa-check" style="font-size: 25px;"></i></button><br><br>
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