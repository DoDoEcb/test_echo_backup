<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Structure
 *
 * @author Wesley A. Alves <wesley.alves.jhenp@hotmail.com>
 * @copy All rights reserved by Mocha Developement
 * @version 1.0 beta
 * 
 */
class Structure {
    
    // Função que contém a estrutura do cabeçalho.
    function Navigator($dropUm, $dropDois, $dropTres, $linkUm, $linkDois, $linkTres, $linkQuatro, $linkCinco, $linkSeis, $linkSete, $linkOito, $linkNove, $linkDez, $linkOnze) {
        try {
            ?>
                <!--Header-part-->
                <div id="header">
                    <h1><a href="index.php">Admin</a></h1>
                </div>
                <!--close-Header-part--> 

                <!--top-Header-menu-->
                <div id="user-nav" class="navbar navbar-inverse">
                    <ul class="nav">

                        <li class=""><a title="" href="settings"><i class="icon icon-cog"></i> <span class="text">Configuraçao</span></a></li>
                        <li class=""><a title="" href="logout"><i class="icon icon-share-alt"></i> <span class="text">sair</span></a></li>
                    </ul>
                </div>
                <!--close-top-Header-menu-->
                <!--start-top-serch-->

                <!--close-top-serch-->
                <!--sidebar-menu-->
                <div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
                    <ul>
                        <li class="<?php echo $linkUm; ?>"><a href="index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
                        <li class="submenu <?php echo $dropUm ?>"> <a href="#"><i class="icon icon-user"></i> <span>Usuarios</span> <span class="label label-important">4</span></a>
                            <ul>
                                <li class="<?php echo $linkDois ?>"><a href="enabled-users">Usuários ativos</a></li>
                                <li class="<?php echo $linkTres ?>"><a href="disabled-users">Usuários Inativos</a></li>
                                <li class="<?php echo $linkQuatro ?>"><a href="block-users">Usuários Bloqueado</a></li>
                                <li class="<?php echo $linkCinco ?>"><a href="all-users">Todos os usuários</a></li>
                            </ul>

                        <li class="submenu <?php echo $dropTres ?>"> <a href="#"><i class="icon icon-list"></i> <span>Financeiro</span> <span class="label label-important">2</span></a>
                            <ul>
                                <li><a href="withdrawal-request">Solicitaçao / Saques</a></li>
                                <li ><a href="upgrade-request">Ativar Usuarios</a></li>
                                <li ><a href="prorenew">Usuarios a Renovar</a></li>
                                <li><a href="renovacao"><b style='color:red'>ATIVAR RENOVACAO</b></a></li>
                                <li><a href="withdrawal-requestpayd">Saques / Pagos</a></li>
                                <li><a href="withdraw_storm">Saques / Estornado</a></li>
                                <li><a href="invoice_payd">Faturas / Pagas</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>
                <!--sidebar-menu-->
            <?php
        } catch (Exception $ex) {
            echo "ERRO 01: {$ex->getMessage()}";
        }
    }
}
