<?php

    include "inc/functions.php";

    // If 'msg' is set, sanitize and filter ready for display
    if(isset($_GET['msg'])) {
        $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
    }

    // When new tag form is submitted
    if(isset($_POST['addTag']) && isset($_POST['entryId'])) {
        $tag = filter_input(INPUT_POST, 'addTag', FILTER_SANITIZE_STRING);
        $entry_id = filter_input(INPUT_POST, 'entryId', FILTER_SANITIZE_STRING);
        $tag_id = add_tag($tag);
        if($tag_id) {
            add_entries_tags($entry_id, $tag_id);
        } else {
            // Error message for if tag cannot be added
            $tag_error = 'Could not add tag';
        }
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
                        if(isset($tag_error)) {
                            echo "<div class='index-error-message'>";
                            echo "<p>$tag_error</p>";
                            echo "</div>";
                        }

                    ?>
                <div class="entry-list index-entries">
                    <?php 
                        foreach(get_all_entries() as $entry) {

                            // Format Date
                            $formattedDate = date('F j, Y', strtotime($entry['date']));

                            echo "<article>";
                            echo "<h2><a class='index-title' href='detail.php?id=" . $entry['entry_id'] . "'>" . $entry['title'] . "</a></h2>";
                            // If date is not defined, don't include the time element
                            if(!empty($entry['date'])) {
                                echo "<time class='index-time' datetime='" . $entry['date'] . "'>" . $formattedDate . "</time>";
                            }

                            // Get entry tags
                            if (!empty(get_entry_tags($entry['entry_id']))) {

                                // Get final tag in returned tags array, so that different formatting can be applied (no comma)
                                $lastTag = end(get_entry_tags($entry['entry_id']));

                                echo "<p class='tags-list'>Tags:";
                                foreach(get_entry_tags($entry['entry_id']) as $entry) {
                                    if($entry['tag_name'] !== $lastTag['tag_name']) {
                                        echo " <a href='tags.php?tag=" . $entry['tag_name'] . "'>" . $entry['tag_name'] . "</a>,";
                                    } else {
                                        echo " <a href='tags.php?tag=" . $entry['tag_name'] . "'>" . $entry['tag_name'] . "</a>";
                                    }
                                }
                                echo "</p>";
                            }

                            // Form to add new tags
                            echo "<form method='post' method='index.php' class='add-tags-form'>";
                            echo "<input type='hidden' name='entryId' value='" . $entry['entry_id'] . "'>";
                            echo "<input class='input-tags' type='text' name='addTag'>";
                            echo "<input class='submit-tags' type='submit' value='Add Tag'><br>";
                            echo "</form>";

                            echo "</article>";
                        }
                    ?>
                </div>
            </div>
        </section>
    
    <?php include "inc/footer.php"; ?>
       