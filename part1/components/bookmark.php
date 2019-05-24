<?php


class Bookmark
{
    private $db;
    private $userId;

    public function __construct($db, $userId)
    {
        $this->db = $db;
        $this->userId = $userId;
    }

    public function get_top_ten()
    {
        $sql = 'SELECT url, COUNT(*) AS counts FROM bookmarks GROUP BY url ORDER BY counts DESC LIMIT 10;';
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
                return $result_array;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}