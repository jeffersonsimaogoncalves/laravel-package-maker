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
     * @return int
     */
    protected function runConsoleCommand(string $command, string $path): int
    {
        $output = method_exists($this, 'getOutput') ? $this->getOutput() : false;
        $process = Process::fromShellCommandline($command, $path)->setTimeout(null);
        $process->setTty($process->isTtySupported());

        return $process->run(function ($type, $line) use ($output) {
            if ($output) {
                $output->write($line);
            }
        });
    }
}
