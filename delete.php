<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute delete query
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: viewdata.php?message=User deleted successfully");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}
?>
