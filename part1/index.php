<?php
require_once('../config/database.php');
require_once('./components/auth_user.php');
require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');
?><!DOCTYPE html>
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
            echoNavbar($user);
            ?>

            <!-- Begin Page Content -->
            <div class="container">
                <!-- Outer Row -->
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-5 ">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">The TOP 10 Bookmarks</h1>
                                    </div>

                                    <div class="list-group">
                                        <?php
                                        require_once('./components/bookmark.php');

                                        $db = new Database();
                                        $bookmark = new Bookmark($db,null);

                                        $results = $bookmark->get_top_ten();

                                        if($results){
                                            foreach ($results as $url) {
                                                echo '<a href="'.$url['url'].'" target="_blank" class="list-group-item list-group-item-action">'.$url['url'].'</a> ';
                                            }
                                        }else{
                                            echo `<p>Sorry the database is empty</p>`;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome to bookmarking!</h1>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <p>Already have an account?</p>
                                    </div>
                                    <a href="./login.php" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Login
                                    </a>
                                    <br/>
                                    <div class="text-center">
                                        <p>Dont't have an account yet?</p>
                                    </div>
                                    <a href="./register.php" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Register now!
                                    </a>
                                </div>
                            </div>
                        </div>
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



<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

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
