<?php

namespace App\Services;

use App\Services\Interfaces\ApiService as ApiInterface;
use App\Models\Capital;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;
use App\Exceptions\NoConnectionException;

class ApiService implements ApiInterface
{

  /**
   * @inheritDoc
   */
  public function getData(): array
  {
    $client = new Client();
    $capitalDataArray = [];
    try {
      $apiResponse = $client->get('http://restcountries.com/v3.1/region/europe');
      $apiResponseDataArray = json_decode($apiResponse->getBody()->getContents(), true);
      if (!$apiResponseDataArray || empty($apiResponseDataArray)) {
        throw new NoConnectionException('Cant reach the API');
      }
      foreach ($apiResponseDataArray as $apiResponseDataItem) {
        //ASSUMING NONE IS NULL
        $capitalDataArray[] = [
          'country' => $apiResponseDataItem['name']['common'],
          'name' => array_pop($apiResponseDataItem['capital'])
        ];
      }
    } catch (\Exception $e) {
      \Log::info('ERROR HAPPENED DURING API CONNECTION');
      \Log::info($e->getMessage());
      //...
    }
    return $capitalDataArray;
  }

  /**
   * @inheritDoc
   */
  public function sync(): Collection
  {
    Capital::truncate();
    $capitalArrayToSync = $this->getData();
    $returnCollection = collect();
    foreach ($capitalArrayToSync as $capitalData) {
      $capital = Capital::create($capitalData);
      $returnCollection->push($capital);
    }

    return $returnCollection;
  }

}
