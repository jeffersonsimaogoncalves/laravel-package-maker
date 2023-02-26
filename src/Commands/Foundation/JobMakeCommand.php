<?php

namespace JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation;

use Illuminate\Foundation\Console\JobMakeCommand as MakeJob;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Traits\CreatesPackageStubs;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Traits\HasNameInput;

class JobMakeCommand extends MakeJob
{
    use CreatesPackageStubs, HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:job';

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'src';
    }
}
