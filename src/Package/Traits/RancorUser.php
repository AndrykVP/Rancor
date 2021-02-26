<?php

namespace AndrykVP\Rancor\Package\Traits;

use AndrykVP\Rancor\Scanner\Traits\CanScan;
use AndrykVP\Rancor\News\Traits\Newscaster;
use AndrykVP\Rancor\Faction\Traits\FactionMember;
use AndrykVP\Rancor\Auth\Traits\HasPrivs;

trait RancorUser
{
   use CanScan, Newscaster, FactionMember, HasPrivs;
}
