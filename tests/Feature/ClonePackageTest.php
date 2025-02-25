<?php

namespace JeffersonSimaoGoncalves\LaravelPackageMaker\Tests\Feature;

use JeffersonSimaoGoncalves\LaravelPackageMaker\Tests\TestCase;

class ClonePackageTest extends TestCase
{
    /** @test */
    public function it_can_clone_local_packages()
    {
        $src = './tests/Support/package';
        $target = './tests/Support/local-package-clone';

        $this->artisan('package:clone', [
            'src' => $src,
            'target' => $target,
        ])->assertSuccessful();

        $this->assertTrue($this->files->isDirectory($target));
        $this->assertTrue($this->files->isDirectory($target . '/src'));
        $this->assertEquals(count($this->files->allFiles($target, true)), count($this->files->allFiles($src, true)));

        $this->files->deleteDirectory($target);
    }

    /** @test */
    public function it_can_clone_git_repositories()
    {
        $src = 'https://github.com/jeffersonsimaogoncalves/laravel-package-maker.git';
        $target = './tests/Support/git-package-clone';

        $this->artisan('package:clone', [
            'src' => $src,
            'target' => $target,
        ])->assertSuccessful();
        $this->assertTrue($this->files->isDirectory($target));
        $this->assertEquals(
            count($this->files->allFiles($target . '/src', true)),
            count($this->files->allFiles('./src', true))
        );

        $this->files->deleteDirectory($target);
    }
}
