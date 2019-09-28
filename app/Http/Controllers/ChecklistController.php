<?php

namespace App\Http\Controllers;

use App\Checklist;
use Illuminate\Http\Request;
use App\Http\Resources\ChecklistResource;
use App\Http\Resources\ChecklistCollection;

class ChecklistController extends Controller
{
	protected $type;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->type = 'checklists';
	}

	public function index(Request $request)
	{
		$data = Checklist::filter($request)->with('attributes')->paginate(10);

		return new ChecklistCollection($data);
	}

	public function show(Request $request, $id)
	{
		$data = Checklist::with('attributes')->find($id);

		return new ChecklistResource($data);
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'data'	=>	'required',
			'data.attributes'	=>	'required'
		]);

		try {
			\DB::beginTransaction();

			$checklist = Checklist::create([
				'type'	=>	$this->type
			]);
			$checklist->attributes()->create($request->data['attributes']);

			\DB::commit();

			return new ChecklistResource($checklist);
		} catch (\Throwable $th) {
			\DB::rollback();

			throw $th;
		}
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'data'	=>	'required',
			'data.attributes'	=>	'required'
		]);

		try {
			\DB::beginTransaction();

			$data = $request->except('data.attributes.created_at', 'data.attributes.updated_at')['data'];

			$checklist = Checklist::findOrFail($id);
			$checklist->attributes->update($data['attributes']);

			\DB::commit();

			return new ChecklistResource($checklist);
		} catch (\Throwable $th) {
			\DB::rollback();

			throw $th;
		}
	}

	public function destroy($id)
	{
		$checklist = Checklist::findOrFail($id);
		$checklist->delete();

		return response(null, 204);
	}
}
