<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiService;

class SyncCapitals extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'api:sync';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Syncing data via API';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle(ApiService $service)
  {
    $this->info($this->description);

    $service->sync();
    $count = Capital::count();
    $this->info($count . ' CAPITALS SYNCED');
    //dd($capitalData);

  }
}
