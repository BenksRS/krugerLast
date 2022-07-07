<?php
namespace Modules\Component\View\Components\Form;
use Illuminate\View\Component;
class Text extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('component::components.form/text');
    }
}
