<?php

namespace AndrykVP\Rancor\Package\Traits;

use AndrykVP\Rancor\Audit\Traits\Auditable;
use AndrykVP\Rancor\Auth\Traits\HasPrivs;
use AndrykVP\Rancor\Structure\Traits\FactionMember;
use AndrykVP\Rancor\Forums\Traits\ForumUser;
use AndrykVP\Rancor\News\Traits\Newscaster;

trait RancorUser
{
    use Auditable, HasPrivs, FactionMember, ForumUser, Newscaster;
}
