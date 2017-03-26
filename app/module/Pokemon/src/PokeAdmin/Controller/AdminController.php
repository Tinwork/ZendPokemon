<?php

/**
 * Class AdminController
 *
 * @package             Pokemon\PokeAdmin\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Controller;

use Pokemon\Common\Controller\AbstractController;
use Pokemon\PokeAdmin\Strategy\AdminServiceStrategy;

class AdminController extends AbstractController
{
    /** @var AdminServiceStrategy $adminService */
    protected $adminService;

    /**
     * AdminController constructor.
     * @param AdminServiceStrategy $service
     */
    public function __construct(AdminServiceStrategy $service)
    {
        $this->adminService = $service;
    }

    public function show()
    {

    }

    public function view()
    {
        /** @var int $userId */
        $userId = $this->params()->fromRoute('id');
        /** @var array $admins */
        $admins = $this->adminService->getCollection();

        return $this->renderJson([
            "collection" => $admins
        ]);
    }

    public function create()
    {
        die('create');
    }

    public function update()
    {
        die('update');
    }

    public function destroy()
    {
        die('destroy');
    }
}