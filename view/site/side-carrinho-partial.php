<?php $baseUri = Http::base(); ?>
<?php if (Carrinho::isfull()): ?>
    <div class="panel-body" style="margin-top: 0px!important; padding-top: 0px!important">
        <div id="painel-carrinho">
            <?php foreach (Carrinho::get_all() as $cart): ?>
                <div class="item" id="list-item-<?= $cart->item_hash ?>">
                    <div class="row">
                        <div class="col-md-5 col-xs-9">
                            <div class="row text-left">
                                <i class="fa fa-minus-circle btn-plus-minus text-danger del-more"
                                   data-estoque="<?= $cart->item_estoque ?>"
                                   data-id="<?= $cart->item_id ?>"
                                   data-hash="<?= $cart->item_hash ?>"
                                   data-toggle="tooltip" title="-1"></i>&nbsp;
                                <span id="sp-qt-<?= $cart->item_hash ?>"
                                      class="item-qtde"><?= ($cart->qtde <= 9) ? "0$cart->qtde" : $cart->qtde ?></span>
                                <i class="fa fa-plus-circle btn-plus-minus text-success add-more"
                                   data-estoque="<?= $cart->item_estoque ?>"
                                   data-id="<?= $cart->item_id ?>"
                                   data-hash="<?= $cart->item_hash ?>"
                                   data-toggle="tooltip" title="+1"></i>
                                <span class="item-nome text-capitalize" style="padding-top: 2px"><?= strtolower($cart->item_nome) ?>
                                    <small class="item-estoque-<?= $cart->item_hash ?> text-danger" style="padding-top: 0px;padding-left: 5px;"></small>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-5 hidden-xs">
                            <?php if(strlen($cart->extra) <= 0) : ?>
                            <small class="text-muted"><?= strtolower($cart->item_obs) ?></small><br>
                            <?php endif;?>                            
                            <small class="text-muted"><?= substr($cart->extra, 0, -2) ?></small>
                        </div>
                        <div class="col-md-2 col-xs-3"><p class="text-right item-valor row">
                                R$ <?= Currency::moeda($cart->total * $cart->qtde) ?></p>
                        </div>
                        <div class="visible-xs">
                            <small class="text-muted"><?= substr($cart->extra, 0, -2) ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="divi-btn-finaliza">
            <div class="row">
                <?php if (isset($data['config']) && $data['config']->config_aberto == 1): ?>
                    <br>
                    <?php if (isset($_SESSION['busca']) && $_SESSION['busca'] == true): ?>
                        <a href="<?php echo $baseUri; ?>" class="btn btn-block btn-success text-uppercase no-radius">
                            <i class="fa fa-plus-circle"></i>
                            escolher mais itens
                        </a>
                    <?php else: ?>
                        <button class="btn btn-block btn-success text-uppercase no-radius" data-dismiss="modal">
                            <i class="fa fa-plus-circle"></i>
                            escolher mais itens
                        </button>
                    <?php endif; ?>
                    <br>
                    <?php if (Carrinho::get_total() < $data['config']->config_pedmin): ?>
                            <h4 class="text-center text-danger">
                                O VALOR MÍNIMO DO PEDIDO É DE R$ <?= $data['config']->config_pedmin ?> <br>
                                <small>Escolha algo mais para completar seu pedido!</small>
                            </h4>
                    <?php else: ?>
                        <a <?php if (Carrinho::get_total() <= 0): ?> disabled<?php endif; ?>
                                href="<?php echo $baseUri; ?>/pedido/"
                                class="btn btn-block btn-primary text-uppercase no-radius">
                            <i class="fa fa-chevron-right"></i>
                            <i class="fa fa-chevron-right"></i>
                            concluir meu pedido
                        </a>
                 <?php endif; ?>
                <?php else: ?>
                    <button class="btn btn-block btn-danger text-uppercase no-radius" type="button">
                        <i class="fa fa-clock-o"></i> Estamos Fechados ;(
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="text-center">
        <img src="<?php echo $baseUri; ?>/midias/thumb.php?zcx=3&w=218&h=178&src=img/icon-triste.png"
             alt="..." class="img-thumbnail img-responsive"
             style="margin-top: 80px; border: 0px !important">
        <h4><b>Carrinho Vazio</b></h4>
        <p class="text-center">
            <br><br><br>
            <a href="<?php echo $baseUri; ?>/" class="btn btn-warning btn-block text-uppercase">
                <i class="fa fa-shopping-bag"></i>
                Comece aqui o seu pedido
            </a>
        </p>
    </div>
<?php endif; ?>


