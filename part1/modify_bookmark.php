<?php
/**
 * Created by IntelliJ IDEA.
 * User: yihua
 * Date: 2019-05-21
 * Time: 4:21 PM
 */

require_once('./config/database.php');
require_once('./components/auth_user.php');

if(!$user){
    $link = './login.php';
    header( "Location: $link" ) ;
}

require_once('./components/head.php');
require_once('./components/footer.php');
require_once('./components/navbar.php');

function check_exit($id)
{
    $db = new Database();

    $sql = "SELECT * FROM `bookmarks` WHERE `id` = '$id' ";
    $result = $db->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    else{
        return false;
    }
}

if(isset($_GET))
{
    if(!empty($_GET['bookmark_id']) && !empty($_GET['method']) )
    {
        $bookmark_id = $_GET['bookmark_id'];
        $method = $_GET['method'];
    }
    else{
        $message="Error 401";
    }
}


function echoAddBookmark(){
    echo '
         <form>
            <div class="form-group row">
                <label for="url" class="col-sm-2 col-form-label">Website Url</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="url" placeholder="Url">
                </div>
            </div>
            <div class="form-group row fa-pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>';
}

function echoEditBookmark($id){
    $result = check_exit($id);

    if($result){
        echo '
         <form>
            <div class="form-group row">
                <label for="url" class="col-sm-2 col-form-label">Website Url</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="url" placeholder="Url" value="'.$result['url'].'">
                </div>
            </div>
              <input type="hidden" id="bookmark_id" name="bookmark_id" value="'.$id.'"> 
            <div class="form-group row fa-pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>';
    }
    else{
        echo '<h3 style="color: red">Sorry you cannot access.</h3>';
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

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php
            echoNavbar($user);
            ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Add / Edit a Bookmark</h1>
                </div>

                <div class="row">

                    <!-- Area Chart -->
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Bookmark</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <?php
                                if($method === 1)
                                {
                                    echoAddBookmark();

                                }else if($method === 2){
                                    echoEditBookmark($bookmark_id);
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

