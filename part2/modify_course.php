<?php
/**
 * Created by IntelliJ IDEA.
 * User: yihua
 * Date: 2019-05-21
 * Time: 4:21 PM
 */

require_once('./config/database.php');
require_once('./classes/System.php');
require_once('./classes/EML_Parsing.php');
require_once('./components/auth_user.php');

if(!$user){
    $link = './login.php';
    header( "Location: $link" ) ;
}

if (isset($_POST)) {
    if (isset($_POST['course'])) {
        if ($system->delete_course($_POST['course'], $user['id'])) {
            $news_string = $user['firstname'] . ' ' . $user['lastname'] . ' has deleted course: ' . $_POST['course'] . '. All registered students will automatically drop this course. :(';
            $system->insert_news($news_string, $user['id']);
            echo "<script>alert('You have succeeded delete: " . $_POST['course'] . "')</script>";
            $link = './modify_course.php?method=2';
            header( "Location: $link" ) ;
        }
        else{
            echo "<script>alert('You have failed delete: " . $_POST['course'] . "')</script>";
            $link = './modify_course.php?method=2';
            header( "Location: $link" ) ;
        }
    }
}

require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');
require_once('./components/sidebar.php');


function echo_edit_eml(){
    echo '
    <!-- Area Chart -->
    <div class="col-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Add / Edit a Bookmark</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
            <form id="eml-form" method="post" action="processing_modify.php">
                <div class="form-group row">
                    <label for="eml"  class="col-sm-2 col-form-label">Please enter EML here</label>
                    <textarea class="form-control" id="eml" name="eml" rows="30"></textarea>
                </div>
                <div class="form-group row fa-pull-right">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>';
}


$message = null;
$method = null;
$bookmark_id =null;

if(isset($_GET))
{
    if(!empty($_GET['method']) )
    {
        $method = $_GET['method'];

        if(!empty($_GET['bookmark_id'])){
            $bookmark_id = $_GET['bookmark_id'];
        }
    }
    else{
        $message="Error 401";
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

    <?php
    if(strcmp($method,'1') === 0) {
        echoSidebar($system,$parsing,$user,'modify_course');
    }else if(strcmp($method,'2') === 0){
        echoSidebar($system,$parsing,$user,'delete_course');
    }

    ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php echoNavbar($user); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Courses Management</h1>
                </div>

                <div class="row">


                                <?php
                                if($message)
                                {
                                    echo "<h2 style='color: red'>".$message."</h2>";
                                }
                                else{
                                    if(strcmp($method,'1') === 0) {
                                        echo_edit_eml();

                                    }  else if(strcmp($method,'2') === 0){
                                        $results = $system->get_instructor_create_course($user["id"]);
                                        if($results){
                                            foreach ($results as $result){
                                                $parsing->set_course($result["course_code"]);
                                                $mOverview = $parsing->get_overview();
                                                if($mOverview){
                                                    echo '
                                                    <div class="col-lg-6">
                                                        <div class="card shadow mb-4">
                                                            <div class="card-header py-3">
                                                                <h6 class="m-0 font-weight-bold text-primary">'.$result["course_code"].': '.$mOverview["title"].'</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <p>'.$mOverview["introduction"].'</p>
                                                                 <ul>
                                                                  <li><strong>Instructor: </strong>'.$mOverview["instructor"].'</li>
                                                                  <li><strong>Discipline: </strong>'.$mOverview["discipline"].'</li>
                                                                </ul> 
                                                                <form method="post" action="'.(htmlspecialchars($_SERVER["PHP_SELF"])).'">
                                                                <input type="hidden" name="course" value="' . $result["course_code"] . '">
                                                                <button onclick="return confirm(\'Are you sure to delete the course?\');" type="submit" name="completeYes" class="btn btn-danger btn-block">
                                                                Delete
                                                                </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                }else{
                                                    echo '<h1 style="color: red">Something went wrong to read '.$result["course_code"].'';
                                                }
                                            }
                                        }else{
                                            echo "<h1 style='color: red'>You haven't created any course yet.</h1>";
                                        }
                                    }
                                    else{
                                        if (!isset($_POST)) {
                                            echo "<h1 style='color: red'>Error 403</h1>";
                                        }
                                    }
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

