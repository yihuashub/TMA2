<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

require_once('./config/database.php');
require_once('./components/auth_user.php');

if($user){
    $link = './dashboard.php';
    header( "Location: $link" ) ;
}
require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');

$salt = time();
$register = false;
$message = '';

$firstName = "";
$lastName = "";
$password = "";
$repassword = "";
$email = "";

function check_exit($email)
{
    $db = new Database();

    $sql = "SELECT * FROM `users` WHERE `email` = '$email' ";
    $result = $db->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return false;
    }
    else{
        return true;
    }
}

function insert_db($email,$firstName,$lastName,$password,$salt)
{
    $db = new Database();
    $hashPassword = md5($password. $salt);

    $sql = "INSERT INTO `users` (`id`, `email`, `firstname`, `lastname`, `password`, `salt`) VALUES (NULL, '$email', '$firstName', '$lastName', '$hashPassword', '$salt'); ";
    $result = $db->query($sql);

    if ($result === TRUE) {
        return true;
    }
    else {
        $message = $db->error();
        return false;
    }
}

if(isset($_POST))
{
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $email = $_POST['email'];

    if(!empty($firstName) && !empty($lastName) && !empty($password) && !empty($repassword) && !empty($email)){
        if(strcmp($password,$repassword) === 0)
        {
            if(check_exit($email))
            {
                if (insert_db($email,$firstName,$lastName,$password,$salt)) {
                    setcookie('login', $email . ',' . md5($password. $salt));
                    $message = "You were successful registered!";
                    $register = true;
                }else{
                    $message = "You can not register based on your info, please make some changes.";
                }
            }else{
                $message="The User Already Exist.";
            }
        }else{
            $message="The passwords do not match.";
        }
    }else{
     $message="Please enter all info that required.";
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<?php
echoHead();
?>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <?php
                    echoNavbar($user)
                    ?>

                    <!-- Begin Page Content -->
            <div class="container-fluid">
                <?php
                if($register)
                {
                    echo '
                <div class="text-center">
                    <i class="fa fa-thumbs-up" style="font-size:48px;color:green"></i>
                    <p class="lead text-gray-800 mb-5">All Set! '.$message.'</p>
                    <a href="dashboard.php">&larr; Go To Dashboard</a>
                </div>';
                }else{
                    echo '
                <div class="text-center">
                    <i class="fa fa-thumbs-down" style="font-size:48px;color:red"></i>
                    <p class="lead text-gray-800 mb-5">Sorry Please Try Again. '.$message.'</p>
                    <a href="register.php">&larr; Go Back</a>
                </div>';
                }
                ?>
                <!-- Text -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php
        echoFooter()
        ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
<?php
echoLogoutModal();
?>


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="../shared/vendor/jquery/jquery.min.js"></script>
<script src="../shared/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../shared/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../shared/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../shared/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="../shared/js/demo/chart-area-demo.js"></script>
<script src="../shared/js/demo/chart-pie-demo.js"></script>

</body>

</html>


