SwiftMail is an implementation of the [Facade pattern](http://en.wikipedia.org/wiki/Facade_pattern) for [Swift Mailer](http://swiftmailer.org/) 4.x: a powerful component based mailing library for PHP by Chris Corbyn.

A simple e-mail can be sent in this way:

    SwiftMail::newInstance($subject, $message)
        ->setTo($to)
        ->setFrom($from)
        ->send()
    ;

By default SwiftMail try to send emails using the Swift_MailTransport (that use the mail function of PHP).
The default transport can be changed using the static method SwiftMail::setDefaultTransport.

    $smtp = Swift_SmtpTransport::newInstance($host, $port)
        ->setUsername($user)
        ->setPassword($pass)
    ;

    SwiftMail::setDefaultTransport($smtp);

A list of Tranports is available in the [Swift Mailer documentation](http://swiftmailer.org/docs/transport-types).