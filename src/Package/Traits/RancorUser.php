<?php

namespace Rancor\Package\Traits;

use Rancor\Audit\Traits\Auditable;
use Rancor\Auth\Traits\AuthRelations;
use Rancor\Auth\Traits\RancorAttributes;
use Rancor\Structure\Traits\FactionMember;
use Rancor\Forums\Traits\ForumUser;
use Rancor\Scanner\Traits\CanScan;

trait RancorUser
{
	use Auditable, AuthRelations, FactionMember, ForumUser, CanScan, RancorAttributes;
}
