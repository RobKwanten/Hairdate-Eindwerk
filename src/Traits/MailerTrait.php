<?php


namespace App\Traits;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

trait MailerTrait
{
    public function sendMail( $link)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 1;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.live.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $_ENV['EMAIL_ADDRESS'];                     // SMTP username
            $mail->Password   = $_ENV['EMAIL_PASS'];                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('robkwanten1@hotmail.com', 'Rob');
            $mail->addAddress('robkwanten@hotmail.com', 'Rob Kwanten');     // Add a recipient

            $body = '<strong>Hello</strong> this is my first email with PHPMailer.';

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Test';
            $mail->Body    = str_replace('%%link%%', $link, file_get_contents(__DIR__.'/../Mail/mail.html'));
            $mail->AltBody = strip_tags($body);

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}