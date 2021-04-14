<?php

namespace Codeception\Module\Tests;

class SeeFolderWithAbsolutePathTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function passesIfAFolderWithTheGivenAbsolutePathExists()
    {
        $this->module->_setResult([
            'name' => 'USER_ROOT',
            'absolute_path' => '/',
            'link_target' => null,
            'children' => [
                [
                    'name' => 'Inbox',
                    'absolute_path' => '/Inbox',
                    'link_target' => null,
                    'children' => []
                ]
            ]
        ]);

        $this->module->seeFolderWithAbsolutePath('/Inbox');
    }
}
