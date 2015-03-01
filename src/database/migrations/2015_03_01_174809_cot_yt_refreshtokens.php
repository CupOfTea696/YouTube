<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CotYtRefreshtokens extends Migration {
    
    protected $table;
    protected $model;
    protected $userKey;
    
    public function __construct(){
        $this->table = Config::get('youtube::youtube.table');
        $this->model = Config::get('auth.model');
        $this->userKey = $this->model::getKeyName();
    }
    
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->table, function(Blueprint $table)
		{
			$table->increments('refreshTokenID');
			$table->string('token', 45);
            $table->integer($this->userKey)->unsigned();
			$table->foreign($this->userKey)
                  ->references($this->userKey)->on($this->model)
                  ->onDelete('cascade');
		});
	}
    
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->table);
	}
    
}
