<?php

namespace Modules\Charts\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Modules\Core\Http\Controllers\AdminController;

class ChartsController extends AdminController {

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index ()
    {




        $dateTypes = [
            'date-range' => [
                'label'      => 'Date Range',
                'attributes' => [
                    'class'            => 'input-group input-daterange',
                    'data-provide'     => 'datepicker',
                    'data-date-format' => 'dd M, yyyy',
                ],
                'input'      => [
                    'start' => ['placeholder' => 'Start Date'],
                    'end'   => ['placeholder' => 'End Date'],
                ],

            ],
        ];

        $elements = [
            'menu' => [
                'day'   => ['label' => 'Day', 'value' => Carbon::now()->startOfDay(),],
                'week'  => ['label' => 'Week', 'value' => Carbon::now()->startOfWeek(),],
                'month' => ['label' => 'Month', 'value' => Carbon::now()->startOfMonth(),],
            ],
            'form' => [
                'range' => [
                    'type' => 'date-range',
                ],
            ]
        ];

        return view('charts::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create ()
    {
        return view('charts::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Renderable
     */
    public function store ( Request $request )
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function show ( $id )
    {
        return view('charts::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function edit ( $id )
    {
        return view('charts::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Renderable
     */
    public function update ( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function destroy ( $id )
    {
        //
    }

}
