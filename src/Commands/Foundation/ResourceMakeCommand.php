<?php

namespace JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation;

use Illuminate\Foundation\Console\ResourceMakeCommand as MakeResource;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Traits\CreatesPackageStubs;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Traits\HasNameInput;

class ResourceMakeCommand extends MakeResource
{
    use CreatesPackageStubs, HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:resource';

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
