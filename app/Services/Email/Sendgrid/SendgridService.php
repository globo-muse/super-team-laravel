<?php

namespace App\Services\Email\Sendgrid;

use Exception;
use SendGrid;
use \SendGrid\Mail\Mail as SengridMail;

class SendgridService
{
    static public function send($templateId, $toEmail, $toName, $dinamicTemplateData)
    {
        $email = new SengridMail();
        $email->setFrom(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
        $email->addTo($toEmail, $toName);
        $email->addDynamicTemplateDatas($dinamicTemplateData);
        $email->setTemplateId($templateId);
        $sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
            return $response;
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
