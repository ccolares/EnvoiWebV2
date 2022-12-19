<?php

@session_start();

class Carrinho
{

    static public function _show()
    {
        Filter::pre($_SESSION['__APP__CART__']);
    }

    static public function isfull()
    {
        if (isset($_SESSION['__APP__CART__']) && !empty($_SESSION['__APP__CART__'])) {
            return true;
        } else {
            return false;
        }
    }

    static public function count()
    {
        if (isset($_SESSION['__APP__CART__']) && !empty($_SESSION['__APP__CART__'])) {
            return count($_SESSION['__APP__CART__']);
        } else {
            return 0;
        }
    }

    static public function get_count()
    {
        if (isset($_SESSION['__APP__CART__']) && count($_SESSION['__APP__CART__']) >= 1) {
            return '<span class="badge">' . count($_SESSION['__APP__CART__']) . '</span>';
        } else {
            return '';
        }
    }

    static public function get_count_js()
    {
        if (isset($_SESSION['__APP__CART__']) && count($_SESSION['__APP__CART__']) >= 1) {
            echo '<span class="badge">' . count($_SESSION['__APP__CART__']) . '</span>';
        } else {
            echo '';
        }
    }

    static public function get_all()
    {
        if (isset($_SESSION['__APP__CART__'])) {
            return $_SESSION['__APP__CART__'];
        } else {
            return false;
        }
    }

    static public function add()
    {
        if (isset($_POST) && !empty($_POST) && isset($_POST['item_id'])) {
            $array = $_POST;
            $object = new stdClass();
            foreach ($array as $key => $value) {
                $object->$key = Filter::trim_str($value);
            }
            if (isset($object->item_preco) && isset($object->item_nome)) {
                $object->qtde = 1;
                $object->item_hash = uniqid(time());
                if (self::check_exist($object)) {
                    $_SESSION['__APP__CART__'][] = $object;
                } else {
                    echo '-1';
                }
            }
        }
    }

    static public function check_exist($item = null)
    {
        $qtde = 0;
        $flag = false;
        if (isset($_SESSION['__APP__CART__'])) {
            foreach ($_SESSION['__APP__CART__'] as $k => $v) {
                if ($_SESSION['__APP__CART__'][$k]->item_id == $item->item_id) {
                    $qtde += $_SESSION['__APP__CART__'][$k]->qtde;
                    $flag = true;
                }
            }
        }
        $qtde = (!$flag) ? 0 : $qtde;
        if (($qtde + 1) <= $item->item_estoque) {
            return true;
        } else {
            return false;
        }
    }

    static public function add_more()
    {
        $hash = Req::post('hash');
        $item = new stdClass;
        $item->item_id = Req::post('id');
        $item->item_estoque = Req::post('estoque');
        if (!self::check_exist($item)) {
            echo '-1';
            exit;
        }
        if ($item->item_id > 0) {
            if (isset($_SESSION['__APP__CART__'])) {
                foreach ($_SESSION['__APP__CART__'] as $k => $v) {
                    if ($_SESSION['__APP__CART__'][$k]->item_hash == $hash) {
                        if ($_SESSION['__APP__CART__'][$k]->qtde + 1 <= $item->item_estoque) {
                            $_SESSION['__APP__CART__'][$k]->qtde++;
                            if ($_SESSION['__APP__CART__'][$k]->qtde <= 9) {
                                echo "0" . $_SESSION['__APP__CART__'][$k]->qtde;
                            } else {
                                echo $_SESSION['__APP__CART__'][$k]->qtde;
                            }
                        } else {
                            echo '-1';
                        }
                    }
                }
            }
        }
    }

    static public function del_more()
    {
        $hash = Req::post('hash');
        $id = Req::post('id');
        if ($id > 0) {
            if (isset($_SESSION['__APP__CART__'])) {
                foreach ($_SESSION['__APP__CART__'] as $k => $v) {
                    if ($_SESSION['__APP__CART__'][$k]->item_hash == $hash) {
                        if ($_SESSION['__APP__CART__'][$k]->qtde > 1) {
                            $_SESSION['__APP__CART__'][$k]->qtde--;
                            if ($_SESSION['__APP__CART__'][$k]->qtde <= 9)
                                echo "0" . $_SESSION['__APP__CART__'][$k]->qtde;
                            else
                                echo $_SESSION['__APP__CART__'][$k]->qtde;
                        } else {
                            if (isset($_SESSION['__APP__CART__'][$k])) {
                                unset($_SESSION['__APP__CART__'][$k]);
                            }
                        }
                    }
                }
            }
        }
    }

    static public function clear()
    {
        if (isset($_SESSION['__APP__CART__'])) {
            unset($_SESSION['__APP__CART__']);
        }
        if (isset($_SESSION['__CUPOM__'])) {
            unset($_SESSION['__CUPOM__']);
        }
        if (isset($_SESSION['__LOCAL__'])) {
            unset($_SESSION['__LOCAL__']);
        }
        if (isset($_SESSION['__OBS__'])) {
            unset($_SESSION['__OBS__']);
        }
    }

    static public function get_total()
    {
        if (isset($_SESSION['__APP__CART__'])) {
            $total = 0;
            foreach ($_SESSION['__APP__CART__'] as $k) {
                $total += (floatval($k->item_preco) + floatval($k->extra_preco)) * intval($k->qtde);
            }
            if (isset($_SESSION['__CUPOM__']) && !empty($_SESSION['__CUPOM__'])) {
                if ($_SESSION['__CUPOM__']->cupom_tipo == 1) {
                    $total = $total - floatval($_SESSION['__CUPOM__']->cupom_valor);
                } else {
                    $desconto = (($total * intval($_SESSION['__CUPOM__']->cupom_percent)) / 100);
                    $total = $total - $desconto;
                }
            }
            return $total;
        }
    }

    static public function __show()
    {
        if (isset($_SESSION['__APP__CART__'])) {
            Filter::pre($_SESSION['__APP__CART__']);
        }
    }

    static public function reload()
    {
        $config = (new configModel)->get_config();
        $cat_item = array();
        $categorias = (new categoriaModel)->get_all('categoria_pos ASC');
        $k = 0;
        foreach ($categorias as $cat) {
            $itens = (new itemModel)->get_by_categoria($cat->categoria_id);
            $cat_item[$k]['categoria'] = $cat->categoria_nome;
            $cat_item[$k]['categoria_id'] = $cat->categoria_id;
            $cat_item[$k]['item'] = $itens;
            $k++;
        }
        $dados = [
            'config' => $config,
            'lista' => (object)$cat_item
        ];
        Tpl::view("site.side-carrinho-partial", $dados);
    }

    static public function minimo()
    {
        $total = Carrinho::get_total();
        $minimo = (new configModel())->get_valor_min();
        $diff = Filter::moeda($total - $minimo, 'USD');
        $flag = (($total - $minimo) >= 0) ? 'true' : 'false';
        $json = ['total' => $total, 'minimo' => $minimo, 'diff' => $diff, 'flag' => $flag];
        echo json_encode($json);
    }

}
