<?php

namespace RalphJSmit\Tall\Interactive\Commands;

use Illuminate\Console\Command;

class Tall\InteractiveCommand extends Command
{
    public $signature = 'tall-interactive';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
