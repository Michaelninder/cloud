<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory, HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function files(): MorphToMany
    {
        return $this->morphedByMany(File::class, 'taggable');
    }

    public function folders(): MorphToMany
    {
        return $this->morphedByMany(Folder::class, 'taggable');
    }
}