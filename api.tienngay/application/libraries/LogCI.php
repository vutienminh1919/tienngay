<?php

class LogCI {

    public static function message($chanel, $msg) { //here overriding
        /* HERE YOUR LOG FILENAME YOU CAN CHANGE ITS NAME */
        $filename = '/log-'.date('Y-m-d').'.log';
        $path = 'application/logs/'.$chanel;
        if( is_dir($path) === false ){
            mkdir($path);
        }
        $filepath = $path . $filename;
        chmod($path, 0777);
        if ( ! $fp = fopen($filepath, 'a'))
        {
            return FALSE;
        }
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        $message = '['.date("Y-m-d H:i:s").'] '.session_id().' ' . basename($caller['file']) . ' Line:' . $caller['line'] . ' ' . $msg . PHP_EOL;

        fwrite($fp, $message);
        fclose($fp);
        return TRUE;
    }
}