<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body
    style="margin:0; padding:0; background-color:#f8f9fa; font-family: 'Segoe UI', sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="left">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background-color:#ffffff; border-radius:8px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="left" style="padding-bottom: 20px;">
                            <img src="<?= base_url('assets/images/nav_logo_blue.png') ?>" alt="BATNF | Wealth is here Logo"
                                style="height: 60px;">
                        </td>
                    </tr>

                    <tr>
                        <td style="color: #000000; font-size: 16px; line-height: 1.6;">
                            <h4 style="margin: 0 0 16px 0; font-weight: 500;">Dear
                                <?= htmlspecialchars($full_name ?? 'Applicant') ?>,</h4>

                            <p>We noticed that you’ve started your application for the <?= $type === 'f4f' ? 'Farmers for the Future Grant' : 'Graduate Agripreneur Program' ?>, but
                                it’s still in progress and hasn’t been submitted yet.</p>

                            <p>This is a gentle reminder that applications close on
                                <strong><?= date('l, F j, Y', strtotime($application_end_date)); ?></strong>. We’d love
                                to see your big agricultural idea fully submitted before the deadline!</p>

                            <p>Time is ticking, and we don’t want you to miss this opportunity to receive funding,
                                visibility, and support for your agribusiness journey.</p>

                            <p>To resume and complete your application, <a href="<?= site_url('login')?>"
                                    style="color: #007bff; text-decoration: underline;">Click this link</a> to log in
                                and pick up right where you left off.</p>

                            <p>Follow us to stay updated on the next stages of the process:</p>

                            <table cellpadding="0" cellspacing="0" border="0" style="margin: 10px 0 20px;">
                                <tr>
                                    <td style="padding-right:10px;">
                                        <a href="https://web.facebook.com/BATNFoundation/?_rdc=1&_rdr#"><img
                                                src="https://cdn-icons-png.flaticon.com/512/733/733547.png"
                                                alt="Facebook" width="24" height="24" style="display:block;"></a>
                                    </td>
                                    <td style="padding-right:10px;">
                                        <a href="https://www.instagram.com/batnfoundation/"><img
                                                src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png"
                                                alt="Instagram" width="24" height="24" style="display:block;"></a>
                                    </td>
                                    <td style="padding-right:10px;">
                                        <a href="https://x.com/BATNFoundation/"><img
                                                src="https://cdn-icons-png.flaticon.com/512/733/733579.png"
                                                alt="Twitter" width="24" height="24" style="display:block;"></a>
                                    </td>
                                    <td style="padding-right:10px;">
                                        <a href="https://www.youtube.com/channel/UCektzc9hBeVRLPqEsQuqfzQ"><img
                                                src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png"
                                                alt="YouTube" width="24" height="24" style="display:block;"></a>
                                    </td>
                                    <td style="padding-right:10px;">
                                        <a href="https://www.linkedin.com/showcase/batn-foundation/about/"><img
                                                src="https://cdn-icons-png.flaticon.com/512/145/145807.png"
                                                alt="LinkedIn" width="24" height="24" style="display:block;"></a>
                                    </td>
                                </tr>
                            </table>

                            <p>Don’t let this opportunity slip away. Complete your application before
                                <strong><?= date('F j', strtotime($application_end_date)); ?></strong> and take the next
                                big step in your agricultural journey!</p>

                            <p>Best regards,<br>
                                <strong>BATN Foundation</strong>
                            </p>

                            <hr style="border:none; border-top:1px solid #ddd; margin:30px 0;">

                            <p style="font-size: 12px; color: #777; text-align: center;">This is an automated message.
                                Please do not reply directly to this email.</p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>