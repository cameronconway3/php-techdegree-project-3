<?php

    include "inc/functions.php";

    // If 'msg' is set, sanitize and filter ready for display
    if(isset($_GET['msg'])) {
        $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
    }

    include "inc/header.php";?>

        <section>
            <div class="container">
                    <?php 
                        if(isset($error_message)) {
                            echo "<div class='index-error-message'>";
                            echo "<p>$error_message</p>";
                            echo "</div>";
                        }
                    ?>
                <div class="entry-list index-entries">
                    <?php 
                        foreach(get_all_entries() as $entry) {

                            // Format Date
                            $formattedDate = date('F j, Y', strtotime($entry['date']));

                            echo "<article>";
                            echo "<h2><a class='index-title' href='detail.php?id=" . $entry['id'] . "'>" . $entry['title'] . "</a></h2>";
                            // If date is not defined, don't include the time element
                            if(!empty($entry['date'])) {
                                echo "<time class='index-time' datetime='" . $entry['date'] . "'>" . $formattedDate . "</time>";
                            }
                            echo "</article>";
                        }
                    ?>
                </div>
            </div>
        </section>
    
    <?php include "inc/footer.php"; ?>
       