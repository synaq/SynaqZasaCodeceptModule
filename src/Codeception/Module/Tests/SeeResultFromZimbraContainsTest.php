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
    public function testSeeResultFromZimbraContains()
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
        $this->module->seeResultFromZimbraContains(array('fruit' => 'apple'));
    }
}