<?php

/**
 * germania-kg/update-command
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Germania\UpdateApp;

// https://symfony.com/doc/current/console/style.html#content-methods
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class UpdateAppCommand extends Command
{
    /**
     * @var string
     */
    public $directory_chmod = '0775';

    // Name of the command (the part after "bin/console")
    protected static $defaultName = 'update';

    /**
     * @var string[]
     */
    protected $directories;

    /**
     * @var callable
     */
    protected $process_factory;

    /**
     * @param string[] $directories
     */
    public function __construct(array $directories = [])
    {
        $this->setCacheDirectories($directories);

        $this->setProcessFactory(function (array $args): Process {
            return new Process($args);
        });

        parent::__construct();
    }

    public function setProcessFactory(callable $process_factory): self
    {
        $this->process_factory = $process_factory;

        return $this;
    }

    public function testExecute(InputInterface $input, OutputInterface $output): int
    {
        return $this->execute($input, $output);
    }

    /**
     * @param string[] $directories
     */
    public function setCacheDirectories(array $directories): self
    {
        $this->directories = $directories;

        return $this;
    }

    public function setDirectoryChmod(string $chmod): self
    {
        $this->directory_chmod = $chmod;

        return $this;
    }

    // Define a description, help message and the input options and arguments:
    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Update this application, basically using "git pull" and "composer install"')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This will pull in the latest repo content from current branch and install the Composer dependencies.')

            ->addOption('no-dev', null, InputOption::VALUE_NONE, 'Do not install dev dependencies (composer install --no-dev)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Update application');

        $verbose = $output->isVerbose();

        $ofn = function ($type, $buffer) {
            echo $buffer;
        };

        try {
            if (!empty($this->directories)) {
                $io->section('Create cache directories');
            }

            foreach ($this->directories as $dir) {
                $process = ($this->process_factory)(['mkdir', '-p', $dir]);
                $this->runProcess($process, $output, $io, $verbose);

                if (is_writable($dir)) {
                    $process = ($this->process_factory)(['chmod', $this->directory_chmod, $dir]);
                    $this->runProcess($process, $output, $io, $verbose);
                } else {
                    $msg = sprintf("Can't chmod on directory '%s'", $dir);
                    $output->writeln($msg);
                }
            }

            $io->section('Update from Git repo');
            $update_args = array_filter(['git', 'pull', $verbose ? '-v' : null]);
            $process = ($this->process_factory)($update_args);
            $process->mustRun($ofn);
            $output->writeln($process->getOutput());

            $io->section('Install Composer dependencies');

            $composer_install_params = ['composer', 'install'];
            if ($input->getOption('no-dev')) {
                $composer_install_params[] = '--no-dev';
            }
            if ($verbose) {
                $composer_install_params[] = '-v';
            }
            $process = ($this->process_factory)($composer_install_params);
            $process->mustRun($ofn);
            $output->writeln($process->getOutput());

            $io->section('Dump Composer autoloader');

            $process = ($this->process_factory)(['composer', 'dump-autoload', '--optimize']);
            $process->mustRun($ofn);
            $output->writeln($process->getOutput());

            $io->section('Git repo information');
            $git_remote_args = array_filter(['git', 'remote', $verbose ? '-v' : null]);
            $process = ($this->process_factory)($git_remote_args);
            $process->mustRun();
            $output->writeln($process->getOutput());

            $process = ($this->process_factory)(['git', 'describe']);
            $process->mustRun();
            $output->writeln($process->getOutput());

            $process = ($this->process_factory)(['git', 'status']);
            $process->mustRun();
            $output->writeln($process->getOutput());
        } catch (ProcessFailedException $e) {
            $io->newLine();
            $io->error(array_filter([
                get_class($e),
                $e->getMessage(),
                $verbose ? sprintf("Line %s in '%s'", $e->getLine(), $e->getFile()) : null,
            ]));
        }

        return Command::SUCCESS;
    }

    protected function runProcess(Process $process, OutputInterface $output, SymfonyStyle $io, bool $verbose): void
    {
        try {
            $process->mustRun(function ($type, $buffer) {
                echo $buffer;
            });
            $output->writeln($process->getOutput());
        } catch (\Throwable $e) {
            $io->newLine();
            $io->error(array_filter([
                get_class($e),
                $e->getMessage(),
                $verbose ? sprintf("Line %s in '%s'", $e->getLine(), $e->getFile()) : null,
            ]));
        }
    }
}
