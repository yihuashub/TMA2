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
        $this->simplexml_load_string=simplexml_load_string($this->xmlEscape($eml));
        $this->course_name = $this->simplexml_load_string->attributes();
        $this->xml_element = new SimpleXMLElement($eml);
    }

    private function xmlEscape($string) {
        return str_replace('&', '&amp;', $string);
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

    private function add_to_courseList($course_code,$user_id){
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

    public function add_course($system)
    {
        $this->course_name = $this->simplexml_load_string->attributes();

        if($this->check_exist($this->course_name)){
            echo "<p>This course already exists, the method will overwrite all contents<p>";
            echo "<p>Dropping exist database table";
            if($this->delete_table($this->course_name)){
                echo "....<strong style='color: green'>success!</strong></p><br>";
            }else{
                echo "....<strong style='color: green'>failed.</strong></p><br>";
            }
        }else{
            $system->register_course($this->course_name,$this->user['id']);
            $this->add_to_courseList($this->course_name,$this->user['id']);
        }

        echo "<p>Creating new database table";
        if($this->create_table($this->course_name)){
            echo "....<strong style='color: green'>success!</strong></p><br>";
        }else{
            echo "....<strong style='color: green'>failed.</strong></p><br>";
        }

        foreach ($this->xml_element->children() as $child) {
            echo "<p>working on ".$child->getName().'_'.$child->attributes();
            if($this->save_row($child->getName().'_'.$child->attributes(),$child->getName(),$child->asXML())){
                echo "....<strong style='color: green'>success!</strong></p><br>";
            }else{
                echo "....<strong style='color: green'>failed.</strong></p><br>";
            }
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