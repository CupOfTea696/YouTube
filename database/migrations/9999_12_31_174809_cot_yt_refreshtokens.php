<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CotYtRefreshtokens extends Migration
{
    protected $tokenTable;
    protected $userTable;
    protected $userKey;
    
    public function __construct()
    {
        $userModel = config('auth.model');
        $user = new $userModel;
        
        $this->tokenTable = config('youtube.table');
        $this->userTable = config('auth.table');
        $this->userKey = $user->getKeyName();
    }
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tokenTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 45);
            if (config('youtube.integration.youtube_id_as_primary_key')) {
                $table->string('user_id', 24);
            } else {
                $table->integer('user_id')->unsigned();
            }
            $table->foreign('user_id')
                  ->references($this->userKey)->on($this->userTable)
                  ->onUpdate('cascade')
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
