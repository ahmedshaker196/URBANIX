<?php
require_once 'config/db.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $message_id = $_GET['id'];

    
    $sql = "DELETE FROM contact_messages WHERE message_id = $message_id";
    if ($conn->query($sql) === TRUE) {
       
        header("Location: posts.php?success=MessageDeleted");
        exit();
    } else {
       
        echo "Error deleting message: " . $conn->error;
    }
} else {
    
    echo "Invalid message ID.";
}
?>
