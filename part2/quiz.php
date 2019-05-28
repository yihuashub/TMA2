<?php
/**
 * Created by IntelliJ IDEA.
 * User: yihua
 * Date: 2019-05-21
 * Time: 4:21 PM
 */

// Import System Classes
require_once('./config/database.php');
require_once('./classes/System.php');
require_once('./classes/EML_Parsing.php');
require_once('./components/auth_user.php');

if (!$user) {
    $link = './login.php';
    header("Location: $link");
}

require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');
require_once('./components/sidebar.php');


$message = null;
$course = null;
$quiz = null;

if (isset($_GET)) {
    if (!empty($_GET['course'])) {
        $course = $_GET['course'];

        if (!empty($_GET['quiz'])) {
            $quiz = $_GET['quiz'];
            $parsing->set_course($course);
            $parsing_string = $parsing->parsing_quiz($quiz);
        }
    } else {
        $message = "Error 403";
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
    <?php echoSidebar($system, $parsing, $user, $course . '+quiz+' . $quiz); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php echoNavbar($user); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?php echo $course ?> : Quiz <?php echo $quiz; ?></h1>
                </div>

                <div class="row">
                    <!-- Area Chart -->
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <!-- Card Body -->
                            <div class="card-body">
                                <?php
                                if ($message) {
                                    echo "<h2 style='color: red'>" . $message . "</h2>";
                                } else {

                                    if ($parsing_string) {
                                        echo '<form method="post" action="correction_quiz.php">';
                                        foreach ($parsing_string as $row) {
                                            echo $row;
                                        }
                                        echo '
                                        <div class="container">
                                          <div class="row">
                                            <div class="col text-center">
                                                <button class="btn btn-primary btn-icon-split btn-lg">
                                                    <span class="icon text-white-50">
                                                      <i class="fas fa-flag"></i>
                                                    </span>
                                                    <span class="text">Submit</span>
                                                  </button>
                                             </div>
                                          </div>
                                        </div>
                                      </form>';

                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
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

<script>
    var urlFormat = false;

    function isURL(s) {
        var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
        return regexp.test(s);
    }

    function checkUrlFormat() {
        var inpObj = document.getElementById("url").value;
        urlFormat = isURL(inpObj);

        if (!urlFormat) {
            document.getElementById("message").innerHTML = "The URL format is NOT correct.";
            document.getElementById("message").className = 'invalid-feedback';
            document.getElementById("url").className = 'form-control is-invalid';
        } else {
            document.getElementById("message").innerHTML = "The URL format is correct.";
            document.getElementById("message").className = 'valid-feedback';
            document.getElementById("url").className = 'form-control is-valid';
        }
    }

    function proceed() {

        if (urlFormat) {
            var form = document.getElementById('url-form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', './processing_modify.php');
            form.submit();
        }
    }
</script>
<!-- Bootstrap core JavaScript-->
<script src="../shared/vendor/jquery/jquery.min.js"></script>
<script src="../shared/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../shared/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../shared/js/sb-admin-2.min.js"></script>


</body>
</html>

