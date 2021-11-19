<?php

namespace Readerstacks\Drive\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class FileManager extends Model
{
     
    
    use SoftDeletes;
    public $table="file_manager";
    
    protected $appends = ['humanDate'];


    public function getMetaDataAttribute($value){

        try{
            return json_decode($value);

        }
        catch(\Exception $e){
            return $value;
        }
    }
    public function getHumanDateAttribute($value){
        $date = Carbon::parse($this->attributes["created_at"])->diffForHumans();
        return $date;

    }
    public function user(){
        return $this->belongsTo(FileManagerUser::class);
    } 
    
}
