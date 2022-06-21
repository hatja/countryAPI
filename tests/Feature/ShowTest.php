<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test with valid id
   *
   * @return void
   */
  public function test_valid()
  {
    $this->artisan('api:sync');
    $id = \DB::table('capitals')->inRandomOrder()->first()->id;

    $response = $this->get('/api/capital/' . $id);
    $response
      ->assertStatus(200)
      ->assertJsonStructure([
        'data' => [
          'id',
          'name',
          'country'
        ]]);
  }

  /**
   * Test with valid id
   *
   * @return void
   */
  public function test_valid_with_other_header()
  {
    $this->artisan('api:sync');
    $id = \DB::table('capitals')->inRandomOrder()->first()->id;
    $response = $this->withHeaders([
      'Accept' => '*/*'
    ])->get('/api/capital/' . $id);
    $response
      ->assertStatus(200)
      ->assertJsonStructure([
        'data' => [
          'id',
          'name',
          'country'
        ]]);
  }

  /**
   * Test with invalid id
   *
   * @return void
   */
  public function test_invalid()
  {
    $this->artisan('api:sync');
    $id = 0;
    $response = $this->get('/api/capital/' . $id);
    $response
      ->assertNotFound();
  }

  /**
   * Test without id
   *
   * @return void
   */
  public function test_noid()
  {
    //$this->artisan('api:sync');
    $response = $this->get('/api/capital/');
    $response
      ->assertNotFound();
  }
}
