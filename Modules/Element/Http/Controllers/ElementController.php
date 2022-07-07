<?php

namespace Modules\Element\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Addons\Entities\Referral\Referral;

class ElementController extends Controller {

	/**
	 * Display a listing of the resource.
	 * @return Renderable
	 */
	public function index (Referral $referral)
	{

		$collections = $referral->find(1);
		dump($collections->authorizations()->attach([

			['authorization_id' => 4, 'active' => 'Y'],
			['authorization_id' => 5, 'active' => 'Y'],
			['authorization_id' => 5, 'active' => 'N'],
		])
		/*	->createMany([
				['authorization_id' => 4, 'active' => 'Y'],
			])*/
		);

/*		dump($collections
			->collections22()
			->createMany([
				['authorization_id' => 4, 'active' => 'Y'],
			])
		);*/

		return;
		$phones = [
			['collect_id' => 6, 'contact' => 'Felipe', 'phone' => '(954) 683-8797', 'preferred' => 'N'],
			['collect_id' => 6, 'contact' => 'Nadal', 'phone' => '(954) 999-9999', 'preferred' => 'Y']
		];

		$notes = [
			['collect_id' => 1, 'text' => 'Test1'],
			['collect_id' => 1, 'text' => 'Test2'],
			['collect_id' => 2, 'text' => 'Test3'],
			['collect_id' => 3, 'text' => 'Test4'],
		];

		$authorizations = [
			['collect_id' => 1, 'authorization_id' => 1, 'active' => 'Y'],
			['collect_id' => 2, 'authorization_id' => 2, 'active' => 'Y'],
			['collect_id' => 3, 'authorization_id' => 3, 'active' => 'Y'],
			['collect_id' => 1, 'authorization_id' => 3, 'active' => 'Y'],
			['collect_id' => 4, 'authorization_id' => 4, 'active' => 'Y'],
			['collect_id' => 1, 'authorization_id' => 4, 'active' => 'Y'],
			['collect_id' => 1, 'authorization_id' => 5, 'active' => 'Y'],
			['collect_id' => 5, 'authorization_id' => 5, 'active' => 'Y'],
		];

		$ids = collect($notes);

		/*		dd($referral->find(2)->phones()->getKey(), $referral->authorizations());*/
		/*		dd($referral->find(2)->phones2()->sync([1]));*/
		/*		dump($referral->syncCollection('notes', $notes), $ids);*/
		/*		dump($referral->collection('phones')->sync($phones));*/

		$referral->collection('authorizations')->sync($authorizations);

		return;

		return view('element::index');

		$re = $referral->find(2);

		/*		$referral->with(['authorizations'])->find(2)->authorizations()->createMany([
					['authorization_id' => 3, 'active' => 'Y'],
				]);*/
		/*
				$referral->with(['authorizations'])->find(1)->authorizations()->createMany([
					['authorization_id' => 1, 'active' => 'Y'],
					['authorization_id' => 3, 'active' => 'Y'],
					['authorization_id' => 4, 'active' => 'Y'],
					['authorization_id' => 5, 'active' => 'Y'],
				]);

				$referral->with(['authorizations'])->find(2)->authorizations()->createMany([
					['authorization_id' => 2, 'active' => 'Y'],
				]);

				$referral->with(['authorizations'])->find(3)->authorizations()->createMany([
					['authorization_id' => 3, 'active' => 'Y'],
				]);

				$referral->with(['authorizations'])->find(4)->authorizations()->createMany([
					['authorization_id' => 4, 'active' => 'Y'],
				]);

				$referral->with(['authorizations'])->find(5)->authorizations()->createMany([
					['authorization_id' => 5, 'active' => 'Y'],
				]);*/

		$auth = $re->authorizations();
		$auth->sync([
			1 => ['active' => 'Y'],
		]);

		dump($re->toArray());

		return;

		$text     = ' 4 md-8';
		$maskared = preg_replace('/[^A-Za-z0-9 ]+/', '-', trim($text));

		/*		$referral = $referral->all();
				$referral->loadMissing(['type', 'phones', 'notes', 'authorizations', 'carriers']);*/

		/*		$authorization = $authorization->all();
				$authorization->loadExists(['referrals']);*/

		/*		$assignment =  $assignment->all();
				$assignment->loadMissing(['referral', 'carrier', 'authorizations', 'job_types', 'user_created', 'user_updated']);

				dump($assignment->toArray());*/

		/*		dump($maskared);*/
		/*return view('element::index');*/
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Renderable
	 */
	public function create ()
	{
		return view('element::create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 *
	 * @return Renderable
	 */
	public function store (Request $request)
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
	public function show ($id)
	{
		return view('element::show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 *
	 * @return Renderable
	 */
	public function edit ($id)
	{
		return view('element::edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int     $id
	 *
	 * @return Renderable
	 */
	public function update (Request $request, $id)
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
	public function destroy ($id)
	{
		//
	}

}
