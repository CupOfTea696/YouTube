<?php namespace CupOfTea\YouTube\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model{
    protected $primaryKey = 'tokenID';
    
    protected $table;
    protected $fillable;
    
    public $timestamps = false;
    
    public function __construct(array $attributes = []){
        $this->userKey = ('\\' . Config::get('auth.model'))::getKeyName();
        $this->table = Config::get('youtube.table');
        $this->fillable = ['token', $this->userKey];
        
        parent::__construct($attributes);
    }
    
    public function user(){
        return $this->hasOne(('\\' . Config::get('auth.model')), $this->userKey, $this->userKey);
    }
}
