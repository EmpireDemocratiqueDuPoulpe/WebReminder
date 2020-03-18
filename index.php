<?php

########################################
# Init
########################################

require "./init.php";

########################################
# Check connection
########################################

if (!isset($_SESSION["user_id"]) or empty($_SESSION["user_id"])) {

    header("Location: ./login.php");
    die;
}

########################################
# Get data
########################################

// Create new instances
$remindersManager = new Reminders($db);
$remindersCatManager = new RemindersCat($db);

// Get reminders and categories
$reminders = $remindersManager->getAll($_SESSION["user_id"]);
$remindersCat = $remindersCatManager->getAll($_SESSION["user_id"]);

// Start output buffering
ob_start();

//// Process reminders
// Categories filled with reminders
foreach ($remindersCat as $cat) {

    // Get category properties
    $c_id = $cat["reminder_cat_id"];
    $c_name = $cat["name"];
    $c_desc = $cat["description"] ? ('<span> - '.$cat["description"].'</span>') : "";
    $c_color = $cat["color"] ? $cat["color"] : "";
    $c_reminders = array_keys(array_column($reminders, 'reminder_cat_id'), $c_id);

    // Output category
    ?>
        <div class="reminderCat">
            <div class="remCHead">
                <p><?= $c_name.$c_desc; ?></p>
            </div>

            <div class="remCWrapper <?php if(!$c_reminders) { echo 'emptyRemC'; } ?>">
                <?php
                    // Add each reminders
                    foreach ($c_reminders as $c_reminder) {

                        $c_reminder = $reminders[$c_reminder];
                        $cr_name = $c_reminder["name"];
                        $cr_desc = $c_reminder["description"] ? ('<span> - '.$c_reminder["description"].'</span>') : "";

                        ?>
                            <div class="reminder inCat">
                                <p><?= $cr_name.$cr_desc; ?></p>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    <?php
}

// Reminders without category
$reminders_without_cat = array_keys(array_column($reminders, 'reminder_cat_id'), null);

foreach ($reminders_without_cat as $reminder_wc) {

    $reminder_wc = $reminders[$reminder_wc];
    $r_name = $reminder_wc["name"];
    $r_desc = $reminder_wc["description"] ? ('<span> - '.$reminder_wc["description"].'</span>') : "";

    ?>
        <div class="reminder">
            <p><?= $r_name.$r_desc; ?></p>
        </div>
    <?php
}

// Get output buffering and clean it
$reminders_list_ob = ob_get_contents();
ob_end_clean();

########################################
# Show
########################################

require "./views/index_v.php";