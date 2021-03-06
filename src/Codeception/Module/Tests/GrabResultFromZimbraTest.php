<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/03/09
 * Time: 13:45
 */

namespace Codeception\Module\Tests;


class GrabResultFromZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldReturnLastResultSetInModule()
    {
        $dummyResult = ['foo' => 'bar'];
        $this->module->_setResult($dummyResult);
        $result = $this->module->grabResultFromZimbra();
        $this->assertEquals($dummyResult, $result);
    }
}