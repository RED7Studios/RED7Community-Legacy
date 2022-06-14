<?php
/*
	  File Name: verify.php
	  Original Location: /verify.php
	  Description: The form for applying for verification.
	  Author: Mitchell (BlxckSky_959)
	  Copyright (C) RED7 STUDIOS 2022
	*/

include_once $_SERVER["DOCUMENT_ROOT"] . "/assets/common.php";

if (!isset($_SESSION)) {
    // Initialize the session
    session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php?u=" . $_SERVER["REQUEST_URI"]);
    exit;
}

if ($_POST) {
    $sendEmail($_SESSION["id"], "/admin/view-application.php?id=blahblah", "verification-form", $_POST["full_name"], $_POST["reason"], $_POST["email"], true);
    //$sendEmail($_SESSION["id"], "", "verification-sent", $_POST["full_name"], $_POST["reason"], $_POST["email"]);
    echo '<div class="alert alert-success" style="margin-bottom: 0; border-radius: 0;" role="alert">
    Your application has been sent to our team and they will get back to you shortly.
  </div>';
}

$requirements = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apply for Verification - <?php echo htmlspecialchars($site_name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="/assets/js/fontawesome.js"></script>
</head>

<body>
    <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/account/navbar.php" ?>

    <?php
    if (isset($your_isBanned)) {
        if ($your_isBanned == 1) {
            echo "<script type='text/javascript'>location.href = '/errors/banned.php';</script>";
        }
    }

    if (isset($maintenanceMode)) {
        if ($maintenanceMode == "on") {
            echo "<script type='text/javascript'>location.href = '/errors/maintenance.php';</script>";
        }
    }
    ?>

    <div class="page-content-wrapper">
        <div class="centered">
            <div class="container">
                <div class="row">
                    <div>
                        <img src="<?php echo $verifiedIcon; ?>" />
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h3>Apply for Verification</h3>
                                <h5>If you have met all of the requirements then you can fill out the form below, and our team will get back to you as soon as possible!</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div>
                <h3>Requirements</h3>
                <p>
                    <?php if ($getSecret($_SESSION["id"]) == "" || $getSecret($_SESSION["id"]) == null) {
                        $requirements = $requirements + 1;
                        echo '<i style="color: #f00;" class="fa-solid fa-xmark"></i>';
                    } else {
                        echo '<i style="color: #50ae47;" class="fa-solid fa-check"></i>';
                    } ?> |
                    You need to have 2FA enabled on your account.
                </p>
                <p>
                    <?php if ($your_email == null) {
                        $requirements = $requirements + 1;
                        echo '<i style="color: #f00;" class="fa-solid fa-xmark"></i>';
                    } else {
                        echo '<i style="color: #50ae47;" class="fa-solid fa-check"></i>';
                    } ?> |
                    You need to have a valid email on your account.
                </p>
                <p>
                    <?php
                    if (strtotime($your_created_at) > strtotime('1 month ago')) {
                        $requirements = $requirements + 1;
                        echo '<i style="color: #f00;" class="fa-solid fa-xmark"></i>';
                    } else {
                        echo '<i style="color: #50ae47;" class="fa-solid fa-check"></i>';
                    } ?> |
                    Your account must be older than 1 month.
                </p>
                <p><b>Status:</b> <?php if ($your_isVerified == 1) { echo "Verified"; } else if ($requirements != 0 ) { echo "Ineligible"; } else if ($your_isVerified != 1 ) { echo "Eligible"; } ?></p>
            </div>

            <?php
            if ($requirements == 0) {
            ?>
                <form class="redeem-form text-center" action="verify.php" method="post">
                    <div class="elem-group">
                        <h4 for="name">Full Name</h4>
                        <input type="text" id="name" name="full_name" placeholder="John Doe" pattern=[A-Z\sa-z]{3,20} required style="width: 70%;">
                    </div>
                    <div class="elem-group">
                        <h4 for="email">Preferred Contact Email</h4>
                        <input type="email" id="email" name="email" value="<?php echo $your_email; ?>" placeholder="john@example.com" required style="width: 70%;">
                    </div>
                    <div class="elem-group">
                        <h4 for="reason">Reason</h4>
                        <textarea type="text" id="reason" name="reason" placeholder="I want to be verified because ... and I feel that I can contribute to <?php echo $site_name; ?> by ..." required style="width: 70%;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            <?php
            }
            ?>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>