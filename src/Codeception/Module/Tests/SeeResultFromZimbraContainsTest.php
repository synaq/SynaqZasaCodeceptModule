<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/03/09
 * Time: 13:47
 */

namespace Codeception\Module\Tests;


class SeeResultFromZimbraContainsTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldPassIfResultContainsSubset()
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
        $this->module->seeResultFromZimbraContains(['fruit' => 'apple']);
    }

    /**
     * @test
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage I don't see that {"foo":"bar","baz":{"fruit":"apple","veg":"tomato","meat":"beef"}} contains {"fruit":"banana"}
     */
    public function shouldFailIfResultDoesNotContainSubset()
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
        $this->module->seeResultFromZimbraContains(['fruit' => 'banana']);
    }
}