<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearDeletedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清除已刪除工作';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jobs = Job::onlyTrashed()->get();
        foreach($jobs as $job){
            $job->forceDelete();
        }
        Log::info('移除所有被刪除職缺');

        return;
    }
}
