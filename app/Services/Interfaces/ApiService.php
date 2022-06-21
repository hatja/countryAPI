<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

/**
 * Interface ApiService
 * @package App\Servcices\Interfaces\ApiService
 */
interface ApiService
{
  /**
   * Gets data from the API
   * @return array
   */
  public function getData(): array;

  /**
   * Sync data to database
   * @return Collection
   */
  public function sync(): Collection;
}
