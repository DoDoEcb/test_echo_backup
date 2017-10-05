<!-- START HEADER -->
<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="navbar-color">
            <div class="nav-wrapper">
                <ul class="left">
                    <li><h1 class="logo-wrapper"><span class="logo-text">System mining</span></h1></li>
                </ul>
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="logout"><i class="mdi-hardware-keyboard-tab"></i></a>
                    </li>
                </ul>
                <!-- translation-button -->

                <!-- notifications-dropdown -->
                <ul id="notifications-dropdown" class="dropdown-content">
                    <li>
                        <h5>Personal Info</h5>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#!"><i class="mdi-action-settings"></i>Personal Setings</a>
                    </li>
                    <li>
                        <a href="logout"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                    </li>


                </ul>
               
        </nav>
    </div>
    <!-- end header nav-->
</header>
<!-- END HEADER --><script src="../js/page-loader.min.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#result").load("minerar.php");
        var atualizar = setInterval(function() {
            $("#result").load('minerar.php?cache='+ Math.random());
        }, 10000);
    });

</script>
