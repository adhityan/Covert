<?php
include_once('application.php');

class DB {
    private static $db;

    private static function init() {
      if(!isset($db)) {
        global $_settings;
        self::$db = new mysqli($_settings['host'], $_settings['username'], $_settings['password'], $_settings['database'], $_settings['port']);
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
