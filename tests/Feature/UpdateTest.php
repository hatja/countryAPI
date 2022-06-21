<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{

  use RefreshDatabase, WithFaker;

  /**
   * Test with valid data
   *
   * @return void
   */
  public function test_valid()
  {
    $this->artisan('api:sync');
    $id = \DB::table('capitals')->inRandomOrder()->first()->id;
    $updateData = [
      "name" => $this->faker->word(),
      "country" => $this->faker->word()
    ];
    $url = '/api/capital/' . $id;
    $response = $this->json('POST', $url, $updateData);

    $response->assertStatus(200)
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
  public function test_invalid_id()
  {
    $this->artisan('api:sync');
    $id = 0;
    $updateData = [
      "name" => $this->faker->word(),
      "country" => $this->faker->word()
    ];
    $url = '/api/capital/' . $id;
    $response = $this->json('POST', $url, $updateData);

    $response->assertNotFound();
  }

  /**
   * Test with invalid id
   *
   * @return void
   */
  public function test_empty_data()
  {
    $this->artisan('api:sync');
    $id = 0;
    $updateData = [
      "name" => "",
      "country" => ""
    ];
    $url = '/api/capital/' . $id;
    $response = $this->json('POST', $url, $updateData);

    $response->assertStatus(422);
  }

  /**
   * Test with invalid id
   *
   * @return void
   */
  public function test_unique()
  {
    $this->artisan('api:sync');
    $idToUpdate = 2;
    $objA = \DB::table('capitals')->find(1);
    $updateData = [
      "name" => $objA->name,
      "country" => $objA->country
    ];
    $url = '/api/capital/' . $idToUpdate;
    $response = $this->json('POST', $url, $updateData);

    $response->assertStatus(422);
  }

  /**
   * Test with invalid id
   *
   * @return void
   */
  public function test_unique_self()
  {
    $this->artisan('api:sync');
    $objA = \DB::table('capitals')->find(1);
    $idToUpdate = 1;
    $updateData = [
      "name" => $this->faker->city(),
      "country" => $objA->country
    ];
    $url = '/api/capital/' . $idToUpdate;
    $response = $this->json('POST', $url, $updateData);

    $response->assertStatus(200)
      ->assertJsonStructure([
        'data' => [
          'id',
          'name',
          'country'
        ]]);
  }
}
