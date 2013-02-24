<?php

class ChatUser extends ChatBase{
	
	protected $name = '', $gravatar = '';
	
	public function save(){
		$table=basename(dirname(dirname(dirname(__FILE__))));
		$table_name_users = $table.'_users';
		DB::query("
			INSERT INTO $table_name_users (name, gravatar)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."'
		)");
		
		return DB::getMySQLiObject();
	}
	
	public function update(){
		$table=basename(dirname(dirname(dirname(__FILE__))));
		$table_name_users = $table.'_users';
		DB::query("
			INSERT INTO $table_name_users (name, gravatar)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."'
			) ON DUPLICATE KEY UPDATE last_activity = NOW()");
	}
}

?>