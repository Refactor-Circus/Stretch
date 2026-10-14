<?php

/**
 * Regenerates composer.local.json from composer.json, prepending a path
 * repository for every sibling package checkout (../<Repo>) ahead of the VCS
 * repositories so development installs symlink the local checkouts instead
 * of cloning git. Everything else is copied verbatim: the manifests must only
 * differ in where the custom packages are sourced from.
 *
 * Composer consults repositories in order, so a package with a local checkout
 * resolves from the path repository while anything without a sibling checkout
 * still falls back to its VCS repository.
 *
 * Use via the composer scripts, which point COMPOSER at the generated file:
 *
 *     composer local:install
 *     composer local:update
 *
 * composer.local.json and composer.local.lock are gitignored; the committed
 * composer.json (VCS-based) is what CI installs.
 */
$root = dirname(__DIR__);

$manifest = json_decode(file_get_contents($root.'/composer.json'), flags: JSON_THROW_ON_ERROR);

$repositories = $manifest->repositories ?? [];

$paths = [];

foreach ($repositories as $repository) {
    if (($repository->type ?? null) !== 'vcs') {
        continue;
    }

    $sibling = dirname($root).'/'.basename($repository->url, '.git');

    if (is_dir($sibling)) {
        $paths[] = [
            'type' => 'path',
            'url' => '../'.basename($sibling),
        ];
    }
}

$manifest->repositories = [...$paths, ...$repositories];

file_put_contents(
    $root.'/composer.local.json',
    json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL,
);

echo 'Regenerated composer.local.json ('.count($paths)." local path repositories)\n";
