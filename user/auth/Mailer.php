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
                    
                    <p>Or copy and paste this URL into your browser:</p>
                    <p><a href='{$url}'>{$url}</a></p>
                    
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

    /*
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
    }*/

    public function sendPurchaseReceipt($toEmail, $orderId, $cartItems, $totalAmount, $downloadLinks)
    {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($toEmail);
            $this->mail->isHTML(true);
            $this->mail->Subject = "Your Purchase Receipt - Order #$orderId";

            // Generate items HTML (keeping your original structure)
            $itemsHtml = '';
            foreach ($cartItems as $item) {
                $subtotal = number_format($item['price'] * $item['quantity'], 2);
                $price = number_format($item['price'], 2);
                $itemsHtml .= "<tr>
                <td style='padding: 15px 10px; border-bottom: 1px solid #eee; color: #333;'>{$item['product_id']}</td>
                <td style='padding: 15px 10px; border-bottom: 1px solid #eee; color: #333; text-align: center;'>{$item['quantity']}</td>
                <td style='padding: 15px 10px; border-bottom: 1px solid #eee; color: #333; text-align: right;'>\${$price}</td>
                <td style='padding: 15px 10px; border-bottom: 1px solid #eee; color: #333; text-align: right; font-weight: 600;'>\${$subtotal}</td>
            </tr>";
            }

            // Generate download links HTML (keeping your original structure)
            $linksHtml = '';
            foreach ($downloadLinks as $link) {
                $linksHtml .= "<li style='margin-bottom: 10px;'><a href='{$link}' target='_blank' style='color: #FF5757; text-decoration: none; padding: 8px 16px; background: #fff; border: 2px solid #FF5757; border-radius: 5px; display: inline-block; font-weight: 500;'>📥 Download File</a></li>";
            }

            $totalFormatted = number_format($totalAmount, 2);
            $orderDate = date('F j, Y');

            $this->mail->Body = "
        <div style='font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Arial, sans-serif; max-width: 700px; margin: auto; background: #f8f9fa;'>
            
            <!-- Header Section -->
            <div style='background: linear-gradient(135deg, #FF5757 0%, #FF6B6B 100%); padding: 40px 30px; text-align: center; color: white;'>
                <div style='background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 28px;'>
                    🛒
                </div>
                <h1 style='margin: 0; font-size: 32px; font-weight: 700;'>DigitalsDesign.com</h1>
                <p style='margin: 10px 0 0; font-size: 18px; opacity: 0.9;'>Digital Purchase Receipt</p>
                <div style='background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 25px; display: inline-block; margin-top: 20px;'>
                    <span style='font-size: 16px;'>✅ Payment Confirmed</span>
                </div>
            </div>

            <!-- Main Content -->
            <div style='background: white; padding: 40px 30px;'>
                
                <!-- Thank You Message -->
                <h2 style='color: #333; margin: 0 0 10px; font-size: 28px;'>Thank you for your purchase!</h2>
                <p style='color: #555; font-size: 16px; line-height: 1.6; margin-bottom: 30px;'>Here is your receipt for order <strong>#$orderId</strong>.</p>

                <!-- Order Info Bar -->
                <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: flex; justify-content: space-between; flex-wrap: wrap;'>
                    <div style='margin-bottom: 10px;'>
                        <div style='color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;'>ORDER NUMBER</div>
                        <div style='color: #333; font-weight: 600; font-size: 16px;'>#$orderId</div>
                    </div>
                    <div style='margin-bottom: 10px;'>
                        <div style='color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;'>ORDER DATE</div>
                        <div style='color: #333; font-weight: 600; font-size: 16px;'>$orderDate</div>
                    </div>
                    <div style='margin-bottom: 10px;'>
                        <div style='color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;'>STATUS</div>
                        <div style='color: #28a745; font-weight: 600; font-size: 16px;'>✅ Completed</div>
                    </div>
                </div>

                <!-- Invoice Summary -->
                <h3 style='border-bottom: 2px solid #FF5757; padding-bottom: 15px; color: #333; font-size: 22px; margin: 30px 0 20px;'>📋 Invoice Summary</h3>

                <table width='100%' style='border-collapse: collapse; margin-top: 10px; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);'>
                    <thead>
                        <tr style='background: linear-gradient(135deg, #FF5757, #FF6B6B); color: white;'>
                            <th style='padding: 15px 10px; text-align: left; font-size: 14px; font-weight: 600;'>Product ID</th>
                            <th style='padding: 15px 10px; text-align: center; font-size: 14px; font-weight: 600;'>Quantity</th>
                            <th style='padding: 15px 10px; text-align: right; font-size: 14px; font-weight: 600;'>Price</th>
                            <th style='padding: 15px 10px; text-align: right; font-size: 14px; font-weight: 600;'>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        $itemsHtml
                    </tbody>
                </table>

                <!-- Total Section -->
                <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0 30px; text-align: right;'>
                    <p style='font-size: 24px; margin: 0; color: #333;'><strong>💰 Total Paid: <span style='color: #FF5757;'>\$$totalFormatted</span></strong></p>
                </div>

                <!-- Download Links Section -->
                <div style='background: linear-gradient(135deg, #e3f2fd, #f3e5f5); padding: 30px; border-radius: 12px; margin: 30px 0; border: 1px solid #e1e5e9;'>
                    <h3 style='margin: 0 0 20px; color: #333; font-size: 22px; display: flex; align-items: center;'>
                        🎯 Your Download Links
                    </h3>
                    <ul style='padding-left: 0; list-style: none; margin: 0;'>
                        $linksHtml
                    </ul>
                    <div style='background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 6px; padding: 15px; margin-top: 20px;'>
                        <p style='margin: 0; color: #856404; font-size: 14px;'>
                            <strong>💡 Tip:</strong> Download links are valid for 30 days. Save your files to a secure location.
                        </p>
                    </div>
                </div>

                <!-- Dashboard Link -->
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='https://digitalsdesign.com/dashboard' target='_blank' style='background: linear-gradient(135deg, #FF5757, #FF6B6B); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: 600; display: inline-block; box-shadow: 0 4px 12px rgba(255, 87, 87, 0.3);'>
                        🏠 Visit Your Dashboard
                    </a>
                </div>

                <!-- Support Section -->
                <div style='background: #fff9e6; border-left: 4px solid #ffc107; padding: 20px; margin: 30px 0; border-radius: 0 8px 8px 0;'>
                    <h4 style='margin: 0 0 10px; color: #333; font-size: 18px;'>💬 Need Help?</h4>
                    <p style='margin: 0 0 15px; font-size: 15px; color: #666; line-height: 1.6;'>
                        If you have any questions or issues, feel free to reach out to our support team at 
                        <a href='mailto:support@digitalsdesign.com' style='color: #FF5757; text-decoration: none; font-weight: 600;'>support@digitalsdesign.com</a>.
                    </p>
                    <div style='text-align: center;'>
                        <a href='mailto:support@digitalsdesign.com' style='background: #ffc107; color: #212529; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: 600; display: inline-block;'>
                            📧 Contact Support
                        </a>
                    </div>
                </div>

                <!-- Closing Message -->
                <div style='text-align: center; margin: 40px 0 20px;'>
                    <p style='margin: 0 0 20px; color: #666; font-size: 16px; line-height: 1.6;'>
                        We hope you love your digital products! Don't forget to follow us for more amazing designs.
                    </p>
                    <p style='margin: 0; font-size: 16px; color: #333;'>
                        Warm regards,<br>
                        <strong style='color: #FF5757; font-size: 18px;'>The DigitalsDesign.com Team</strong>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div style='background: #2c3e50; color: white; padding: 25px 30px; text-align: center;'>
                <p style='margin: 0 0 15px; font-size: 16px; font-weight: 600;'>DigitalsDesign.com</p>
                <p style='margin: 0 0 15px; font-size: 14px; opacity: 0.8;'>© 2025 DigitalsDesign.com — Premium Digital Designs</p>
                <div style='font-size: 13px;'>
                    <a href='https://digitalsdesign.com' target='_blank' style='color: #FF5757; text-decoration: none; margin: 0 10px;'>🌐 Website</a>
                    <span style='color: #7f8c8d;'>|</span>
                    <a href='https://digitalsdesign.com/support' target='_blank' style='color: #FF5757; text-decoration: none; margin: 0 10px;'>🛠️ Support</a>
                    <span style='color: #7f8c8d;'>|</span>
                    <a href='https://digitalsdesign.com/privacy' target='_blank' style='color: #FF5757; text-decoration: none; margin: 0 10px;'>🔒 Privacy</a>
                </div>
            </div>
        </div>";

            $this->mail->send();
            return 1;
        } catch (Exception $e) {
            error_log("Mailer Error (sendPurchaseReceipt): " . $e->getMessage());
            return 0;
        }
    }


}
