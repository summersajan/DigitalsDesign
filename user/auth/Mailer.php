<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

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

        $this->mail->setFrom(getenv('EMAIL'), 'Digitals Product');
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
                    <p>Thanks,<br>Digitals Product Team</p>
                ";
            } elseif ($type === 'reset') {
                $this->mail->Subject = "Reset Your Password";
                $this->mail->Body = "
                    <p>Hello,</p>
                    <p>Click the link below to reset your password:</p>
                    <p><a href='{$url}'>Reset Password</a></p>
                    
                    <p>If you didn't request this, you can ignore this email.</p>
                    <p>Thanks,<br>Digitals Product Team</p>
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
    public function sendPurchaseReceipt($toEmail, $orderId, $cartItems, $totalAmount, $downloadLinks)
    {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($toEmail);
            $this->mail->isHTML(true);
            $this->mail->Subject = "Your Purchase Receipt - Order #$orderId";

            $itemsHtml = '';
            foreach ($cartItems as $item) {
                $itemsHtml .= "<tr>
                <td>{$item['product_id']}</td>
                <td>{$item['quantity']}</td>
                <td>\${$item['price']}</td>
                <td>$" . ($item['price'] * $item['quantity']) . "</td>
            </tr>";
            }

            $linksHtml = '';
            foreach ($downloadLinks as $link) {
                $linksHtml .= "<li><a href='{$link}' target='_blank'>Download File</a></li>";
            }

            $this->mail->Body = "
            <p>Thank you for your purchase!</p>
            <p><strong>Order ID:</strong> $orderId</p>
            <table border='1' cellpadding='6' cellspacing='0' width='100%'>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    $itemsHtml
                </tbody>
            </table>
            <p><strong>Total Paid:</strong> \$$totalAmount</p>
            <h4>Your Download Links:</h4>
            <ul>$linksHtml</ul>
            <p>If you have any issues, contact us.</p>
            <p>Thanks,<br>Digitals Product Team</p>
        ";

            $this->mail->send();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}
