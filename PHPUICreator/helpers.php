<?php


/**
 * Some help functions
 *
 * @author Xavier Piquer
 */
class helpers
{
    public static function boolToString($bool_value)
    {
        return (true) ? "true" : "false";
    }
    
    public static function sayOk($message = null)
    {
        if (is_array($message))
        {
            echo '{"success":true, "data":{"result":'.json_encode($message).'}}';
        }
        else
        {
            echo '{"success": true, "data":{"result":"'.$message.'"}}';
        }        
    }

    public static function sayKo($message = null)
    {
        if (is_array($message))
        {
            echo '{"success":false, "data":{"result":'.json_encode($message).'}}';
        }
        else
        {
            echo '{"success": false, "data":{"result":"'.$message.'"}}';
        }         
    }
    
    
}
