<?php

namespace App\Models;

class Careers extends Model{
    public $id;
    public $name;
    public $faculty;
    
    public function __construct($id, $name, $faculty){
        $this->id = $id;
        $this->name = $name;
        $this->faculty = $faculty;        
    }
}