<?php require_once './database/database.php'; ?>
<?php
session_start();
if(isset($_GET['id']) && !empty($_GET)) {
    $student_id = $_GET['id'];
} else {
    header('location: ./index.php');
}

if($db->delete('students', $student_id)){
    $_SESSION['success'] = 'Magic has been spelled';
    header('location: ./index.php');
} else {
    $_SESSION['error'] = 'Magic has failed to spell';
    header('location: ./index.php');
}

?>