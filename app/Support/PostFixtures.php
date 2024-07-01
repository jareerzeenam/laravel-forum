<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class PostFixtures
{
    private  static Collection $fixtures;
    public static function getFixture(): Collection
    {
        return collect(File::files(database_path('factories/fixtures/posts')))
            ->map(fn(SplFileInfo $fileInfo) => $fileInfo->getContents())
            ->map(fn(string $contents) => str($contents)->explode("\n", 2))
            ->map(fn(Collection $parts) => [
                'title' => str($parts[0])->trim()->after('# '),
                'body' => str($parts[1])->trim(),
            ]);
    }
}
