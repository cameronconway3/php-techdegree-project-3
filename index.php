<?php

    include "inc/functions.php";

    if(isset($_GET['msg'])) {
        $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
    }

    include "inc/header.php";?>

        <section>
            <div class="container">
                    <?php 
                        if(isset($error_message)) {
                            echo "<p>$error_message</p>";
                        }
                    ?>
                <div class="entry-list">
                    <?php 
                        foreach(get_all_entries() as $entry) {
                            echo "<article>";
                            echo "<h2><a href='detail.php?id=" . $entry['id'] . "'>" . $entry['title'] . "</a></h2>";
                            echo "<time datetime='" . $entry['date'] . "'>" . $entry['date'] . "</time>";
                            echo "</article>";
                        }
                    ?>

                    <!-- <article>
                        <h2><a href="detail.html">The best day I’ve ever had</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_2.html">The absolute worst day I’ve ever had</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_3.html">That time at the mall</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_4.html">Dude, where’s my car?</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article> -->
                </div>
            </div>
        </section>
    
    <?php include "inc/footer.php"; ?>
       