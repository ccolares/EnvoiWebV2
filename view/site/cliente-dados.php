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
          href="<?php echo $baseUri; ?>/midias/logo/<?php echo (isset($data['config'])) ? $data['config']->config_foto : ''; ?>"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>"
          type="text/css"/>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div class="container-fluid" id="home-content">
    <div class="content <?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <form action="<?php echo $baseUri; ?>/cadastro/gravar/" method="post" role="form" autocomplete="off"
              enctype="multipart/form-data">
            <br>
            <h5 class="text-uppercase">Dados Pessoais
                <span class="pull-right">
                    <a class="btn btn-primary btn-sm text-uppercase" href="<?php echo $baseUri; ?>/meus-enderecos/">
                        <i class="fa fa-map-marker"></i>
                        Ver meus endereços
                    </a>
                </span>
            </h5>

            <div class="form-group">
                <label for="cliente_nome" class="text-muted">Nome</label>
                <input type="hidden" name="cliente_id" value="<?= $data['cliente']->cliente_id ?>"/>
                <input type="text" name="cliente_nome" id="cliente_nome" class="form-control"
                       value="<?= $data['cliente']->cliente_nome ?>"
                       placeholder="Informe seu nome completo" required>
            </div>
            <div class="form-group">
                <label for="cliente_nasc" class="text-muted">Data de Nascimento</label>
                <input type="text" data-mask="date" name="cliente_nasc" id="cliente_nasc"
                       value="<?= $data['cliente']->cliente_nasc ?>"
                       class="form-control" placeholder="Informe sua data de nascimento">
            </div>
            <div class="form-group hide">
                <label for="cliente_cpf" class="text-muted">Cpf</label>
                <input type="text" data-mask="cpf" name="cliente_cpf" id="cliente_cpf"
                       value="<?= $data['cliente']->cliente_cpf ?>"
                       class="form-control" placeholder="Informe o número do documento">
            </div>

            <h5 class="text-uppercase" style="margin-top: 25px">Dados de Contato</h5>

            <div class="form-group">
                <label for="cliente_fone2" class="text-muted">Celular</label>
                <input type="tel" data-mask="cell" placeholder="(99) 99999-9999" name="cliente_fone2"
                       id="cliente_fone2"
                       value="<?= $data['cliente']->cliente_fone2 ?>" required
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="cliente_senha" class="text-muted">Senha</label>

                <input type="password" name="cliente_senha" id="cliente_senha" class="form-control"
                       autocomplete="off"
                       placeholder="somente se desejar alterar a senha">
            </div>
            <div class="form-group">
                <label for="cliente_email" class="text-muted">Email</label>
                <input type="text" name="cliente_email" id="cliente_email" class="form-control"
                       placeholder="informe um email válido" value="<?= $data['cliente']->cliente_email ?>">
            </div>
            <br/>
            <div class="form-group">
                <button class="btn btn-success btn-block text-uppercase" type="submit">
                    <i class="fa fa-refresh"></i>
                    Atualizar Cadastro
                </button>
            </div>
        </form>
    </div>
    <br>
</div>
<?php require_once 'footer-core-js.php'; ?>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/main.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/cliente.js"></script>
<?php if (isset($_GET['success'])) : ?>
    <script type="text/javascript">__alert__success()</script>
<?php endif; ?>
</body>
</html>