<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="application-name"
          content="<?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?>"/>
    <meta name="description"
          content="<?= (isset($data['config']->config_site_description)) ? $data['config']->config_site_description : ''; ?>"/>
    <meta name="keywords"
          content="<?= (isset($data['config']->config_site_keywords)) ? $data['config']->config_site_keywords : ''; ?>"/>
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
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/slick/slick.css"/>
    <link rel="icon" type="image/png"
          href="<?php echo $baseUri; ?>/midias/logo/<?php echo $data['config']->config_foto; ?>"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>"
          type="text/css"/>
    <?php if (isset($data['config']->config_site_ga) && $data['config']->config_site_ga != "") : ?>
        <script type="text/javascript"><?= $data['config']->config_site_ga; ?> </script>
    <?php endif; ?>
    <!-- Flux Delivery - Desenvolvido por PHP STAFF www.phpstaff.com.br -->
</head>
<body>
<?php require_once 'menu.php'; ?>
<div class="container-fluid">
    <div id="home-content" class="<?= (!$isMobile) ? 'container' : ''; ?>">
        <div class="busca">
            <?php require_once 'busca-form.php'; ?>
        </div>
        <?php if ($data['config']->config_aberto == 0): ?>
            <button class="btn btn-block btn-danger text-uppercase no-radius" type="button">
                <i class="fa fa-clock-o"></i> Estamos fechados, voltaremos logo ;(
            </button>
        <?php endif; ?>

        <div class="slide" style="margin-top:<?= ($isMobile) ? '80px' : '20px'; ?>">
            <?php require_once 'banner.php'; ?>
        </div>
        <div class="lista-item">
            <?php if (isset($data['lista'][0])) : ?>
                <?php foreach ($data['lista'] as $obj) : ?>
                    <?php $categoria_nome = $obj['categoria']; ?>
                    <?php $categoria_img = $obj['categoria_img'];
                    $categoria_img_url = "$baseUri/midias/categoria/$categoria_img";
                    ?>
                    <?php $categoria_id = $obj['categoria_id']; ?>
                    <?php $estoque = $obj['item'][0]->item_estoque; ?>
                    <?php $opcoes = $obj['opcoes']; ?>
                    <?php $meia = $obj['categoria_meia']; ?>
                    <?php $iterator = 0; ?>
                    <?php if (strlen($categoria_img) >= 4) : ?>
                        <img src="<?= $categoria_img_url ?>" class="img-responsive">
                    <?php endif; ?>

                    <h3 class="text-uppercase text-color-1"><?php echo strtolower($categoria_nome); ?><br></h3>
                    <div class="row">
                    <?php foreach ($obj['item'] as $item) : ?>
                        <?php $item->item_estoque = $estoque; ?>
                        <?php $foto_url = "midias/item/$item->item_foto"; ?>
                        <div class="col-md-6 col-xs-12">
                        <?php if (isset($opcoes[0]) || $meia > 1) : ?>
                            <div class="lista-item-box"
                            data-toggle="modal"
                            data-estoque="<?= intval($item->item_estoque); ?>"
                            title="<?php echo ($item->item_estoque > 0) ? 'adicionar à sacola' : 'ITEM INDISPONÍVEL'; ?>"
                            data-target="#item-<?php echo ($item->item_estoque > 0) ? $item->item_id : 'indisponivel'; ?>"
                            style="margin-bottom:20px">
                        <?php else : ?>
                            <div class="lista-item-box <?php echo ($item->item_estoque > 0) ? 'add-item' : ''; ?>"
                            data-toggle="modal"
                            data-target="#item-<?php echo ($item->item_estoque > 0) ? $item->item_id : 'indisponivel'; ?>"
                            id="btn-add-<?= $item->item_id; ?>"
                            data-id="<?= $item->item_id; ?>"
                            data-nome="<?= $item->item_nome; ?>"
                            data-obs="<?= strip_tags($item->item_obs); ?>"
                            data-categoria="<?= $item->categoria_id; ?>"
                            data-categoria-nome="<?= $item->categoria_nome; ?>"
                            data-preco="<?= Currency::moedaUS($item->item_preco); ?>"
                            data-nome="<?= $item->item_nome; ?>"
                            data-cod="<?= $item->item_codigo; ?>"
                            data-estoque="<?= intval($item->item_estoque); ?>"
                            title="<?php echo ($item->item_estoque > 0) ? 'adicionar à sacola' : 'ITEM INDISPONÍVEL'; ?>"
                            style="margin-bottom:20px">
                        <?php endif; ?>
                        <?php
                        $w = (!$isMobile) ? "120" : "95";
                        $h = (!$isMobile) ? "120" : "95";
                        $col1 = (!$isMobile) ? "9" : "8";
                        $col2 = (!$isMobile) ? "3" : "4";
                        ?>
                        <div class="row">
                            <div class="col-xs-<?= $col1 ?> lista-item-desc">
                                <h5 class="text-capitalize"><?= strtolower($item->item_nome) ?></h5>
                                <?php if ($item->item_estoque > 0): ?>
                                    <h6 class="text-muted text-lowercase"><?= strip_tags($item->item_obs); ?></h6>
                                <?php else: ?>
                                    <h6 class="text-muted text-danger">ITEM INDISPONÍVEL</h6>
                                <?php endif; ?>
                                <h4>R$ <?= Currency::moeda($item->item_preco) ?></h4>
                            </div>
                            <div class="col-xs-<?= $col2 ?>">
                                <?php if ($item->item_foto != "" && file_exists($foto_url)): ?>
                                    <img src="<?php echo $baseUri; ?>/midias/thumb.php?zc=2&w=<?= $w ?>&h=<?= $h ?>&src=item/<?= $item->item_foto ?>"
                                         alt="foto produto"
                                         class="img-radius">
                                <?php else : ?>
                                    <img src="<?php echo $baseUri; ?>/midias/thumb.php?zcx=3&w=100&h=100&src=img/sem_foto.jpg"
                                         alt="..." class="img-radius">
                                <?php endif; ?>
                            </div>
                        </div>
                        </div>
                        </div>
                        <?php if (isset($opcoes[0]) || $meia > 1) : ?>
                            <div class="modal fade bs-example-modal-lg modal-itens" tabindex="-1"
                                 id="item-<?= $item->item_id; ?>" role="dialog"
                                 aria-labelledby="myLargeModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title text-uppercase text-center">Detalhes e Opções
                                                <small
                                                        class="text-muted"> <Br><?= $categoria_nome ?></small>
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-center text-uppercase">
                                                <b><?= $item->item_nome; ?> -
                                                    R$ <?= Currency::moeda($item->item_preco) ?></b>
                                            </p>
                                            <?php if (strip_tags($item->item_obs) != "") : ?>
                                                <p>
                                                    <small class="text-uppercase">
                                                        <b>Ingredientes:</b><br>
                                                        <?= strip_tags($item->item_obs); ?>
                                                    </small>
                                                </p>
                                            <?php endif; ?>
                                            <?php if ($meia > 1) : ?>
                                                <input type="hidden" id="sabores-<?= $item->item_id ?>"
                                                       value="<?= $meia ?>">
                                                <p>
                                                    <br>
                                                    <small class="text-uppercase">
                                                        <b>Selecione até <span
                                                                    class="text-danger"><?= $meia ?></span>
                                                            sabores:</b> &nbsp; &nbsp; <small class="text-muted">*
                                                            Opcional</small> <br>
                                                    </small>
                                                    <small>(Será cobrado o preço médio proporcional )</small>
                                                </p>
                                                <?php foreach ($obj['itemAll'] as $sab) : ?>
                                                    <div class="form-check lista-sabores lista-sab-<?= $item->item_id ?>"
                                                         data-preco="<?= Currency::moedaUS($sab->item_preco) ?>">
                                                        <label for="sab-<?= $sab->item_id ?>-<?= $iterator ?>"
                                                               data-id="sab-<?= $sab->item_id ?>">
                                                            <input type="checkbox"
                                                                <?= ($item->item_id == $sab->item_id) ? 'checked' : ' ' ?>
                                                                   class="sabores <?= ($item->item_id == $sab->item_id) ? ' pre-checked' : ' ' ?>"
                                                                   id="sab-<?= $sab->item_id ?>-<?= $iterator ?>"
                                                                   name="sab-<?= $sab->item_id ?>-<?= $iterator ?>"
                                                                   data-id="<?= $sab->item_id ?>-<?= $iterator ?>"
                                                                   data-item-id="<?= $item->item_id ?>"
                                                                   data-item="<?= $item->item_id ?>-<?= $iterator ?>"
                                                                   data-nome="<?= $sab->item_nome ?>"
                                                                   data-estoque="<?= intval($item->item_estoque); ?>"
                                                                   data-preco="<?= $sab->item_preco; ?>"
                                                                   value="<?= $sab->item_id ?>"/>
                                                            <span class="label-text">
                                                                        <span class="lista-item-opcao"><?= ucfirst(strtolower($sab->item_nome)) ?></span>
                                                                        <span class="text-danger"><?= ' R$ ' . Currency::moeda($sab->item_preco); ?></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <?php $iterator++; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>


                                            <?php if (isset($opcoes[0])) : ?>
                                                <?php foreach ($opcoes as $opcao) : ?>
                                                    <?php if (isset($opcao[0]->opcao_id)) : ?>
                                                        <div class="<?= ($opcao[0]->grupo_tipo == 1) ? 'elmRequerido' : ''; ?>">
                                                            <small class="text-uppercase">
                                                                <br>
                                                                <b><?= $opcao[0]->grupo_nome ?></b>
                                                                <?php if ($opcao[0]->grupo_tipo == 1) : ?>
                                                                    <small class="text-muted text-danger"> &nbsp;* obrigatório</small>
                                                                <?php else: ?>
                                                                <?php $lim = $opcao[0]->grupo_limite;?>
                                                                    <small class="text-muted"> * opcional
                                                                        <?= ($lim <= 0) ? '' : '(até '. $lim  ?>
                                                                        <?= ($lim != 0) ? ($lim > 1) ? ' itens)' : 'item) ' : '' ?>
                                                                    </small>
                                                                <?php endif; ?>
                                                            </small>
                                                            <br>
                                                        </div>
                                                        <?php foreach ($opcao as $opc) : ?>
                                                            <div class="form-check opt-<?= $opc->grupo_id ?> opt-<?= $item->item_id ?>
                                                            grupo-<?= $opc->grupo_id ?> "
                                                                 data-preco="<?= Currency::moedaUS($item->item_preco) ?>">
                                                                <label for="opt-<?= $opc->opcao_id ?>-<?= $item->item_id ?>">
                                                                    <input type="<?= ($opc->grupo_tipo == 1) ? 'radio' : 'checkbox'; ?>"
                                                                           name="opt-<?= $opc->grupo_id ?>-<?= $item->item_id ?>"
                                                                           id="opt-<?= $opc->opcao_id ?>-<?= $item->item_id ?>"
                                                                           data-limite="<?= ($opc->grupo_limite <= 0) ? 100 : $opc->grupo_limite ?>"
                                                                           data-grupo="<?= $opc->grupo_id ?>"
                                                                           data-item="<?= $item->item_id ?>"
                                                                           data-estoque="<?= intval($item->item_estoque); ?>"
                                                                           data-id="<?= $opc->opcao_id ?>"
                                                                           data-nome="<?= $opc->opcao_nome ?>"
                                                                           data-preco_real="<?= Currency::moedaUS($opc->opcao_preco) ?>"
                                                                           data-preco=" <?= ($opc->opcao_preco > 0) ? ' + R$ ' . Currency::moeda($opc->opcao_preco) : ''; ?>"
                                                                        <?= ($opc->grupo_tipo == 1) ? 'required' : ''; ?>
                                                                           value="<?= $opc->opcao_id ?>"/>

                                                                    <span class="label-text">
                                                                            <span class="lista-item-opcao text-capitalize"><?= strtolower($opc->opcao_nome) ?></span>
                                                                            <span class="text-danger">
                                                                                <?= ($opc->opcao_preco > 0) ? ' + R$ ' . Currency::moeda($opc->opcao_preco) : ''; ?>
                                                                            </span>
                                                                        </span>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <p class="text-center">
                                                <button type="button"
                                                        id="btn-add-<?= $item->item_id; ?>"
                                                        data-id="<?= $item->item_id; ?>"
                                                        data-nome="<?= $item->item_nome; ?>"
                                                        data-obs="<?= strip_tags($item->item_obs); ?>"
                                                        data-categoria="<?= $item->categoria_id; ?>"
                                                        data-categoria-nome="<?= $item->categoria_nome; ?>"
                                                        data-preco="<?= Currency::moedaUS($item->item_preco); ?>"
                                                        data-nome="<?= $item->item_nome; ?>"
                                                        data-estoque="<?= intval($item->item_estoque); ?>"
                                                        data-cod="<?= $item->item_codigo; ?>"
                                                        class="btn btn-primary btn-lg add-item btn-block"
                                                        title="adicionar à sacola">
                                                    <i class="fa fa-plus-circle"></i> Adicionar ao carrinho
                                                </button>

                                                <button type="button"
                                                        data-dismiss="modal"
                                                        class="btn btn-defaul btn-lg btn-block"
                                                        title="adicionar à sacola">
                                                    <i class="fa fa-chevron-circle-left"></i> Voltar à lista &nbsp; &nbsp;  &nbsp;  &nbsp;&nbsp;
                                                </button>
                                                <br><br>
                                                <strong class="text-danger"
                                                        id="msg-<?= $item->item_id ?>"> </strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="modal fade bs-example-modal" tabindex="-1"
                 id="item-indisponivel" role="dialog"
                 aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title text-uppercase text-center">
                                <strong>INDISPONÍVEL</strong></h4>
                        </div>
                        <div class="modal-body">
                            <p class="text-center text-uppercase">
                                <b>Lamentamos mas o item selecionado está indisponível no momento!</b>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <p class="text-center">
                                <img src="<?php echo $baseUri; ?>/midias/thumb.php?zcx=3&w=218&h=178&src=img/icon-triste.png"
                                     alt="...">
                                <br><br>
                                <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Temos outras opções, clique aqui!
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'side-carrinho.php'; ?>
<script type="text/javascript">var currentUri = 'index';</script>
<?php require_once 'footer-core-js.php'; ?>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/slick/slick.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/number.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
<script type="text/javascript">
    $('#busca').val('A');
    $('.add-item').addClass('returnIndex');
</script>
<script>rebind_reload();</script>
<script type="text/javascript"><?= (isset($data['config']->config_chat) && trim($data['config']->config_chat) != "") ? $data['config']->config_chat : ''; ?></script>
<script>
    $('.banner').removeClass('hide').slick({
        dots: false,
        arrows: false,
        infinite: true,
        mobileFirst: true,
        autoplay: true,
        speed: 2000,
        //slidesToShow: 1,
        adaptiveHeight: true
    });
</script>
<!-- Flux Delivery - Desenvolvido por PHP STAFF www.phpstaff.com.br -->
</body>
</html>
