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
                                
                                $tagsList = array();

                                // IF DUPLICATE TAGS ARE RETURNED
                                // Push tags to the 'tagsList' array only once
                                foreach(get_entry_tags($entry['entry_id']) as $entry_tag) {
                                    if(!in_array($entry_tag['tag_name'], $tagsList)) {
                                        array_push($tagsList, $entry_tag['tag_name']);
                                    }
                                }
                                
                                // Get final tag in returned tags array, so that different formatting can be applied (no comma)
                                $lastTag = end($tagsList);
                                
                                echo "<p class='tags-list'>Tags:";
                                foreach($tagsList as $tag) {
                                    if($tag !== $lastTag) {
                                        echo " <a href='tags.php?tag=" . $tag . "'>" . $tag . "</a>,";
                                    } else {
                                        echo " <a href='tags.php?tag=" . $tag . "'>" . $tag . "</a>";
                                    }
                                }
                                echo "</p>";
                            }
                            echo "</article>";
                        }
                    ?>
                </div>
            </div>
        </section>
    
    <?php include "inc/footer.php"; ?>
       