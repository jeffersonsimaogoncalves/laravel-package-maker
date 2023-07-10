<?php

namespace JeffersonSimaoGoncalves\LaravelPackageMaker\Traits;

use Symfony\Component\Process\Process;

trait InteractsWithTerminal
{
    /**
     * Run the given command as a process.
     *
     * @param string $command
     * @param string $path
     */
    protected function runConsoleCommand($command, $path)
    {
        $output = method_exists($this, 'getOutput') ? $this->getOutput() : false;
        $process = Process::fromShellCommandline($command, $path)->setTimeout(null);
        $process->setTty($process->isTtySupported());

        $process->run(function ($type, $line) use ($output) {
            if ($output) {
                $output->write($line);
            }
        });
    }
}
