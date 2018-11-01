<?php
namespace Reddevs\DjaLaraAdmin\Menu;


use Reddevs\DjaLaraAdmin\Contracts\Menu\RepositoryInterface;

class Repository implements RepositoryInterface
{

    protected $items = [];

    public function push($name, $items)
    {
        $this->items[$name] = $items;
    }

    public function getMenuByName($name)
    {
        return (isset($this->items[$name]) ? $this->items[$name]:[]);
    }

    public function pull()
    {
        return $this->items;
    }
}