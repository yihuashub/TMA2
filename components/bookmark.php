<?php


class Bookmark
{
    private $db;
    private $userId;
    public function __construct($db,$userId){
        $this->db        = $db;
        $this->userId    = $userId;
    }
    public function get_top_ten() {
        $sql = 'SELECT url, COUNT(*) AS counts FROM bookmarks GROUP BY url ORDER BY counts DESC LIMIT 10;';
        $result = $this->db->query($sql);

        $result_array = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($result_array,$row);
            }
            return $result_array;
        }
        else{
            return false;
        }
    }
}