<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class Email
{
    private $mailer;
    private $host;
    private $port;
    private $username;
    private $password;
    private $secure;
    private $charset;

    private $from_email;
    private $from_name;

    private $error;

    private $mail;

    public function __construct()
    {
        $this->mailer        = getenv('MAIL_MAILER');
        $this->host          = getenv('MAIL_HOST');
        $this->port          = getenv('MAIL_PORT');
        $this->username      = getenv('MAIL_USERNAME');
        $this->password      = getenv('MAIL_PASSWORD');
        $this->secure        = getenv('MAIL_ENCRYPTION');

        $this->from_email    = getenv('MAIL_FROM_ADDRESS');
        $this->from_name     = getenv('MAIL_FROM_NAME');

        $this->charset       = 'UTF-8';
    }


    public function getError()
    {
        return $this->error;
    }

    public function send($to, $subject, $body, $attachments = [], $cc = [], $bcc = [])
    {
        try {
            $this->error = null;
            $this->mail = new PHPMailer(true);
            $this->mail->isSMTP();
            $this->mail->Mailer       = $this->mailer;
            $this->mail->Host         = $this->host;
            $this->mail->SMTPAuth     = true;
            $this->mail->Username     = $this->username;
            $this->mail->Password     = $this->password;
            $this->mail->SMTPSecure   = $this->secure;
            $this->mail->Port         = $this->port;
            $this->mail->CharSet      = $this->charset;

            $this->mail->setFrom($this->from_email, $this->from_name);

            $this->addInfo($to,          'addAddress');
            $this->addInfo($attachments, 'addAttachment');
            $this->addInfo($cc,          'addCC');
            $this->addInfo($bcc,         'addBCC');

            $this->mail->isHTML(true);
            $this->mail->Subject    = $subject;
            $this->mail->Body       = $body;

            $this->mail->send();

            return true;
        } catch (PHPMailerException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    private function addInfo($addresses, $method)
    {
        if (!empty($addresses)) {
            $addresses = is_array($addresses) ? $addresses : [$addresses];
            foreach ($addresses as $address) {
                $this->mail->$method($address);
            }
        }
    }
}
