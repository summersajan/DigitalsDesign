<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        // SMTP Configuration for Hostinger
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.hostinger.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = getenv('EMAIL');
        $this->mail->Password = getenv('PASSWORD');
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;

        $this->mail->setFrom(getenv('EMAIL'), 'Digitals Design');
    }

    public function sendLinkEmail($toEmail, $type, $url)
    {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($toEmail);
            $this->mail->isHTML(true);



            if ($type === 'verification') {
                $this->mail->Subject = "Verify Your Account";
                $this->mail->Body = "
                    <p>Hello,</p>
                    <p>Click the link below to verify your account:</p>
                    <p><a href='{$url}'>Verify Account</a></p>
                    
                    <p>If you didn't request this, you can ignore this email.</p>
                    <p>Thanks,<br>Digitals Design Team</p>
                ";
            } elseif ($type === 'reset') {
                $this->mail->Subject = "Reset Your Password";
                $this->mail->Body = "
                    <p>Hello,</p>
                    <p>Click the link below to reset your password:</p>
                    <p><a href='{$url}'>Reset Password</a></p>
                    
                    <p>If you didn't request this, you can ignore this email.</p>
                    <p>Thanks,<br>Digitals Design Team</p>
                ";
            } else {
                return ["status" => 0, "message" => "Invalid email type."];
            }

            $this->mail->send();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}
