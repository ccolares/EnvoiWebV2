<div class="cl-toggle"><i class="fa fa-bars"></i></div>
<div class="cl-navblock">
    <div class="menu-space">
        <div class="content">
        <h3 class="text-whites">&nbsp;</h3>
            <div class="sidebar-logo" style="padding-left:0px">
                <h5 style="color:#fff" class="text-center text-uppercase">
                    <?= (new configModel)->get_config()->config_nome; ?>
                </h5>
            </div>
            <div class="side-user">
                <div class="avatar hide"><img src="<?php echo Sessao::get_avatar(); ?>" alt="Avatar" width="50" height="50" /></div>
                <div class="info">
                    <p><b>PAINEL DE CONTROLE</b> <span><a name="dash-ancor"><i class="fa fa-cog"></i></a></span></p>
                    <div class="progress progress-user">
                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only hide">100%</span>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="cl-vnavigation">
                <li id="menu-dashboard"><a href="<?php echo $baseUri; ?>/admin/"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                <li id="menu-"><a href="<?php echo $baseUri; ?>/" target="_blank"><i class="fa fa-globe"></i><span>Visualizar site</span></a>
                <li id="menu-pedido"><a href="<?php echo $baseUri; ?>/admin/pedidos/"><i class="fa fa-list"></i><span>Pedidos</span></a>
                <li id="menu-cliente"><a href="<?php echo $baseUri; ?>/cliente/"><i class="fa fa-street-view"></i><span>Clientes</span></a>
                <li id="menu-categoria"><a href="<?php echo $baseUri; ?>/categoria/"><i class="fa fa-tags"></i><span>Categorias</span></a>
                <li id="menu-grupo"><a href="<?php echo $baseUri; ?>/grupo/"><i class="fa fa-th"></i><span>Grupos</span></a>
                <li id="menu-item"><a href="<?php echo $baseUri; ?>/item/"><i class="fa fa-th-list"></i><span>Produtos</span></a>
                <li id="menu-banner"><a href="<?php echo $baseUri; ?>/banner/"><i class="fa fa-picture-o"></i><span>Banner</span></a>
                <?php if( Sessao::get_nivel() == 1 ) : ?>
                <li id="menu-usuario"><a href="<?php echo $baseUri; ?>/usuario/"><i class="fa fa-users"></i><span>Usuários</span></a></li>
                <?php endif;?>
                <li id="menu-cupom"><a href="<?php echo $baseUri; ?>/cupom/"><i class="fa fa-money"></i><span>Cupons</span></a></li>
                <?php if( Sessao::get_nivel() == 1 ) : ?>
                <li id="menu-config">
                    <a href="<?php echo $baseUri; ?>/admin/"><i class="fa fa-cog"></i><span>Configurações</span></a>
                    <ul class="sub-menu">
                        <li id="menu-config-site"><a href="<?php echo $baseUri; ?>/configuracao/"><i class="fa fa-globe"></i> Configuração Geral</a></li>
                        <li id="menu-config-tema"><a href="<?php echo $baseUri; ?>/configuracao/tema/"><i class="fa fa-tint"></i> Aparência do Site</a></li>
                        <li id="menu-config-bairro"><a href="<?php echo $baseUri; ?>/entrega/bairro/"><i class="fa fa-map-marker"></i> Bairros para Entrega</a></li>
                        <li id="menu-config-pagseguro"><a href="<?php echo $baseUri; ?>/pagamento/"><i class="fa fa-money"></i> Parâmetros do PagSeguro</a></li>
                        <li id="menu-config-email"><a href="<?php echo $baseUri; ?>/configuracao-email/"><i class="fa fa-envelope-o"></i> Configurações de email</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <li id="menu-"><a href="<?php echo $baseUri; ?>/login/logout/"><i class="fa fa-power-off"></i><span>Sair / Deslogar</span></a></li>
            </ul>
        </div>
        <div class="text-right collapse-button" style="padding:7px 9px;">
            <button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="fa fa-angle-left"></i></button>
        </div>
    </div>
</div>