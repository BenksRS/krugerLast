<?php

namespace Callkruger\Api\Commands;

use Callkruger\Api\Manager;
use Illuminate\Console\Command;

class DatabaseSyncCommand extends Command {

    protected $signature   = 'callkruger:sync {--watch}';

    protected $description = 'Synchronize the database with the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct ()
    {
        parent::__construct();
    }

    public function handle (Manager $manager)
    {
        $options = $this->options();
        if ( $options['watch'] ) {
            $manager->retrieve();
        } else {
            $manager->sync();
        }
    }

}
