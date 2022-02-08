<?php

namespace AndrykVP\Rancor\Auth\Traits;

use AndrykVP\Rancor\SWC\Models\Planet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait RancorAttributes
{
    public function homeplanet(): BelongsTo
    {
        return $this->belongsTo(Planet::class, 'homeplanet_id');
    }

    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getOnlineTimeAttribute(Int $value): string
    {
        $string = '';

        $years = floor ($value / 525600);
        if($years > 0) $string .= $years . 'Y ';
        $value -= $years * 525600;
        
        $days = floor ($value / 1440);
        if($days > 0) $string .= $days . 'D ';
        $value -= $days * 1440;
        
        $hours = floor ($value / 60);
        if($hours > 0) $string .= $hours . 'H ';
        $value -= $hours * 60;
        
        $minutes = $value;
        if($minutes > 0) $string .= $minutes . 'M';

        return $string;
    }
}
