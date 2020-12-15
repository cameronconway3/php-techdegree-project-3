<?php

    include "inc/functions.php";

    // If the id variable is defined
    if(isset($_GET["id"])) {
        // Sanitize and Filter the id value
        $id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);
        // Get the entry that relates to the ID value
        $entry = get_one_entry($id);
        // Format the date
        $formattedDate = date('F j, Y', strtotime($entry['date']));
    }

    // If not entry is defined, then direct to index page
    if(empty($entry)) {
        header('Location: index.php');
        exit;
    }

    // If delete button is submitted causing a post request, call 'delete_entry', then redirect back to index page with message
    if(isset($_POST['delete'])) {
        if(delete_entry(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))) {
            header('Location: index.php?msg=Task+Deleted');
            exit;
        } else {
            header('Location: index.php?msg=Unable+to+Delete+Task');
            exit;
        }
    }

    include "inc/header.php";?>

        <section>
            <div class="container">
                <div class="entry-list single">
                    <article>
                        <h1><?php echo $entry['title'] ?></h1>
                        <?php 
                        // If date is not defined, dont include the time element
                        if(!empty($entry['date'])) {
                        ?>
                            <time datetime="<?php echo $entry['date'] ?>"><?php echo $formattedDate ?></time>
                        <?php
                        }
                        ?>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p class="detail-time"><?php echo $entry['time_spent'] ?></p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php echo $entry['learned'] ?></p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <p><?php echo $entry['resources'] ?></p>
                            <!-- <ul>
                                <li><a href="">Lorem ipsum dolor sit amet</a></li>
                                <li><a href="">Cras accumsan cursus ante, non dapibus tempor</a></li>
                                <li>Nunc ut rhoncus felis, vel tincidunt neque</li>
                                <li><a href="">Ipsum dolor sit amet</a></li>
                            </ul> -->
                        </div>
                    </article>
                </div>
            </div>
            <div class="edit">
                <div class="edit-button">
                    <p><a href="edit.php?id=<?php echo $id ?>">Edit Entry</a></p>
                </div>
                <form method="post">
                    <input type="hidden" value="<?php echo $id ?>" name="delete">
                    <input class="delete-button" type="submit" value="Delete Entry">
                </form>
            </div>
        </section>

    <?php include "inc/footer.php"; ?>