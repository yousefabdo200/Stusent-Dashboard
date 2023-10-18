<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #3490dc;
        }

        p {
            font-size: 16px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Reset</h1>
        <p>You have requested to reset your password. To proceed, click the button below:</p>
       <a id="resetLink" href="http://localhost:8000/resetpassword/{{ $token }}" style="background-color: #3490dc; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Reset Password</a><!--add rest page url -->
        <p>If you did not request a password reset, you can safely ignore this email.</p>
        <p class="footer">Thanks, Your school</p>
    </div>
</body>
</html>
