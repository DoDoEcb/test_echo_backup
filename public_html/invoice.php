<?php
include_once("head.php");
?>
<body>
<!-- Start Page Loading -->
<!-- End Page Loading -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
<?php
include_once("header.php");
//Busca valores da moeda atual
function currency($icoin2, $icoin1, $value=1) {
    $coin1 = strtoupper($icoin1);
    $coin2 = strtoupper($icoin2);
    $coin1 = preg_replace("/[^A-Z{3}]/", null, $coin1);
    $coin2 = preg_replace("/[^A-Z{3}]/", null, $coin2);

    $currency = "'BRLBTC=X',0.00102,'4/20/2017','0:44am',0.00102,0.00102";
    $currency = explode(",", $currency);
    $value = (float)($currency[1]*$value);
    return $value;
}

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
                                    <h5 class="breadcrumbs-title">Seus Pedidos</h5>
                                    <ol class="breadcrumbs">
                                        <li><a href="index.php">Escritorio</a></li>
                                        <li><a href="invoice.php">Pedidos</a></li>
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
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Descrição</th>
                                        <th>Usuário</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>**</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $sql = $pdo->pdo->query("SELECT * FROM invoice_upgrade WHERE personal_id='$row->personal_id'");
                                    if($sql->rowCount() >0){
                                        $res = $sql->fetchAll(PDO::FETCH_OBJ);
                                        foreach($res as $ref){
                                            $Wallet = $block_io->get_address_by_label(array('label'=> $ref->pedido));
                                            $block_io->get_address_by(array('label'=> $ref->pedido));

                                            require_once("../scripts/Classes/actions/_Functions.php");

                                            $Functions = new _Functions();

                                            if($Wallet->data->available_balance >= $ref->price_now AND $ref->status != "Payd"){

                                            $Functions->AtivarUpgrade($ref->price_now,$ref->patrocinador,$ref->personal_id,$ref->username,$ref->plan_up,$ref->pedido);

                                                ?>
                                                <script>
                                                    alert("Upgrade Ativo com sucesso"),window.location='invoice';
                                                </script>
                                                <?php
                                                echo "STATUS ATIVO";
                                                $sts =  '#50FF7D';
                                                $or = 'Payd';
                                            }
                                                if($ref->status != 'Payd'){
                                                    $sts = 'red';
                                                }else{
                                                    $sts = "Green";
                                                }
                                            $DolartoBtc2 =  currency('BTC', 'BRL', $ref->price_up);
                                            ?>
                                            <tr>
                                                <td><?php echo $ref->date?></td>
                                                <td><?php echo $ref->pedido?></td>
                                                <td><?php echo $ref->descricao?></td>
                                                <td><?php echo $ref->username?></td>
                                                <td><?php echo number_format($ref->price_now,8,".",".")?> BTC </td>
                                                <td class="numeric" style="color: <?php echo $sts ?>"><?php echo $ref->status?></td>
                                                <?php
                                                if($Wallet->data->available_balance >= $ref->price_now){
                                                    ?>
                                                <td></td>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <td><a class="waves-effect waves-light btn modal-trigger  light-blue" href="#modal1" onclick="request<?php echo $ref->pedido ?>()"  style="color: #ff8e4d;font-size: 11pt;" data-toggle="modal">Pay Bitcoin</button></a>
                                                    </td>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if($ref->status !='Payd'){
                                                    ?>

                                                    <td><a href="invoice?Delete=<?php echo $ref->pedido?>" style="color: #f55531;font-size: 12pt;"> <i class="fa fa-trash "></i> Delete</a></td>

                                                <?php
                                                }else{

                                                    ?>

                                                    <td><a href="https://chain.so/address/BTCTEST/<?php echo$Wallet->data->address?>" target="_blank" style="color: green;font-size: 12pt;"> <i class="fa fa-btc "></i> Comprovante</a></td>

                                                <?php
                                                }
                                                ?>

                                            </tr>

                                            <script type="text/javascript">
                                                function request<?php echo $ref->pedido;?>() {
                                                    document.getElementById('pedNumber').innerHTML = "<input type='hidden' name='invoice' value='<?php echo $ref->pedido; ?>'>";
                                                    document.getElementById('write-pedido').innerHTML = "#<?php echo $ref->pedido; ?>";
                                                    document.getElementById('price').innerHTML = "<?php $price =  $ref->price_now; ?>";

                                                }

                                            </script>
                                        <?php

                                        }
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--chart dashboard end-->

                    <!-- //////////////////////////////////////////////////////////////////////////// -->
                </div>
                <!-- END WRAPPER -->

            </div>
            <!-- END MAIN -->
            <div id="modal1" class="modal">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title" id="myModalLabel">Pagar sua fatura </h4>
                    </div>
                    <form method="post">
                        <form method="post">
                            <center> <div class="modal-body">
                                    <center><p style="font-size: 22px">ID Pedido : <b id="write-pedido"></b></p></center>
                                    <?php

                                    $aux = 'qr_img0.50j/php/qr_img.php?';
                                    $aux .= "d=bitcoin:⁠⁠⁠1MvU3mjCVSXFcVayHtUkohtaiE6kun6jbh?amount=0.000090&r=http%3A%2F%2Fwww.EmpireBits.esy.es%2Fonebit%2Fscripts%2Fcron.php";
                                    $aux .= 'e=H&';
                                    $aux .= 's=10&';
                                    $aux .= 't=J';
                                    ?>

                                    <center><b>Price : <?php echo $price ?></b> BTC</center>
                                    <script type="text/javascript">
                                        $('#botao').click(function(e){
                                            e.preventDefault();
                                            var texto = '234234234';
                                            var nivel = $('#nivel').val();
                                            var pixels = $('#pixels').val();
                                            var tipo = $('input[name="img"]:checked').val();


                                        if(texto.length == 0){
                                            alert('Informe um texto');
                                            return(false);
                                        }
                                        alert('qr_img0.50j/php/qr_img.php?d='+texto+'&e='+nivel+'&s='+pixels+'&t='+tipo);
                                        $('img').attr('src', 'qr_img0.50j/php/qr_img.php?d='+texto+'&e='+nivel+'&s='+pixels+'&t='+tipo);
                                    });
                                </script>
                                <p style="margin-left: 30%;"><b><?php echo $Wallet->data->address?></b></p>
                                    <p></p>

                                <input type="hidden" name="valor" value="<?php echo $price ?>">

                                <span id="pedNumber"></span>
                            </div></center>

                        <center><div class="modal-footer">
                                <button class="control border rounded default hover-inverse" type="submit" name="confirm_wallet" >Confirmar</button>
                                <button class="control border rounded white " data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            </div></center>
                    </form>
                </div>
            </div>


            <!-- //////////////////////////////////////////////////////////////////////////// -->

            <?php
            include_once("footer.php");

            ?>
            <!-- jQuery Library -->
            <script type="text/javascript" src="../js/plugins/jquery-1.11.2.min.js"></script>
            <!--materialize js-->
            <script type="text/javascript" src="../js/materialize.min.js"></script>
            <!--prism-->
            <script type="text/javascript" src="../js/plugins/prism/prism.js"></script>
            <!--scrollbar-->
            <script type="text/javascript" src="../js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <!-- chartist -->
            <script type="text/javascript" src="../js/plugins/chartist-js/chartist.min.js"></script>

            <!--plugins.js - Some Specific JS codes for Plugin Settings-->
            <script type="text/javascript" src="../js/plugins.min.js"></script>
            <!--custom-script.js - Add your own theme custom JS-->
            <script type="text/javascript" src="../js/custom-script.js"></script>


</body>

</html>