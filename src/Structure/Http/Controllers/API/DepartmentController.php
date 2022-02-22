<?php

namespace Rancor\Structure\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Rancor\Structure\Models\Department;
use Rancor\Structure\Http\Resources\DepartmentResource;
use Rancor\Structure\Http\Requests\DepartmentForm;
use Rancor\Structure\Http\Requests\DepartmentSearch;

class DepartmentController extends Controller
{    
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$query = Department::paginate(config('rancor.pagination'));

		return DepartmentResource::collection($query);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\Structure\Http\Requests\DepartmentForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(DepartmentForm $request)
	{
		$this->authorize('create',Department::class);
		
		$data = $request->validated();
		$department = Department::create($data);

		return response()->json([
			'message' => 'Department "'.$department->name.'" has been created'
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\Structure\Models\Department  $department
	 * @return \Illuminate\Http\Response
	 */
	public function show(Department $department)
	{
		$this->authorize('view', $department);

		return new DepartmentResource($department->load('faction','ranks'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Structure\Http\Requests\DepartmentForm  $request
	 * @param  \Rancor\Structure\Models\Department  $department
	 * @return \Illuminate\Http\Response
	 */
	public function update(DepartmentForm $request, Department $department)
	{
		$this->authorize('update', $department);
		
		$data = $request->validated();
		$department->update($data);

		return response()->json([
			'message' => 'Department "'.$department->name.'" has been updated'
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Rancor\Structure\Models\Department  $department
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Department $department)
	{
		$this->authorize('delete', $department);
		
		$department->delete();

		return response()->json([
			'message' => 'Department "'.$department->name.'" has been deleted'
		], 200);        
	}

	/**
	 * Display the results that match the search query.
	 *
	 * @param  \Rancor\Structure\Http\Requests\DepartmentSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(DepartmentSearch $request)
	{
		$this->authorize('viewAny',Department::class);
		$search = $request->validated();
		$departments = Department::where($search['attribute'], 'like', '%' . $search['value'] . '%')
						->paginate(config('rancor.pagination'));

		return DepartmentResource::collection($departments);
	}
}