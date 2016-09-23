<?php
/**
 * Created by PhpStorm.
 * User: wugang
 * Date: 16/9/7
 * Time: 13:31
 */

namespace RealRap;


use RealRap\Traits\RealRapDatabase;

class RealRap
{

    use RealRapDatabase;


    /**
     * Transaction
     * @param \Closure $closure
     * @param \Closure $success
     * @param \Closure|null $failed
     */
    public static function trans(\Closure $closure, \Closure $success, \Closure $failed = null){
        $realRap = new RealRap();
        $realRap->db->trans_start();
        $closure();
        $realRap->db->trans_complete();
        if($realRap->db->trans_status() == false){
            $realRap->db->trans_rollback();
            $failed();
        }else{
            $success();
        }
    }

}