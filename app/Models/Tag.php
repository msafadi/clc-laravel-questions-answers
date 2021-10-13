<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'tags';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'name', 'slug'
    ];

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'question_tag',
            'tag_id',
            'question_id',
            'id',
            'id'
        );
    }
}
