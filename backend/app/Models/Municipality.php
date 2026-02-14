<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trek;

class Municipality extends Model
{

   protected $fillable = [
      "name",
      "island_id",
      "zone_id",
   ];
   //
   public function treks()
   {
      return $this->hasMany(Trek::class);//un municipio puede tener muchos treks
   }
   public function zone()
   {
      return $this->belongsTo(Zone::class);//un municipio pertenece a una zona
   }
   public function island()
   {
      return $this->belongsTo(Island::class);//un municipio pertenece a una isla
   }
}
