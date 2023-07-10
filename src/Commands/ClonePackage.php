<?php

namespace JeffersonSimaoGoncalves\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Traits\InteractsWithTerminal;

class ClonePackage extends Command
{
    use InteractsWithTerminal;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:clone
                                {src : Source path of the package to clone}
                                {target : Path where it should be cloned in}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone a package to start building your own.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->files->isDirectory($target = $this->getTargetInput())) {
            $this->error($target . ' directory already exists!');
        }

        if ($this->srcIsRemote()) {
            $this->gitClone();
            return self::SUCCESS;
        }

        $this->localClone();

        return self::SUCCESS;
    }

    /**
     * Get the target path.
     *
     * @return string
     */
    public function getTargetInput(): string
    {
        return trim($this->argument('target'));
    }

    /**
     * Checks if source is remote.
     *
     * @return bool
     */
    public function srcIsRemote(): bool
    {
        return Str::contains($this->getSrcInput(), ['https', 'git@']);
    }

    /**
     * Get the src path.
     *
     * @return string
     */
    public function getSrcInput(): string
    {
        return trim($this->argument('src'));
    }

    /**
     * Clone package via git.
     */
    public function gitClone(): int
    {
        $result = $this->runConsoleCommand('git clone ' . $this->argument('src') . ' ' . $this->argument('target'), getcwd());

        if ($this->files->isDirectory($git = $this->getTargetInput() . '/.git')) {
            $this->files->deleteDirectory($git);

            $this->info('Removed .git folder.');
        }

        return $result;
    }

    /**
     * Clone local package.
     */
    public function localClone(): int
    {
        $successFull = $this->files->copyDirectory($this->getSrcInput(), $this->getTargetInput());

        if (!$successFull) {
            $this->error('Copying was not successFull!');
        }

        if ($this->files->isDirectory($vendor = $this->getTargetInput() . '/vendor')) {
            $this->files->deleteDirectory($vendor);

            $this->info('Removed vendor folder.');
        }

        $this->info('Cloning was successful!');

        return (int)$successFull;
    }
}
