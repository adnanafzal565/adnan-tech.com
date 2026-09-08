<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>New Newsletter Subscriber</h2>
    <p>A new user just subscribed to the newsletter.</p>
    <table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td><strong>Email:</strong></td>
            <td>{{ $email }}</td>
        </tr>
        <tr>
            <td><strong>Subscribed at:</strong></td>
            <td>{{ $subscribedAt }}</td>
        </tr>
    </table>
</body>
</html>