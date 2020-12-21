<?php

namespace AndrykVP\Rancor\Package\Traits;

use AndrykVP\Rancor\Auth\Traits\HasPrivs;
use AndrykVP\Rancor\Faction\Traits\FactionMember;
use AndrykVP\Rancor\Forums\Traits\ForumUser;
use AndrykVP\Rancor\News\Traits\Newscaster;

trait RancorUser
{
    use HasPrivs, FactionMember, ForumUser, Newscaster;
}
