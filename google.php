<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Google Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #loginDiv {
            text-align: center;
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div id="loginDiv">
        <div id="g_id_onload" data-client_id="" data-callback="handleCredentialResponse" data-auto_prompt="false">
        </div>
        <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline" data-text="sign_in_with"
            data-shape="rectangular" data-logo_alignment="left">
        </div>
    </div>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Fetch client ID dynamically
        $(document).ready(function () {
            $.getJSON('get_google_credentials.php', function (data) {
                if (data.client_id) {
                    $('#g_id_onload').attr('data-client_id', data.client_id);
                    google.accounts.id.initialize({
                        client_id: data.client_id,
                        callback: handleCredentialResponse
                    });
                    google.accounts.id.renderButton(
                        document.querySelector('.g_id_signin'),
                        { theme: "outline", size: "large" }  // Optional
                    );
                }
            });
        });

        function handleCredentialResponse(response) {
            $.ajax({
                url: 'google_login_handler.php',
                method: 'POST',
                data: {
                    credential: response.credential
                },
                success: function (res) {
                    const result = JSON.parse(res);
                    if (result.success) {
                        alert('Logged Ok');
                        window.location.href = "user/dashboard.php"; // Change as needed
                    } else {
                        alert('Login failed!');
                    }
                }
            });
        }
    </script>
</body>

</html>