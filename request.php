<?php
session_start();
$uid = $_SESSION['id'];
include "configure.php";
$name = null;
$sql = "SELECT center_name FROM user WHERE uid='$uid'";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $name=$row['center_name'];
        }
    }
}

if (isset($_POST['send_request'])) {
    $type = mysqli_real_escape_string($link, $_REQUEST['type']);
    $deadline = mysqli_real_escape_string($link, $_REQUEST['deadline']);

    $sql = "INSERT INTO request (request_blood_type, request_deadline, uid,request_status) VALUES (?,?,?,?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        $status="requesting";
        mysqli_stmt_bind_param($stmt, "ssis", $type, $deadline, $uid,$status);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to login page
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL= request.php">';
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>

<?php
include "head.php";
?>

<body>
    <?php
    include "navbar.php";

    if (!$_SESSION['admin']) {
    ?>
        <div class="card" style="margin: 20px;">
            <div class="card-header">
                <h5 class="mb-0">Request for Blood</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2" style="margin-bottom: 10px;">
                        <div class="col">
                            <label class="form-label">Blood Type needed</label>
                            <select name="type" class="form-select form-control">
                                <option value="undefined" selected="">Select Blood Type</option>
                                <option value="A">A type</option>
                                <option value="A">B type</option>
                                <option value="AB">AB type</option>
                                <option value="O">O type</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Deadline</label>
                            <input required name="deadline" class="form-control" type="date">
                        </div>
                    </div>
                    <div class="row text-end" style="margin-bottom: 10px;">
                        <div class="col">
                            <input name="send_request" type="submit" class="btn btn-danger" style="border-radius: 10px;" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }
    ?>


    <div style="margin: 20px;">
        <h1 class="display-6 text-center" style="font-size: 30px;margin-top: 10px;">latest Request</h1>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>center name</th>
                        <th>requested blood type</th>
                        <th>Request date</th>
                        <th>status</th>
                        <th>action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Attempt select query execution with order by clause
                    $sql = "SELECT * FROM request INNER JOIN user ON request.uid=user.uid ORDER BY request_created_at ASC";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<tr>
                                    <td>' . $row["center_name"] . '</td>
                                    <td>' . $row["request_blood_type"] . '</td>
                                    <td>' . $row["request_created_at"] . '</td>
                                    <td>' . $row["request_status"] . '</td>';
                                if($row["request_status"]=="received"){
                                    echo '<td>by -'.$row['receiver_name'].'</td>
                                        </tr>';
                                }else if ($row["uid"] == $uid) {
                                    $name = $row["center_name"];
                                    echo '<td><a class="link-danger" href="delete_req.php?id=' . $row['request_id'] . '">delete request</a></td>
                                        </tr>';
                                } else {
                                    echo '<td><a class="link-success" href="receive_req.php?id=' . $row['request_id'] . '&name=' . $name . '">receive request</a></td>
                                        </tr>';
                                }
                            }
                            // Close result set
                            mysqli_free_result($result);
                        } else {
                            echo "No request found.";
                        }
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>