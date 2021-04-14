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
}
