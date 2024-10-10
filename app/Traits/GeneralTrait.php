<?php

namespace App\Traits;

trait GeneralTrait
{
    public function buildResponse($data=null,$type=null,$message=null,$status=null){
        $array=[
            'data'=>$data,
            'type'=>$type,
            'message'=>$message,
            'status'=>$status
        ];

        return response($array,$status);
    }
}
