<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapitalUpdateRequest extends FormRequest
{

  /**
   * @return bool
   */
  public function expectsJson(): bool
  {
    return true;
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $id = $this->id;
    return [
      'name' => 'required|string|min:2|max:255',
      'country' => 'required|string|min:2|max:255|unique:capitals,country,' . $id
    ];
  }

}
