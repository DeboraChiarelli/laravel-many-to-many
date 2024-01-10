<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image_path', 'description', 'type_id'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    // Aggiungo la funzione con cui il modello Project sarà adesso in grado di recuperare le tecnologie associate a un progetto 
    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
