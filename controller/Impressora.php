<?php

@session_start();

/*
    api key
    AIzaSyB72FVHSVx2o0J8-o-3c2oCJexcxmkVRqo

    oauth
    813872395150-4s83e1tuac9nv4nal3br7m77272fdfe8.apps.googleusercontent.com
    eVnMih7TsTJIq0qXqlgCv6u0

    https://accounts.google.com/o/oauth2/v2/auth?
    scope=https%3A//www.googleapis.com/auth/cloudprint&
    access_type=offline&
    include_granted_scopes=true&
    response_type=code&
    state=state_parameter_passthrough_value&
    redirect_uri=http%3A//xfluxdelivery.com.br&
    client_id=813872395150-4s83e1tuac9nv4nal3br7m77272fdfe8.apps.googleusercontent.com
 */

class Impressora
{
    public function indexAction()
    {
        if (isset($_SESSION['TOKEN']) && !empty($_SESSION['TOKEN'])) {
            self::list();
        } else {
            if (isset($_GET['code'])) {
                self::token();
            } else {
                $url = trim("https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/cloudprint&prompt=consent&access_type=offline&include_granted_scopes=true&response_type=code&state=state_parameter_passthrough_value&redirect_uri=http://xfluxdelivery.com.br/impressora&client_id=813872395150-4s83e1tuac9nv4nal3br7m77272fdfe8.apps.googleusercontent.com");
                echo '<p> <center>impressora cloud</center></p>';
                echo '<br><center><a href="' . $url . '">Solicitar acesso ao cloud print</a></center>';
            }
        }
    }


    public function token()
    {
        $code = $_GET['code'];
        $params = [
            'client_id' => '813872395150-4s83e1tuac9nv4nal3br7m77272fdfe8.apps.googleusercontent.com',
            'client_secret' => 'eVnMih7TsTJIq0qXqlgCv6u0',
            'grant_type' => 'authorization_code',
            'prompt' => 'consent',
            'code' => $code,
            'redirect_uri' => 'http://xfluxdelivery.com.br/impressora'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v4/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $result = curl_exec($ch);
        $result = json_decode($result);
        $_SESSION['TOKEN'] = $result->access_token;
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        if(isset($result->refresh_token)) {
            $_SESSION['TOKEN_REFRESH'] = $result->refresh_token;
        }
        Filter::pre($result);
    }

    public function refresh()
    {
        $refresh = $_SESSION['TOKEN_REFRESH'];
        $params = [
            'client_id' => '813872395150-4s83e1tuac9nv4nal3br7m77272fdfe8.apps.googleusercontent.com',
            'client_secret' => 'eVnMih7TsTJIq0qXqlgCv6u0',
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh,
            'access_type' => 'offline'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v4/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $result = curl_exec($ch);
        $result = json_decode($result);
        $_SESSION['TOKEN'] = $result->access_token;
        //$_SESSION['TOKEN_REFRESH'] = $result->refresh_token;
        Filter::pre($result);
    }

    public function submit()
    {
        $url = "https://www.google.com/cloudprint/submit";
        $title = "Foo " . uniqid();
        $content = 'TESTE BODY';
        $printerid = '621a7558-7a7a-29fb-919c-ed6dc410e22d';
        $params = [
            'printerid' => $printerid,
            'title' => $title,
            'ticket' => '{"version":"1.0","print":{}}',
            'content' => $content,
            'contentType' => 'text/plain'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $token = $_SESSION['TOKEN'];
        $headers = [];
        $headers[] = 'Authorization: Bearer ' . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        Filter::pre($result);
    }

    public function list()
    {
        $url = "https://www.google.com/cloudprint/search";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $token = $_SESSION['TOKEN'];
        $headers = [];
        $headers[] = 'Authorization: Bearer ' . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        Filter::pre($result);
    }
}

