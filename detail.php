<?php

    include "inc/functions.php";

    if(isset($_GET["id"])) {
        $id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);
        $entry = get_one_entry($id);
    }

    if(empty($entry)) {
        header('Location: index.php');
        exit;
    }

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
                        <time datetime="<?php echo $entry['date'] ?>"><?php echo $entry['date'] ?></time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p><?php echo $entry['time_spent'] ?></p>
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
                <p><a href="edit.php?id=<?php echo $id ?>">Edit Entry</a></p>
            </div>
            <div class="delete">
                <form method="post">
                    <input type="hidden" value="<?php echo $id ?>" name="delete">
                    <input type="submit" value="Delete">
                </form>
            </div>
        </section>

    <?php include "inc/footer.php"; ?>