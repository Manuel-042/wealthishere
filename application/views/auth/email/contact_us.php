<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Contact Form Submission</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border: 1px solid #ddd; text-align:left;">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <img src="<?= base_url('assets/images/nav_logo_blue.png'); ?>" alt="BATNF Logo" style="height: 60px;">
            </td>
        </tr>

        <tr>
            <td style="padding: 20px 20px 0 20px; font-size: 20px; font-weight: bold; color: #333;">
                New Contact Form Submission
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <table width="100%" cellpadding="8" cellspacing="0" border="0">
                    <tr>
                        <td width="30%" style="font-weight: bold;">Name:</td>
                        <td><?= $fullName ?></td>
                    </tr>
                    <tr style="background-color: #f4f4f4;">
                        <td style="font-weight: bold;">Email:</td>
                        <td><?= $email ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Phone:</td>
                        <td><?= $phone ? $phone : 'Not provided' ?></td>
                    </tr>
                    <tr style="background-color: #f4f4f4;">
                        <td style="font-weight: bold; vertical-align: top;">Message:</td>
                        <td><?= nl2br($message) ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f1f1f1; padding: 15px; text-align: text; font-size: 12px; color: #555;">
                This message was sent via your website's contact form.
            </td>
        </tr>
    </table>
</body>

</html>