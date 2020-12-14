<?php

    include "inc/functions.php";

    include "inc/header.php";?>

        <section>
            <div class="container">
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
       