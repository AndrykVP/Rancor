<?php

namespace Rancor\Scanner\Traits;

use Rancor\Audit\Models\EntryLog;

trait CanScan
{
	/**
	 * Relationship to Rank model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function scanlogs()
	{
		return $this->hasMany(EntryLog::class);
	}
}
