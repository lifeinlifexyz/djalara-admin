<?php
namespace Reddevs\DjaLaraAdmin\Contracts\Menu;

interface LoaderInterface
{
    public function load(RepositoryInterface $repo);
}