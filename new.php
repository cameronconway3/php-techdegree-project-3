<?php

    include "inc/functions.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Sanitize and filter input
        $title = trim(filter_input(INPUT_POST,"title",FILTER_SANITIZE_STRING));
        $date = trim(filter_input(INPUT_POST,"date",FILTER_SANITIZE_STRING));
        $time_spent = trim(filter_input(INPUT_POST,"timeSpent",FILTER_SANITIZE_STRING));
        $what_i_learned = trim(filter_input(INPUT_POST,"whatILearned",FILTER_SANITIZE_STRING));
        $resources_to_remember = trim(filter_input(INPUT_POST,"resourcesToRemember",FILTER_SANITIZE_STRING));

        // If any of the fields are empty, add the error message
        if(empty($title) || empty($time_spent) || empty($what_i_learned)) {
            $error_message = "Please fill in the required fields: Title, Time Spent, and What I Learned.";
        } else {
            // If 'add_entry' returns true, direct the user to 'index.php', else, update the error message
            if(add_entry($title, $date, $time_spent, $what_i_learned, $resources_to_remember)) {
                header('Location: index.php');
                exit;
            } else {
                $error_message = "Could not add project";
            }
        }

    }

    include "inc/header.php";?>
        <section>
            <div class="container">
                <div class="new-entry">
                    <h2>New Entry</h2>
                    <?php 
                        if(isset($error_message)) {
                            echo "<div class='form-error-message'>";
                            echo "<p>$error_message</p>";
                            echo "</div>";
                        }
                    ?>
                    <form method="post">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="resourcesToRemember"></textarea>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
 
    <?php include "inc/footer.php"; ?>   