<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>

<body style="margin:0;padding:20px;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td align="center">

            <table role="presentation"
                   cellpadding="0"
                   cellspacing="0"
                   border="0"
                   width="100%"
                   style="max-width:600px;background:#ffffff;border:1px solid #e5e5e5;border-radius:8px;">

                <tr>
                    <td align="center"
                        style="padding:40px 30px;border-bottom:1px solid #eeeeee;">

                        <h1 style="margin:0;font-size:32px;color:#222;font-weight:bold;">
                            {{ site_title() }}
                        </h1>

                    </td>
                </tr>

                <tr>
                    <td style="padding:40px 30px;">

                        <h2 style="margin:0 0 20px 0;font-size:28px;color:#222;">
                            Welcome, {{ $name }}! 🎉
                        </h2>

                        <p style="margin:0 0 20px 0;font-size:16px;line-height:28px;color:#555;">
                            Thank you for joining <strong>{{ site_title() }}</strong>.
                            Your account has been created successfully and you're ready to get started.
                        </p>

                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr>
                                <td align="center"
                                    bgcolor="#222"
                                    style="border-radius:6px;">

                                    <a href="{{ url('/') }}"
                                       style="
                                            display:inline-block;
                                            padding:14px 32px;
                                            color:#ffffff;
                                            text-decoration:none;
                                            font-size:16px;
                                            font-weight:bold;
                                       ">
                                        Go to Home
                                    </a>

                                </td>
                            </tr>
                        </table>

                        <hr style="border:none;border-top:1px solid #eeeeee;margin:20px 0;">

                        <p style="margin:0;font-size:15px;line-height:26px;color:#666;">
                            If you have any questions or need assistance, simply reply to this email.
                            Our team is always happy to help.
                        </p>

                        <p style="margin:35px 0 0 0;font-size:16px;line-height:28px;color:#555;">
                            Best regards,<br>
                            <strong style="color:#222;">The {{ site_title() }} Team</strong>
                        </p>

                    </td>
                </tr>

                <tr>
                    <td align="center"
                        style="padding:25px;border-top:1px solid #eeeeee;font-size:13px;color:#888;line-height:22px;">

                        © {{ date("Y") }} {{ site_title() }}<br>
                        All rights reserved.

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>