<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test as valid
   *
   * @return void
   */
  public function test_index()
  {
    $this->artisan('api:sync');
    $count = \DB::table('capitals')->count();
    $response = $this->get('/api/capitals');
    $response
      ->assertStatus(200)
      ->assertJsonCount($count, 'data');
  }

  /**
   * Test with other header
   *
   * @return void
   */
  public function test_index_with_other_header()
  {
    $this->artisan('api:sync');
    $count = \DB::table('capitals')->count();

    $response = $this->withHeaders([
      'Accept' => '*/*'
    ])->get('/api/capitals');
    $response
      ->assertStatus(200)
      ->assertJsonCount($count, 'data');
  }
}
