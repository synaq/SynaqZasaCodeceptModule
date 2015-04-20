<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 15/04/20
 * Time: 13:51
 */

namespace Codeception\Module;

use Codeception\Lib\Interfaces\MultiSession;
use Codeception\Module;
use Codeception\TestCase;
use Synaq\CurlBundle\Curl\Wrapper;
use Synaq\ZasaBundle\Connector\ZimbraConnector;

/**
 * Class ZasaModule
 * @package Codeception\Module
 */
class ZasaModule extends Module implements MultiSession
{
    /**
     * @var Wrapper
     */
    private $client;

    /**
     * @var ZimbraConnector
     */
    private $zasa;

    protected $requiredFields = array('server', 'admin_user', 'admin_pass');

    /**
     * Get an account from Zimbra
     *
     * @param string $name The name of the account. e.g. example@example.com
     * @return array
     */
    public function getAccountFromZimbra($name)
    {

        return $this->zasa->getAccount($name);
    }

    public function _initialize()
    {
        $this->client = new Wrapper();
        $this->_initializeSession();
    }

    public function _before(TestCase $test) {
        $this->_initializeSession();
    }

    public function _initializeSession()
    {
        $zasa = new ZimbraConnector($this->client,
            $this->config['server'],
            $this->config['admin_user'],
            $this->config['admin_pass']);

        $this->_setZasa($zasa);
    }

    public function _backupSessionData()
    {
        return [
            'client'    => $this->client,
            'zasa'    => $this->zasa
        ];
    }

    public function _loadSessionData($data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }

    public function _closeSession($data)
    {
        unset($data);
    }

    /**
     * @param ZimbraConnector $zasa
     * @return ZasaModule
     */
    public function _setZasa(ZimbraConnector $zasa)
    {
        $this->zasa = $zasa;

        return $this;
    }
}