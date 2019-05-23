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

function check_exit($id,$user_id)
{
    $db = new Database();

    $sql = "SELECT * FROM `bookmarks` WHERE `id` = '$id' AND `user_id` = '$user_id'";
    $result = $db->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    else{
        return false;
    }
}


function echoAddBookmark(){
    echo '
         <form id="url-form">
            <div class="form-group row">
                <label for="url" class="col-sm-2 col-form-label">Website Ur;</label>
                <div class="col-sm-10">
                    <input id="url" name="url" onchange="checkUrlFormat()"  type="text" class="form-control"  placeholder="Url"  required>
                    <div id="message"></div>
                </div>
            </div>
            <div class="form-group row fa-pull-right">
                <div class="col-sm-12">
                    <button type="button" onclick="proceed();" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>';
}

function echoEditBookmark($id,$user_id){
    $result = check_exit($id,$user_id);

    if($result){
        echo '
         <form id="url-form">
            <div class="form-group row">
                <label for="url" class="col-sm-2 col-form-label">Website Ur;</label>
                <div class="col-sm-10">
                    <input id="url" onchange="checkUrlFormat()"  type="text" class="form-control"  placeholder="Url"  required>
                    <div id="message"></div>
                </div>
            </div>
              <input type="hidden" id="bookmark_id" name="bookmark_id" value="'.$id.'"> 
            <div class="form-group row fa-pull-right">
                <div class="col-sm-12">
                    <button type="button" onclick="proceed();" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>';
    }
    else{
        echo '<h3 style="color: red">Sorry you cannot access.</h3>';
    }

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
                                if($message)
                                {
                                    echo "<h2 style='color: red'>".$message."</h2>";
                                }
                                else{
                                    if(strcmp($method,'1') === 0) {
                                        echoAddBookmark();

                                    }  else if(strcmp($method,'2') === 0){
                                        echoEditBookmark($bookmark_id,$user['id']);
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
            document.getElementById("message").innerHTML = "Input NOT OK";
            document.getElementById("message").className = 'invalid-feedback';
            document.getElementById("url").className = 'form-control is-invalid';
        } else {
            document.getElementById("message").innerHTML = "Input OK";
            document.getElementById("message").className = 'valid-feedback';
            document.getElementById("url").className = 'form-control is-valid';
        }
    }

    function proceed () {

        if(urlFormat){
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

