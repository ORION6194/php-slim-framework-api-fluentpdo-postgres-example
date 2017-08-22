<?php

namespace KCTAPI\Models;

class BaseModel {
    public $updated_at;
    public $created_at;
    public $created_by;
    public $updated_by;
    public $record_status;
    
    public function __construct() {
        $cur_time = time();
        $this->updated_at = $cur_time*1000;
        $this->created_at = $cur_time*1000;
        $this->updated_by = '';
        $this->created_by = '';
        $this->record_status = 'A';
    }
    
    public function toObj($array){
        $object_vars = get_object_vars($this);
        foreach($array as $key=>$value){
            if(!array_key_exists($key, $object_vars)){
                continue;
            }
            $this->{$key} = $value;
        }
    }
}
