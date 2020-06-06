<?php


namespace App\Traits;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

trait MailerTrait
{
    public function sendMail($mailTo, $link)
    {
        $mail = new PHPMailer();

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $_ENV['EMAIL_ADDRESS'];                 // SMTP username
        $mail->Password   = $_ENV['EMAIL_PASS'];                     // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($_ENV['EMAIL_ADDRESS'], 'Rob Kwanten');
        $mail->addAddress($mailTo);     // Add a recipient
        $mail->addReplyTo($_ENV['EMAIL_ADDRESS'], 'Rob Kwanten');
        $mail->addCC($_ENV['EMAIL_ADDRESS']);
        $mail->Subject = 'Bevestigingsmail Haridate';
        $mail->msgHTML(str_replace('%%link%%', $link, file_get_contents(__DIR__.'/../Mail/mail.html')), __DIR__);

        $mail->send();
    }

}