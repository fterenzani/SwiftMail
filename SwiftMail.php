<?php
/**
 * @author Francesco Terenzani <f.terenzani@gmail.com>
 * @copyright Copyright (c) 2011, Francesco Terenzani
 */
class SwiftMail extends Swift_Message
{

    /**
     * @var Swift_Mailer
     */
    protected static $mailer;

    /**
     * Set the default Swift_Transport and initialize the Swift_Mailer
     *
     * @param Swift_Trasport $name
     */
    static function setDefaultTransport(Swift_Transport $name) {
        self::$mailer = new Swift_Mailer($transport);

    }
    
    /**
    * Create a new Message
    *
    * @param string $subject
    * @param string $body
    * @param string $contentType
    * @param string $charset
    * @return Swift_Mime_Message
    */
    static function newInstance($subject = null, $body = null, $contentType = null, $charset = null) {
        return new self($subject, $body, $contentType, $charset);
    }

    /**
     * @return Swift_Transport
     */
    static function getTransport() {
        return self::getMailer()->getTransport();
    }

    /**
     * @return Swift_Mailer
     */
    static function getMailer() {
        if (!isset(self::$mailer)) {
            self::setDefaultTransport(new Swift_MailTransport);
        }
        return self::$mailer;
    }

    /**
     *
     * @param array $failures A list of addresses that were rejected by the Transport
     * @return int 1 on success 0 on
     */
    function send(&$failures = null) {
        return self::getMailer()->send($this, $failures);
    }

    /**
     *
     * @param array $failures A list of addresses that were rejected by the Transport
     * @return int The number of sent emails
     */
    function batchSend(&$failures = null) {
        return self::getMailer()->batchSend($this, $failures);
    }

    /**
     * Embed an existing file from a given path
     *
     * @param string $source Source file path
     * @return string An identifier of the embed file
     */
    function embedFile($source) {
        $file = Swift_EmbeddedFile::fromPath($source);
        return $this->embed($file);

    }

    /**
     * Embed a file from dynamic content
     *
     * @param string $data
     * @param string $fileName
     * @param string $contentType
     * @return string An identifier of the embed file
     */
    function embedData($data, $fileName = null, $contentType = null) {
        $file = Swift_EmbeddedFile::newInstance($data, $fileName, $contentType);
        return $this->embed($file);

    }

    /**
     * Attach an existing file from a given path
     *
     * @param string $source Source file path
     * @param string $contentType The content type (image/jpg, ...)
     * @return Swift_Attachment
     */
    function attachFile($source, $contentType = null) {
        $attachment = Swift_Attachment::fromPath($source, $contentType);
        $this->attach($attachment);
        return $attachment;

    }

    /**
     * Attach a file from dynamic content
     *
     * @param string $data
     * @param string $fileName
     * @param string $contentType
     * @return Swift_Attachment
     */
    function attachData($data = null, $fileName = null, $contentType = null) {
        $attachment = Swift_Attachment::newInstance($data, $fileName, $contentType);
        $this->attach($attachment);
        return $attachment;
        
    }

}


