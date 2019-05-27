<?php
/**
 * Created by IntelliJ IDEA.
 * User: yihua
 * Date: 2019-05-16
 * Time: 4:21 PM
 */
require_once('./config/database.php');
require_once('./classes/EML_Parsing.php');
require_once('./classes/System.php');
require_once('./components/auth_user.php');

if(!$user){
    $link = './login.php';
    header( "Location: $link" ) ;
}

require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');
require_once('./components/sidebar.php');

$db = new Database();

// Import Classes
require_once ('./classes/System.php');
require_once ('./classes/EML_Parsing.php');

?>
<!DOCTYPE html>
<html lang="en">

<?php
echoHead();
?>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <?php echoSidebar($system,$parsing,$user,'register_course'); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php echoNavbar($user); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                </div>

                <div class="row">
                    <?php
                    $mSystem = new System($db);

                    $courseList = $mSystem->get_course_list();

                    if($courseList){
                        foreach ($courseList as $item){
                            $parsing->set_course($item["course_code"]);
                            $mOverall = $parsing->get_overall();
                            if($mOverall){
                                echo '
                                <div class="col-lg-6">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">'.$item["course_code"].': '.$mOverall["title"].'</h6>
                                        </div>
                                        <div class="card-body">
                                            <p>'.$mOverall["introduction"].'</p>
                                             <ul>
                                              <li><strong>Instructor: </strong>'.$mOverall["instructor"].'</li>
                                              <li><strong>Discipline: </strong>'.$mOverall["discipline"].'</li>
                                            </ul> 
                                            <a href="#" class="btn btn-primary btn-block">Register</a>
                                        </div>
                                    </div>
                                </div>';
                            }else{
                                echo '<h1 style="color: red">Something went wrong to read '.$item["course_code"].'';
                            }

                        }
                    }else{
                        echo '<h1 style="color: red">There is no any course available now.</h1>';
                    }
                    ?>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php
        echoFooter();
        ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php
echoLogoutModal();
?>

<!-- Bootstrap core JavaScript-->
<script src="../shared/vendor/jquery/jquery.min.js"></script>
<script src="../shared/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../shared/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../shared/js/sb-admin-2.min.js"></script>

</body>

</html>

