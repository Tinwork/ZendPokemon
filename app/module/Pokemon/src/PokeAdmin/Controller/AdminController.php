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

    /**
     * Render all admins
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function show()
    {
        return $this->renderJson($this->adminService->getCollection());
    }

    /**
     * Render admin by id
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function view()
    {
        /** @var int $userId */
        $userId = $this->params()->fromRoute('id');
        if (!isset($userId)) {
            return $this->show();
        }
        /** @var array $response */
        $response = $this->adminService->getAdmin($userId);

        return $this->renderJson($response);
    }

    /**
     * Create new admin
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function create()
    {
        /** @var string $data */
        $data = $this->request->getContent();
        /** @var array $response */
        $response = $this->adminService->createAdmin($data);

        return $this->renderJson($response);
    }

    /**
     * Update admin by id
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function update()
    {
        die('update');
    }

    /**
     * Destroy admin by id
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function destroy()
    {
        /** @var int $userId */
        $userId = $this->params()->fromRoute('id');
        /** @var array $response */
        $response = $this->adminService->deleteAdmin($userId);

        return $this->renderJson($response);
    }
}