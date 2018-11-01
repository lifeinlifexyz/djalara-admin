<?php

namespace Reddevs\DjaLaraAdmin\Contracts\Menu;

interface RepositoryInterface
{
    public function push($name, $items);

    public function getMenuByName($name);

    public function pull();
}