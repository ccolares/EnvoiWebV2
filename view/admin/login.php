<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php require_once 'site-base.php'; ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
        <!-- Bootstrap core CSS -->
        <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
        <link rel="stylesheet" href="fonts/font-awesome-4/css/font-awesome.min.css">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
        <!-- Custom styles for this template -->
        <link href="css/style-prusia.css" rel="stylesheet" />
    </head>
    <body class="texture">
        <div id="cl-wrapper" class="login-container">

            <div class="middle-login">
                <div class="block-flat">
                    <div class="header">							
                        <h3 class="text-center">Painel de Controle - Admin</h3>
                    </div>
                    <div>
                        <form style="margin-bottom: 0px !important;" method="post" class="form-horizontal" action="<?php echo $baseUri; ?>/login/entrar/">
                            <div class="content">
                                <h4 class="title">Acesso Restrito</h4>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input type="text" name="usuario_login" id="usuario_login" class="form-control" placeholder="Informe o login" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <input type="password" name="usuario_senha" id="usuario_senha" class="form-control" placeholder="Informe a senha" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="foot">
                                <button class="btn btn-primary" data-dismiss="modal" type="submit">
                                    <i class="fa fa-lock"></i>
                                    Entrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center out-links"><a href="#">&copy; <?php echo date('Y'); ?></a></div>
            </div> 
        </div>

        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js" ></script>
        <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(function () {
                $("#cl-wrapper").css({opacity: 1, 'margin-left': 0});
<?php if (Post::request('incorreto') != '') : ?>
                    $.gritter.add({
                        title: 'Login/Senha Incorreto',
                        text: 'Verifique seus dados de acesso e tente novamente.',
                        class_name: 'danger'
                    });
<?php endif; ?>
            });
        </script>
    </body>
</html>
