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


?>

<!DOCTYPE html>
<html lang="en">

<?php
echoHead();
?>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php echoSidebar($system,$parsing,$user,'file_management'); ?>
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
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Your Course List</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class='centrebox2'>
                                    <form action="upload_file.php" method="post"
                                          enctype="multipart/form-data">
                                        <p>
                                        <h4><label for="file">Upload File:</label></h4>
                                        <div class="custom-file mb-3">
                                            <input type="file" class="custom-file-input" id="file" name="file">
                                            <label class="custom-file-label" for="file">Choose file</label>
                                        </div>
                                        <p>
                                            <button type="submit" class="btn btn-info btn-icon-split">
                                                <span class="icon text-white-50">
                                                  <i class="fas fa-upload"></i>
                                                </span>
                                                <span class="text">Upload File</span>
                                            </button>
                                        </p>
                                    </form>
                                    <hr/>
                                    <h4>File List:</h4>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                                        <?php
                                        $files = $system->get_user_files($user['id']);
                                        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/TMA2/part2/upload/";
                                        if(!$files)
                                        {
                                            echo "<p>No any file exist.</p>";
                                        }
                                        else
                                        {
                                            echo "<ul  class=\"list-group\">";

                                            foreach($files as $value):
                                                echo '<li class="list-group-item list-group-item-action">'.PHP_EOL;
                                                echo '<input type="checkbox" name="DeleteFiles[]" value="'.$value["file_name"].'" id="CheckboxGroup1_1" />  ';
                                                echo $value["file_name"].'   <a href="'.$actual_link.$value["file_name"].'">Online View</a> </li>'.PHP_EOL;
                                            endforeach;
                                            echo'</div>';
                                        }


                                        ?>
                                        <div class='centre' style="padding-top: 20px">
                                            <button type="submit" name="submit" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Delete select file(s)</span>
                                            </button>
                                        </div>
                                    </form>

                                    <form action="" method="get">
                                        <?php
                                        $nameErr = $emailErr = $genderErr = $websiteErr = "";
                                        $deletefiles = $email = $gender = $comment = $website = "";
                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                            if (empty($_POST["DeleteFiles"])) {
                                                $nameErr = "Name is required";
                                            } else {
                                                $deletefiles = ($_POST["DeleteFiles"]);
                                                $path = "./upload/";
                                                foreach ($deletefiles as $name) {
                                                    foreach (glob($path . $name) as $filename) {
                                                        if(unlink(realpath($filename)) && $system->delete_user_files($name)){
                                                            echo '<code>'.$name.' has been deleted.</code><br/>';
                                                        }else{
                                                            echo '<code>'.$name.' delete failed.</code><br/>';
                                                        }
                                                    }
                                                }

                                            }

                                        }

                                        function test_input($data) {
                                            $data = trim($data);
                                            $data = stripslashes($data);
                                            $data = htmlspecialchars($data);
                                            return $data;
                                        }
                                        ?>
                                    </form>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../shared/vendor/jquery/jquery.min.js"></script>
    <script src="../shared/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../shared/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../shared/js/sb-admin-2.min.js"></script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>

</html>