<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet'
          type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.min.css"/>
    <link rel="stylesheet" type="text/css" href="js/jquery.easypiechart/jquery.easy-pie-chart.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css"/>
    <link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css"/>
    <link href="css/style-prusia.css" rel="stylesheet"/>
    <style>
        .bootstrap-switch-handle-off {
            padding-right: 30px !important;
        }
    </style>
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
                <h3>Status da Loja </h3>
                <input class="switch" name="loja-status" data-size="large" type="checkbox" data-on-color="success"
                       data-off-color="danger" data-on-text="&nbsp; ABERTA"
                       data-off-text="FECHADA&nbsp;" <?= (isset($data['config']) && $data['config']->config_aberto == 1) ? 'checked' : '' ?>>
                <br/><br/><br/><br/><br/>
                <?php if (isset($data['pedido'][0])) : ?>
                    <div class="header">
                        <h3>Últimos Pedidos Pendentes</h3>
                    </div>
                    <table class="table table-bordered table-striped datatable" id="datatable">
                        <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Forma de Pagto</th>
                            <th>Valor</th>
                            <th width="170">Data</th>
                            <th>Status Pagseguro</th>
                            <th>Status Pedido</th>
                            <th width="50"><i class="fa fa-cog"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['pedido'] as $obj): ?>
                            <?php
                            $status = Status::check($obj->pedido_status);
                            $status_pg = Status::pagseguro($obj->pedido_pagseguro);
                            $obj->cliente_fone2 = preg_replace('/\D/','', $obj->cliente_fone2);
                            ?>
                            <tr class="status-<?=$obj->pedido_status?>">
                                <td><?= $obj->pedido_id ?></td>
                                <td><?= ucfirst($obj->cliente_nome) ?></td>
                                <td><?= $obj->pedido_obs_pagto ?></td>
                                <td><?= Currency::moeda($obj->pedido_total) ?></td>
                                <td class="text-center"><?= Timer::parse_date_br($obj->pedido_data) ?></td>
                                <td width="170" class="bg-<?= $status_pg->color ?>"><?= $status_pg->icon ?></td>
                                <td width="170" class="bg-<?= $status->color ?>"><?= $status->icon ?></td>
                                <td width="160" class="text-center">

                                    <a href="https://api.whatsapp.com/send?phone=+55<?=$obj->cliente_fone2?>"
                                       data-toggle="tooltip"
                                       title="chamar no whats"
                                       target="_blank" class="btn btn-success btn-xs">
                                        <i class="fa fa-whatsapp"></i> </span>
                                    </a>

                                    <a class="btn btn-warning btn-xs" data-toggle="tooltip"
                                       href="<?php echo $baseUri; ?>/admin/imprimir/<?= $obj->pedido_id ?>/"
                                       target="_blank" title="Imprimir"><i class="fa fa-print"></i></a>

                                    <a href="<?php echo $baseUri; ?>/admin/pedido/<?= $obj->pedido_id ?>/" data-toggle="tooltip"
                                       title="detalhes"
                                                  class="btn btn-xs btn-prusia"><i class="fa fa-search"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <br>
                <?php if (isset($data['estoque'][0])) : ?>
                    <div class="header">
                        <h3>Itens com estoque baixo</h3>
                    </div>
                    <table class="table table-bordered table-striped datatable" id="datatabler">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Categoria</th>
                            <th>Quantidade</th>
                            <th width="60"><i class="fa fa-cog"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['estoque'] as $obj): ?>
                            <tr>
                                <td><?= $obj->item_nome ?></td>
                                <td><?= $obj->categoria_nome ?></td>
                                <td width="120" class=" text-center bg-<?= ($obj->item_estoque < 10 ) ? 'danger': ''; ?>"><?= $obj->item_estoque ?></td>
                                <td width="60" class="text-center"><a href="<?php echo $baseUri; ?>/item/editar/<?= $obj->item_id ?>/" title="repor" data-toggle="tooltip"
                                                  class="btn btn-xs btn-prusia"><i class="fa fa-refresh"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <br> <br>
                <?php if (isset($data['cliente'][0])) : ?>
                    <div class="header">
                        <h3>Últimos Clientes Cadastrados</h3>
                    </div>
                    <table class="table table-bordered table-striped datatable" id="datatablex">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Fone</th>
                            <th>Cidade</th>
                            <th>Bairro</th>
                            <th width="60"><i class="fa fa-cog"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['cliente'] as $obj): ?>
                            <tr>
                                <td><?= $obj->cliente_id ?></td>
                                <td><?= $obj->cliente_nome ?></td>
                                <td><?= $obj->cliente_email ?></td>
                                <td><?= ($obj->cliente_fone != '') ? $obj->cliente_fone : $obj->cliente_fone2; ?></td>
                                <td><?= $obj->endereco_cidade ?></td>
                                <td><?= $obj->endereco_bairro ?></td>
                                <td width="60" class="text-center"><a href="<?php echo $baseUri; ?>/cliente/editar/<?= $obj->cliente_id ?>/"
                                                  class="btn btn-xs btn-prusia"><i class="fa fa-search"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>


            </div>
        </div>
    </div>
    <?php
    $last_pedido = 0;
    if (isset($data['pedido'][0])) :
        $last_pedido = end($data['pedido']);
        $last_pedido = $last_pedido->pedido_id;
    endif;
    ?>
    <input type="hidden" id="last-pedido" value="<?= $last_pedido ?>">
    <?php //require_once 'side-right-chat.php'; ?>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.js"></script>
    <script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
    <script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="app-js/main.js"></script>
    <script type="text/javascript">
        var baseUrl = '<?php echo $baseUri; ?>';
        $("#cl-wrapper").removeClass("sb-collapsed");
        $('#menu-dashboard').addClass('active');
        $('.switch').bootstrapSwitch();
        if(oDt){oDt.fnSort([[0, 'desc']]);}
        $('input[name="loja-status"]').on('switchChange.bootstrapSwitch', function (event, state) {
            var url = baseUrl + '/configuracao/gravar/';
            if (state == false) {
                state = 0;
            } else {
                state = 1;
            }
            $.post(url, {config_aberto: state, redir: 'true'}, function (data) {
                console.log(data)
            });
        });
    </script>
</body>
</html>
