<?php

namespace Rancor\Auth\Traits;

<<<<<<< HEAD
use Rancor\SWC\Models\Planet;

trait RancorAttributes
{
	/**
	 * Relationship to Planet model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function homeplanet()
	{
		return $this->belongsTo(Planet::class, 'homeplanet_id');
	}

	/**
	 * Get Name attribute from first_name and last_name columns
	 * 
	 * @return string
	 */
	public function getNameAttribute()
	{
		return "{$this->first_name} {$this->last_name}";
	}

	/**
	 * Get value of online_time column into readable format
	 * 
	 * @param int  $value
	 * @return string
	 */
	public function getOnlineTimeAttribute($value)
	{
		$string = '';
=======
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
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

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
