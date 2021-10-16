<?php

namespace AndrykVP\Rancor\Auth\Traits;

trait SplitName
{
    /**
     * Get Name attribute from first_name and last_name columns
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
