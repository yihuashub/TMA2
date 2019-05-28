<?php

function echoUsersCourse($system,$parsing,$user,$active_name){
    $course_array = $system->get_user_registered_course($user['id']);

    if($course_array){
        echo '
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading">
        Your Courses
      </div>';

        foreach ($course_array as $course){
            $active_sub_array_1='';
            $active_sub_array_2='';
            $active_array = explode("+",$active_name);
            $parsing->set_course($course["course_code"]);
            $lesson_array = $parsing->get_lesson_list();
            $quiz_array = $parsing->get_quiz_list();

            if(strcmp($active_array[0],$course["course_code"])==0){
                $active_sub_array_1 = $active_array[0];
                $active_sub_array_2 = $active_array[1].$active_array[2];
            }



            echo '
              <!-- Nav Item - Pages Collapse Menu -->
              <li class="nav-item  '.((strcmp($active_sub_array_1,$course["course_code"])==0)?'active':"").'">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#'.$course["course_code"].'" aria-expanded="true" aria-controls="'.$course["course_code"].'">
                  <i class="fas fa-fw fa-folder"></i>
                  <span style="text-transform: uppercase;">'.$course["course_code"].'</span>
                </a>
                <div id="'.$course["course_code"].'" class="collapse '.((strcmp($active_sub_array_1,$course["course_code"])==0)?'show':"").'" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Lessons:</h6>';
                    if($lesson_array){
                        foreach($lesson_array as $key=>$value) {
                            echo '<a class="collapse-item '.((strcmp($active_sub_array_2,"lesson".($key+1))==0)?'active':"").'" href="./view.php?course='.$course["course_code"].'&lesson='.($key+1).'">Lesson '.$value.'</a>';
                        }
                    }
                    echo'
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Quizzes:</h6>';
                    if($quiz_array){
                        foreach($quiz_array as $key=>$value) {
                            echo '<a class="collapse-item '.((strcmp($active_sub_array_2,"quiz".($key+1))==0)?'active':"").'" href="./quiz.php?course='.$course["course_code"].'&quiz='.$value.'">Quiz '.$value.'</a>';
                        }
                    }
                    echo '
                  </div>
                </div>
              </li>';
        }

    }else{
        echo '     
     <li class="nav-item" style="color:red;;">
        <a class="nav-link" href="#">
          <span style="text-transform: uppercase;">No Any Registered course</span>
        </a>
      </li>';
    }
}

function echoStudentOperations($active_name){
    $active = false;
    if(strcmp($active_name,'register_course') === 0){
        $active = true;
    }
    echo '
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Student Operations
      </div>

      <!-- Nav Item - Add course -->
      <li class="nav-item '.(($active)?'active':"").'">
        <a class="nav-link" href="register_course.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Register a course</span></a>
      </li>';
}

function echoInstructorOperations($active_name){
    $active = false;
    if(strcmp($active_name,'modify_course') === 0 || strcmp($active_name,'delete_course') === 0){
        $active = true;
    }
    echo '
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Instructor Operations
      </div>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item '.(($active)?'active':"").'">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Courses Management</span>
        </a>
        <div id="collapseUtilities" class="collapse '.(($active)?'show':"").'" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Courses Utilities:</h6>
            <a class="collapse-item  '.((strcmp($active_name,"modify_course")==0)?'active':"").'" href="modify_course.php?method=1">Add / Update</a>
            <a class="collapse-item  '.((strcmp($active_name,"delete_course")==0)?'active':"").'" href="modify_course.php?method=2">Delete</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - File Management -->
      <li class="nav-item '.((strcmp($active_name,"file_management")===0)?'active':"").'">
        <a class="nav-link" href="file_manager.php">
          <i class="far fa-copy"></i>
          <span>File Management</span></a>
      </li>
      ';
}

function echoSidebar($system,$parsing,$user,$active_name)
{
    $username = 'Please Login';
    $user_role = '';
    if($user)
    {
        $username = $user['firstname'].' '.$user['lastname'];
        if($user['role'] === '0'){
            $user_role = 'a students';
        }else{
            $user_role = 'an instructor';
        }
    }

    echo '
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">EZ-Learn<sup>Beta</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item '.((strcmp($active_name,"dashboard")===0)?'active':"").'">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>';

    if($user['role'] === '0') {
        echoStudentOperations($active_name);
    }else{
        echoInstructorOperations($active_name);
    }

    echoUsersCourse($system,$parsing,$user,$active_name);

    echo '
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->';
}
