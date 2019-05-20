<?php
require_once('../config/database.php');
require_once('../components/auth_user.php');
require_once('../components/head.php');
require_once('../components/footer.php');
require_once('../components/navbar.php');
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
                                        <a href="#" class="list-group-item list-group-item-action">yihua.ca</a>
                                        <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                                        <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur
                                            ac</a>
                                        <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum
                                            at eros</a>
                                        <a href="#" class="list-group-item list-group-item-action">yihua.ca</a>
                                        <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                                        <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur
                                            ac</a>
                                        <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum
                                            at eros</a>
                                        <a href="#" class="list-group-item list-group-item-action">yihua.ca</a>
                                        <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                                        <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur
                                            ac</a>
                                        <a href="#" class="list-group-item list-group-item-action disabled">Vestibulum
                                            at eros</a>
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

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
