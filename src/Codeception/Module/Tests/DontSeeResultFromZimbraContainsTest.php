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
    public function testDontSeeResultFromZimbraContains()
    {
        $dummyResult = array(
            'foo' => 'bar',
            'baz' => array(
                'fruit' => 'apple',
                'veg' => 'tomato',
                'meat' => 'beef'
            )
        );

        $this->module->_setResult($dummyResult);
        $this->module->dontSeeResultFromZimbraContains(array('fruit' => 'banana'));
    }
}