<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Activate Your Account</title>
</head>

<body style="margin:0; padding: 2rem; background-color:#f8f9fa; font-family:'Segoe UI', sans-serif;">

	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 40px 0;">
		<tr>
			<td align="left">

				<table width="600" cellpadding="0" cellspacing="0" border="0"
					style="background-color:#ffffff; border-radius:10px; padding:30px; box-shadow:0 5px 15px rgba(0,0,0,0.1); text-align:left;">
					<tr>
						<td align="left" style="padding-bottom: 20px;">
							<img src="<?= base_url('assets/images/nav_logo_dark.png'); ?>" alt="BATNF Logo"
								style="height: 60px;">
						</td>
					</tr>

					<tr>
						<td style="font-size: 16px; color: #000000; text-align: left; line-height: 1.6;">

							<h4 style="margin: 0 0 16px 0; font-weight: 400; font-size: 1rem">Hi
								<?= $this->ion_auth->user($id)->row()->first_name ?>!</h4>

							<p>Thank you for registering for the Farmers for the Future Grant Program. You're one step
								closer to turning your agribusiness dream into reality!</p>

							<p>To complete your registration and access your application dashboard, please activate your
								account by clicking the button below:</p>

							<a href="<?= site_url('auth/activate/' . $id . '/' . $activation); ?>"
								style="display:inline-block; background-color:#007bff; color:#ffffff; padding:12px 24px; border-radius:50px; text-decoration:none; font-weight:500; margin-top: 15px; margin-bottom: 15px;">Activate
								My Account</a>

							<p style="margin-top: 20px;">
								If the button doesn’t work, copy and paste this link into your browser:<br>
								<span style="word-break: break-all;"><a
										href="<?= site_url('auth/activate/' . $id . '/' . $activation); ?>"><?= site_url('auth/activate/' . $id . '/' . $activation); ?></a></span>
							</p>

							<p style="margin: 16px 0 0 0;">We’re excited to have you on this journey with us.</p>
							<p style="margin: 0 0 16px 0;">If you didn’t initiate this registration, please ignore
								this email.</p>

							<p>Warm regards,<br><strong>BATN Foundation</strong></p>

							<p style="font-size: 0.85rem; color: #6c757d; margin: 16px 0 0 0;">Need help? Reach out via
								the support page on the BATN Foundation mobile app or visit <a
									href="https://www.batnf.net/wealthishere"
									style="color: #007bff; text-decoration: underline;">this link</a></p>

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