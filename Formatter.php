<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/6
 * Time: 15:38
 */

namespace RealRap;
use RealRap\Exception\ModelFormatException;

class Formatter
{

    private $formats = ['string','bool','date','integer','float'];

    public function format($formatValue,$format){
        if(in_array(strtolower($format),$this->formats)){
            return call_user_func([self::class,$format.'fy'],$formatValue);
        }
        throw new ModelFormatException('TransferType '.$format.' is invalid',500,new \Exception());
    }

    private function stringfy($value){
        return (string) $value;
    }

    private function boolfy($value){
        return (bool) $value;
    }

    private function datefy($value){
        return date('Y-m-d H:i:s',strtotime($value));
    }

    private function integerfy($value){
        return intval($value);
    }

    private function floatfy($value){
        return floatval($value);
    }

}