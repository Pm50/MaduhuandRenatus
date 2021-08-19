<?php
session_start();
$uid = $_SESSION['id'];
include "configure.php";
$name = "";
$a = 0;
$b = 0;
$ab = 0;
$o = 0;

// Attempt select query execution with order by clause
$sql1 = "SELECT * FROM user WHERE uid LIKE '$uid'";
if ($result1 = mysqli_query($link, $sql1)) {
    if (mysqli_num_rows($result1) > 0) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $name = $row1['center_name'];
        }
        // Close result set
        mysqli_free_result($result1);
    } else {
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL= login.php">';
        exit;
    }
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
    <h3 style="margin: 20px;"><?php echo $name; ?></h3>
    <div style="margin: 20px;">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2">
            <div class="col menuss" style="margin-bottom: 10px;">
                <div class="card" style="height: 100%;">
                    <div class="card-header">
                        <h5 class="mb-0">Menu</h5>
                    </div>
                    <?php
                    include "sidemenu.php";
                    ?>
                </div>
            </div>
            <div class="col menus" style="margin-bottom: 10px;">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Blood information</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Blood Type</th>
                                        <th>Blood Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!$_SESSION['admin']) {
                                        $sql = "SELECT * FROM blood JOIN user ON blood.uid=user.uid JOIN donor ON donor.donor_id=blood.donor_id WHERE user.uid=$uid";
                                    } else {
                                        $sql = "SELECT * FROM blood INNER JOIN donor ON donor.donor_id=blood.donor_id";
                                    }
                                    if ($result = mysqli_query($link, $sql)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                if ($row['donor_blood_type'] == "A") {
                                                    $a = $a + 1;
                                                }

                                                if ($row['donor_blood_type'] == "B") {
                                                    $b = $b + 1;
                                                }

                                                if ($row['donor_blood_type'] == "AB") {
                                                    $ab = $ab + 1;
                                                }

                                                if ($row['donor_blood_type'] == "O") {
                                                    $o = $o + 1;
                                                }
                                            }
                                            // Close result set
                                            mysqli_free_result($result);
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>A</td>
                                        <td><?php echo $a; ?></td>
                                    </tr>
                                    <tr>
                                        <td>B</td>
                                        <td><?php echo $b; ?></td>
                                    </tr>
                                    <tr>
                                        <td>AB</td>
                                        <td><?php echo $ab; ?></td>
                                    </tr>
                                    <tr>
                                        <td>O</td>
                                        <td><?php echo $o; ?></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Blood Type</td>
                                        <td>Blood Amount</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>