<?php

function getNewMail() {
    static $done;
    if ($done !== true) {
        require_once 'Swift/swift_required.php';
        require_once 'SwiftMail.php';

        // Set a default Transport
        SwiftMail::setDefaultTransport('Smtp', $host, $port)
            ->setUsername($user)
            ->setPassword($pass);

        $done = true;

    }

    return SwiftMail::newInstance();

}

require_once 'Swift/swift_required.php';
require_once 'SwiftMail.php';

// Set a default Transport
SwiftMail::setDefaultTransport('Smtp', $host, $port)
    ->setUsername($user)
    ->setPassword($pass);

$logger = new Swift_Plugins_Loggers_EchoLogger();
SwiftMail::getMailer()
    ->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));


$mail = SwiftMail::newInstance()

    ->setSubject('Hello subject')

    ->setFrom(array('francesco.terenzani@sembox.it' => 'Francesco Terenzani'))

    ->setTo(array('f.terenzani@gmail.com' => 'Frank'))
    ->addTo('f.terenzani@sembox.it', 'Francesco Terenzani')

//    ->setCc()
//    ->addCc()
//
//    ->setBcc()
//    ->addBcc()
//
//    ->setSender()
//    ->setReturnPath()
//
//    ->setReadReceiptTo()
    
    ->setCharset('iso-8859-2')
    
    ->setMaxLineLength(1000)
    
    ->setPriority(2) // High

    ->addPart('Hello Frank', 'text/plain');

$mail
    ->setBody(
        '<p style="color:#666">Hello Frank</p>' .
        '<p><img src="' . $mail->embedFile('http://swiftmailer.org/images/logo.png') . '"></p>' .
        '<p><img src="' . $mail->embedData(file_get_contents('http://swiftmailer.org/images/logo.png'), 'logo.png', 'image/png') . '"></p>'
        , 'text/html'
    );

$mail
    ->attachFile('http://swiftmailer.org/images/logo.png', 'image/png')
    ->setFilename('cool.png');

$data = file_get_contents('http://swiftmailer.org/images/logo.png');
$mail
    ->attachData($data, 'data.png', 'image/png')
    ->setDisposition('inline');

var_dump(@$mail->send());



