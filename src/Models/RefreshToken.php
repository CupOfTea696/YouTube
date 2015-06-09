<?php namespace CupOfTea\YouTube\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model{
    
    protected $table;
    protected $fillable;
    protected $userKey;
    
    public $timestamps = false;
    
    public function __construct(array $attributes = []){
        $model = '\\' . Config::get('auth.model');
        
        $this->userKey = (new $model)->getKeyName();
        $this->table = Config::get('youtube.table');
        $this->fillable = ['token', $this->userKey];
        
        parent::__construct($attributes);
    }
    
    public function user(){
        return $this->hasOne(('\\' . Config::get('auth.model')), $this->userKey, 'user_id');
    }
}
