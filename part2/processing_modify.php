<?php
// Import System Classes
require_once('./config/database.php');
require_once('./classes/System.php');
require_once('./classes/EML_Parsing.php');
require_once('./components/auth_user.php');

if(!$user){
    $link = './login.php';
    header( "Location: $link" ) ;
}
require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');
require_once('./components/sidebar.php');

// Class
require_once('./classes/EML_Processor.php');


$salt = time();
$login = false;

$email = "";

$eml = null;
$status = false;
$message = '';

if(isset($_POST)) {
    if ($user) {
        if (!empty($_POST['eml'])) {
            $eml = $_POST['eml'];
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
    <?php echoSidebar($system,$parsing,$user,'modify_course'); ?>
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
                if($eml)
                {
                    $parseEML = new EML_Processor(new Database(),$eml,$user);
                    $parseEML->add_course($system);
                    $system->insert_news(''.$user["firstname"].' '.$user["lastname"].' has created / updated course: '.$parseEML->get_course_name().'! Hurry up! take look at the new content.',$user["id"]);
                    echo "<p>End of processing ".$parseEML->get_course_name()."</p>";
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


