<?php

use \SendGrid\Mail\Mail;

require("./../vendor/autoload.php");


class EmailSendgrid
{

    public static function send2($to, $toName, $subject, $message)
    {
        $email = new Mail();
        // Replace the email address and name with your verified sender
        $email->setFrom(
            'contacto@dondecompro.ar',
            'DondeCompro?'
        );
        $email->setSubject($subject);
        // Replace the email address and name with your recipient
        $email->addTo(
            $to,
            $toName
        );
        $email->addContent(
            'text/html',
            $message
        );
        $sendgrid = new \SendGrid('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');
        try {
            $response = $sendgrid->send($email);
            $result  = array('code' => $response->statusCode(), 'headers' => $response->headers());
         
            return $result;
        } catch (Exception $e) {
            return $e;
        }
    }
}
