<?php

function echoStudentOperations($active_name){
    echo '
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Student Operations
      </div>

      <!-- Nav Item - Add course -->
      <li class="nav-item">
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
      ';
}

function echoSidebar($db,$user,$active_name)
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
        <div class="sidebar-brand-text mx-3">E-Learning<sup>Beta</sup></div>
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

    echo '
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Your Courses
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#comp466" aria-expanded="true" aria-controls="comp466">
          <i class="fas fa-fw fa-folder"></i>
          <span style="text-transform: uppercase;">comp466</span>
        </a>
        <div id="comp466" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Lessons:</h6>
            <a class="collapse-item" href="./course.php?course=COMP466&lesson=1">Lesson 1:dsadasdasdsadasdas dsadsa</a>
            <a class="collapse-item" href="./course.php?course=COMP466&lesson=2">Lesson 1:dsadsadsad dsadasdsa </a>
            <a class="collapse-item" href="./course.php?course=COMP466&lesson=3">Lesson 1:dsadsadas dsadsadsadsd dasdsad </a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Quizzes:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#comp477" aria-expanded="true" aria-controls="comp477">
          <i class="fas fa-fw fa-folder"></i>
          <span style="text-transform: uppercase;">comp477</span>
        </a>
        <div id="comp477" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Lessons:</h6>
            <a class="collapse-item" href="login.html">Lesson 1:dsadasdasdsadasdas dsadsa</a>
            <a class="collapse-item" href="login.html">Lesson 1:dsadsadsad dsadasdsa </a>
            <a class="collapse-item" href="login.html">Lesson 1:dsadsadas dsadsadsadsd dasdsad </a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Quizzes:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#comp467" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>comp467</span>
        </a>
        <div id="comp467" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Lessons:</h6>
            <a class="collapse-item" href="login.html">Lesson 1:dsadasdasdsadasdas dsadsa</a>
            <a class="collapse-item" href="login.html">Lesson 1:dsadsadsad dsadasdsa </a>
            <a class="collapse-item" href="login.html">Lesson 1:dsadsadas dsadsadsadsd dasdsad </a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Quizzes:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->';
}
