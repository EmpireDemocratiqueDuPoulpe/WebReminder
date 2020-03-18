<!DOCTYPE html>

<html lang="fr">
    <head>
        <title>WebReminder</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="./assets/css/normalize.css"/>
        <link rel="stylesheet" href="./assets/css/main.css"/>
    </head>
    <body>
        <!-- Left container -->
        <div id="leftContainer">
            <!-- Head -->
            <div>
                <h1>WebReminder</h1>
                <p id="date"></p>
            </div>

            <!-- User -->
            <div>
                <p><?= $_SESSION["username"]; ?> - <a href="./php/disconnect_user.php">D&eacute;connexion</a></p>
            </div>
        </div>

        <!-- Right container -->
        <div id="rightContainer">
            <div id="remindersWrapper">
                <?= $reminders_list_ob; ?>
            </div>
        </div>

        <!-- Scripts -->
        <script src="./assets/js/clock.js"></script>
    </body>
</html>