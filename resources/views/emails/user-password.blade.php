<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Account Details</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f6f6f6; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 8px;">
        
        <h2 style="color: #333;">Welcome, {{ $user->name }}</h2>

        <p>Your account has been created successfully.</p>

        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>

        <hr>

        <p style="font-size: 12px; color: #888;">
            Please keep your login details secure.
        </p>

        <p style="font-size: 12px; color: #888;">
            You can change your password after login.
        </p>

    </div>

</body>
</html>