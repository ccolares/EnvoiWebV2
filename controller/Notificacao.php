<?php

@session_start();

class Notificacao
{
    public function pagSeguro()
    {
        $pagamento = (new pagamentoModel)->get_all();
        if ( $pagamento ==  null )
        {
            $body = "<p>Retorno PagSeguro: Módulo não configurado! <br/>";
            $body .= "Hora: " . date( 'd/m/Y H:i:s' ) . " <br />";
            $body .= "Url: " . $this->baseUri;
            $body .= "</p>";
            exit;
        }
        if($pagamento->pagamento_gw == "SANDBOX"){
            $notificationCode = $_REQUEST['notificationCode'];
            $url = "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/$notificationCode?email=$pagamento->pagamento_usuario&token=$pagamento->pagamento_senha";
        }else{
            $notificationCode = $_REQUEST['notificationCode'];
            $url = "https://ws.pagseguro.uol.com.br/v3/transactions/notifications/$notificationCode?email=$pagamento->pagamento_usuario&token=$pagamento->pagamento_senha";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch); //exit;
        }else {
            $result = simplexml_load_string($result);
            $pedido_status = intval($result->status);
            $pedido_id = intval($result->reference);
            (new pedidoModel)->status_pagseguro($pedido_status, $pedido_id);
        }

    }
}