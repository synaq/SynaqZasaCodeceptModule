<?php

namespace Codeception\Module\Tests;

use PHPUnit_Framework_ExpectationFailedException;

class SeeZimbraFilterRuleWithAttributesTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function passesIfAllGivenAttributesArePresentInAtLeastOneRuleInTheCurrentResult()
    {
        $this->module->_setResult([
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
        ]);
        $this->module->seeZimbraFilterRuleWithAttributes([
            'name' => 'Archive_Read',
            'actions' => [
                [
                    'action' => 'flag',
                    'flagName' => 'read',
                    'index' => '0'
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function failsIfNoRuleMatchesTheGivenAttributes()
    {
        $this->module->_setResult([
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
                        'action' => 'discard',
                        'index' => '0'
                    ],
                    [
                        'action' => 'stop',
                        'index' => '1'
                    ],
                ]
            ],
            [
                'name' => 'Something_Else',
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
        ]);

        $attributeSubset = [
            'name' => 'Archive_Read',
            'actions' => [
                [
                    'action' => 'flag',
                    'flagName' => 'read',
                    'index' => '0'
                ]
            ]
        ];

        $this->setExpectedException(PHPUnit_Framework_ExpectationFailedException::class, 'I do not see any rule with at least these attributes: ' . json_encode($attributeSubset));
        $this->module->seeZimbraFilterRuleWithAttributes($attributeSubset);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->module->_setResult([]);
    }
}
