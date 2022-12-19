<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet'
          type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css"/>
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css"/>
    <link rel="stylesheet" type="text/css" href="js/bootstrap.summernote/dist/summernote.css"/>
    <link href="css/style-prusia.css" rel="stylesheet"/>
    <link href="css/btn-upload.css" rel="stylesheet"/>
</head>
<body class="animated">
<div id="cl-wrapper">
    <div class="cl-sidebar">
        <?php require_once 'side-menu.php'; ?>
    </div>
    <div class="container-fluid" id="pcont">
        <!-- TOP NAVBAR -->
        <?php require_once 'top-menu.php'; ?>
        <div class="cl-mcont">
            <div class="block-flat">
                <div class="header">
                    <h3>Informações do Site</h3>
                </div>
                <?php if (isset($data['config'])): ?>
                <div class="content">
                    <form action="<?php echo $baseUri; ?>/configuracao/gravar/" method="post" role="form"
                          autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="config_taxa_entrega" id="config_taxa_entrega"
                               class="form-control" placeholder="Taxa de entrega"
                               value="<?= Currency::moedaUS($data['config']->config_taxa_entrega) ?>"
                        >
                        <input type="hidden" name="config_id" id="config_id"
                               value="<?= $data['config']->config_id ?>">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="config_nome">Nome da empresa <span
                                                class="text-danger">*</span></label>
                                    <input type="text" name="config_nome" id="config_nome" class="form-control"
                                           placeholder="Informe o nome da empresa"
                                           value="<?= $data['config']->config_nome ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="config_endereco">Endereço da empresa <span
                                                class="text-danger">*</span></label>
                                    <input type="text" name="config_endereco" id="config_endereco"
                                           class="form-control" placeholder="Informe o endereço da empresa"
                                           value="<?= $data['config']->config_endereco ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="config_taxa_entrega">CEP da empresa
                                        <small class="pull-right"></small>
                                    </label>
                                    <input type="text" name="config_cep" id="config_cep"
                                           class="form-control cep" placeholder="Cep da empresa"
                                           value="<?= $data['config']->config_cep?>"
                                           >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="config_retirada" data-toggle="tooltip" title="Permitir que o cliente retire o pedido no local">Permitir retirada no local</label>
                                    <select name="config_retirada" id="config_retirada" class="form-control">
                                        <option value="1">ATIVO</option>
                                        <option value="0">INATIVO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="config_horario">Horário de funcionamento <span
                                                class="text-danger">*</span></label>
                                    <input type="text" name="config_horario" id="config_horario"
                                           class="form-control" placeholder="Informe o horário de funcionamento"
                                           value="<?= $data['config']->config_horario ?>" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="config_nome">Telefone Whatsapp<span
                                                class="text-danger"> *</span></label>
                                    <input type="text" name="config_fone1" id="config_fone1"
                                           class="form-control fone" placeholder="Informe um telefone"
                                           value="<?= $data['config']->config_fone1 ?>" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="config_nome">Telefone Fixo</label>
                                    <input type="text" name="config_fone2" id="config_fone2"
                                           class="form-control fone" placeholder="Informe um telefone"
                                           value="<?= $data['config']->config_fone2 ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="config_cep_unico" data-toggle="tooltip" title="Se ativado, ao término do pedido, irá enviar para a loja e cliente o resumo do pedido no Whatsapp">Pedido no Whatsapp?</label>
                                    <select name="config_resumo_whats" id="config_resumo_whats" class="form-control">
                                        <option value="0">NÃO</option>
                                        <option value="1">SIM</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="config_nome">Alerta / Campainha</label>
                                    <select type="text" name="config_bell" id="config_bell"
                                            class="form-control">
                                        <option value="1">Ativada</option>
                                        <option value="0">Desativada</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="config_nome">Valor Mínimo de Pedido</label>
                                    <input type="text" name="config_pedmin" id="config_pedmin"
                                            class="form-control" placeholder="R$ 50,00"
                                            value="<?= $data['config']->config_pedmin ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="config_desc">Sobre Nós</label>
                                    <textarea name="config_desc" id="config_desc" name="config_desc"
                                              class="form-control"><?= $data['config']->config_desc ?></textarea>
                                </div>
                                <br>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="config_nome">Chat Script</label>
                                    <span class="pull-right">
                                        <i class="fa fa-exclamation-circle"></i>
                                         acesse  https://getbutton.io/ para gerar botão flutuante do whats em sua loja
                                    </span>
                                    <textarea name="config_chat" id="config_chat"
                                              class="form-control" rows="3"
                                              placeholder="Cole o script JS"><?= $data['config']->config_chat ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="config_site_keywords">Palavras-Chave (Meta Keywords)</label>
                                    <input type="text" name="config_site_keywords" id="config_site_keywords"
                                           class="form-control" placeholder="Palavras-chave"
                                           value="<?= strip_tags($data['config']->config_site_keywords) ?>"
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="config_site_description">Descrição Breve (Meta Description)</label>
                                    <input type="text" name="config_site_description" id="config_site_description"
                                           class="form-control" placeholder="Descrição Breve"
                                           value="<?= strip_tags($data['config']->config_site_description) ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="config_site_ga">Google Analytics</label>
                                    <textarea name="config_site_ga" id="config_site_ga"
                                              rows="2"
                                              placeholder="Informe o código Analytics"
                                              class="form-control"><?= $data['config']->config_site_ga ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 hide">
                            <div class="form-group">
                                <div class="col-md-8  hide">
                                        <span class="btn btn-primary btn-file btn-block"
                                              style="height: 50px; border-radius: 50px;">
                                            <p style="margin: 0; height: 10px;">&nbsp;</p>
                                            <span class="fileinput-exists">
                                                <i class="fa fa-retweet"></i>
                                                Trocar Alerta Sonoro
                                            </span>
                                            <input type="file" id="config_alert" name="config_alert"
                                                   class="form-control">
                                        </span>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <p>Alerta de Novo Pedido</p>
                                        <audio controls>
                                            <source src="<?php echo $baseUri; ?>/midias/alerta/alert.mp3"
                                                    type="audio/mpeg">
                                            Seu browser não suporta o player!
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container">
                                <p class="text-center">
                                    <button class="btn btn-primary btn-lg" type="submit"><i
                                                class="fa fa-check-circle-o"></i> Gravar Dados
                                    </button>
                                </p>
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<!-- Right Chat-->
<?php //require_once 'side-right-chat.php'; ?>
<script src="js/jquery.js"></script>
<script src="js/jquery.cooki/jquery.cooki.js"></script>
<script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
<script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="js/behaviour/core.js"></script>
<script type="text/javascript" src="js/jquery.select2/dist/js/select2.js"></script>
<script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $baseUri; ?>/assets/vendor/uf-combo/cidades-estados-1.4-utf8.js" charset="utf-8"></script>
<script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.mask.js"></script>
<script type="text/javascript" src="js/bootstrap.summernote/dist/summernote.min.js"></script>

<script src="app-js/main.js"></script>
<script src="app-js/config.js"></script>
<script type="text/javascript">
    $('#menu-config-site').addClass('active');
    $('#config_pedmin').mask("#.##0,00", {reverse: true});
    <?php if (isset($_GET['success'])): ?>
    _alert_success();
    <?php endif; ?>
</script>
<script>
    //$('#config_cep').mask("99999-999");
    //$('#config_taxa_entrega').mask("#.##0.00", {reverse: true});
    $('#config_retirada').val(<?= $data['config']->config_retirada ?>);
    $('#config_cep_unico').val(<?= $data['config']->config_cep_unico ?>);
    $('#config_resumo_whats').val(<?= $data['config']->config_resumo_whats ?>);
    $('#config_bell').val(<?= $data['config']->config_bell ?>);
</script>
<script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
<script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>
</html>
