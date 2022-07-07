<?php

namespace CallKruger\BladeComponents\Concerns\Form;

trait DataBinder {

	protected function modelBinding ($target): void
	{
		\Form::setModel($target);
	}

}