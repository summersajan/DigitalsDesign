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
                $subtotal = number_format($item['price'] * $item['quantity'], 2);
                $price = number_format($item['price'], 2);
                $itemsHtml .= "<tr>
                <td style='padding: 10px; border: 1px solid #eee;'>{$item['product_id']}</td>
                <td style='padding: 10px; border: 1px solid #eee;'>{$item['quantity']}</td>
                <td style='padding: 10px; border: 1px solid #eee;'>\${$price}</td>
                <td style='padding: 10px; border: 1px solid #eee;'>\${$subtotal}</td>
            </tr>";
            }

            $linksHtml = '';
            foreach ($downloadLinks as $link) {
                $linksHtml .= "<li><a href='{$link}' target='_blank' style='color: #007BFF;'>Download File</a></li>";
            }

            $totalFormatted = number_format($totalAmount, 2);

            $this->mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 700px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 6px;'>
            <h2 style='color: #333;'>Thank you for your purchase!</h2>
            <p style='color: #555;'>Here is your receipt for order <strong>#{$orderId}</strong>.</p>

            <h3 style='border-bottom: 1px solid #eee; padding-bottom: 10px;'>Invoice Summary</h3>

            <table width='100%' style='border-collapse: collapse; margin-top: 10px;'>
                <thead>
                    <tr style='background-color: #f8f8f8; text-align: left;'>
                        <th style='padding: 10px; border: 1px solid #eee;'>Product ID</th>
                        <th style='padding: 10px; border: 1px solid #eee;'>Quantity</th>
                        <th style='padding: 10px; border: 1px solid #eee;'>Price</th>
                        <th style='padding: 10px; border: 1px solid #eee;'>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    {$itemsHtml}
                </tbody>
            </table>

            <p style='font-size: 1.1em; margin-top: 15px;'><strong>Total Paid:</strong> \${$totalFormatted}</p>

            <h3 style='margin-top: 30px;'>Your Download Links</h3>
            <ul style='padding-left: 20px; color: #007BFF;'>
                {$linksHtml}
            </ul>

            <p style='margin-top: 30px; font-size: 0.95em; color: #777;'>
                If you have any questions or issues, feel free to reach out to our support team at 
                <a href='mailto:support@digitalsdesign.com' style='color: #007BFF;'>support@digitalsdesign.com</a>.
            </p>

            <p style='margin-top: 20px;'>Warm regards,<br><strong>The DigitalsDesign.com Team</strong></p>
        </div>";

            $this->mail->send();
            return 1;
        } catch (Exception $e) {
            error_log("Mailer Error (sendPurchaseReceipt): " . $e->getMessage());
            return 0;
        }
    }

}
