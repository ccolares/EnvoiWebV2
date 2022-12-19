<?php

require 'vendor/phpmailer/class.phpmailer.php';
require 'vendor/phpmailer/class.phpmaileroauth.php';
require 'vendor/phpmailer/class.phpmaileroauthgoogle.php';
require 'vendor/phpmailer/class.smtp.php';
require 'vendor/phpmailer/class.pop3.php';

Class Sender {

    public function indexAction() {
        
    }

    public function __runtest() {
        $data = array(
            'destinatario' => 'rafadinix@gmail.com',
            'assunto' => 'ASSUNTO TESTE',
            'mensagem' => 'MENSAGEM TESTE',
            'responder' => ''
        );
        self::mail($data);
    }

    static function mail($data) {
        $host = new smtpModel();
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        //$mail->Debugoutput = 'html';        
        $mail->SMTPAuth = true;
        $mail->Host = $host->__get('host');
        $mail->Port = $host->__get('port');
        $mail->Username = $host->__get('email');
        $mail->Password = $host->__get('pass');
        //$mail->SMTPSecure = 'tls';
        $mail->setFrom($host->__get('email'), utf8_decode($host->__get('nome')));
        $mail->addAddress($data['destinatario']);
        $mail->Subject = utf8_decode($data['assunto']);
        //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
        $mail->msgHTML(utf8_decode($data['mensagem']));
        $mail->AltBody = '';
        //$mail->addAttachment('images/phpmailer_mini.png');
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

}