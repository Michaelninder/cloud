<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Link extends Model
{
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'slug',
        'original_url',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function views()
    {
        return $this->hasMany(LinkView::class);
    }

    public function getViewCount()
    {
        return $this->views()->count();
    }
}