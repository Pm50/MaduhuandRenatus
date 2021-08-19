<?php
include "configure.php";
$a = 0;
$b = 0;
$ab = 0;
$o = 0;
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
    <div style="margin: 20px;">
        <h1 class="display-6 text-center" style="font-size: 30px;margin-top: 10px;">Blood Centres</h1>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Centre name</th>
                        <th>A</th>
                        <th>B</th>
                        <th>AB</th>
                        <th>O</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Attempt select query execution with order by clause
                    $sql = "SELECT * FROM user WHERE admin=false";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $ids = $row['uid'];
                                $a = 0;
                                $b = 0;
                                $ab = 0;
                                $o = 0;

                                $sql1 = "SELECT * FROM blood INNER JOIN user ON blood.uid=user.uid INNER JOIN donor ON donor.donor_id=blood.donor_id WHERE user.uid=$ids";
                                if ($result1 = mysqli_query($link, $sql1)) {
                                    if (mysqli_num_rows($result1) > 0) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            if ($row1['donor_blood_type'] == "A") {
                                                $a = $a + 1;
                                            }

                                            if ($row1['donor_blood_type'] == "B") {
                                                $b = $b + 1;
                                            }

                                            if ($row1['donor_blood_type'] == "AB") {
                                                $ab = $ab + 1;
                                            }

                                            if ($row1['donor_blood_type'] == "O") {
                                                $o = $o + 1;
                                            }
                                        }
                                        // Close result set
                                        mysqli_free_result($result1);
                                    }
                                }
                                echo '<tr>
                                    <td>' . $row["center_name"] . '</td>
                                    <td>' . $a . '</td>
                                    <td>' . $b . '</td>
                                    <td>' . $ab . '</td>
                                    <td>' . $o . '</td>
                                    </tr>';
                            }
                            // Close result set
                            mysqli_free_result($result);
                        } else {
                            echo "No center found.";
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