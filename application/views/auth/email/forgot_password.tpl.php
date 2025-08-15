<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Forgot Password Verification</title>
</head>

<body style="margin:0; padding: 32px; background-color:#f8f9fa; font-family: 'Segoe UI', sans-serif;">

	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 40px 0;">
		<tr>
			<td align="left">
				<table width="600" cellpadding="0" cellspacing="0" border="0"
					style="background-color:#ffffff; border-radius:10px; padding:30px; box-shadow:0 5px 15px rgba(0,0,0,0.1); text-align:left;">
					<tr>
						<td style="padding-bottom: 20px;">
							<img src="<?= base_url('assets/images/nav_logo_blue.png'); ?>" alt="BATNF Logo"
								style="height: 60px;">
						</td>
					</tr>

					<tr>
						<td style="font-size: 16px; color: #000000; line-height: 1.6;">
							<h4 style="margin-top: 0;">Hi <?= $identity ?>,</h4>

							<p>Looks like you requested a password reset. No worries—we’ve got you covered!</p>

							<p style="margin-bottom: 30px;">Click the button below to reset your password and get back
								into your account.</p>

							<p style="text-align: left;">
								<a href="<?= site_url('auth/reset_password/' . $forgotten_password_code); ?>"
									style="display:inline-block; background-color:#007bff; color:#ffffff; padding:12px 24px; border-radius:50px; text-decoration:none; font-weight:500;">
									Reset My Password
								</a>
							</p>

							<p style="margin-top: 30px;">
								If the button doesn’t work, you can also copy and paste this link into your browser:
							</p>
							<p style="word-break: break-all; font-size: 0.9rem; color: #007bff;">
								<a
									href="<?= site_url('auth/reset_password/' . $forgotten_password_code); ?>"><?= site_url('auth/reset_password/' . $forgotten_password_code); ?></a>
							</p>

							<!-- Footer -->
							<p style="font-size: 0.85rem; color: #6c757d;">
								If you didn’t request this, you can safely ignore this email. No changes will be made to
								your account.
							</p>

							<p style="margin-top: 30px;">Warm regards,<br><strong>BATN Foundation Team</strong></p>

							<hr style="border:none; border-top:1px solid #ddd; margin:30px 0;">

							<p style="font-size: 12px; color: #777; text-align: center;">
								This is an automated message. Please do not reply directly to this email.
							</p>

						</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>

</body>

</html>