<?php
include_once('application.php');

class DB {
    private static $db;

    private static function init() {
      if(!isset($db)) {
        self::$db = new mysqli('petunia.arvixe.com', 'zen', 'zencard101', 'zenmaster', 3306);
      }
    }

    public static function getDB() {
        self::init();
        return self::$db;
    }

    public static function prepare($stmt) {
        self::init();
        return $db::prepare($stmt);
    }

    public static function bind_result_array($stmt) {
        $meta = $stmt->result_metadata();
        
        $result = array();
        while ($field = $meta->fetch_field())
        {
            $result[$field->name] = NULL;
            $params[] = &$result[$field->name];
        }

        call_user_func_array(array($stmt, 'bind_result'), $params);
        return $result;
    }
}
?>
