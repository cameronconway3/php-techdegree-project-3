<?php

    include "inc/functions.php";

    // Get the tag name
    if(isset($_GET['tag'])) {
        $tag = trim(filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_STRING));

        // If entries are returned assign them to the variable $entries, else add an error message
        if(get_entries_by_tag_name($tag)) {
            $entries = get_entries_by_tag_name($tag);
        } else {
            $error_message = 'No entries found';
        }
    }

    include "inc/header.php";?>

        <section>
            <div class="container">
                <?php 
                    if(isset($error_message)) {
                        echo "<div class='tag-error-message'>";
                        echo "<p>$error_message</p>";
                        echo "</div>";
                    } else {
                        echo "<div class='tag-title'>";
                        echo  "<h2>Tag - \"" . $tag . "\"'</h2>";
                        echo "</div>";
                    }
                ?>

                <div class="entry-list">
                    <?php
                        // For each entry in entries build the html to display each entry
                        foreach($entries as $entry) {
                            echo "<div class='tag-entries'>";
                             // Format Date
                             $formattedDate = date('F j, Y', strtotime($entry['date']));
                             echo "<article>";
                             echo "<h2><a class='tag-title' href='detail.php?id=" . $entry['entry_id'] . "'>" . $entry['title'] . "</a></h2>";
                             // If date is not defined, don't include the time element
                             if(!empty($entry['date'])) {
                                 echo "<time class='tag-time' datetime='" . $entry['date'] . "'>" . $formattedDate . "</time>";
                             }
                            echo "</articale>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </section>

    <?php include "inc/footer.php"; ?>