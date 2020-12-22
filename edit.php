<?php

    include "inc/functions.php";

    // If the id variable is defined
    if(isset($_GET["id"])) {
        // Sanitize and Filter the id value
        $id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);
        // Get the entry that relates to the ID value
        $entry = get_one_entry($id);
    }

    // If there is a POST request made
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Sanitize and filter input
        $title = trim(filter_input(INPUT_POST,"title",FILTER_SANITIZE_STRING));
        $date = trim(filter_input(INPUT_POST,"date",FILTER_SANITIZE_STRING));
        $time_spent = trim(filter_input(INPUT_POST,"timeSpent",FILTER_SANITIZE_STRING));
        $what_i_learned = trim(filter_input(INPUT_POST,"whatILearned",FILTER_SANITIZE_STRING));
        $resources_to_remember = trim(filter_input(INPUT_POST,"resourcesToRemember",FILTER_SANITIZE_STRING));
        $tags = trim(filter_input(INPUT_POST,"tags",FILTER_SANITIZE_STRING));

        // If any of the fields are empty, add the error message
        if(empty($title) || empty($time_spent) || empty($what_i_learned)) {
            $error_message = "Please fill in the required fields: Title, Time Spent and What I Learned.";
        } else {
            // If 'add_entry' returns true, direct the user to 'index.php', else, update the error message
            if(add_entry($title, $date, $time_spent, $what_i_learned, $resources_to_remember, $id)) {
                if(add_tags($tags, $id)) {
                    header('Location: detail.php?id=' . $id);
                    exit;
                } else {
                    $error_message = "Error adding tags, ";
                }
            } else {
                $error_message = "Could not add project";
            }
        }
    }

    include "inc/header.php";?>

        <section>
            <div class="container">
                <div class="edit-entry">
                    <h2>Edit Entry</h2>
                    <?php 
                        if(isset($error_message)) {
                            echo "<div class='form-error-message'>";
                            echo "<p>$error_message</p>";
                            echo "</div>";
                        }
                    ?>
                    <form method="post">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title" value="<?php echo $entry['title'] ?>"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date" value="<?php echo $entry['date'] ?>"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent" value="<?php echo $entry['time_spent'] ?>"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo $entry['learned'] ?></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="resourcesToRemember"><?php echo $entry['resources'] ?></textarea>
                        <label for="tags">Tags (Comma Seperated)</label>
                        <input id='tags' class="tags-input" type='text' name='tags' value="<?php 

                                if (!empty(get_entry_tags($id))) {

                                    $tagsList = array();

                                    // IF DUPLICATE TAGS ARE RETURNED
                                    // Push tags to the 'tagsList' array only once
                                    foreach(get_entry_tags($id) as $entry_tag) {
                                        if(!in_array($entry_tag['tag_name'], $tagsList)) {
                                            array_push($tagsList, $entry_tag['tag_name']);
                                        }
                                    }

                                    // Get final tag in returned tags array, so that different formatting can be applied (no comma)
                                    $lastTag = end($tagsList);

                                    // Return filtered tags and seperate them all by commas unless the last one
                                    foreach($tagsList as $tag) {
                                       if($tag !== $lastTag) {
                                           echo $tag . ", ";
                                       } else {
                                           echo $tag;
                                       }
                                   };
                                }

                            ?>">
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="detail.php?id=<?php echo $id ?>" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    <?php include "inc/footer.php"; ?>    
