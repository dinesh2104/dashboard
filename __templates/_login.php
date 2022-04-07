<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="/Dashboard/css/login.css">
</head>

<body>
    <div class="hero">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="register()">Register</button>

            </div>
            <div class="social-icon">
                <img src="/Dashboard/img/fb.png">
                <img src="/Dashboard/img/tw.png">
                <img src="/Dashboard/img/gp.png">
            </div>
            <form id="login" class="input-group">
                <input type="text" placeholder="Username" class="input-field" required>
                <input type="text" placeholder="Password" class="input-field" required>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button type="submit" class="submit-btn">Log In</button>

            </form>
            <form id="register" class="input-group">
                <input type="text" placeholder="Username" class="input-field" required>
                <input type="text" placeholder="Email Id" class="input-field" required>
                <input type="text" placeholder="Password" class="input-field" required>
                <input type="checkbox" placeholder="username" class="check-box"><span>I agree to the terms &
                    conditions</span>
                <button type="submit" class="submit-btn">Register</button>
            </form>
        </div>

    </div>
</body>
<script>
    var x = document.getElementById("login");
    var y = document.getElementById("register");
    var z = document.getElementById("btn");

    function register() {
        x.style.left = "-400px"
        y.style.left = "50px"
        z.style.left = "110px"
    }

    function login() {
        x.style.left = "50px"
        y.style.left = "450px"
        z.style.left = "0"
    }
</script>

</html>