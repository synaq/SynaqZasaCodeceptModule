<?php

namespace Codeception\Module\Tests;

use Synaq\ZasaBundle\Exception\SoapFaultException;

class GetFilterRulesFromZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     * @throws SoapFaultException
     */
    public function callsGetFilterRulesOnZimbraConnectorOnce()
    {
        $this->module->getFilterRulesFromZimbra(null);
        $this->zasa->shouldHaveReceived('getFilterRules')->once();
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function getFilterRulesForTheGivenAccount()
    {
        $this->module->getFilterRulesFromZimbra('foo@bar.com');
        $this->zasa->shouldHaveReceived('getFilterRules')->with('foo@bar.com');
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function acceptsAnyAccountName()
    {
        $this->module->getFilterRulesFromZimbra('bar@baz.com');
        $this->zasa->shouldHaveReceived('getFilterRules')->with('bar@baz.com');
    }
}
