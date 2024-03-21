<?php
require_once './Facebook/autoload.php';
$fb = new Facebook\Facebook([
    'app_id' => '277774842033660',
    'app_secret' => '3e95a6c8ef286e052bebc5cb018fa839',
    'default_graph_version' => 'v12.0',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email'];
$loginUrl = $helper->getLoginUrl('https://your-website.com/fb-callback.php', $permissions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>

<form action="login.php" method="post" id="loginForm" >
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Login</h2>
                    </div>
                    <div class="card-body">
                        <form id="login-form" method="post">
                                <label for="username">username:</label><br>
                                <input type="text" class="form-control" id="username" placeholder="what's your name"name="username"><br>
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" placeholder="password enter"name="password"><br>
                                <!-- Display age field after 3 unsuccessful attempts -->
                                <div id="ageField" style="display: none;">
                                    <label for="age">Age:</label>
                                    <input type="text" class="form-control" id="age" name="age" placeholder="enter the age"><br>
                                </div>
                            <button type="submit" class="btn btn-success">Login</button>
                            <a class="btn btn-success" href="<?php echo htmlspecialchars($loginUrl); ?>">Facebook</a>
                        </form>
                        <div id="agefield"  class="text-danger mt-3"></div>
                        <div id="message" class="text-danger mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var attempts = 0; // Variable to track login attempts

        $('#loginForm').submit(function(event){
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'login.php',
                data: formData,
                success: function(response){
                    if(response.trim() == 'Login successful!'){
                        window.location.href = 'view.php';
                    } else {
                        $('#message').text(response);
                        attempts++;
                        // Display age field after 3 unsuccessful attempts
                        if(attempts >= 3) {
                            $('#ageField').show();
                        }
                    }
                }
            });
        });
    });
</script>
</body>
</html>
<!-- <input type="submit" name="submit" value="submit">  -->
