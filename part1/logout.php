<?php

require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');

$logout = true;

?>

<?php
if (isset($_COOKIE['login'])) {
    setcookie("login", "", time()-3600);
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
                    if($logout)
                    {
                        echo '
                <div class="text-center">
                    <i class="fa fa-thumbs-up" style="font-size:48px;color:green"></i>
                    <p class="lead text-gray-800 mb-5">You have successful logout!</p>
                    <a href="index.php">&larr; Go To Home</a>
                </div>';
                    }else{
                        echo '
                <div class="text-center">
                    <i class="fa fa-thumbs-down" style="font-size:48px;color:red"></i>
                    <p class="lead text-gray-800 mb-5">Sorry, Something went wrong, Please Try Again. </p>
                    <a href="index.php">&larr; Go Back</a>
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

