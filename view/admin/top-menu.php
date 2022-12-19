<div id="head-nav" class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-collapse">
            <ul class="nav navbar-nav navbar-left pedidos-alerta" style="margin-top: 20px;">
                <span class="fa fa-bell fa-4x"></span>
                <?php  if(isset($data['config']) && $data['config']->config_bell == 0): ?>
                    <a href="<?php echo $baseUri; ?>/configuracao/"
                       sclass="btn btn-xs btn-primary">Alerta sonoro desativado</a>
                <?php endif;?>
            </ul>
            <ul class="nav navbar-nav navbar-right user-nav">
                <li class="dropdown profile_menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!--
                        <img alt="Avatar" src="<?php echo Sessao::get_avatar();?>" width="50" height="50" class="img-circle"/><span><?php echo Sessao::get_nome(); ?></span> <b class="caret"></b></a>
                        -->
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $baseUri; ?>/usuario/me/">Minha Conta</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $baseUri; ?>/login/logout/">Sair</a></li>
                    </ul>
                </li>
            </ul>		
        </div>
    </div>
</div>
<!-- variaveis usadas no main.js -->
<script> var baseUri = '<?php echo $baseUri; ?>'; </script>
<script> var baseDir = window.baseUri; </script>
