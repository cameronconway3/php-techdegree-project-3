<?php

// Get all journal entries
function get_all_entries() {
    include "connection.php";

    try {
        return $db->query('SELECT id, title, date FROM entries ORDER BY date DESC');
    } catch(Exception $e) {
        echo "Error Message - " . $e->getMessage() . "</br>";
        return false;
    }
    return true;

}

// Get one journal entry
function get_one_entry($id) {
    include "connection.php";

    $sql = 'SELECT title, date, time_spent, learned, resources FROM entries WHERE id = ?';

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
        $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE id = ?';
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

    $sql = 'DELETE FROM entries WHERE id = ?';

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
