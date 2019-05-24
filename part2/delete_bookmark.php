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


function check_exist($id,$user_id)
{
    $db = new Database();

    $sql = "SELECT * FROM `bookmarks` WHERE `id` = '$id' AND `user_id` = '$user_id';";
    $result = $db->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    else{
        return false;
    }
}

function delete_db($url_id)
{
    $db = new Database();

    $sql = "DELETE FROM `bookmarks` WHERE `bookmarks`.`id` = '$url_id'";
    $result = $db->query($sql);

    if ($result === TRUE)
    {
        return true;
    }
    else
    {
        return false;
    }
}

$url = null;
$status = false;
$bookmark_id = null;
$message = '';

if(isset($_GET)) {
    if ($user) {
        if (!empty($_GET['bookmark_id'])) {
            $bookmark_id = $_GET['bookmark_id'];
            $exist = check_exist($bookmark_id,$user['id']);
            if($exist){
                $status = delete_db($bookmark_id);
                if ($status) {
                    $message =  '  successful delete!';
                } else {
                    $message =  '  not delete.';
                }
            }else{
                $message ='Error:403';
            }
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

</body>

</html>


