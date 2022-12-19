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
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/btn-upload.css" rel="stylesheet" />
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
                    <h3>Gerenciar Cupons</h3>
                </div>
                <div class="content">
                    <form action="<?php echo $baseUri; ?>/cupom/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                        <h3>Novo cupom</h3>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="cupom_nome">Nome</label>
                                <input type="text" class="form-control" name="cupom_nome" id="cupom_nome" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="cupom_validade">Data de validade</label>
                                <input type="text" name="cupom_validade" id="cupom_validade"
                                       class="form-control  date-calendar" autocomplete="off"
                                       required/>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="cupom_tipo">Tipo de cupom</label>
                                <select name="cupom_tipo" id="cupom_tipo" class="form-control" required>
                                    <option value="1">Valor R$</option>
                                    <option value="2">Porcentagem %</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group" id="cp_valor">
                                <label for="cupom_valor">Valor</label>
                                <input type="text" name="cupom_valor" id="cupom_valor" class="form-control">
                            </div>
                            <div class="col-md-3 form-group" id="cp_percent">
                                <label for="cupom_percent">Porcentagem</label>
                                <input type="text" name="cupom_percent" id="cupom_percent" class="form-control" maxlength="2">
                            </div>
                            <div class="col-md-12 text-center form-group">
                                <br>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Gravar cupom</button>
                            </div>
                        </div>

                    </form>

                    <div id="cupom-grid">
                        <?php if(isset($data['cupom'])):?>
                            <br><br><br><br>
                            <table>
                                <thead>
                                <th class=""><strong>Nome</strong></th>
                                <th class=""><strong>Valor/Porcentagem</strong></th>
                                <th class=""><strong>Validade</strong></th>
                                <th class="hidden-xs" width="75"><strong>Ação</strong></th>
                                </thead>
                                <tbody>
                                <?php foreach($data['cupom'] as $cp):?>
                                    <tr>
                                        <td><strong><?= $cp->nome ?></strong></td>
                                        <td><strong><?= $cp->valor ?></strong></td>
                                        <td><strong><?= $cp->validade ?></strong></td>
                                        <td width="75"><a class="btn btn-xs btn-danger" onclick="remove(<?= $cp->id ?>)"> <i class="fa fa-trash"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif;?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Right Chat-->
<div class="modal fade colored-header warning md-effect-10" id="modal-remove" tabindex="-1" role="dialog">
    <div class="modal-dialog custom-width">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Remover Registro</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                    <h4>Atenção!</h4>
                    <p>Você está prestes à remover um registro e esta ação não pode ser desfeita. <br />
                        Deseja realmente prosseguir?</p>
                </div>
            </div>
            <div class="modal-footer">
                <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/cupom/remove/" method="post">
                    <input type="hidden" name="cupom_id" id="cupom_id">
                    <a class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</a>
                    <button type="submit" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script src="js/jquery.js"></script>
<script src="js/jquery.cooki/jquery.cooki.js"></script>
<script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
<script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="js/jquery.ui/jquery-ui.js" ></script>
<script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="js/behaviour/core.js"></script>
<script type="text/javascript" src="js/jquery.select2/dist/js/select2.js"></script>
<script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $baseUri; ?>/assets/vendor/uf-combo/cidades-estados-1.4-utf8.js" charset="utf-8"></script>
<script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.mask.js"></script>
<!-- CALENDAR JS -->
<script src="js/cupom-desconto/moment.js"></script>
<script src="js/cupom-desconto/moment-pt-br.js"></script>
<script src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.js"></script>
<?php require_once 'switch-color.php'; ?>
<script src="app-js/main.js"></script>
<script type="text/javascript">
    <?php if (isset($_GET['success'])): ?>
    _alert_success();
    <?php endif; ?>
</script>
<script>
    $(document).ready(function () {
        $('#cp_percent').hide();
        $('#cupom_validade').mask('00/00/0000');
        $('#cupom_valor').mask('00,00', {reverse: true});
        $('#menu-cupom').addClass('active');

        $('#cupom_tipo').on('change', function () {
            var val = $('#cupom_tipo').val();
            if(val == 1){
                $('#cp_valor').show();
                $('#cp_percent').hide();
                $('#cupom_valor').attr('required', 'required');
                $('#cupom_percent').removeAttr('required', 'required');
            }else{
                $('#cp_percent').show();
                $('#cp_valor').hide();
                $('#cupom_percent').attr('required', 'required');
                $('#cupom_valor').removeAttr('required', 'required');
            }
        });

        $('.date-calendar').datetimepicker({
            format: 'DD/MM/YYYY'
        });

    });

    function remove(id) {
        $('#modal-remove').modal('show');
        $('#cupom_id').val(id);
    }

</script>
<script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
<script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>
</html>
