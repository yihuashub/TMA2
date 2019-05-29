<?php
// Import System Classes
require_once('./config/database.php');
require_once('./classes/System.php');
require_once('./classes/EML_Parsing.php');
require_once('./components/auth_user.php');

require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');
require_once('./components/sidebar.php');

$salt = time();
$register = false;
$message = '';

$firstName = "";
$lastName = "";
$password = "";
$repassword = "";
$email = "";
$role = 0;

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

function insert_db($email,$role,$firstName,$lastName,$password,$salt)
{
    $db = new Database();
    $hashPassword = md5($password. $salt);

    $sql = "INSERT INTO `users` (`id`, `email`, `role`, `firstname`, `lastname`, `password`, `salt`) VALUES (NULL, '$email', '$role', '$firstName', '$lastName', '$hashPassword', '$salt'); ";
    $result = $db->query($sql);

    if ($result === TRUE) {
        return $db->insert_id();
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
    if(strcmp($_POST['role'],'student')!==0){
        $role = 1;
    }

    if(!empty($firstName) && !empty($lastName) && !empty($password) && !empty($repassword) && !empty($email)){
        if(strcmp($password,$repassword) === 0)
        {
            if(check_exit($email))
            {
                $user_id = insert_db($email,$role,$firstName,$lastName,$password,$salt);
                if ($user_id) {
                    setcookie('login', $email . ',' . md5($password. $salt));
                    $system->insert_news('A new '.$_POST['role'].', '.$firstName.' '.$lastName.' just joined us, Welcome!',$user_id);
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

</body>

</html>


