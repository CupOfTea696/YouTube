<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CotYtRefreshtokens extends Migration {
    
    protected $tokenTable;
    protected $userTable;
    protected $userKey;
    
    public function __construct(){
        $userModel = Config::get('auth.model');
        $user = new $userModel;
        
        $this->tokenTable = Config::get('youtube.table');
        $this->userTable = Config::get('auth.table');
        $this->userKey = $user->getKeyName();
    }
    
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tokenTable, function(Blueprint $table)
		{
			$table->increments('refreshTokenID');
			$table->string('token', 45);
            $table->integer($this->userKey)->unsigned();
			$table->foreign($this->userKey)
                  ->references($this->userKey)->on($this->userTable)
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
		Schema::drop($this->tokenTable);
	}
    
}
