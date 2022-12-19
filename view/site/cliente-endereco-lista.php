<?php @session_start(); ?>
<?php $baseUri=Http::base(); ?>
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
          href="<?php echo $baseUri; ?>/midias/logo/<?php echo $data['config']->config_foto; ?>"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>"
          type="text/css"/>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div class="container-fluid" id="home-content">
    <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <br/><br/>
        <a href="<?php echo $baseUri; ?>/novo-endereco/" class="btn btn-success btn-block text-uppercase">
            <i class="fa fa-plus-circle"></i> Novo Endereço
        </a>
        <br/>
        <?php if (isset($data['endereco'][0])) : ?>
            <?php foreach ($data['endereco'] as $end) : ?>
                <div
                        data-id="<?= $end->endereco_id ?>"
                        id="tr-<?= $end->endereco_id; ?>">
                    <a class="btn btn-block btn-primary"
                       href="<?php echo $baseUri; ?>/editar-endereco/<?= $end->endereco_id; ?>/">
                        <small class="text-uppercase">
                            <i class="fa fa-map-marker"></i> <b><?= $end->endereco_nome ?> </b>
                            <br>
                            <small>
                                <?= $end->endereco_endereco ?> - <?= $end->endereco_bairro ?>
                            </small>
                        </small>
                    </a>
                    <br>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="alert alert-success">Você precisa cadastrar um endereço para entrega!</p>
        <?php endif; ?>
    </div>
</div>
<?php require 'side-carrinho.php'; ?>
<?php require_once 'footer-core-js.php'; ?>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/endereco.js"></script>
</body>
</html>