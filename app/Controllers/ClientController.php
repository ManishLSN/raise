<?php

namespace App\Controllers;

use App\Facades\RequestFacade;
use App\Facades\SecurityFacade;
use App\Managers\DatabaseManager;
use App\Managers\ResponseManager;
use App\Models\Response\TokenResponse;
use Koine\QueryBuilder\Statements\Select;

/**
 * Class ClientController.
 */
class ClientController extends BaseController
{
    /**
     * Register Process.
     *
     * @return void
     */
    public function register()
    {
        if (($mappedModel = SecurityFacade::validateBody('client', RequestFacade::body())) == false) {
            ResponseManager::get()->setResponse(400, 'Missing required Parameters');

            return;
        }

        ResponseManager::get()->setResponseModel(200, new TokenResponse(), [
            'message' => 'Client Registered Successfully',
            'token'   => SecurityFacade::insertToken(DatabaseManager::getConnection()->insert('client', $mappedModel)),
        ]);
    }

    /**
     * List Process.
     *
     * @param string     $modelName
     * @param array|null $list
     */
    public function list(string $modelName = null, array $list = null)
    {

        if(RequestFacade::headers('name') || RequestFacade::headers('processor') || RequestFacade::headers('channel') || RequestFacade::headers('tag') || RequestFacade::headers('limit') || RequestFacade::headers('order') || RequestFacade::headers('interval')){
            this->filter();
        }

        $list = DatabaseManager::getConnection()->select('client', new Select());

        parent::list('client', $list);
    }

    /**
     * Filter Input Data.
     *
     * @param Select|null $query
     *
     * @return Select
     */
    protected function filter(Select $query = null)
    {
        $query = new Select();

        return parent::filter($query);
    }
}
