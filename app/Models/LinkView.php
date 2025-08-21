<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkView extends Model
{
    use HasUuid;

    protected $table = 'link_views';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'link_id',
        'ip_address',
        'user_agent',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}