<?php


class EML_Processor
{
    private $db;
    private $eml;
    private $user;
    private $course_code;
    private $course_instructor;
    private $simplexml_load_string;
    private $xml_element;


    public function __construct($db, $eml,$user)
    {
        $this->db = $db;
        $this->eml = $eml;
        $this->user = $user;
        $this->simplexml_load_string=simplexml_load_string($eml);
        $this->course_name = $this->simplexml_load_string->attributes();
        $this->xml_element = new SimpleXMLElement($eml);
    }


    private function save_row($key_word,$key_type,$sub_eml)
    {
        $sub_eml = $this->db->mysqli_real_escape_string($sub_eml);
        $sql = "INSERT INTO `$this->course_name` (id, key_word,key_type,eml) VALUES (NULL, '$key_word','$key_type', '$sub_eml')";
        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            echo $this->db->error();
            return false;
        }
    }

    private function create_table($course_code){
        $sql = "CREATE TABLE `learning`.`$course_code` ( `id` INT(6) NOT NULL AUTO_INCREMENT , `key_word` VARCHAR(30) NOT NULL ,`key_type` VARCHAR(30) NOT NULL , `eml` VARCHAR(55555) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            echo $this->db->error();
            return false;
        }
    }

    private function delete_table($course_code){
        $sql = "DROP TABLE `$course_code`;";
        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            echo $this->db->error();
            return false;
        }
    }

    private function addToCourseList($course_code,$user_id){
        $sql = "INSERT INTO `course_list` (`id`, `course_code`, `user_id`) VALUES (NULL, '$course_code', '$user_id'); ";
        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            echo $this->db->error();
            return false;
        }
    }

    public function check_exist($course_code){
        $sql = "SHOW TABLES LIKE '$course_code' ";
        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addCourse()
    {
        $this->course_name = $this->simplexml_load_string->attributes();

        if($this->check_exist($this->course_name)){
            echo "This course already exists, do you want to override this?";
            if($this->delete_table($this->course_name)){
                echo "This table was successful delete";
            }else{
                echo "failed delete.";
            }
        }else{
            $this->addToCourseList($this->course_name,$this->user['id']);
        }

        echo "Creating this table";
        $this->create_table($this->course_name);

        foreach ($this->xml_element->children() as $child) {
            echo "working on ".$child->getName();
            if($this->save_row($child->getName().'_'.$child->attributes(),$child->getName(),$child->asXML())){
                echo " is success!<br>";
            }else{
                echo " failed <br>";
            }
        }
    }


    public function get_user_list()
    {
        if ($this->userId) {
            $m_user_id = $this->userId;
            $sql = "SELECT * FROM `bookmarks` WHERE `user_id` = '$m_user_id'  ORDER BY `id` DESC;";
            $result = $this->db->query($sql);

            $result_array = array();

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($result_array, $row);
                }
                $this->total = count($result_array);
                return $result_array;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_user_total_count()
    {
        return $this->total;
    }

    //to string functions

    public function get_course_name(){
        return $this->course_name;
    }
}