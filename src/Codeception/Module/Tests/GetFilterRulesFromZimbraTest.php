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

    /**
     * @test
     * @throws SoapFaultException
     */
    public function placesTheReturnedFilterRulesInTheResultFromZimbra()
    {
        $returnedRules = [
            [
                'name' => 'Archive_Read',
                'active' => true,
                'test_condition' => 'any',
                'tests' =>
                    [
                        [
                            'test' => 'header',
                            'stringComparison' => 'matches',
                            'header' => 'from',
                            'index' => '0',
                            'value' => '*'
                        ]
                    ],
                'actions' => [
                    [
                        'action' => 'flag',
                        'flagName' => 'read',
                        'index' => '0'
                    ]
                ]
            ]
        ];
        $this->zasa->shouldReceive('getFilterRules')->andReturn($returnedRules);
        $this->module->getFilterRulesFromZimbra(null);
        $this->assertEquals($returnedRules, $this->module->grabResultFromZimbra());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function acceptsAnyResultFromZimbra()
    {
        $this->zasa->shouldReceive('getFilterRules')->andReturn([]);
        $this->module->getFilterRulesFromZimbra(null);
        $this->assertEquals([], $this->module->grabResultFromZimbra());
    }

    protected function setUp()
    {
        parent::setUp();
        $this->zasa->shouldReceive('getFilterRules')->andReturn([])->byDefault();
    }
}
