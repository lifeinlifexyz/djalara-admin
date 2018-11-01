<?php
namespace Reddevs\DjaLaraAdmin\Menu;



use Reddevs\DjaLaraAdmin\Contracts\Menu\LoaderInterface;
use Reddevs\DjaLaraAdmin\Contracts\Menu\RepositoryInterface;

class Manager
{
    private $isLoaded = false;
    protected $loaders = [];

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function addLoader(LoaderInterface $loader)
    {
        $this->loaders[] = $loader;
        return $this;
    }

    public function forseLoad()
    {
        foreach($this->loaders as $loader) {
            $loader->load($this->repository);
        }
        return $this;
    }

    public function load()
    {
        if (!$this->isLoaded) {
            $this->forseLoad();
            $this->isLoaded = true;
        }
        return $this;
    }

    public function render($menuName, $viewName = 'djalara-admin::menu.menu')
    {
        $this->load();
        $menuItems = $this->repository->getMenuByName($menuName);
        return view($viewName, ['items' => $menuItems])->render();
    }

    /**
     * @param RepositoryInterface $repository
     * @return MenuManager
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
        return $this;
    }

    public function get($name)
    {
        $this->load();
        return $this->repository->getMenuByName($name);
    }
}