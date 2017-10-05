<!-- START LEFT SIDEBAR NAV-->
<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li style="background-color: rgba(15, 15, 15, 0.91)">
            <div class="row"><br>
                <div class="">
                 <center>   <img src="../images/empirebits.png" alt="" style="width: 80%;"></center>
                </div>
                <div class="col col s8 m8 l8">
                    <ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="settings.php"><i class="mdi-action-settings"></i> Configurações</a>
                        </li>
                        <li><a href="logout.php"><i class="mdi-hardware-keyboard-tab"></i> Sair</a>
                        </li>
                    </ul>
                    <center><a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $row->username ?><i class="mdi-navigation-arrow-drop-down right"></i></a></center>
                </div>
            </div>
        </li>
        <li class="bold active"><a href="index" class="waves-effect waves-cyan"><i class="mdi-action-wallet-travel"></i> Escritório</a>
        </li>
        
        <li class="bold"><a href="extract" class="waves-effect waves-cyan"><i class="mdi-editor-insert-chart"></i> Extrato</a>
        </li>
        <li class="bold"><a href="invoice" class="waves-effect waves-cyan"><i class="mdi-action-assignment"></i> Pedidos</a>
        </li>
        <li class="bold"><a href="withdrawal" class="waves-effect waves-cyan"><i class="mdi-editor-attach-money"></i> Retirar Bitcoins</a>
        </li>
        <li><a href="network"><i class="mdi-social-person-add"></i>Minha Rede </a>
        <li><a href="https://www.flexipay.com.br/flexishop/"><i class="mdi-maps-local-grocery-store"></i>Loja Virtual</a>
        <li><a href="binary"><i class="mdi-av-web"></i> Rede Binaria </a>
        </li>
        <li><a href="settings"><i class="mdi-action-settings"></i> Configurações</a>
        </li>
        <li><a href="secury"><i class="mdi-action-lock"></i> Segurança</a>
        </li>
        <li><a href="logout"><i class="mdi-hardware-keyboard-tab"></i> Sair</a>
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
</aside>
<!-- END LEFT SIDEBAR NAV-->