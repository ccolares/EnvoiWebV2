<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cadastro - <?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/style.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
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
    <form action="<?php echo $baseUri; ?>/cadastro/gravar/" method="post" role="form"
          style="padding-top: 50px"
          id="form-cadastro" autocomplete="off" enctype="multipart/form-data">
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <h4 class="text-uppercase">Cadastre-se</h4>
            <hr/>
            <div class="form-group">
                <label for="cliente_nome">Nome</label>
                <small class="text-muted pull-right">* obrigatório</small>
                <input type="text" name="cliente_nome" id="cliente_nome" class="form-control"
                       placeholder="Informe seu nome" required>
            </div>
            <div class="form-group">
                <label for="cliente_fone2">Celular</label>
                <small class="text-muted pull-right">* obrigatório</small>
                <span class="pull-right text-danger" id="exists"></span>
                <input type="tel" data-mask="cell" placeholder="(99) 99999-9999" name="cliente_fone2"
                       id="cliente_fone2" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="cliente_senha">Senha</label>
                <small class="text-muted pull-right">* obrigatório</small>
                <input type="password" name="cliente_senha" id="cliente_senha" class="form-control"
                       placeholder="informe uma senha" required>
            </div>
            <div class="form-group">
                <label for="cliente_email">Email</label>
                <small class="text-muted pull-right">* opcional (utilizado se precisar recuperar a senha)</small>
                <input type="email" name="cliente_email" id="cliente_email" class="form-control"
                       placeholder="informe seu melhor email">
            </div>
            <div class="form-group">
                <br>
                <button class="btn btn-success btn-block" type="submit" id="btn-cad">
                    <i class="fa fa-check-circle-o"></i>
                    CONCLUIR
                </button>
            </div>
        </div>
    </form>
</div>
</body>
<?php require 'side-carrinho.php'; ?>
<?php require_once 'footer-core-js.php'; ?>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/number.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/js/select2.js"></script>
<script type="text/javascript"
        src="<?php echo $baseUri; ?>/assets/vendor/jquery.maskedinput/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/cliente.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
<script>rebind_reload();</script>
<script>
    $('#cliente_nome').focus();
    $('#cliente_fone2').on('change', function () {
        var url = baseUri + '/cadastro/exists/';
        var fone = $('#cliente_fone2').val();
        $.post(url, {fone: fone}, function (req) {
            if (req == 1) {
                $('#cliente_fone2').focus();
                $('#exists').text('Telefone já cadastrado!');
                $('#btn-cad').attr('disabled', 'disabled');
            } else {
                $('#exists').text('');
                $('#btn-cad').removeAttr('disabled');
            }
        })
    })
</script>
</html>