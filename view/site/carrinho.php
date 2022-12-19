<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/style.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css"/>
    <link rel="icon" type="image/png"
          href="<?php echo $baseUri; ?>/midias/logo/<?php echo (isset($data['config'])) ? $data['config']->config_foto : ''; ?>"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>"
          type="text/css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css"/>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div class="container-fluid" id="home-content">
    <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <form action="<?php echo $baseUri; ?>/pedido/confirmar/" method="post" id="form-pedido"
              onsubmit="return validaPagamento()">
            <input type="hidden" name="pedido_local" id="pega-endereco2"/><br>
            <?php if ($data['config']->config_aberto == 0): ?>
                <button class="btn btn-block btn-danger text-uppercase no-radius" type="button">
                    <i class="fa fa-clock-o"></i> Estamos fechados, voltaremos logo ;(
                </button>
            <h3 class="text-center">
                <br>
                <?php echo $data['config']->config_horario; ?>
            </h3>
            <?php else: ?>

                <?php $total = Currency::moeda(Carrinho::get_total(), 'double'); ?>
                <input type="hidden" name="pedido_total" id="pedido_total"
                       value="<?= str_replace(',', '.', $total); ?>"/>
                <?php if (Carrinho::isfull()): ?>
                    <section id="pedido-itens">
                        <h4><strong>Itens do pedido</strong></h4>
                        <?php foreach (Carrinho::get_all() as $cart): ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="text-capitalize">
                                        <span id="sp-qt-<?= $cart->item_hash ?>"><?= ($cart->qtde <= 9) ? "0$cart->qtde" : $cart->qtde ?></span>
                                        <small class="text-muted">x</small>
                                        <?= strtolower($cart->categoria_nome) ?> - <?= strtolower($cart->item_nome) ?>
                                        <span class="pull-right">R$ <?= Currency::moeda($cart->total * $cart->qtde) ?></span>
                                        <br><small class="text-muted"><?= strtolower($cart->item_obs) ?></small>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                    </section>
                    <section id="pedido-obs">
                        <div class="form-group">
                            <h5><b>Alguma observação?</b></h5>
                            <textarea class="form-control" name="pedido_obs" id="pedido_obs"
                                      placeholder="Ex: tirar cebola, maionese à parte, etc..."
                                      rows="2"><?= (isset($_SESSION['__OBS__'])) ? $_SESSION['__OBS__'] : ''; ?></textarea>
                        </div>
                        <hr>
                    </section>
                    <section id="pedido-enderecos">
                        <h5><strong>Onde deseja receber seu pedido?</strong></h5>

                        <select class="form-control" name="pedido_local" id="pedido_local">
                            <option value="" data-cep="" data-bairro="" selected>Selecione uma opção...</option>
                            <?php if ($data['config']->config_retirada == 1): ?>
                                <option value="0" data-cep="0">Retirar no Local</option>
                            <?php endif; ?>
                            <?php foreach ($data['endereco'] as $end) : ?>
                                <option value="<?= $end->endereco_id ?>"
                                        data-bairro="<?= $end->endereco_bairro_id ?>"
                                        data-cep="<?= $end->endereco_cep ?>"
                                        data-tempo="<?= $end->bairro_tempo ?>">
                                    <?= ucfirst($end->endereco_nome) ?> em
                                    <?= $end->endereco_bairro ?> (<?= $end->bairro_tempo ?>)
                                </option>
                            <?php endforeach; ?>
                            <option value="-1" data-cep="0">Cadastrar novo endereço</option>
                        </select>
                        <hr>
                    </section>
                    <section id="pedido-cupom">
                        <?php if (!isset($_SESSION['__CUPOM__'])): ?>
                            <div class="row">
                                <div class="col-xs-8">
                                    <input type="text" class="form-control text-uppercase"
                                           id="cupom_nome" placeholder="Cupom de desconto">
                                </div>
                                <div class="col-xs-4">
                                    <div>
                                        <button type="button" onclick="aplica_cupom()"
                                                class="btn btn-primary btn-block text-left">
                                            <i class="fa fa-ticket text-white"></i> Aplicar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-center text-success">
                                <i class="fa fa-check-circle-o"></i> CUPOM: <?= $_SESSION['__CUPOM__']->cupom_nome ?>
                                <br>
                                <br>
                                <button type="button" onclick="remove_cupom()" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash-o"></i>
                                    Remover Cupom
                                </button>
                            </p>
                        <?php endif; ?>
                        <hr>
                    </section>
                    <section id="pedido-valores">
                        <?php if (isset($_SESSION['__CUPOM__'])): ?>
                            <p class="text-right">
                            <span id="cupomrm_resposta">
                                Descontos
                                <span style="display:inline-block;width: 65px;">
                                <?php if ($_SESSION['__CUPOM__']->cupom_tipo == 1): ?>
                                    R$ <?= number_format($_SESSION['__CUPOM__']->cupom_valor, 2, ',', '') ?>
                                <?php else: ?>
                                    <?= $_SESSION['__CUPOM__']->cupom_percent ?>%
                                <?php endif; ?>
                                </span>
                            </span>
                            </p>
                        <?php endif; ?>
                        <h3 class="text-right">
                            <small>Taxa de entrega <span id="taxa-faixa">R$ 0,00</span></small><br>
                            Total
                            <span id="pedido-total">R$ <?= $total; ?></span>
                        </h3>
                        <div class="hidden-xs row"></div>
                        <hr>
                    </section>

                    <div class="form-group">
                        <h5 class="text-left"><strong>Forma de pagamento</strong></h5>
                        <select disabled class="form-control" id="forma-pagamento" required>
                            <option value="">Selecione uma opção...</option>
                            <?php if ($data['pagamento']->pagamento_status == 1): ?>
                                <option value="7">Cartão de Crédito (Pagamento Online)</option>
                            <?php endif; ?>
                            <option value="1">Dinheiro (na entrega)</option>
                            <option value="2">Cartão de Débito (na entrega)</option>
                            <option value="3">Cartão de Crédito (na entrega)</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group hide" id="forma-pagamento-troco-bandeira">
                        <label id="troco-bandeira-label">Troco para quanto?</label>
                        <input type="text" id="troco-bandeira" name="troco-bandeira" class="form-control"/>
                    </div>
                    <input type="hidden" id="pedido_obs_pagto" name="pedido_obs_pagto"/>
                    <input type="hidden" id="pedido_bairro" name="pedido_bairro" class="pedido_bairro"/>
                    <p class="visible-xs">
                        <br><br><br><br><br><br>
                    </p>
                    <input type="hidden" id="pedido_entrega_prazo" name="pedido_entrega_prazo"/>
                    <br>
                    <div class="divi-btn-finaliza">
                        <button type="submit" disabled
                                class="btn btn-block btn-success text-uppercase"
                                id="btn-pedido-concluir"
                            <?php if (Carrinho::get_total() <= 0): ?> disabled<?php endif; ?>>
                            <i class="fa fa-check-circle-o"></i>
                            Confirmar pedido
                        </button>
                        <br><br>
                    </div>
                <?php else: ?>
                    <div class="text-center">
                        <br><br><br>
                        <img src="<?php echo $baseUri; ?>/midias/thumb.php?zcx=3&w=218&h=178&src=img/icon-triste.png"
                             alt="...">
                    </div>
                    <div class="text-center">
                        <h4><b>Sacola Vazia</b></h4>
                        <p class="text-center">
                            <br><br><br>
                            <a href="<?php echo $baseUri; ?>/" class="btn btn-warning btn-block text-uppercase">
                                <i class="fa fa-shopping-bag"></i>
                                Comece aqui o seu pedido
                            </a>
                        </p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </form>
        <?php if ($data['pagamento']->pagamento_status == 1 && isset($data['url_js'])): ?>
            <?php require_once 'pagseguro-checkout.php'; ?>
        <?php endif; ?>
    </div>
</div>
<div class="container"><a id="link-footer" name="link-footer"></a></div>
<?php require 'side-carrinho.php'; ?>
<?php require_once 'footer-core-js.php'; ?>
<?php if ($data['pagamento']->pagamento_status == 1 && isset($data['url_js'])): ?>
    <script type="text/javascript" src="<?= $data['url_js'] ?>"></script>
    <script>var pagseguro_id = "<?= $data['url_ssid'] ?>";</script>
<?php endif; ?>
<script type="text/javascript">
    var baseUri = '<?php echo $baseUri; ?>';
    var totalCompra = '<?= Currency::moedaUS(Carrinho::get_total()) ?>';
    var pedido_entrega_prazo = $('#pedido_entrega_prazo').val();
    <?php if(isset($_SESSION['__LOCAL__'])):?>
    <?php $local = intval($_SESSION['__LOCAL__']);?>
    $('#pedido_local').val('<?=$local;?>');
    setTimeout(function () {
        $('#pedido_local').trigger('change');
    }, 300);
    <?php endif; ?>
    $('#pedido_obs').focus();

    <?php if (Carrinho::get_total() < $data['config']->config_pedmin): ?>
    var url = baseUri + "/carrinho/reload/";
    $.post(url, {}, function (data) {
        $("#carrinho-lista").html(data);
        rebind_add();
        rebind_del();
        rebind_get_count();
        $('[data-toggle="tooltip"]').tooltip();
        $('#modal-carrinho').modal('show');
        setTimeout(function () {
            window.location = baseUri;
        }, 4000)
    });
    <?php endif; ?>
</script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.maskedinput/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
<?php if ($data['pagamento']->pagamento_status == 1): ?>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/card.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/pagseguro-checkout.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/pagseguro.js"></script>
<?php endif; ?>
</body>
</html>