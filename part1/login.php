<?php
require_once('./config/database.php');
require_once('./components/auth_user.php');

if($user){
    $link = './dashboard.php';
    header( "Location: $link" ) ;
}
require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');
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
            echoNavbar($user);
            ?>

            <!-- Begin Page Content -->
            <div class="container">
                <!-- Outer Row -->
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                    <div class="col-lg-6">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Welcome Join Us!</h1>
                                            </div>
                                            <form class="user" method="post" action="login_user.php">
                                                <div class="form-group">
                                                    <input type="email" class="form-control form-control-user" id="inputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Your Email...">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control form-control-user" id="inputPassword" name="password" placeholder="Password">
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Login
                                                </button>
                                            </form>
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

