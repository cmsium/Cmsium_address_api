<?php
class ErrorHandler {

    /**
     * Throw custom exception
     * @param $exception array Exception name(constant)
     */
    public static function throwException($exception){
        header('App-Exception: '.$exception['code']);
        ob_clean();
        exit;
    }

    public static function throwExceptionByCode($code){
        header('App-Exception: '.$code);
        ob_clean();
        exit;
    }

}