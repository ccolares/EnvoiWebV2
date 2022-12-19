$(function () {
    $(".sabores").on("click", function () {
        var sab_id = $(this).data("id");
        var item_id = $(this).data("item");
        var item = $(this).data("item-id");
        var sabores = $("#sabores-" + item).val();
        if (sab_id == item_id) {
            return false;
        }
        if ($(".lista-sab-" + item).find("input:checked").length >= sabores) {
            $(".lista-sab-" + item)
                .find("input:not(:checked)")
                .attr("disabled", "disabled");
        } else {
            $(".lista-sab-" + item)
                .find("input")
                .removeAttr("disabled");
        }
    });
    $(".add-item").on("click", function () {
        var item_id = $(this).data("id");
        var item_hash = $(this).data("hash");
        var item_nome = $(this).data("nome");
        var grupo = $(this).data("nome");
        var item_categoria = $(this).data("categoria");
        var categoria_nome = $(this).data("categoria-nome");
        var item_obs = $(this).data("obs");
        var item_cod = $(this).data("cod");
        var item_estoque = parseInt($(this).data("estoque"));

        var url = baseUri + "/carrinho/add_more/";
        $.post(url, {id: item_id, hash: item_hash, estoque: item_estoque}, function (rs) {
            if (rs == '-1') {
                $("#modal-carrinho").modal("show");
                $('.item-estoque-' + item_hash).html('Quantidade indisponível!');
                return false;
            }
        });
        var item_preco = parseFloat($(this).data("preco"));
        var optExtraValTotal = 0;
        var optExtraNames = "";
        var optExtraVals = "";
        var optElm = $(".opt-" + item_id).find("input:checked");
        var optElmReq = parseInt(
            $("#item-" + item_id + " .elmRequerido").length
        );
        var optElmReqSet = parseInt(
            $(".opt-" + item_id).find("[type=radio]:checked").length
        );
        if (optElmReqSet < optElmReq) {
            $("#msg-" + item_id).text(
                "SELECIONE OS (" + optElmReq + ") ITENS OBRIGATÓRIOS!"
            );
            setTimeout(function () {
                $("#msg-" + item_id).text("");
            }, 2000);
            return false;
        }
        var sabElm = $(".lista-sab-" + item_id).find("input:checked");
        if (sabElm.length > 1) {
            var valMinMax = 0;
            var valMinMaxQtde = 0;
            sabElm.each(function () {
                var preco = parseFloat($(this).data("preco"));
                var nome = $(this).data("nome");
                valMinMax += preco;
                valMinMaxQtde++;
                item_preco = preco;
                optExtraNames += "Sabor " + nome + " + ";
            });
            item_preco = parseFloat(valMinMax / valMinMaxQtde);
        }
        $("#btn-add-" + item_id).removeAttr("disabled");
        if (optElm.length >= 1) {
            optElm.each(function () {
                optExtraNames += $(this).data("nome") + ", ";
                optExtraVals += $(this).data("preco_real") + ", ";
                optExtraValTotal += parseFloat($(this).data("preco_real"));
            });
        }
        var itemOptItemPreco =
            parseFloat(item_preco) + parseFloat(optExtraValTotal);
        var dados = {
            item_id: item_id,
            item_estoque: item_estoque,
            item_codigo: item_cod,
            item_nome: item_nome,
            categoria_nome: categoria_nome,
            categoria_id: item_categoria,
            item_obs: item_obs,
            item_preco: item_preco,
            extra: optExtraNames,
            extra_vals: optExtraVals,
            extra_preco: optExtraValTotal,
            total: itemOptItemPreco,
        };
        var url = baseUri + "/carrinho/add/";
        $.post(url, dados, function () {
        }).then(() => {
            rebind_reload();
        });
        $("#item-" + item_id).modal("hide");
        saboresSelect = 1;
        $(".lista-sabores").find("input").removeAttr("disabled");
        $(".lista-sabores").find("input:checked").removeAttr("checked");
        $(".form-check").find("input:checked").removeAttr("checked");
        $(".pre-checked").parent().trigger("click");
        setTimeout(() => {
            $("#modal-carrinho").modal("show");
        }, 500);
        $("#busca").val("");
    });

    $(".form-check input[type=checkbox]").on("click", function () {
        var limite = $(this).data("limite");
        var item = $(this).data("grupo");
        var optSet = parseInt(
            $(".opt-" + item).find("input[type=checkbox]:checked").length
        );
        if (optSet >= limite) {
            $(".opt-" + item)
                .find("input[type=checkbox]")
                .not(":checked")
                .attr("disabled", "disabled");
        } else {
            $(".opt-" + item)
                .find("input[type=checkbox]")
                .not(":checked")
                .removeAttr("disabled");
        }
    });

    $(".modal-itens").on("hide.bs.modal", function () {
        saboresSelect = 1;
        $(".lista-sabores").find("input").removeAttr("disabled");
        $(".lista-sabores").find("input").removeAttr("checked");
        $(".form-check").find("input").removeAttr("disabled");
        $(".form-check").find("input:checked").removeAttr("checked");
        $(".pre-checked").parent().trigger("click");
    });
    rebind_add();
    rebind_del();
    rebind_scroll();
    rebind_get_count();
});

