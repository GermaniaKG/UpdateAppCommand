<?php

/**
 * germania-kg/update-command
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests;

use Germania\UpdateApp\UpdateAppCommand;
use Prophecy;
use Symfony\Component\Console;
use Symfony\Component\Process;

/**
 * @internal
 *
 * @coversNothing
 */
class UpdateAppCommandTest extends \PHPUnit\Framework\TestCase
{
    use Prophecy\PhpUnit\ProphecyTrait;

    public function testInstantiation(): UpdateAppCommand
    {
        $directories = [];

        $sut = new UpdateAppCommand($directories);
        $this->assertInstanceOf(UpdateAppCommand::class, $sut);
        $this->assertInstanceOf(Console\Command\Command::class, $sut);

        return $sut;
    }

    /**
     * @depends testInstantiation
     */
    public function testProcessFactoryInterceptors(UpdateAppCommand $sut): void
    {
        $fluid = $sut->setProcessFactory(fn () => new Process\Process([]));

        $this->assertSame($fluid, $sut);
    }

    /**
     * @depends testInstantiation
     */
    public function testSuccessfulExecution(UpdateAppCommand $sut): void
    {
        $application = new Console\Application();
        $application->add($sut);

        $command_name = $sut->getName();
        $command = $application->find($command_name);

        $tester = new Console\Tester\CommandTester($command);
        $tester->execute([
            '--no-dev' => true,
        ]);

        $tester->assertCommandIsSuccessful();
    }
}
