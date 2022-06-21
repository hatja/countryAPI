<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;

class Capital extends Resource
{
  /**
   * The model the resource corresponds to.
   *
   * @var string
   */
  public static $model = \App\Models\Capital::class;


  public static function label()
  {
    return 'Városok';
  }

  public static function singularLabel()
  {
    return 'Város';
  }

  /**
   * The single value that should be used to represent the resource when being displayed.
   *
   * @var string
   */
  public static $title = 'name';

  /**
   * The columns that should be searched.
   *
   * @var array
   */
  public static $search = [
    'id', 'name', 'country',
  ];

  /**
   * Get the fields displayed by the resource.
   *
   * @param Request $request
   * @return array
   */
  public function fields(Request $request)
  {
    return [
      ID::make()->sortable(),

      Text::make('Város neve', 'name')
        ->sortable()
        ->rules('required', 'max:255'),

      Text::make('Ország', 'country')
        ->sortable()
        ->rules('required', 'min:2', 'max:254')
        ->creationRules('unique:capitals,country')
        ->updateRules('unique:capitals,country,{{resourceId}}'),

      DateTime::make('Módosítva', 'updated_at')
        ->hideWhenCreating()->hideWhenUpdating()
    ];
  }

  /**
   * Get the cards available for the request.
   *
   * @param Request $request
   * @return array
   */
  public function cards(Request $request)
  {
    return [];
  }

  /**
   * Get the filters available for the resource.
   *
   * @param Request $request
   * @return array
   */
  public function filters(Request $request)
  {
    return [];
  }

  /**
   * Get the lenses available for the resource.
   *
   * @param Request $request
   * @return array
   */
  public function lenses(Request $request)
  {
    return [];
  }

  /**
   * Get the actions available for the resource.
   *
   * @param Request $request
   * @return array
   */
  public function actions(Request $request)
  {
    return [];
  }
}