function aplica_cupom() {
    var url = baseUri + "/pedido/aplica_cupom/";
    var cupom = $("#cupom_nome").val();
    var local = $("#pedido_local").val();
    var obs = $("#pedido_obs").val();
    $.post(url, {cupom: cupom, local: local, obs: obs}).then(function (rs) {
        if (parseInt(rs) == 1) {
            var html = '<strong class="text-success"> Cupom aplicado</strong>';
            setTimeout(function () {
                window.location.reload();
            }, 350);
        } else {
            var html = '<strong class="text-danger"> Cupom inválido</strong>';
            let bor = $('#cupom_nome').css('border');
            $('#cupom_nome').css('border', '1px solid red');
            $('#cupom_nome').val('Cupom inválido ou expirado!');
            setTimeout(() => {
                $('#cupom_nome').val('');
                $('#cupom_nome').css('border', bor);
            }, 2000)
        }
        $("#cupom_resposta").html(html);
    });
}

function remove_cupom() {
    var url = baseUri + "/pedido/remove_cupom/";
    $.post(url).then(function (rs) {
        var html = '<strong class="text-success"> Cupom removido</strong>';
        setTimeout(function () {
            window.location.reload();
        }, 350);
        $("#cupomrm_resposta").html(html);
    });
}

$("#pedido_obs").on("change", function () {
    var valor_obs = $(this).val();
    $("#pega-obs").val(valor_obs);
});

function rebind_reload() {
    var url = baseUri + "/carrinho/reload/";
    $.post(url, {}, function (data) {
        $("#carrinho-lista").html(data);
    }).then(() => {
        setTimeout(() => {
            rebind_add();
            rebind_del();
            rebind_get_count();
            $('[data-toggle="tooltip"]').tooltip();
        }, 500)
    });
}

function rebind_add() {
    $(".add-more").on("click", function () {
        var id = parseInt($(this).data("id"));
        var hash = $(this).data("hash");
        var estoque = parseInt($(this).data("estoque"));
        var url = baseUri + "/carrinho/add_more/";
        $.post(url, {id: id, estoque: estoque, hash: hash}, function (rs) {
            if (rs == '-1') {
                $('.item-estoque-' + hash).html('Quantidade indisponível!');
            } else {
                rebind_reload();
            }
        });
    });
}

function rebind_del() {
    $(".del-more").on("click", function () {
        var id = parseInt($(this).data("id"));
        var hash = $(this).data("hash");
        var url = baseUri + "/carrinho/del_more/";
        $.post(url, {id: id, hash: hash}, function () {
            rebind_reload();
        });
    });
}

function rebind_scroll() {
    $(".scroll-to-up").on("click", function () {
        scroll_to("topo");
    });
}

function rebind_get_count() {
    var url = baseUri + "/carrinho/get_count_js/";
    $.post(url, {}, function (rs) {
        $("#cart-count").html(rs);
    });
}

$("#pedido_local").on("change", function () {
    $(".pedido_bairro").val("");
    var ori_total = totalCompra;
    var local = parseInt($(this).val());
    var total = parseFloat(totalCompra);
    var taxa = 0;
    $("#pedido_total").val(totalCompra);
    $("#pedido_entrega").val(0);
    $("#pedido-total").html(total.formatMoney());
    $("#taxa-faixa").html("R$ 0,00");
    if (local == -1) {
        window.location.href = baseUri + "/novo-endereco/?return=pedido";
    }
    if (local >= 0) {
        var bairro = $("#pedido_local option:selected").data("bairro");
        var prazo = $("#pedido_local option:selected").data("tempo");
        $("#pedido_entrega_prazo").val(prazo);
        if (bairro > 0) {
            $(".pedido_bairro").val(bairro);
            var url = baseUri + "/local/get_preco_entrega/";
            $.post(url, {bairro: bairro}).done(function (rs) {
                if (rs == "-1") {
                    $("#pedido_local").val("");
                    $("#btn-pedido-concluir").attr("disabled", "disabled");
                    return false;
                } else {
                    taxa = parseFloat(rs);
                    $("#pedido_entrega").val(taxa);
                }
                total = parseFloat(totalCompra) + parseFloat(taxa);
                $("#pedido_total").val(total);
                $("#pedido_entrega").val(taxa);
                $("#pedido-total").html(total.formatMoney());
                $("#taxa-faixa").html(taxa.formatMoney());
            });
        } else {
            $("#pedido-total").html(ori_total);
            $("#pedido_total").val(ori_total);
        }
        $("#pega-endereco").val(local);
        $("#pega-endereco2").val(local);
        $("#forma-pagamento").removeAttr("disabled");
        scroll_to("forma-pagamento");
    } else {
        $("#btn-pedido-concluir").attr("disabled", "disabled");
        $("#forma-pagamento").attr("disabled", "disabled");
        $("#taxa-faixa").html("R$ 0,00");
        $("#pedido_total").val(ori_total);
        $("#pedido-total").html(parseFloat(totalCompra).formatMoney());
    }
});

