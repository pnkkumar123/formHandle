<?php
include 'db.php';
include 'userid.php';
include 'header.php';

// check if id is set
if(isset($_GET['id'])){
    $id=intval($_GET['id']);

    // prepare a delete statement
    $stmt=$conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i",$id);

    if($stmt->execute()){
        echo "Record deleted successfully";
    }else{
        echo "Error deleting record:" . $conn->error;
    }
    $stmt->close();
}
// close the connection
$conn->close();

header("Location: viewdata.php");
exit();
?>

<?php
include 'footer.php';

?>