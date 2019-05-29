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

$init = false;
$course =null;
$quiz =null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if(isset($_POST['course']) && isset($_POST['quiz'])){
        $course = $_POST['course'];
        $quiz = $_POST['quiz'];
        $parsing->set_course($course);
        $parsing_answer = $parsing->parsing_quiz_answer($quiz);
        $init = true;
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
                    <h1 class="h3 mb-0 text-gray-800">Quiz Result</h1>
                </div>

                <div class="row">

                    <!-- Area Chart -->
                    <div class="col-xl-12">
                        <div class="card shadow mb-4">
                            <!-- Card Body -->
                            <div class="card-body">
                                <ul class="list-group">
                                    <?php
                                    if($init){
                                        if($parsing_answer){
                                            if(sizeof($parsing_answer) != (sizeof($_POST)-2)){
                                                echo "<h1 style='color: red'>Please complete all questions!</h1>";
                                            }else{
                                                $points = 0;
                                                $array = array_values($_POST);
                                                $answers = array_slice($_POST,2);
                                                $array = array_values($answers);

                                                for($i=0;$i<sizeof($array);$i++){
                                                    if(is_array($array[$i])){
                                                        //echo '<p>index '.$i.' :is array</p><br>';
                                                        if(array_diff($parsing_answer[$i], $array[$i])){
                                                            echo '<strong style="color: red">Question '.($i+1).' : Your selected is wrong</strong><br>';
                                                            foreach ($parsing_answer[$i] as $option)
                                                            {
                                                                echo '<code style="color: blue">The correct answer option: '.$option.'</code><br>';
                                                            }
                                                        }else{
                                                            echo '<p style="color: green">Question '.($i+1).' : Your answer is correct!</p><br>';
                                                            $points++;
                                                        }

                                                    }else{
                                                        //echo '<p>index '.$i.' :is '.$array[$i].'</p><br>';
                                                        if(strcmp(strtolower ($parsing_answer[$i]),strtolower ($array[$i])) === 0){
                                                            echo '<p style="color: green">Question '.($i+1).' : Your answer is correct!</p><br>';
                                                            $points++;
                                                        }else{
                                                            echo '<strong style="color: red">Question '.($i+1).' : You answer / selected the option : '.$array[$i].' is wrong</strong><br>';
                                                            echo '<code style="color: blue">The correct answer is : '.$parsing_answer[$i].'</code><br>';

                                                        }
                                                    }
                                                }

                                                echo '<hr/>';
                                                $final_grade = $points/sizeof($array) * 100;
                                                echo "<h3>Overview, your final grade: ".$final_grade."%</h3>";
                                            }
                                        }else{
                                            echo '<h1 style="color: red">Error on getting answers</h1>';
                                        }
                                    }else{
                                        echo '<h1 style="color: red">Error 403</h1>';
                                    }
                                    ?>
                                </ul>
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

</body>

</html>

