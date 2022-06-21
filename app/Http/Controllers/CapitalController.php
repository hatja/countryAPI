<?php

namespace App\Http\Controllers;

use App\Http\Resources\Capital as CapitalResource;
use App\Http\Requests\CapitalUpdateRequest;
use App\Models\Capital;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CapitalController extends Controller
{
  /**
   * @return AnonymousResourceCollection
   */
  public function index(): AnonymousResourceCollection
  {
    return CapitalResource::collection(Capital::all());
  }

  /**
   * @param int $id
   * @return CapitalResource
   */
  public function show(int $id): CapitalResource
  {
    return new CapitalResource(Capital::findOrFail($id));
  }

  /**
   * @param CapitalUpdateRequest $request
   * @param int $id
   * @return CapitalResource
   */
  public function update(CapitalUpdateRequest $request, int $id): CapitalResource
  {
    $capital = Capital::findOrFail($id);
    $validData = $request->validated();
    $capital->update($validData);

    return new CapitalResource($capital);
  }


  /*
   * WITHOUT FORCED JSON HEADER
   */
  /*  public function update(Request $request, int $id): CapitalResource
    {
      $capital = Capital::findOrFail($id);
      $requestData = $request->only(['country', 'name']);
      $validator = \Validator::make($requestData, [
        'name' => 'required|string|min:2|max:255',
        'country' => 'required|string|min:2|max:255|unique:capitals,country,'.$id
      ]);
      if($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
      }

      $capital->update($requestData);

      return new CapitalResource($capital);
    }*/
}