$("#forma-pagamento").on("change", function () {
    scroll_to("btn-pedido-concluir");
    var forma = $("#forma-pagamento").val();
    $("#troco-bandeira").attr('required', 'required');
    $("#troco-bandeira").attr("type", "text");
    $("#troco-bandeira").val("");
    $("#troco-bandeira").unmask();
    if (forma == 7) {
        $("#btn-pedido-concluir").addClass("hide");
        $("#btn-pedido-concluir").hide();
        $("#pagamento-online").removeClass("hide");
        $("#pagamento-online").show();
        $("#forma-pagamento-troco-bandeira").addClass("hide").hide();
    }
    if (forma == 2 || forma == 3) {
        var cartao = $("#forma-pagamento option:selected").text();
        $("#troco-bandeira-label").html(
            "Informe a bandeira: (ex: Visa, Master...)"
        );
        $("#troco-bandeira").attr(
            "placeholder",
            "Informe a bandeira: Visa, Master, Elo..."
        );
        $("#forma-pagamento-troco-bandeira").removeClass("hide").show();
        $("#pagamento-online").hide();
        $("#btn-pedido-concluir").removeClass("hide");
        $("#btn-pedido-concluir").show();
    }
    if (forma == 1) {
        $("#troco-bandeira").attr("type", "tel");
        $("#troco-bandeira-label").html(
            'Troco para quanto? <button type="button" class="btn btn-link" id="sem-troco">Não preciso de troco</button>'
        );
        $("#troco-bandeira").attr("placeholder", "Troco para quanto?");
        $("#forma-pagamento-troco-bandeira").removeClass("hide").show();
        $("#pagamento-online").hide();
        $("#btn-pedido-concluir").removeClass("hide");
        $("#btn-pedido-concluir").show();
        $("#troco-bandeira").mask("#.##0,00", {reverse: true});
        $("#sem-troco").on("click", function () {
            $("#troco-bandeira").removeAttr('required');
            $("#troco-bandeira").val("0");
            $("#forma-pagamento-troco-bandeira").addClass("hide").hide();
        });
    }
    if (forma != "") {
        $("#btn-pedido-concluir").removeAttr("disabled");
        $("#troco-bandeira").focus();
    } else {
        $("#btn-pedido-concluir").attr("disabled", "disabled");
        return false;
    }
});

function validaPagamento() {
    var forma = $("#forma-pagamento").val();
    var troco_bandeira = $("#troco-bandeira").val();
    var pagto = "";

    if (forma == "") {
        $("#troco-bandeira").focus();
        return false;
    } else {
        if (forma == 1) {
            var troco_bandeira = parseFloat(
                $("#troco-bandeira").val().replace(",", ".")
            );
            var pedido_total = parseFloat(
                $("#pedido_total").val().replace(",", ".")
            );
            if (troco_bandeira > 0 && troco_bandeira < pedido_total) {
                alert("Valor informado inferior ao valor total!");
                $("#troco-bandeira").focus();
                return false;
            }
            pagto = "Pagto em Dinheiro";
            if (troco_bandeira != "") {
                pagto +=
                    " - Troco para " + parseFloat(troco_bandeira).formatMoney();
            }
        }
        if (forma == 2) {
            pagto = "Pagto com Cartão de Débito: " + troco_bandeira;
        }
        if (forma == 3) {
            pagto = "Pagto com  Cartão de Crédito: " + troco_bandeira;
        }
    }
    $("#pedido_obs_pagto").val(pagto);
    $(this).text("Aguarde...");
    $(this).addClass("disabled");
}

Number.prototype.formatMoney = function (places, symbol, thousand, decimal) {
    places = !isNaN((places = Math.abs(places))) ? places : 2;
    symbol = symbol !== undefined ? symbol : "R$ ";
    thousand = thousand || ".";
    decimal = decimal || ",";
    var number = this,
        negative = number < 0 ? "-" : "",
        i =
            parseInt((number = Math.abs(+number || 0).toFixed(places)), 10) +
            "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return (
        symbol +
        negative +
        (j ? i.substr(0, j) + thousand : "") +
        i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) +
        (places
            ? decimal +
            Math.abs(number - i)
                .toFixed(places)
                .slice(2)
            : "")
    );
};
