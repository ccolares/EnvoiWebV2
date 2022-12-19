<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet'
          type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.easypiechart/jquery.easy-pie-chart.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css"/>
    <link href="css/style-prusia.css" rel="stylesheet"/>
</head>
<body class="animated">
<div id="cl-wrapper">
    <div class="cl-sidebar">
        <?php require_once 'side-menu.php'; ?>
    </div>
    <div class="container-fluid" id="pcont">
        <?php require_once 'top-menu.php'; ?>
        <div class="cl-mcont">
            <div class="block-flat">
                <?php if (isset($data['lista'])): ?>
                    <div class="header">
                        <h3>
                            <a href="<?php echo $baseUri; ?>/admin/imprimir/<?= $data['pedido']->pedido_id ?>/"
                               target="_blank" title="Imprimir"><i class="fa fa-print"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            Detalhes do Pedido #<?= $data['pedido']->pedido_id ?>
                            <br>
                            <small class="pull-right" style="font-size:13px;font-family: 'Open Sans',arial,verdana;">Data: <?= Timer::parse_date_br($data['pedido']->pedido_data) ?></small>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="itens-cart">
                            <h5><b>ITENS DO PEDIDO</b></h5>
                            <?php foreach ($data['lista'] as $cart): ?>
                                <div class="item" id="list-item-<?= $cart->lista_pedido ?>">
                                            <span class="item-span">
                                                    <?= $cart->lista_qtde ?> x <?= ($cart->lista_opcao_nome != "") ? ' ' . strtoupper($cart->lista_opcao_nome) : strtoupper($cart->lista_item_nome) ?>
                                                <?php if (strip_tags($cart->lista_item_desc) != ''): ?>
                                                    <small>(<?= strip_tags(strtoupper($cart->lista_item_desc)) ?>)</small>
                                                <?php endif; ?>
                                                    <span class="pull-right mar-right-3" data-toggle="tooltip"
                                                          title="<?= $cart->lista_qtde ?> x <?= Currency::moeda($cart->lista_opcao_preco) ?>">
                                                            R$ <?= Currency::moeda($cart->lista_opcao_preco * $cart->lista_qtde) ?>
                                                    </span>
                                            </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($data['pedido']->pedido_obs != ""): ?>
                            <div>
                                <br/><br/>
                                <p>
                                    <b>OBSERVAÇÕES:</b><br/>
                                    <?= $data['pedido']->pedido_obs ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <hr>
                        <div class="text-right">
                            <?php if ($data['pedido']->pedido_entrega > 0): ?>
                                <p>Taxa de Entrega R$ <?= Currency::moeda($data['pedido']->pedido_entrega) ?></p>
                            <?php endif; ?>
                            <p><b>
                                    Total do Pedido R$
                                    <?= ($data['pedido']->pedido_total > 0) ? Currency::moeda($data['pedido']->pedido_total) : '0,00'; ?>
                                </b>
                            </p>

                            <?php if ($data['pedido']->pedido_entrega_prazo != ''): ?>
                                <p><small>Tempo de Entrega
                                        Estimado: <?= $data['pedido']->pedido_entrega_prazo ?></small></p>
                            <?php endif; ?>
                            <p><strong><?= $data['pedido']->pedido_obs_pagto ?></strong></p>
                        </div>
                        <hr>
                        <div class="">
                            <?php if (isset($data['endereco']) && $data['endereco']->endereco_cidade != "") : ?>
                                <?php $end = $data['endereco']; ?>
                                <h4>Endereço de entrega: <b><?= $end->endereco_nome ?></b></h4>

                                <?= $end->endereco_endereco ?>,
                                <?= $end->endereco_numero ?>,
                                <?= ($end->endereco_complemento != "") ? $end->endereco_complemento . " - " : '' ?>
                                <?= $end->endereco_cidade ?>
                                <?= ($end->endereco_referencia != "") ? " (" . $end->endereco_referencia . ") " : '' ?>
                            <?php else: ?>
                                <h4><b>Retirada no local</b></h4>
                            <?php endif; ?>
                        </div>
                        <hr>
                        <div class="">
                            <br>
                            <h5>
                                Cliente: <b><?= $data['pedido']->cliente_nome ?></b>
                                <br><br>
                                Contato: <b><?= $data['pedido']->cliente_fone ?>
                                    &nbsp; <?= $data['pedido']->cliente_fone2 ?> </b>
                            </h5>
                        </div>
                        <hr>
                        <br>

                        <div class="">
                            <?php $status = Status::check($data['pedido']->pedido_status); ?>
                            <h4 class="alert alert-<?= $status->color ?> text-center"
                                id="current-status"><?= $status->icon ?></h4>
                            <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control input-lg"
                                                name="pedido_status" id="pedido_status"
                                                data-id="<?= $data['pedido']->pedido_id ?>"
                                                data-cliente="<?= $data['pedido']->pedido_cliente ?>" required>
                                            <option value="">ALTERAR STATUS DO PEDIDO PARA:</option>
                                            <option value="1">Pendente</option>
                                            <option value="2">Em Produção</option>
                                            <option value="3">Saiu para entrega</option>
                                            <option value="4">Entregue</option>
                                            <option value="5">Cancelado</option>
                                            <option value="6">Disponível para retirada</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-lg btn-success" id="btn-update-status"><i
                                                class="fa fa-refresh"></i> Atualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                <?php endif; ?>

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
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var baseUrl = '<?php echo $baseUri; ?>';
        $("#cl-wrapper").removeClass("sb-collapsed");
        $('#menu-pedido').addClass('active');
        $('#btn-update-status').on('click', function () {
            var status = $('#pedido_status option:selected').val();
            if (status != "") {
                var url = baseUrl + '/admin/atualiza_status/';
                var id = $('#pedido_status').data('id');
                var cliente = $('#pedido_status').data('cliente');
                $('#btn-update-status').html(' Atualizando, aguarde....').attr('disabled', 'disabled');
                $.post(url, {pedido_id: id, pedido_status: status, cliente: cliente}, function (data) {
                    window.location.href = baseUrl +"/admin/pedidos/?success";
                    /*
                    if (data != "") {
                        $('#btn-update-status').removeAttr('disabled').html('<i class="fa fa-refresh"></i> Atualizar');
                        //data = $.parseJSON(data)
                        $('#current-status').removeClass('alert-success alert-warning alert-info alert-info alert-danger');
                        $('#current-status').addClass('alert-' + data.class);
                        $('#current-status').html(data.text);
                        window.location.reload();
                    }
                    */
                });
            }
        });
    </script>
</body>
</html>
