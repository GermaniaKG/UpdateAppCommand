<?php
namespace tests;

use Germania\UpdateApp\UpdateAppCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Prophecy;

class UpdateAppCommandTest extends \PHPUnit\Framework\TestCase
{
    use Prophecy\PhpUnit\ProphecyTrait;

    public function testInstantiation() : UpdateAppCommand
    {
        $directories = array();

        $sut = new UpdateAppCommand($directories);
        $this->assertInstanceOf(UpdateAppCommand::class, $sut);
        $this->assertInstanceOf(Command::class, $sut);

        return $sut;
    }

    /**
     * @depends testInstantiation
     */
    public function testSuccessfulExecution( UpdateAppCommand $sut) : void
    {
        $input = new ArrayInput(array('--no-dev' => true), new InputDefinition([new InputOption('no-dev')]));
        $output = new ConsoleOutput();

        $sut->setProcessFactory(function($args) : Process {
            return new Process(array());
        });

        $result = $sut->testExecute($input, $output);
        $this->assertIsInt($result);
        $this->assertEquals(Command::SUCCESS, $result);
    }


}
