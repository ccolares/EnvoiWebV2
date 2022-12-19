<?php

error_reporting(E_ALL);

Class Request {

    static function query_build() {
        $obj = (object) Request::get_all();
        return $obj;
    }

    static function get_all() {
        $sql_update = array();
        $sql_insert = array();
        foreach ($_REQUEST as $key => $input) {
            $_REQUEST[$key] = @addslashes(trim($input));
            $sql_update[] = $key . " = '" . $_REQUEST[$key] . "'";
        }
        $sql_update = implode(', ', $sql_update);
        $sql_insert = "(`" . implode("`,`", array_keys($_REQUEST)) . "`) VALUES "
                . "('" . implode("','", array_values($_REQUEST)) . "')";
        return array(
            'fields' => array_keys($_REQUEST),
            'values' => array_values($_REQUEST),
            'sql_update' => $sql_update,
            'sql_insert' => $sql_insert,
            'sql_fields' => "(`" . implode("`,`", array_keys($_REQUEST)) . "`)",
            'sql_values' => "('" . implode("','", array_values($_REQUEST)) . "')",
            'obj' => (object) array_combine(array_keys($_REQUEST), array_values($_REQUEST))
        );
    }

    static function get_uri($key, $parse = 'string') {
        $uri = filter_input(INPUT_GET, 'rota', FILTER_SANITIZE_SPECIAL_CHARS);
        $uri = explode("/", $uri);
        if (array_key_exists($key, $uri)) {
            if ($parse == 'int') {
                $uri[$key] = intval($uri[$key]);
            }
            return $uri[$key];
        } else {
            return false;
        }
    }

    static function get_all_obj() {
        $obj = (object) Request::get_all();
        return $obj;
    }

    static function add_index($key, $value) {
        $_REQUEST[$key] = trim($value);
    }

    static function remove_index($key) {
        if (isset($_REQUEST[$key]))
            unset($_REQUEST[$key]);
    }

    static function change_index($key, $value) {
        if (isset($_REQUEST[$key]))
            $_REQUEST[$key] = trim($value);
    }

    static function remove_blank($key) {
        foreach ($_REQUEST as $key => $input) {
            $_REQUEST[$key] = trim($input);
            if (empty($_REQUEST[$key]))
                unset($_REQUEST[$key]);
        }
    }

    static function get($key) {
        if (isset($_REQUEST[$key]))
            return ltrim(rtrim(trim($_REQUEST[$key])));
    }

    static function parse($post) {
        parse_str($post, $arr);
        return $arr;
    }

    static function parse2Obj($post) {
        parse_str($post, $arr);
        return (object) $arr;
    }

    static function get_and_remove($key) {
        $str = "";
        if (isset($_REQUEST[$key])) {
            $str = ltrim(rtrim(trim($_REQUEST[$key])));
            if (isset($_REQUEST[$key])) {
                unset($_REQUEST[$key]);
            }
        }
        return $str;
    }

    static function open_curl($url, $data = null) {
          $buffer = "";
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $buffer = trim(curl_exec($ch));
        curl_close($ch);
        return $buffer;
    }

    static function open_url($param = array()) {
        if (empty($param)) {
            throw new Exception('openUrl: Array de parâmetros vazio!');
        } else {
            if (isset($param['method'])) {
                $method = strtoupper($param['method']);
            } else {
                throw new Exception('openUrl: Parâmetro method deve ser informado no array de parâmetros!');
            }
            if ($method == 'C') {

                $url = $param['url'];
                $buffer = "opa";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $buffer = trim(curl_exec($ch));
                if (curl_errno($ch)) {
                    throw new Exception('Curl error: ' . curl_error($ch));
                }
                return $buffer;
                curl_close($ch);
            } elseif ($method == 'F') {
                $url = $param['url'];
                $line = "";
                $buffer = "";
                $handle = @fopen("$url", "r");
                if ($handle) {
                    while (!feof($handle)) {
                        $line = trim(@fgets($handle, 4096));
                        if (isset($param['return']) && $param['return'] == 'array') {
                            $buffer[] = explode(",", $line);
                        } else {
                            $buffer .= $line . "\n";
                        }
                    }
                    fclose($handle);
                    return $buffer;
                }
            } elseif ($method == 'FC') {
                $url = $param['url'];
                $buffer = trim(@file_get_contents($url, 0, null));
                $buffer = $buffer;
                return $buffer;
            }
        }
    }

}
