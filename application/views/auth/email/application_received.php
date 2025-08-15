<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Application Received</title>
</head>

<body style="margin:0; padding: 32px; background-color:#f8f9fa; font-family:'Segoe UI', sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4; padding: 20px 0;">
        <tr>
            <td align="left">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background-color:#ffffff; border-radius:8px; padding:30px; box-shadow:0 0 10px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="left" style="padding-bottom: 20px;">
                            <img src="<?= base_url('assets/images/nav_logo_blue.png') ?>" alt="BATNF | Wealth is here Logo"
                                style="height: 60px;">
                        </td>
                    </tr>

                    <tr>
                        <td style="color: #000000; font-size: 16px; line-height: 1.6;">
                            <h4 style="margin-top: 0; font-weight: 500;">Dear <?= htmlspecialchars($full_name ?? 'Applicant') ?>,</h4>

                            <p>Congratulations on successfully completing your application for the <?= $type == 'f4f' ? 'Farmers for the Future Grant' : 'Graduate Agripreneur Program' ?>!</p>

                            <p>We’re excited about your passion and commitment to shaping the future of agriculture in
                                Nigeria.</p>

                            <p>Your application has been successfully received and will be reviewed as part of the
                                selection process. Your drive and vision are exactly what this program is designed to
                                support.</p>

                            <p>Next Steps: Stay tuned! The review process is underway, and shortlisted applicants will
                                be contacted in the coming weeks. Make sure to keep an eye on your email and
                                notifications from on our social media platforms</p>

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

                            <p>Thank you once again for taking this bold step. We wish you the very best and look
                                forward to what lies ahead!</p>

                            <p>Warm regards,<br>
                                <strong>The BATN Foundation Team</strong>
                            </p>

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


<!-- Encourage them to apply before <?= date('l, F j, Y', strtotime($application_end_date)); ?>, this could be a life-changing
                                opportunity for them too! -->