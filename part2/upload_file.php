<?php
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


?>

<!DOCTYPE html>
<html lang="en">

<?php
echoHead();
?>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php echoSidebar($system, $parsing, $user, 'file_management'); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php echoNavbar($user); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">File Management</h1>
                </div>

                <div class="row">
                    <!-- Area Chart -->
                    <div class="col-xl-12">
                        <p>
                            <?php
                            ini_set('display_errors', 1);
                            error_reporting(E_ALL);
                            $uploads_dir = 'upload/';
                            if ($_FILES["file"]["type"] == "video/mp4") {
                                if ($_FILES["file"]["size"] < 250000000) {
                                    if ($_FILES["file"]["error"] > 0) {
                                        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                                    } else {
                                        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                                        echo "Type: " . $_FILES["file"]["type"] . "<br />";
                                        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                                        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                                        if (file_exists("/upload/" . $_FILES["file"]["name"])) {
                                            echo $_FILES["file"]["name"] . " already exists. ";
                                        } else {
                                            if (move_uploaded_file($_FILES["file"]["tmp_name"],
                                                $uploads_dir . $_FILES["file"]["name"])) {
                                                echo "<script>alert('The file was successful upload on server.')</script>";
                                                if($system->save_file_into_db($_FILES["file"]["name"],$_FILES["file"]["type"],$user['id'])){
                                                    echo  $_FILES["file"]["name"] . " was successful insert into database." ;
                                                }
                                            } else {
                                                echo "<script>alert('File not uploaded')</script>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "too large file MAX 250 Mb";
                                }
                            } else if (($_FILES["file"]["type"] == "image/gif")
                                || ($_FILES["file"]["type"] == "image/jpeg")
                                || ($_FILES["file"]["type"] == "image/png")
                                || ($_FILES["file"]["type"] == "image/pjpeg")) {
                                if (($_FILES["file"]["size"] < 5000000)) {
                                    if ($_FILES["file"]["error"] > 0) {
                                        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                                    } else {
                                        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                                        echo "Type: " . $_FILES["file"]["type"] . "<br />";
                                        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                                        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                                        if (file_exists("upload/" . $_FILES["file"]["name"])) {
                                            echo $_FILES["file"]["name"] . " already exists. ";
                                        } else {
                                            if (move_uploaded_file($_FILES["file"]["tmp_name"],
                                                $uploads_dir . $_FILES["file"]["name"])) {
                                                echo "<script>alert('The file was successful upload on server.')</script>";
                                                if($system->save_file_into_db($_FILES["file"]["name"],$_FILES["file"]["type"],$user['id'])){
                                                    echo  $_FILES["file"]["name"] . " was successful insert into database." ;
                                                }
                                            } else {
                                                echo "<script>alert('Not uploaded')</script>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "too large file";
                                }
                            } else {
                                echo "Invalid file";

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