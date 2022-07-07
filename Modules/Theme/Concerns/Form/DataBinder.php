<?php

namespace Modules\Theme\Concerns\Form;

trait DataBinder {

	protected function modelBinding ($target): void
	{
		\Form::setModel($target);
	}

}