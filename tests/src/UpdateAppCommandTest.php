<?php
namespace tests;

use Germania\UpdateApp\UpdateAppCommand;
use Symfony\Component\Console;
use Symfony\Component\Process;

use Prophecy;

class UpdateAppCommandTest extends \PHPUnit\Framework\TestCase
{
    use Prophecy\PhpUnit\ProphecyTrait;

    public function testInstantiation() : UpdateAppCommand
    {
        $directories = array();

        $sut = new UpdateAppCommand($directories);
        $this->assertInstanceOf(UpdateAppCommand::class, $sut);
        $this->assertInstanceOf(Console\Command\Command::class, $sut);

        return $sut;
    }

    /**
     * @depends testInstantiation
     */
    public function testProcessFactoryInterceptors( UpdateAppCommand $sut) : void
    {
        $fluid = $sut->setProcessFactory(fn() => new Process\Process(array()));

        $this->assertSame($fluid, $sut);
    }

    /**
     * @depends testInstantiation
     */
    public function testSuccessfulExecution( UpdateAppCommand $sut) : void
    {
        $application = new Console\Application();
        $application->add($sut);

        $command_name = $sut->getName();
        $command = $application->find($command_name);

        $tester = new Console\Tester\CommandTester($command);
        $tester->execute([
            '--no-dev' => true
        ]);

        $tester->assertCommandIsSuccessful();
    }


}
