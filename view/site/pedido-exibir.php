<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/css/jquery.gritter.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/style.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css"/>
    <link rel="icon" type="image/png"
          href="<?php echo $baseUri; ?>/midias/logo/<?php echo (isset($data['config'])) ? $data['config']->config_foto : ''; ?>"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>"
          type="text/css"/>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div class="container-fluid" id="home-content">
    <br>
    <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <?php $status = Status::check($data['pedido']->pedido_status); ?>
        <div class="well well-sm">
            <div class="row">
                <div class="col-xs-6">
                    <span>
                        PEDIDO #<?= $data['pedido']->pedido_id ?><br>
                        <span class="text-bold"> TOTAL R$ <?= Currency::moeda($data['pedido']->pedido_total); ?></span>
                    </span>
                </div>
                <div class="col-xs-6">
                    <small class="pull-right">
                        <i class="fa fa-clock-o"></i>
                        <?= date('d/m/Y H:i', strtotime($data['pedido']->pedido_data)); ?>
                        <br>
                    </small>
                </div>
            </div>
        </div>
        <?php if (isset($data['lista'])): ?>
            <?php
            $re_id = $data['pedido']->pedido_id;
            $cliente = $data['cliente'];
            $resumo = "*RESUMO DO PEDIDO*\n";
            $resumo .= "Número do Pedido: $re_id \n";
            $resumo .= "Nome: $cliente->cliente_nome \n";
            $resumo .= "Telefone: $cliente->cliente_fone2 \n";
            ?>
            <?php foreach ($data['lista'] as $cart): ?>
                <div class="rows">
                    <div class="text-capitalize well-sm well">
                        <span class="text-bold"><?= strtolower($cart->lista_item_nome) ?></span>
                        <?= ($cart->lista_opcao_nome != "" && $cart->lista_opcao_nome != $cart->lista_item_nome) ? ' - ' . strtolower($cart->lista_opcao_nome) : '' ?>
                        <small class="text-muted pull-right">
                            <span style="font-size: 9px">x</span>
                            <?= $cart->lista_qtde ?>
                        </small>
                        <br>
                        <small class="text-muted">
                            <?php if (strip_tags($cart->lista_item_desc) != ''): ?>
                                <?= strip_tags($cart->lista_item_desc) ?>
                            <?php endif; ?>
                            <?php if (strip_tags($cart->lista_item_obs) != '' && strip_tags($cart->lista_item_desc) == ''): ?>
                                <?= strip_tags($cart->lista_item_obs) ?>
                            <?php endif; ?>
                        </small>
                        <p>
                            <small class="pull-right text-muted text-bold">
                                R$ <?= Currency::moeda($cart->lista_opcao_preco * $cart->lista_qtde) ?>
                            </small>
                        </p>
                    </div>
                </div>
                <?php
                $re_preco = Currency::moeda($cart->lista_opcao_preco);
                $resumo .= "Item: $cart->lista_item_nome x $cart->lista_qtde - R$ $re_preco \n";
                if (strip_tags($cart->lista_item_desc) != '') {
                    $resumo .= "($cart->lista_item_desc)\n";
                }
                $resumo .= "\n";
                ?>
            <?php endforeach; ?>
            <?php
            $re_obs = trim($data['pedido']->pedido_obs);
            $re_obs_pagto = trim($data['pedido']->pedido_obs_pagto);
            $re_total = Currency::moeda($data['pedido']->pedido_total);
            $prazo = $data['pedido']->pedido_entrega_prazo;
            $re_obs = ($re_obs != "") ? "Obs: $re_obs \n" : "";
            $taxa_entrega = Currency::moeda($data['pedido']->pedido_entrega);
            $resumo .= "Taxa de entrega: R$  $taxa_entrega \n";
            if($prazo != ""){
                $resumo .= "Tempo estimado: $prazo \n";
            }
            $resumo .= "*Total: R$ $re_total*\n";
            $resumo .= "$re_obs_pagto \n";
            ?>
            <?php if ($data['pedido']->pedido_obs != ""): ?>
                <h5 class="text-uppercase text-bold">Observações</h5>
                <small class="text-muted"><?= $data['pedido']->pedido_obs ?></small>
                <hr>
            <?php endif; ?>
            <?php if (isset($data['endereco'])) : ?>
                <?php $end = $data['endereco']; ?>
                <?php
                $compl = ($end->endereco_complemento != "") ? $end->endereco_complemento . " - " : '';
                $ref = ($end->endereco_referencia != "") ? " (" . $end->endereco_referencia . ") " : '';
                $endereco_full = ucfirst("$end->endereco_endereco, $end->endereco_numero, $compl  $end->endereco_bairro - $end->endereco_cidade $ref  ");
                ?>
                <h5 class="text-uppercase text-bold">Entregar em:  <?= strtoupper($end->endereco_nome) ?></h5>
                <?= $endereco_full ?>
                <?php $resumo .= "Local de entrega: $endereco_full \n"; ?>
                <?php $resumo .= "$re_obs \n \n"; ?>
                <?php $resumo .= "ENVIE A MENSAGEM COM RESUMO PARA: ". $data['config']->config_nome."\n"; ?>                                
                <Br><small>Tempo estimado: <?= $prazo ?></small>
            <?php endif; ?>
            <?php if (isset($data['pedido']->retirar_no_local)) : ?>
                <h5 class="text-uppercase text-bold">Retirar no local</h5>
                <p><?= $data['config']->config_endereco; ?></p>
                <?php $resumo .= "Local de entrega: Irá retirar no local \n"; ?>
                <?php $resumo .= "$re_obs \n \n"; ?>
                <?php $resumo .= "ENVIE A MENSAGEM COM RESUMO PARA: ". $data['config']->config_nome."\n"; ?>                
                <hr>
            <?php endif; ?>
            <h5 class="text-uppercase alert alert-<?= $status->color ?> text-center"><?= $status->icon ?></h5>
        <?php endif; ?>
    </div>
    <script>var currentUri = 'pedido';</script>
    <?php require_once 'footer-core-js.php'; ?>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <?php if (isset($resumo) && $resumo != "" && $isMobile == true && isset($_GET['new'])): ?>
        <?php if (isset($data['config']->config_resumo_whats) && $data['config']->config_resumo_whats == 1) : ?>
            <script>
                setTimeout(function () {
                    var whats = '55<?= preg_replace('/\D/', '', $data['config']->config_fone1) ?>';
                    var link = 'https://api.whatsapp.com/send?phone=' + whats + '&text=<?=urlencode($resumo)?>';
                    window.location = link;
                }, 500)
            </script>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (isset($data['pedido']->pedido_status) && $data['pedido']->pedido_status < 4) : ?>
        <?php
        $_SESSION['__LAST__PEDIDO__']['ID'] = $data['pedido']->pedido_id;
        $_SESSION['__LAST__PEDIDO__']['STATUS'] = $data['pedido']->pedido_status;
        ?>
    <?php endif; ?>
</body>
</html>            