<html>
<head>
    <?php include_once "components/head.php"; ?>
    <link rel="stylesheet" href="resources/css/dashboard.css">
</head>
<body>
<?php include_once "components/background.php"; ?>

<main>
    <nav>
        <img class="profile-picture">
        <h1 class="username"></h1>

        <a id="dashboard-link">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>
        <a id="data-viewer-link">
            <i class="fa-solid fa-table"></i>
            <span>Veri Görüntüleyici</span>
        </a>
        <a id="logout-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Çıkış Yap</span>
        </a>
    </nav>
    <div class="topbar">
        <h1>Dashboard</h1>
    </div>
    <div id="dashboard" class="page">
        <?php include_once "components/dashboard.php"; ?>
    </div>
    <div id="data-viewer" class="page hidden">
        <?php include_once "components/data-view.php"; ?>
    </div>
</main>

</body>

<script>
    var profilePicture = document.querySelector(".profile-picture");

    getSessionUser().then(user => {
        document.user = user;
        if (user == null) {
            window.location.href = "index.php";
        }

        getProfilePicture(user.username)
            .then(response => {
                profilePicture.src = response;
                document.querySelector(".username").innerText = user.username;
            });
    });

    function animateDashboardCards() {
        document.querySelectorAll("#dashboard .card").forEach((card, i) => {
            card.classList.add("hidden");
            setTimeout(() => {
                card.classList.remove("hidden");
            }, i * 100);
        });
    }

    document.querySelector("#dashboard-link").addEventListener("click", () => {
        document.querySelector("#dashboard").classList.remove("hidden");
        document.querySelector("#data-viewer").classList.add("hidden");

        document.querySelector(".topbar h1").innerText = "Dashboard";

        animateDashboardCards();
    });

    document.querySelector("#data-viewer-link").addEventListener("click", () => {
        document.querySelector("#dashboard").classList.add("hidden");
        document.querySelector("#data-viewer").classList.remove("hidden");

        document.querySelector(".topbar h1").innerText = "Veri Görüntüleyici";
    });


    document.querySelector("#logout-link").addEventListener("click", () => {
        logout().then(() => {
            window.location.href = "index.php";
        });
    });

    animateDashboardCards();



</script>

</html>
