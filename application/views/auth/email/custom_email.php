<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Account Activation Successful</title>
</head>

<body style="margin:0; padding:0; background-color:#FBFCFC; font-family:Arial, sans-serif;">
  <table role="presentation" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FBFCFC">
    <tr>
      <td align="center">
        <!-- Email Container -->
        <table cellpadding="0" cellspacing="0" width="600" style="max-width:600px; background-color:#ffffff; border-radius:8px; overflow:hidden;">
          <tr>
            <td style="padding:30px;">
              <!-- Logo -->
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" style="border-bottom:1px solid #cccccc; padding-bottom:10px;">
                    <img src="<?= base_url('assets/images/nav_logo.png') ?>" alt="BAT Logo" width="150" style="display:block; height:auto;">
                  </td>
                </tr>
              </table>

              <!-- Email Content -->
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
                <tr>
                  <td style="font-size:15px; line-height:1.6; color:#333333;">
                    Dear <strong><?= $firstname ?></strong>,<br><br>

                    Great news! Your account has been successfully activated. You are now ready to proceed with completing your application for the <strong>Farmers for the Future Grant</strong>.<br><br>

                    This is an exciting opportunity, and we encourage you to log in and finalize your submission at your earliest convenience.<br><br>

                    <strong>Please note:</strong> The application window for the Farmers for the Future Grant will officially close on <strong>Sunday, July 20th</strong>. Ensure all required sections are completed and submitted before this deadline.<br><br>

                    <a href="<?= site_url('login') ?>" style="color:#007bff; text-decoration:none;">Click here to log in to your account</a><br><br>

                    We wish you the best of luck with your application!<br><br>

                    Warm regards,<br>
                    <strong>BATN Foundation Team</strong>
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
                    Please do not reply to this message as this inbox is not monitored.
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
