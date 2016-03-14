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
        $this->module->_setResult(
            [
                'foo' => 'bar',
                'baz' => [
                    'fruit' => 'apple',
                    'veg' => 'tomato',
                    'meat' => 'beef'
                ]
            ]
        );

        $this->module->dontSeeResultFromZimbraContains(['fruit' => 'banana']);
    }

    /**
     * @test
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage I see that {"foo":"bar","baz":{"fruit":"apple","veg":"tomato","meat":"beef"}} contains {"fruit":"apple"}
     */
    public function shouldFailIfResultContainsSubset()
    {
        $this->module->_setResult(
            [
                'foo' => 'bar',
                'baz' => [
                    'fruit' => 'apple',
                    'veg' => 'tomato',
                    'meat' => 'beef'
                ]
            ]
        );

        $this->module->dontSeeResultFromZimbraContains(['fruit' => 'apple']);
    }
}