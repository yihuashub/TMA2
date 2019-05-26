<?php


class EML_parsing
{
    private $db;
    private $eml;
    private $course_name;
    private $course_instructor;
    private $simplexml_load_string;
    private $xml_element;


    public function __construct($db, $eml)
    {
        $this->db = $db;
        $this->eml = $eml;
        $this->simplexml_load_string=simplexml_load_string($eml);
        $this->course_name = $this->simplexml_load_string->attributes();
        $this->xml_element = new SimpleXMLElement($eml);
    }


    private function save_row($key_word,$sub_eml)
    {
        $sub_eml = $this->db->mysqli_real_escape_string($sub_eml);
        $sql = "INSERT INTO `$this->course_name` (id, key_word, eml) VALUES (NULL, '$key_word', '$sub_eml')";
        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    private function create_table($course_name){
        $sql = "CREATE TABLE `learning`.`$course_name` ( `id` INT(6) NOT NULL AUTO_INCREMENT , `key_word` VARCHAR(30) NOT NULL , `eml` VARCHAR(500) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    private function delete_table($course_name){
        $sql = "DROP TABLE `$course_name`;";
        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist($course_name){
        $sql = "SHOW TABLES LIKE '$course_name' ";
        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function parsing()
    {
        $this->course_name = $this->simplexml_load_string->attributes();

        if($this->check_exist($this->course_name)){
            echo "This course already exists, do you want to override this?";
            if($this->delete_table($this->course_name)){
                echo "This table was successful delete";
            }else{
                echo "failed delete.";
            }

        }

        echo "Creating this table";
        $this->create_table($this->course_name);

        foreach ($this->xml_element->children() as $child) {
            $this->save_row($child->getName(),$child->asXML());

            echo $child->getName()."<br>";
//
//            if (strcmp($child->getName(), 'overall') === 0) {
//                echo $child->asXML();
//               // $this->save_row('overall',$child->asXML());
//            }
        }
    }

    public function sss(){
//        $course = array();
//        if ($this->xml === false) {
//            echo "Failed loading XML: ";
//            foreach(libxml_get_errors() as $error) {
//                echo "<br>", $error->message;
//            }
//        } else {
//            //print_r($xml);
//        }
//
//        echo "Couese name ".$this->xml->attributes();
//
//        foreach($xml->product->catalog_item as $item)
//        {
//            foreach ($item->attributes() as $attKey ) {
//                echo $attKey;
//            }
//            foreach($item as $key => $value)
//            {
//                echo $value->attributes() ;
//
//                $course[(string)$key] = (string)$value;
//            }
//
//            $course[] = $course;
//        }
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