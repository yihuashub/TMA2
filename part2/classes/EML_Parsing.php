<?php


class EML_Parsing
{
    private $db;
    private $course_code;
    private $sub_title;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function set_course($course_code)
    {
        $this->course_code = $course_code;
    }

    public function get_lesson_list(){
        $sql = "SELECT * FROM `$this->course_code` WHERE `key_type` = 'lesson' ORDER BY `id`;";
        $result = $this->db->query($sql);
        $result_array = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $mRow = simplexml_load_string($row['eml']);
                array_push($result_array, $mRow->attributes().' '.$mRow->title);
            }
            return $result_array;
        } else {
            return false;
        }
    }

    public function get_quiz_list(){
        $sql = "SELECT * FROM `$this->course_code` WHERE `key_type` = 'quiz' ORDER BY `id`;";
        $result = $this->db->query($sql);
        $result_array = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $mRow = simplexml_load_string($row['eml']);
                array_push($result_array, $mRow->attributes().' ');
            }
            return $result_array;
        } else {
            return false;
        }
    }

    private function check_exist($course_code){
        $sql = "SHOW TABLES LIKE '$course_code' ";
        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function eml_to_array($eml){

        $xml = simplexml_load_string($eml, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        return $array;
    }

    private function parsing_to_html($parsing_string){
        if($parsing_string){
            $result = array();
            $xml = new SimpleXMLElement($parsing_string);
            $this->sub_title = $xml->title;

            foreach ($xml->section as $children) {
                foreach ($children->children() as $child) {
                    if($child->attributes()){
                        $attributes_array = $child->attributes();
                        if(strcmp($child->getName(),'title')===0){
                            if(isset($attributes_array["size"])){
                                $string = '<'.$attributes_array["size"].'>'.$child.'</'.$attributes_array["size"].'>';
                                array_push($result,$string);
                            }
                        }
                        else if(strcmp($child->getName(),'text')===0){
                            if(isset($attributes_array["style"])){
                                $string = '<p style="'.$attributes_array["style"].'">'.$child.'</p>';
                                array_push($result,$string);
                            }
                        }
                        else if(strcmp($child->getName(),'code')===0){
                            if(isset($attributes_array["style"])){
                                $string = '<code style="'.$attributes_array["style"].'">'.$child.'</code>';
                                array_push($result,$string);
                            }
                        }
                        else if(strcmp($child->getName(),'link')===0){
                            if(isset($attributes_array["href"])){
                                $string = '<a style="'.$attributes_array["href"].'">'.$child.'</a>';
                                array_push($result,$string);
                            }
                        }
                        else if(strcmp($child->getName(),'image')===0){
                            if(isset($attributes_array["width"]) && isset($attributes_array["height"])){
                                $string = '<img src="'.$child.'" height="'.$attributes_array["height"].'" width="'.$attributes_array["width"].'"/> ';
                                array_push($result,$string);
                            }
                        }
                        else if(strcmp($child->getName(),'video')===0){
                            if(isset($attributes_array["width"]) && isset($attributes_array["height"]) && isset($attributes_array["type"])){
                                $string = '
                                                             <video width="'.$attributes_array["width"].'" height="'.$attributes_array["height"].'" controls>
                                                              <source src="'.$child.'" type="'.$attributes_array["type"].'">
                                                              Your browser does not support the video tag.
                                                            </video> ';
                                array_push($result,$string);
                            }
                        }
                    }

                    if(strcmp($child->getName(),'text')===0){
                        $string = '<p>'.$child.'</p>';
                        array_push($result,$string);
                    }
                    else if(strcmp($child->getName(),'code')===0){
                        $string = '<code>'.$child.'</code>';
                        array_push($result,$string);
                    }
                    else if(strcmp($child->getName(),'text-same-line')===0){
                        $string = '<span>'.$child.'</span >';
                        array_push($result,$string);
                    }
                }
                array_push($result,'<hr/>');
            }
            return $result;
        }else{
            return false;
        }
    }

    public function get_subtitle(){
        return $this->sub_title;
    }

    public function get_overall(){
        if($this->check_exist($this->course_code)){
            $sql = "SELECT * FROM `$this->course_code` WHERE `key_type` = 'overall';";
            $result = $this->db->query($sql);
            $eml ='';
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $eml = $row['eml'];
                }
                return $this->eml_to_array($eml);
            } else {
                return false;
            }
        }else{
            echo "<h1 style='color: red'>This course is no longer exist.</h1>";
        }
    }

    public function parsing_lesson($id){
        if($this->check_exist($this->course_code)){
            $sql = "SELECT * FROM `$this->course_code` WHERE `key_word` = 'lesson_".$id."';";
            $result = $this->db->query($sql);
            $eml ='';
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $eml = $row['eml'];
                }
                return $this->parsing_to_html($eml);
            } else {
                return false;
            }
        }else{
            echo "<h1 style='color: red'>This course is no longer exist.</h1>";
        }
    }

}