<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>

<body style="margin:0;padding:20px;background-color:#f3f4f6;font-family:Arial,Helvetica,sans-serif;">

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td align="center">

            <table role="presentation"
                   cellpadding="0"
                   cellspacing="0"
                   border="0"
                   width="100%"
                   style="max-width:600px;background:#ffffff;border:1px solid #e5e7eb;border-radius:8px;">

                <tr>
                    <td align="center"
                        style="background:#222;padding:30px;border-radius:8px 8px 0 0;">

                        <span style="font-size:28px;font-weight:bold;color:#ffffff;">
                            {{ site_title() }}
                        </span>

                    </td>
                </tr>

                <tr>
                    <td style="padding:40px 30px;color:#374151;font-size:16px;line-height:26px;">

                        <h2 style="margin:0 0 20px 0;color:#111827;font-size:24px;">
                            Hello {{ $name }},
                        </h2>

                        <p style="margin:0 0 20px 0;">
                            Thank you for creating your account.
                        </p>

                        <p style="margin:0 0 30px 0;">
                            Please enter the following verification code to complete your email verification.
                        </p>

                        <table role="presentation"
                               cellpadding="0"
                               cellspacing="0"
                               border="0"
                               width="100%">
                            <tr>
                                <td align="center">

                                    <div style="
                                        display:inline-block;
                                        padding:18px 32px;
                                        border:2px dashed #222;
                                        border-radius:8px;
                                        background:#F3F4F6;
                                        color:#222;
                                        font-size:34px;
                                        font-weight:bold;
                                        letter-spacing:8px;
                                    ">
                                        {{ $verification_code }}
                                    </div>

                                </td>
                            </tr>
                        </table>

                        <p style="margin:35px 0 0 0;">
                            If you didn't request this verification code, you can safely ignore this email.
                        </p>

                    </td>
                </tr>

                <tr>
                    <td style="
                        padding:20px;
                        text-align:center;
                        color:#6b7280;
                        font-size:13px;
                        border-top:1px solid #e5e7eb;
                    ">

                        © {{ date("Y") }} {{ site_title() }}<br><br>
                        All rights reserved.

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>