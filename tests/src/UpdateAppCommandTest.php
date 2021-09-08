<?php
namespace tests;

use Germania\UpdateApp\UpdateAppCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateAppCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testInstantiation() : UpdateAppCommand
    {
        $directories = array();

        $sut = new UpdateAppCommand($directories);
        $this->assertInstanceOf(UpdateAppCommand::class, $sut);

        return $sut;
    }
}
