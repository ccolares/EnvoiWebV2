<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/css/jquery.gritter.css"/>
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
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>"
          type="text/css"/>

</head>
<body>
<?php require_once 'menu.php'; ?>
<div id="home-content" class="container-fluid">
    <form action="<?php echo $baseUri; ?>/cliente-login-entrar/<?= (isset($data['carrinho'])) ? '?carrinho' : '' ?>"
          method="post" role="form" autocomplete="off" enctype="multipart/form-data"
          style="padding-top: 40px">
        <h4 class="text-center text-uppercase text-muted">efetue o login ou cadastre-se!</h4>
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <div class="form-group">
                <label for="cliente_email">celular</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                    <input type="tel" name="cliente_fone2" id="cliente_fone2" class="form-control"
                           data-mask="cell" placeholder="(99) 99999-9999" required>
                </div>
            </div>
            <div class="form-group">
                <label for="cliente_email">senha</label>
                <span class="pull-right">
                        <a class="recupera-senha" href="<?php echo $baseUri; ?>/recupera-senha/">
                        <small>esqueceu?</small>
                    </a>
                </span>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="cliente_senha" id="cliente_senha" class="form-control"
                           placeholder="Informe sua senha" required>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" data-dismiss="modal" type="submit">
                    <i class="fa fa-check-circle-o"></i>
                    ENTRAR
                </button>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xs-12">
                    <p class="text-center">
                        <a class="" href="<?php echo $baseUri; ?>/cadastro/">
                            Cadastre-se
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
</body>

<?php require 'side-carrinho.php'; ?>
<?php require_once 'footer-core-js.php'; ?>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript"
        src="<?php echo $baseUri; ?>/assets/vendor/jquery.maskedinput/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/cliente.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
<script type="text/javascript">
    $(function () {
        <?php if (Post::request('incorreto') != '') : ?>
        $.gritter.add({
            time: 2000,
            position: 'center',
            title: 'Login/Senha Incorreto',
            text: 'Confira seus telefone e senha.',
            class_name: 'danger'
        });
        <?php endif; ?>
        <?php if (Post::request('falha') != '') : ?>
        $.gritter.add({
            title: 'Email não enviado',
            text: 'Verifique seu email e tente novamente.',
            class_name: 'danger'
        });
        <?php endif; ?>
        <?php if (Post::request('envio') != '') : ?>
        $.gritter.add({
            title: 'Email de recuperação enviado',
            text: 'Por favor verifique sua caixa de entrada.',
            class_name: 'success'
        });
        <?php endif; ?>
        <?php if (Post::request('muda-senha') != '') : ?>
        $.gritter.add({
            title: 'A Senha foi alterada com sucesso',
            text: 'Por favor, entre com seus novos dados.',
            class_name: 'success'
        });
        <?php endif; ?>
    });
    rebind_reload();
</script>
</html>