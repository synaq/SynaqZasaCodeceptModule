<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 15/04/20
 * Time: 13:51
 */

namespace Codeception\Module;

use Codeception\Lib\Interfaces\MultiSession;
use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Codeception\TestCase;
use Synaq\CurlBundle\Curl\Wrapper;
use Synaq\ZasaBundle\Connector\ZimbraConnector;
use Synaq\ZasaBundle\Exception\SoapFaultException;

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

    /**
     * @var array
     */
    private $result;

    protected $requiredFields = array('server', 'admin_user', 'admin_pass');

    public function __construct(ModuleContainer $container, $config, ZimbraConnector $zasa = null)
    {
        if (!empty($zasa)) {
            $this->zasa = $zasa;
        } else {
            parent::__construct($container, $config);
            $this->_zasaCreate();
        }
    }

    public function getAccountFromZimbra($name)
    {
        $this->result = $this->zasa->getAccount($name);
    }

    public function modifyAccountOnZimbra($name, $attributes)
    {
        $accountId = $this->zasa->getAccountId($name);
        $this->result = $this->zasa->modifyAccount($accountId, $attributes);
    }

    public function getDistributionListFromZimbra($emailAddress)
    {
        $this->result = $this->zasa->getDl($emailAddress);
    }

    public function getDomainFromZimbra($domainName)
    {
        $this->result = $this->zasa->getDomain($domainName);
    }

    /**
     * @return array
     */
    public function grabResultFromZimbra()
    {

        return $this->result;
    }

    /**
     * @param array $subset Array subset to check for
     */
    public function seeResultFromZimbraContains(array $subset)
    {
        $this->assertTrue(($this->arrayIntersectAssocRecursive($subset, $this->result) == $subset),
            "I don't see that " . json_encode($this->result) . " contains " . json_encode($subset));
    }

    /**
     * @param array $subset Array subset that should not be present
     */
    public function dontSeeResultFromZimbraContains(array $subset)
    {
        $this->assertFalse(($this->arrayIntersectAssocRecursive($subset, $this->result) == $subset),
            "I see that " . json_encode($this->result) . " contains " . json_encode($subset));
    }

    public function _initialize()
    {
        $this->_initializeSession();
    }

    public function _before(TestCase $test) {
        $this->_initializeSession();
        $this->result = array();
    }

    public function _initializeSession()
    {
    }

    public function _backupSession()
    {
        return [
            'client'    => $this->client,
            'zasa'    => $this->zasa
        ];
    }

    public function _loadSession($data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }

    public function _closeSession($session = null)
    {
        unset($session);
    }

    private function _zasaCreate()
    {
        if (is_null($this->client))
        {
            $this->client = new Wrapper(null, false, true, false, array(
                'CURLOPT_RETURNTRANSFER' => true,
                'CURLOPT_SSL_VERIFYPEER' => false,
                'CURLOPT_SSL_VERIFYHOST' => false,
                'CURLOPT_SSLVERSION' => 1
            ));
        }

        if (is_null($this->zasa)) {
            $zasa = new ZimbraConnector($this->client,
                $this->config['server'],
                $this->config['admin_user'],
                $this->config['admin_pass']);

            $this->zasa = $zasa;
        }
    }

    /**
     * @param array $result
     */
    public function _setResult(array $result)
    {
        $this->result = $result;
    }

    /**
     * @author nleippe@integr8ted.com
     * @author tiger.seo@gmail.com
     * @link http://www.php.net/manual/en/function.array-intersect-assoc.php#39822
     *
     * @param mixed $arr1
     * @param mixed $arr2
     *
     * @return array|bool
     */
    private function arrayIntersectAssocRecursive($arr1, $arr2)
    {
        if (!is_array($arr1) || !is_array($arr2)) {
            return null;
        }

        $commonkeys = array_intersect(array_keys($arr1), array_keys($arr2));
        $ret = array();
        foreach ($commonkeys as $key) {
            $_return = $this->arrayIntersectAssocRecursive($arr1[$key], $arr2[$key]);
            if ($_return) {
                $ret[$key] = $_return;
                continue;
            }
            if ($arr1[$key] === $arr2[$key]) {
                $ret[$key] = $arr1[$key];
            }
        }
        if (empty($commonkeys)) {
            foreach ($arr2 as $arr) {
                $_return = $this->arrayIntersectAssocRecursive($arr1, $arr);
                if ($_return && $_return == $arr1) return $_return;
            }
        }

        return $ret;
    }

    public function createDomainOnZimbra($domainName)
    {
        $this->zasa->createDomain($domainName, ['zimbraDomainStatus' => 'active']);
    }

    public function deleteDomainOnZimbra($domainName)
    {
        $id = $this->zasa->getDomainId($domainName);
        $this->zasa->deleteDomain($id);
    }

    public function createMailboxOnZimbra($mailboxName, $password)
    {
        $this->zasa->createAccount($mailboxName, $password, ['sn' => $mailboxName]);
    }

    public function deleteMailboxOnZimbra($mailboxName)
    {
        $id = $this->zasa->getAccountId($mailboxName);
        $this->zasa->deleteAccount($id);
    }

    public function createAliasOnZimbra($mailboxAddress, $aliasAddress)
    {
        $id = $this->zasa->getAccountId($mailboxAddress);
        $this->zasa->addAccountAlias($id, $aliasAddress);
    }

    public function removeAliasOnZimbra($mailboxAddress, $aliasAddress)
    {
        $accountId = $this->zasa->getAccountId($mailboxAddress);
        $this->zasa->removeAccountAlias($accountId, $aliasAddress);
    }

    public function deleteDistributionListOnZimbra($dlEmailAddress)
    {
        $id = $this->zasa->getDlId($dlEmailAddress);
        $this->zasa->deleteDl($id);
    }

    public function createDistributionListOnZimbra($address, array $attributes, array $members)
    {
        $id = $this->zasa->createDl($address, $attributes, []);

        foreach ($members as $member) {
            $this->zasa->addDlMember($id, $member);
        }
    }

    /**
     * @param string $name
     * @param string $password
     * @param string $displayName
     * @param string $resourceType
     * @param array $otherAttributes
     * @throws SoapFaultException
     */
    public function createCalendarResourceOnZimbra($name, $password = null, $displayName = null, $resourceType = null, $otherAttributes = [])
    {
        $this->zasa->createCalendarResource('foo@bar.com', null, null, null, []);
    }
}