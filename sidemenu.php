<div class="card-body">
    <ul>
        <?php
        if($_SESSION['admin']){
            echo '<li style="margin-bottom: 5px;"><a href="request.php">Request</a></li>
            <li style="margin-bottom: 5px;"><a href="new_account.php">Create new Account</a></li>
            <li style="margin-bottom: 5px;"><a href="centre.php">Blood centres</a></li>';
        }else{
            echo '<li style="margin-bottom: 5px;"><a href="request.php">Request</a></li>
            <li style="margin-bottom: 5px;"><a href="new_donor.php">New Donor</a></li>
            <li style="margin-bottom: 5px;"><a href="new_blood.php">New Blood Bag</a></li>';
        }

        ?>

    </ul>
</div>