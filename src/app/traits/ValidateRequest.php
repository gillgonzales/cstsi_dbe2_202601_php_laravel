<?php

namespace Dbe2\Topico01\app\traits;

trait ValidateRequest{

    protected function validatePostRequest(array $fields):bool{
		foreach($fields as $field){
			if(!isset($_POST[$field])) return false;
            if($_POST[$field]=="") return false;
        }
		return true;
	}
}