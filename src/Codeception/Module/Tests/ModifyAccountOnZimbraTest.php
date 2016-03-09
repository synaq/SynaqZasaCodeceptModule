<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 15/04/20
 * Time: 16:36
 */

namespace Codeception\Module\Tests;

use \Mockery as m;

/**
 * Class ModifyAccountOnZimbraTest
 * @package Codeception\Module
 */
class ModifyAccountOnZimbraTest extends ZasaModuleTestCase
{
    public function testModifyAccountOnZimbra()
    {
        $this->zasa
            ->shouldReceive('getAccountId')
            ->once()
            ->with('example@example.com')
            ->andReturn('example-account-id');

        $this->zasa
            ->shouldReceive('modifyAccount')
            ->once()
            ->withArgs(array(
                'example-account-id',
                array(
                    'zimbraPrefMailForwardingAddress' => 'dummy@example.com'
                )
            ));

        $this->module->modifyAccountOnZimbra("example@example.com", array(
            'zimbraPrefMailForwardingAddress' => 'dummy@example.com'
        ));
        $this->zasa->mockery_verify();
    }
}