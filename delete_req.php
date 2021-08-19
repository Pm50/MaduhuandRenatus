<?php
$id = $_GET['id'];
include "configure.php";

$sql = "DELETE FROM request WHERE request_id=?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {

            // Redirect to login page
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL= request.php">';
            exit;
        } else {
            echo "fail to update try again";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
?>