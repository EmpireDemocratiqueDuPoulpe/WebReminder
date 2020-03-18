<!DOCTYPE html>

<html lang="fr">
    <head>
        <title>Web Reminder - Connexion</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="./assets/css/normalize.css"/>
        <link rel="stylesheet" href="./assets/css/main.css"/>
    </head>
    <body>
        <!-- Register/login container -->
        <div id="registerLoginContainer">
            <div>
                <!-- Register container -->
                <div id="registerContainer">
                    <!-- Title -->
                    <div id="registerContainerTitle">
                        <h2>S'inscrire</h2>
                    </div>

                    <!-- Form -->
                    <div id="registerContainerForm">
                        <form action="./php/register_user.php" method="POST">
                            <input type="text" name="username" class="<?php input_errors("r_error", [0, USR_NOT_VALID, USR_ALREADY_USED]); ?>" placeholder="Nom d'utilisateur*" required/> <br>
                            <input type="email" name="email" class="<?php input_errors("r_error", [1, EMAIL_NOT_VALID, EMAIL_ALREADY_USED]); ?>" placeholder="E-mail*" required/> <br>
                            <input type="password" name="password1" class="<?php input_errors("r_error", [2, PASSWORDS_DIFFERENT, PASSWORDS_NOT_VALID]); ?>" placeholder="Mot de passe*" required/> <br>
                            <input type="password" name="password2" class="<?php input_errors("r_error", [3, PASSWORDS_DIFFERENT, PASSWORDS_NOT_VALID]); ?>" placeholder="R&eacute;p&eacute;ter mot de passe*" required/> <br>
                            <input type="tel" name="phone_number" class="<?php input_errors("r_error", [4, TEL_NOT_VALID]); ?>" placeholder="T&eacute;l&eacute;phone" pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}"/> <br>
                            <input type="submit" value="INSCRIPTION"/>
                        </form>
                    </div>
                </div>

                <!-- Login container -->
                <div id="loginContainer">
                    <!-- Title -->
                    <div id="loginContainerTitle">
                        <h2>Se connecter</h2>
                    </div>

                    <!-- Form -->
                    <div id="loginContainerForm">
                        <form action="./php/login_user.php" method="POST">
                            <input type="text" name="username" class="<?php input_errors("l_error", [51, USR_NOT_VALID]); ?>" placeholder="Nom d'utilisateur" required/> <br>
                            <input type="password" name="password" class="<?php input_errors("l_error", [52, PASSWORDS_NOT_VALID]); ?>" placeholder="Mot de passe" required/> <br>
                            <input type="submit" value="CONNEXION"/>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Error container -->
            <?php if (isset($errors_ob)) { echo $errors_ob; } ?>
        </div>
    </body>
</html>