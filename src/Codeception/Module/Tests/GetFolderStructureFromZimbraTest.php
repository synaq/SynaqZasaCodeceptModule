<?php

namespace Codeception\Module\Tests;

class GetFolderStructureFromZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function callsGetFoldersOnZimbraConnectorOnce()
    {
        $this->module->getFolderStructureFromZimbra(null);
        $this->zasa->shouldHaveReceived('getFolders')->once();
    }

    /**
     * @test
     */
    public function callsGetFoldersWithGivenAccountName()
    {
        $this->module->getFolderStructureFromZimbra('foo@bar.com');
        $this->zasa->shouldHaveReceived('getFolders')->with('foo@bar.com');
    }
}
