<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Final Reminder</title>
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
                                        Dear <strong><?= $firstname ?></strong>,<br><br>

                                        As the application deadline approaches, we kindly ask that you log in to your
                                        account using the link below to review your submission:<br><br>

                                        <a href="<?= base_url('api/f4f-application/') . $id ?>" style="color: #007BFF;">
                                           Click here to view your application
                                        </a><br><br>

                                        Please verify that all your details were correctly captured and that your
                                        application is complete.<br><br>

                                        If you need any assistance, feel free to reach out to us.<br><br>

                                        Warm regards,<br>
                                        <strong>The BATN Foundation Team</strong>
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
