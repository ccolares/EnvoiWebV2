<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
</head>
<style>
/* print styles */
@media print {
  body {
    margin: 10px !important;
    padding: 10px !important;
    /*background-color: #fff;*/
    color: black;
    font-weight: 900;
	wheigh: 100%;
  }

  p {
    margin: 0;
    padding: 0;
    line-height: 20px;
    font-weight: 900;
	font-size: 14px;
    color: black!important;
  }
}</style>
<body class="animated">
<div id="cl-wrapper" style="width: 320px;">
    <div class="container" id="pcont">
        <div class="cl-mcontX text-center">
            <div class="block-flats text-center">
                <?php if (isset($data['lista'])): ?>
                    <div class=" text-center">
                        <h5>
                            <b><strong><?= $data['config']->config_nome ?></strong> <br></b>
                            <strong><?= $data['config']->config_endereco ?></strong> <br>
                            <strong><?= $data['config']->config_fone1 ?></strong> <br>
			               </h5>
                        <hr>
                    </div>
                    <div class="panel-bodys text-center">
                        <div class="">
                            <?php foreach ($data['lista'] as $key => $cart): ?>
                                <div class="item" id="list-item-<?= $cart->item_id ?>">
                                    <p class="item text-center" style="color: black!important;">
                                        <?= $cart->categoria_nome ?> <br>
                                        <?= $cart->lista_qtde ?> <small>x</small> <?= ($cart->lista_opcao_nome != "") ?  $cart->lista_opcao_nome : $cart->lista_item_nome ?>
                                        - R$ <?= Currency::moeda($cart->lista_opcao_preco * $cart->lista_qtde) ?>
                                        <?php if (strip_tags($cart->lista_item_desc) != ''): ?>
                                            <center><small>(<?= strip_tags(strtolower($cart->lista_item_desc)) ?>)</small></center>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($data['pedido']->pedido_obs != ""): ?>
                            <div>
                                <p style="color: black!important;">
                                    <b><strong>Observações:</strong></b>
                                    <?= $data['pedido']->pedido_obs ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        <hr style="clear: both !important;">
                        <div class="float-right pull-rights">
                            <p style="color: black!important;">Taxa de Entrega  R$ <?= Currency::moeda($data['pedido']->pedido_entrega) ?></p>
                            <p style="color: black!important;"><strong>Total R$ <?= Currency::moeda($data['pedido']->pedido_total); ?></strong>
                            </p>
                            <?php if (isset($data['endereco'])) : ?>
                                <p style="color: black!important;">Entrega Estimada: <?= $data['pedido']->pedido_entrega_prazo ?></p>
                            <?php endif; ?>
                            <p style="color: black!important;"><strong><?= $data['pedido']->pedido_obs_pagto ?></strong></p>
                        </div>
                        <hr style="clear: both !important;">
                        <div>
						<strong>
                            <?php if (isset($data['endereco'])) : ?>
                                <?php $end = $data['endereco']; ?>
                                <h4><strong>Endereço de entrega:</strong> <b><?= $end->endereco_nome ?></b></h4>
                                <h5><?= $end->endereco_endereco ?>,
                                <?= $end->endereco_numero ?>,
                                <?php if ($end->endereco_complemento != ""): ?>
                                    <?= $end->endereco_complemento ?> -
                                <?php endif; ?>
                                <?= $end->endereco_bairro ?> -
                                <?= $end->endereco_cidade ?>
                                    <?php if ($end->endereco_complemento != ""): ?>
                                      <br>
                                        Ponto de Ref.: <?= $end->endereco_referencia ?>
                                    <?php endif; ?>
                                </h5>
                            <?php else: ?>
                                <h4 class="text-center"><b>Retirada no Local</b></h4>
                            <?php endif; ?>
							</strong>
                        </div>
                        <hr>
                        <div style="clear: both !important;">
                            <p style="color: black!important;">
                                Cliente: <b><?= ucfirst($data['pedido']->cliente_nome) ?></b>
                                <br>
                                Contato: <b><?= $data['pedido']->cliente_fone2 ?> </b>
                            </p>
                        </div>
                        <hr>
                        <div  class="text-center" style="clear: both !important;">
                                <p style="color: black!important;">Pedido #<?= $data['pedido']->pedido_id ?> <br>
                                <p style="font-family; color: black!important: 'Open Sans',arial,verdana;">Data: <?= Timer::parse_date_br($data['pedido']->pedido_data) ?> </p>
                                <b><strong>DOCUMENTO NÃO FISCAL</strong></b> </h3>
                                </p>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js" ></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        setTimeout(function () {
            window.print();
        },300);
    </script>
</body>
</html>
