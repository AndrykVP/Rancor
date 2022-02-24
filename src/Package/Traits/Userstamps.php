<?php

namespace Rancor\Package\Traits;

trait Userstamps
{
	public static function bootUserstamps()
	{
		// Update created_by column when model is created
		static::creating(function ($model) {
			if ($model->isClean('created_by')) {
				$model->created_by = auth()->user()->id;
			}
		});

		// Update updated_by column when model is updated
		static::updating(function ($model) {
			if ($model->isClean('updated_by')) {
				$model->updated_by = auth()->user()->id;
			}
		});
	}
}