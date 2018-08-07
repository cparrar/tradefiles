<?php

    namespace App\Command;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\ArrayInput;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Style\SymfonyStyle;

    class InstallCommand extends Command {

        /**
         * configure
         */
        protected function configure()
        {
            $this->setName('zyos:install');
            $this->setDescription('Install for development');
        }

        /**
         * @param InputInterface $input
         * @param OutputInterface $output
         *
         * @return int|null|void
         * @throws \Exception
         */
        protected function execute(InputInterface $input, OutputInterface $output) {

            $io = new SymfonyStyle($input, $output);

            $this->getExecuteCommand($output, 'doctrine:database:drop', ['--if-exists' => true, '--force' => true]);
            $this->getExecuteCommand($output, 'doctrine:database:create');
            $this->getExecuteCommand($output, 'doctrine:schema:update', ['--force' => true]);
            $this->getExecuteCommand($output, 'doctrine:fixtures:load', ['--append' => true]);
            //$this->getExecuteCommand($output, '');

            $io->success('Process Finished');
        }

        /**
         * Execute command
         *
         * @param OutputInterface $output
         * @param string $command
         * @param array $array
         *
         * @return int
         * @throws \Exception
         */
        private function getExecuteCommand(OutputInterface $output, string $command, array $array = []) {

            $command = $this->getApplication()->find($command);

            $input = new ArrayInput(array_merge(['command'], $array));
            return $command->run($input, $output);
        }
    }
