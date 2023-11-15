<?php
namespace App\Http\Helper;


class ResponseBuilder{
    public static function result($msg="" , $status="" , $data="" ){
        return [
            "success" => $status,
            "message" => $msg,
            "data" => $data
        ];
    }
}
?>
