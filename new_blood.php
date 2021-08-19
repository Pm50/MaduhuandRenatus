<?php
session_start();
$uid = $_SESSION['id'];
include "configure.php";

if (isset($_POST['send_blood'])) {
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $bag_number = mysqli_real_escape_string($link, $_REQUEST['bag_number']);
    $did = 0;

    // Attempt select query execution with order by clause
    $sql1 = "SELECT * FROM donor WHERE donor_name LIKE '$name'";
    if ($result1 = mysqli_query($link, $sql1)) {
        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $did = $row1['donor_id'];

                $sql = "INSERT INTO blood (blood_bag_number, donor_id,uid) VALUES (?,?,?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "sii", $bag_number, $did, $uid);

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect to login page
                        echo '<META HTTP-EQUIV="Refresh" Content="0; URL= index.php">';
                        exit;
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }
            // Close result set
            mysqli_free_result($result1);
        } else {
            echo "Donor doesn't exist";
            exit;
        }
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
    ?>
    <div class="card" style="margin: 20px;">
        <div class="card-header">
            <h5 class="mb-0">Add New Blood Bag</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2" style="margin-bottom: 10px;">
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Full name of Donor</label>
                            <select name="name" class="form-control" id="exampleFormControlSelect1">
                                <?php
                                $sql10 = "SELECT donor_name FROM donor";
                                if ($result10 = mysqli_query($link, $sql10)) {
                                    if (mysqli_num_rows($result10) > 0) {
                                        echo'<option>select name</option>';
                                        while ($row10 = mysqli_fetch_array($result10)) {
                                            echo'<option>'.$row10['donor_name'].'</option>';
                                        }
                                    }else{
                                        echo'<option>no donor in database</option>';
                                    }
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label">Blood Bag Number</label>
                        <input required name="bag_number" placeholder="Blood Bag Number" class="form-control form-control" type="text">
                    </div>
                </div>
                <div class="row text-end" style="margin-bottom: 10px;">
                    <div class="col">
                        <input name="send_blood" type="submit" class="btn btn-danger" style="border-radius: 10px;" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
<!-- TODO -->
<!-- check name in db before send infor -->

</html>