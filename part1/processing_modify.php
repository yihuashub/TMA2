<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

require_once('./config/database.php');
require_once('./components/auth_user.php');

if(!$user){
    $link = './login.php';
    header( "Location: $link" ) ;
}
require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');

$salt = time();
$login = false;
$message = '';

$firstName = "";
$lastName = "";
$password = "";
$repassword = "";
$email = "";

function insert_db($url,$user_id)
{
    $db = new Database();

    $sql = "INSERT INTO `bookmarks` (`id`, `url`, `user_id`) VALUES (NULL, '$url', '$user_id'); ";
    $result = $db->query($sql);

    if ($result === TRUE)
    {
        $message = $url.' was successful insert!' ;
        return true;
    }
    else
    {
        return false;
    }
}

$url = null;
$status = false;
$message = '';

if(isset($_POST))
{
    if(!empty($_POST['url'])  )
    {
        $url =  $_POST['url'];
        if($user){
            insert_db($url,$user['id']);
        }
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
                if($status)
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
                    <a href="login.php">&larr; Go Back</a>
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


