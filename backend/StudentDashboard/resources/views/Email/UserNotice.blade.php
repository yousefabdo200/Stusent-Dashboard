<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your CSS styles here */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #3498db;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .content {
            padding: 20px;
        }

        .button {
            background-color: #3498db;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to Our Community!</h1>
        </div>
        <div class="content">
            <p>Hello {{$user_name}},</p>
            <p>Thank you for joining our community. We are excited to have you on board!</p>
            <p>To get started, click the button below to log in to your account and if it fisrt time click on forget password:</p>
            @if($type==='Student')
                <a id="resetLink" href="http://localhost:8000/Student/login" style="background-color: #3490dc; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">log in</a><!--add rest page url -->
            @else
                <a id="resetLink" href="http://localhost:8000/Teacher/teacher" style="background-color: #3490dc; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">log in</a><!--add rest page url -->
            @endif
            <p>If you have any questions or need assistance, feel free to contact us.</p>
            <p>Best regards,<br>[Your School]</p>
        </div>
    </div>
</body>
</html>
