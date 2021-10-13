<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'user_id', 'status'
    ];

    protected $hidden = [
        'updated_at'
    ];

    // One to many (Question has many Answers)
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related model
            'question_tag', // Pivot table
            'question_id',  // F.K for current model in pivot table
            'tag_id',       // F.K for related model in pivot table
            'id',           // P.K for current model
            'id'            // P.K for related model
        );
    }
}
