<html>
<head>
    <link rel="stylesheet" href="resources/css/site.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="resources/js/site.js"></script>

    <link rel="stylesheet" href="resources/css/login.css">
</head>
<body>
<?php include_once "components/background.php"; ?>


<form id="login-form" class="login-form" method="post">
    <img class="profile-picture" src="resources/img/empty_pfp.png">
    <div class="icon-input">
        <i class="fa-solid fa-user"></i>
        <input id="username" type="text" placeholder="Kullanıcı adı" name="username">
    </div>
    <div class="icon-input">
        <i class="fa-solid fa-lock"></i>
        <input type="password" placeholder="Şifre" name="password">
    </div>
    <input type="submit" value="Giriş Yap">
</form>
</body>

</html>


<script>
    var loginForm = document.getElementById('login-form');


    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var username = this.username.value;
        var password = this.password.value;

        fetch('api/user/login.php', {
            method: 'POST',
            body: JSON.stringify({
                username: username,
                password: password
            })
        })
            .then(response => {
                if (response.status === 200) {
                    window.location.href = 'dashboard.php';
                } else {
                    console.log(response);
                    throw new Error('Invalid credentials');
                }
            })
            .catch(error => {
                alert(error.message);
            });
    });


    var usernameInput = document.getElementById('username');

    usernameInput.addEventListener('input', function () {
        var username = this.value;
        var profilePicture = document.querySelector('.profile-picture');

        getProfilePicture(username).then(x => {
            profilePicture.src = x;
            if(x === 'resources/img/empty_pfp.png') return;
            animate(profilePicture);
        });
    });
</script>
