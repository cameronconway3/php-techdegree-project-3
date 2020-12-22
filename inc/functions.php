<?php

// Get all journal entries
function get_all_entries() {
    include "connection.php";

    try {
        return $db->query('SELECT entry_id, title, date FROM entries ORDER BY date DESC');
    } catch(Exception $e) {
        echo "Error Message - " . $e->getMessage() . "</br>";
        return false;
    }
    return true;

}

// Get one journal entry
function get_one_entry($id) {
    include "connection.php";

    $sql = 'SELECT title, date, time_spent, learned, resources FROM entries WHERE entry_id = ?';

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error Message - " . $e->getMessage() . "</br>";
        return false;
    }
    
    $entry = $results->fetch(PDO::FETCH_ASSOC);

    return $entry;
}

// Add/Update a journal entry (depending on whether $id is null or not)
function add_entry($title, $date, $time_spent, $what_i_learned, $resources_to_remember, $id = null) {
    include "connection.php";

    if($id) {
        $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE entry_id = ?';
    } else {
        $sql = 'INSERT INTO entries(title, date, time_spent, learned, resources) VALUES(?, ?, ?, ?, ?)';
    }

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $time_spent, PDO::PARAM_STR);
        $results->bindValue(4, $what_i_learned, PDO::PARAM_STR);
        $results->bindValue(5, $resources_to_remember, PDO::PARAM_STR);
        if($id) {
            $results->bindValue(6, $id, PDO::PARAM_INT);
        }
        $results->execute();
    } catch (Exception $e) {
        echo "Error Message - " . $e->getMessage() . "</br>";
        return false;
    }
    return true;
}

// Delete a journal entry
function delete_entry($id) {
    include "connection.php";

    $sql = 'DELETE FROM entries WHERE entry_id = ?';

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e) {
        echo "Error Message - " . $e->getMessage() . "</br>";
        return false;
    }
    return true;
}

// Add tag to entry
function add_tags($tags, $entry_id) {
    include "connection.php";

    $tagsArray = explode(",", $tags);

    // Delete all tags associated with the entry
    $cleanUpSql = '
        SELECT tag_id 
        FROM entries_tags
        WHERE entry_id = ?
    ';

    try {
        $cleanUpResluts = $db->prepare($cleanUpSql);
        $cleanUpResluts->bindValue(1, $entry_id, PDO::PARAM_INT);
        $cleanUpResluts->execute();
    } catch (Exception $e) {
        return false;
    }

    $idsToDelete = $cleanUpResluts->fetchAll();

    // For each element returned from SELECT above, DELETE the tag with that ID from tags and entries_tags table
    // Remove the chance of there being any duplicates
    foreach($idsToDelete as $delete_id) {

        $deleteTagsSql = '
            DELETE
            FROM tags
            WHERE tag_id = ?
        ';

        try {
            $deleteTagsResluts = $db->prepare($deleteTagsSql);
            $deleteTagsResluts->bindValue(1, $delete_id['tag_id'], PDO::PARAM_INT);
            $deleteTagsResluts->execute();
        } catch (Exception $e) {
            return false;
        }

        $deleteEntriesTagsSql = '
            DELETE
            FROM entries_tags
            WHERE tag_id = ?
        ';
        try {
            $deleteEntriesTagsResluts = $db->prepare($deleteEntriesTagsSql);
            $deleteEntriesTagsResluts->bindValue(1, $delete_id['tag_id'], PDO::PARAM_INT);
            $deleteEntriesTagsResluts->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // For each value in $tagsArray add it to database
    foreach($tagsArray as $tag) {
        $tag = trim($tag);

        // Add new tag to database
        $sqlInsert = 'INSERT INTO tags(tag_name) VALUES(?)';
    
        try {
            $tagInsertResult = $db->prepare($sqlInsert);
            $tagInsertResult->bindValue(1, $tag, PDO::PARAM_STR);
            $tagInsertResult->execute();
        } catch (Exception $e) {
            return false;
        }

        // Get the tag ID of the inserted tag
        $tag_id = $db->lastInsertId();

        // Add tag to 'entries_tags'
        $sql = 'INSERT INTO entries_tags(entry_id, tag_id) VALUES(?, ?)';

        try {
            $results = $db->prepare($sql);
            $results->bindValue(1, $entry_id, PDO::PARAM_INT);
            $results->bindValue(2, $tag_id, PDO::PARAM_INT);
            $results->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    return true;
}

// Join entries and tags table using the entries_tag table and return the tag_names
function get_entry_tags($entry_id) {
    include "connection.php";
    
    $sql = '
        SELECT tag_name FROM entries
        INNER JOIN entries_tags ON entries.entry_id = entries_tags.entry_id
        INNER JOIN tags ON entries_tags.tag_id = tags.tag_id
        WHERE entries.entry_id = ?
    ';

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $entry_id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        return false;
    }

    $joinResults = $results->fetchAll();

    return $joinResults;
}

function get_entries_by_tag_name($tag_name) {
    include "connection.php";

    $sql = '
        SELECT * FROM entries
        INNER JOIN entries_tags ON entries.entry_id = entries_tags.entry_id
        INNER JOIN tags ON entries_tags.tag_id = tags.tag_id
        WHERE tags.tag_name = ?
        ORDER BY date DESC
    ';

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $tag_name, PDO::PARAM_STR);
        $results->execute();
    } catch (Exception $e) {
        return false;
    }

    $joinResults = $results->fetchAll();

    return $joinResults;
}



