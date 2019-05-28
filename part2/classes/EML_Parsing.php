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
    private function parsing_to_quiz_answer($parsing_string){
        if($parsing_string){
            $result = array();
            $xml = new SimpleXMLElement($parsing_string);
            foreach ($xml->question as $key=>$children) {

                if(strcmp($children->type,'checkbox')===0){
                    $index = 0;
                    $options = array();
                    foreach ($children->option as $child){
                        $index++;
                        if($child->attributes()){
                            array_push($options,$index);
                        }
                    }
                    array_push($result,$options);
                }else if(strcmp($children->type,'radio')===0){
                    $index = 0;
                    $options = array();
                    foreach ($children->option as $child){
                        $index++;
                        if($child->attributes()){
                            array_push($result,$index);
                        }
                    }
                }else{
                    array_push($result,$children->answer->__toString());
                }

//                foreach ($children as $child){
//                    if(strcmp($child->getName(),'answer')==0){
//                        echo ($index).'--->'.$child->__toString().'<br/>';
//
//                        array_push($result,$child->__toString());
//                        echo $child.'<br/>';
//                    }
//                    else if(strcmp($child->getName(),'option')==0){
//                        if($child->attributes()){
//                            echo ($index).'---'.$child.'<br/>';
//                            array_push($options,$index);
//                        }
//                    }
//                }

            }
            return $result;
        }else{
            return false;
        }
    }

    private function parsing_to_quiz_html($parsing_string){
        if($parsing_string){
            $result = array();
            $xml = new SimpleXMLElement($parsing_string);
            $index = 0;
            array_push($result,'  <input type="hidden"  name="course" value="'.$this->course_code.'"> ');
            array_push($result,'  <input type="hidden"  name="quiz" value="'.$xml->attributes().'"> ');

            foreach ($xml->question as $key=>$children) {
                $index++;
                $string = '<h3>'.$index.'. '.$children->questionText.'</h3>';
                array_push($result,$string);

                if(strcmp($children->type,'text')==0){
                    $string = '
                           <div class="form-group">
                           <small id="id_s_'.$index.'" class="form-text text-muted">This question <strong>only accept text</strong> as answer. </small>
                            <input type="text" class="form-control" id="id_'.$index.'" name="q_'.$index.'" aria-describedby="emailHelp" placeholder="Enter text">
                          </div>';
                    array_push($result,$string);
                }
                else if(strcmp($children->type,'number')==0){
                    $string = '
                           <div class="form-group">
                           <small id="id_s_'.$index.'" class="form-text text-muted">This question <strong>only accept number</strong> as answer. </small>
                            <input type="number" class="form-control" id="id_'.$index.'" name="q_'.$index.'" aria-describedby="emailHelp" placeholder="Enter number">
                          </div>';
                    array_push($result,$string);
                }
                else if(strcmp($children->type,'radio')==0){
                    $sub_index=0;
                    $string ='<small id="id_s_'.$index.'" class="form-text text-muted">This question has <strong>only one</strong> correct answer.</small>';
                    array_push($result,$string);

                    foreach ($children->option as $child) {
                        $sub_index++;
                        $string ='<div class="custom-control custom-radio">
                                  <input type="radio" class="custom-control-input" value="'.$sub_index.'" id="q_'.$index.'_'.$sub_index.'" name="q_'.$index.'">
                                  <label class="custom-control-label" for="q_'.$index.'_'.$sub_index.'">'.$child.'</label>
                                </div>';
                        array_push($result,$string);
                    }
                }
                else if(strcmp($children->type,'checkbox')==0){
                    $sub_index=0;
                    $string ='<small id="id_s_'.$index.'" class="form-text text-muted">This question has <strong>multiple</strong> correct answers.</small>';
                    array_push($result,$string);

                    foreach ($children->option as $child) {
                        $sub_index++;
                        $string ='<div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="'.$sub_index.'" id="q_'.$index.'_'.$sub_index.'" name="q_'.$index.'[]">
                                    <label class="custom-control-label" for="q_'.$index.'_'.$sub_index.'">'.$child.'</label>
                                </div>';
                        array_push($result,$string);
                    }
                }
                $string = '<code>'.$children.'</code>';
                array_push($result,$string);

                foreach ($children->children() as $key=>$child) {
                    if($child->type){

                    }
                }
                array_push($result,'<hr/>');
            }
            return $result;
        }else{
            return false;
        }
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
            return false;
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
            return false;
        }
    }

    public function parsing_quiz($id){
        if($this->check_exist($this->course_code)){
            $sql = "SELECT * FROM `$this->course_code` WHERE `key_word` = 'quiz_".$id."';";
            $result = $this->db->query($sql);
            $eml ='';
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $eml = $row['eml'];
                }
                return $this->parsing_to_quiz_html($eml);
            } else {
                return false;
            }
        }else{
            echo "<h1 style='color: red'>This course is no longer exist.</h1>";
            return false;
        }
    }

    public function parsing_quiz_answer($id){
        if($this->check_exist($this->course_code)){
            $sql = "SELECT * FROM `$this->course_code` WHERE `key_word` = 'quiz_".$id."';";
            $result = $this->db->query($sql);
            $eml ='';
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $eml = $row['eml'];
                }
                return $this->parsing_to_quiz_answer($eml);
            } else {
                return false;
            }
        }else{
            echo "<h1 style='color: red'>This course is no longer exist.</h1>";
            return false;
        }
    }
}