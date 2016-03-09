<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/03/09
 * Time: 13:48
 */

namespace Codeception\Module\Tests;


class DontSeeResultFromZimbraContainsTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldPassIfResultDoesNotContainSubset()
    {
        $dummyResult = [
            'foo' => 'bar',
            'baz' => [
                'fruit' => 'apple',
                'veg' => 'tomato',
                'meat' => 'beef'
            ]
        ];

        $subset = ['fruit' => 'banana'];

        $this->module->_setResult($dummyResult);
        $this->module->dontSeeResultFromZimbraContains($subset);
    }

    /**
     * @test
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage I see that {"foo":"bar","baz":{"fruit":"apple","veg":"tomato","meat":"beef"}} contains {"fruit":"apple"}
     */
    public function shouldFailIfResultContainsSubset()
    {
        $dummyResult = [
            'foo' => 'bar',
            'baz' => [
                'fruit' => 'apple',
                'veg' => 'tomato',
                'meat' => 'beef'
            ]
        ];

        $subset = ['fruit' => 'apple'];

        $this->module->_setResult($dummyResult);
        $this->module->dontSeeResultFromZimbraContains($subset);
    }
}