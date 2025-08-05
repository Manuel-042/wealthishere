<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Support Email</title>
</head>

<body style="margin:0; padding:0; background-color:#FBFCFC; font-family:Arial, sans-serif;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FBFCFC">
        <tr>
            <td align="center">
                <!-- Email Container -->
                <table cellpadding="0" cellspacing="0" width="600"
                    style="max-width:600px; background-color:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="padding:30px;">
                            <!-- Logo -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="left" style="border-bottom:1px solid #cccccc; padding-bottom:10px;">
                                        <img src="<?= base_url('assets/images/nav_logo.png') ?>" alt="BAT Logo"
                                            width="150" style="display:block; height:auto;">
                                    </td>
                                </tr>
                            </table>

                            <!-- Email Content -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
                                <tr>
                                    <td style="font-size:15px; line-height:1.6; color:#333333;">
                                        Dear <strong><?= $fullname ?></strong>,<br><br>

                                        Thank you for reaching out to the Youth Empowerment in Agriculture Program (YEEP) team via
                                        <a href="<?= base_url() ?>"><?= base_url() ?></a>.<br><br>

                                        Your question: <?= $question ?>. <br><br>

                                        <?php if ($answer !== "Others"): ?>
                                            Answer: <?= $answer ?><br><br>
                                        <?php else: ?>
                                            Your enquiry has been received and is being reviewed by our support team.<br><br>
                                        <?php endif; ?>

                                        For common questions, you may consult our YEEP Support Guide.<br>

                                        <a href="<?= base_url("assets/files/YEEP Support Guide Clean.docx")?>" target="_blank">Click to view the support guide</a><br><br>

                                        <?php if ($answer == "Others"): ?>
                                            A member of our team will respond within 48 hours.<br><br>
                                        <?php endif; ?>

                                        If you need any assistance, feel free to reach out to us.<br><br>

                                        Best regards,<br>
                                        <strong>The BATN Foundation YEEP Team</strong><br>
                                        <a href="<?= base_url() ?>"><?= base_url() ?></a> |
                                        <a href="mailto:support@batnf.net">support@batnf.net</a>
                                    </td>

                                </tr>
                            </table>

                            <!-- Divider -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:30px;">
                                <tr>
                                    <td style="border-top:1px solid #dddddd;"></td>
                                </tr>
                            </table>

                            <!-- Footer -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:15px;">
                                <tr>
                                    <td align="center" style="font-size:12px; color:#777777;">
                                        Please do not reply to this message. This inbox is not monitored.
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>