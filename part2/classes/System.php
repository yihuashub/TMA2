<?php


class System
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register_course($course_code,$user_id){
        $sql = "INSERT INTO `course_enroll` (`id`, `course_code`, `user_id`) VALUES (NULL, '$course_code', '$user_id');";
        $result = $this->db->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function drop_course($course_code,$user_id){
        $sql = "DELETE FROM `course_enroll` WHERE `course_code` = '$course_code' AND `user_id` = '$user_id';";
        $result = $this->db->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_course_list()
    {
        $sql = "SELECT * FROM `course_list` ";
        $result = $this->db->query($sql);
        $result_array = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($result_array, $row);
            }
            return $result_array;
        } else {
            return false;
        }
    }

    public function get_user_registered_course($user_id){
        $sql = "SELECT * FROM `course_enroll` WHERE `user_id` = '$user_id' ";
        $result = $this->db->query($sql);
        $result_array = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($result_array, $row);
            }
            return $result_array;
        } else {
            return false;
        }
    }

    public function get_user_files($user_id){
        $sql = "SELECT * FROM `files` WHERE `user_id` = '$user_id' ;";
        $result = $this->db->query($sql);
        $result_array = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($result_array, $row);
            }
            return $result_array;
        } else {
            return false;
        }
    }

    public function save_file_into_db($file,$type,$user_id){
        $sql = "INSERT INTO `files` (`id`, `file_name`, `file_type`, `user_id`) VALUES (NULL, '$file', '$type', '$user_id');";
        $result = $this->db->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_user_files($file_name){
        $sql = "DELETE FROM `files` WHERE `files`.`file_name` = '$file_name';";
        $result = $this->db->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_news($news_string,$user_id){
        $t=time();
        $news_string = $this->db->mysqli_real_escape_string($news_string);

        $sql = "INSERT INTO `news` (`id`, `news`, `user_id`, `time`) VALUES (NULL, '$news_string', '$user_id', '$t');";
        $result = $this->db->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_news(){
        $sql = "SELECT * FROM `news` ORDER BY `id` DESC LIMIT 20 ;";
        $result = $this->db->query($sql);
        $result_array = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($result_array, $row);
            }
            return $result_array;
        } else {
            return false;
        }
    }
}