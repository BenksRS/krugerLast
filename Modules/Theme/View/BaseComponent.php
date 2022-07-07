<?php

namespace Modules\Theme\View;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Modules\Theme\Concerns\ManageTheme;

abstract class BaseComponent extends Component {

	use ManageTheme;

	public function render ()
	{
		$view = $this->viewComponent();

		return view("components.$view");
	}

	/**
	 * @return string
	 */
	protected function viewComponent ()
	{
		$alias = Str::after(get_class($this), '\\View\\Components\\');

		return collect(explode('\\', $alias))->map([Str::class, 'kebab'])->implode('.');
	}

	/**
	 * Converts a bracket-notation to a dotted-notation
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	protected function convertBracketsToDots (string $name): string
	{
		return rtrim(str_replace(['[', ']'], ['.', ''], $name), '.');
	}

}