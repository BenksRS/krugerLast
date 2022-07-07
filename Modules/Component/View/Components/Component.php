<?php

namespace Modules\Component\View\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponet;

abstract class Component extends BaseComponet {

	/**
	 * @var string
	 */
	protected string $reference = 'component';

	/**
	 * @var string
	 */
	protected string $viewName;

	public function __construct ()
	{
		$this->setViewName();
	}

	public function render ()
	{
		$views = [
			'theme'   => "$this->viewName",
			'module'  => "$this->reference::$this->viewName",
			'default' => "$this->reference::default"
		];

		return View::first($views);
	}

	protected function setViewName ()
	{
		$component = Str::of(get_class($this))->after('\\View\\Components\\');
		$component = Str::of($component)->explode('\\')->map([Str::class, 'kebab'])->implode('.');

		$this->viewName = "components.$component";
	}

}