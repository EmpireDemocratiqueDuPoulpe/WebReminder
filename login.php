<?php

########################################
# Init
########################################

require "./init.php";

########################################
# Check connection
########################################

if (isset($_SESSION["user_id"]) AND !empty($_SESSION["user_id"])) {

    header("Location: ./index.php");
    die;
}

########################################
# Get errors
########################################

// Start output buffering
ob_start();

//// Process errors
// Get the error
if (isset($_GET["r_error"]))     { $error = (int) $_GET["r_error"]; }
elseif (isset($_GET["l_error"])) { $error = (int) $_GET["l_error"]; }

// Echo the corresponding text
if (isset($error)) {

    echo '<div id="regLogErrors">';

    // Change error 0 into 1 to prevent switch from showing default text
    $error = $error == 0 ? 1 : $error;

    switch ($error) {

        // Missing/empty field
        case in_array($error, range(0,19)):
            echo '<p>Veuillez remplir tous les champs.</p>';
            break;

        // Username not valid
        case USR_NOT_VALID:
            echo '<p>Le nom d\'utilisateur renseign&eacute; n\'est pas valide.</p>';
            break;

        // Username already exist
        case USR_ALREADY_USED:
            echo '<p>Le nom d\'utilisateur renseign&eacute; est d&eacute;j&agrave; utilis&eacute;</p>';
            break;

        // Email not valid
        case EMAIL_NOT_VALID:
            echo '<p>L\'e-mail renseign&eacute; n\'est pas valide.</p>';
            break;

        // Email already used
        case EMAIL_ALREADY_USED:
            echo '<p>L\'email renseign&eacute; est d&eacute;j&agrave; utilis&eacute;</p>';
            break;

        // Passwords are not the same
        case PASSWORDS_DIFFERENT:
            echo '<p>Les mots de passe renseign&eacute; sont diff&eacute;rents.</p>';
            break;

        // Passwords aren't valid/secure
        case PASSWORDS_NOT_VALID:
            echo '<p>Le mot de passe renseign&eacute; n\'est pas valide.</p>';
            break;

        // Phone number isn't valid
        case TEL_NOT_VALID:
            echo '<p>Le num&eacute;ro de t&eacute;l&eacute;phone renseign&eacute; n\'est pas valide.</p>';
            break;

        // Unknown error
        case UNKNOWN_REG_LOG_ERROR:
        default:
            echo '<p>Erreur inconnue: impossible de poursuivre. Si le probl&egrave;me persiste, veuillez <a>contacter le support</a>.</p>';
            break;
    }

    echo '</div>';

}

// Get output buffering and clean it
$errors_ob = ob_get_contents();
ob_end_clean();

########################################
# Show
########################################

require "./views/login_v.php";