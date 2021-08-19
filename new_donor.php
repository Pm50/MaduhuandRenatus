<?php
include "configure.php";

if (isset($_POST['send_donor'])) {
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $contact = mysqli_real_escape_string($link, $_REQUEST['contact']);
    $address = mysqli_real_escape_string($link, $_REQUEST['address']);
    $birthday = mysqli_real_escape_string($link, $_REQUEST['birthday']);
    $gender = mysqli_real_escape_string($link, $_REQUEST['gender']);
    $type = mysqli_real_escape_string($link, $_REQUEST['type']);

    $sql = "INSERT INTO donor (donor_name, donor_contact, donor_blood_type, donor_address, donor_gender, donor_birthday)
     VALUES (?,?,?,?,?,?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $contact, $type, $address, $gender, $birthday);

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
            <h5 class="mb-0">Create New Donor</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2" style="margin-bottom: 10px;">
                    <div class="col">
                        <label class="form-label">Donor name</label>
                        <input required name="name" placeholder="Donor name" class="form-control" type="text">
                    </div>
                    <div class="col">
                        <label class="form-label">Donor Contact</label>
                        <input required name="contact" placeholder="Donor Contact"  class="form-control" type="text">
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2" style="margin-bottom: 10px;">
                    <div class="col">
                        <label class="form-label">Donor Address</label>
                        <input required name="address" placeholder="Donor Address" class="form-control" type="text">
                    </div>
                    <div class="col">
                        <label class="form-label">Donor Birthday</label>
                        <input required name="birthday" placeholder="Donor Birthday" class="form-control" type="date">
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2" style="margin-bottom: 10px;">
                    <div class="col">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select form-control">
                            <option value="undefined" selected="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">Blood Type</label>
                        <select name="type" class="form-select form-control">
                            <option value="undefined" selected="">Select Blood Type</option>
                            <option value="A">A type</option>
                            <option value="A">B type</option>
                            <option value="AB">AB type</option>
                            <option value="O">O type</option>
                        </select>
                    </div>
                </div>
                <div class="row text-end" style="margin-bottom: 10px;">
                    <div class="col">
                        <input name="send_donor" type="submit" class="btn btn-danger" style="border-radius: 10px;" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>