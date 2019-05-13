<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\News\Models\News;

class my extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'none';

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
    public function handle()
    {
        foreach(News::all() as $new){
            $new->forum_link = [
                'en' => $new->forum_link ? $new->forum_link : '',
                'ru' => $new->forum_link ? $new->forum_link : ''
            ];
            $new->save();
            $this->info($new->title);
        }
    }
}
