<?php $isMobile = Browser::agent('mobile'); ?>
    <nav class="navbar navbar-default navbar-fixed-top" id="myNav">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-bars"></i>
                </button>
                <?php if (isset($data['lista_combo'])) : ?>
                    <button type="button" class="navbar-toggle collapsed"
                            data-toggle="modal" data-target="#modal-carrinho">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-shopping-bag"></i>
                        <span id="cart-count"></span>
                    </button>
                <?php else: ?>
                    <a href="<?= $baseUri ?>" class="navbar-toggle collapsed">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-home"></i>
                    </a>
                <?php endif; ?>
                <a class="navbar-brand" href="<?= $baseUri ?>" id="brand-logo">
                    <img src="<?= $baseUri ?>/midias/logo/<?= (new configModel)->get_config()->config_foto; ?>"
                         alt="logo"/>
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($data['lista_combo'])) : ?>
                        <li><a href="#" data-target="#modal-carrinho" data-toggle="modal"><i
                                        class="fa fa-shopping-cart"></i>
                                MEU CARRINHO</a>
                        </li>
                    <?php else: ?>
                        <?php if (Carrinho::isfull()): ?>
                            <li><a href="<?= $baseUri ?>/pedido/"><i class="fa fa-shopping-cart"></i>
                                    MEU CARRINHO
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (ClienteSessao::get_id() > 0): ?>
                        <li><a href="<?= $baseUri ?>/meus-pedidos/"><i class="fa fa-th-list"></i> MEUS PEDIDOS</a></li>
                    <?php endif; ?>
                    <li><a href="<?= $baseUri ?>/promocoes/"><i class="fa fa-percent"></i> PROMOÇÕES</a></li>
                    <?php if (ClienteSessao::get_id() > 0): ?>
                        <li><a href="<?= $baseUri ?>/meus-dados/"><i class="fa fa-user-circle-o"></i> MEUS DADOS</a>
                        </li>
                        <li><a href="<?= $baseUri ?>/sair/"><i class="fa fa-power-off"></i> SAIR</a></li>
                    <?php else: ?>
                        <li><a href="<?= $baseUri ?>/entrar/"><i class="fa fa-user-circle-o"></i> ENTRAR</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
