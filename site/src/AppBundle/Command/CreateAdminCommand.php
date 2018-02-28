<?php
/**
 * Created by PhpStorm.
 * User: nasri
 * Date: 28/02/2018
 * Time: 17:26
 */

namespace AppBundle\Command;


use AppBundle\Manager\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminCommand extends Command
{
    /**
     * @var UserManager
     */
    private $manager;

    /**
     * CreateAdminCommand constructor.
     * @param UserManager $manager
     */
    public function __construct(UserManager $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setName('app:create:admin')
            ->setDescription('Create Actor')
            ->setHelp('This command allow you to create Actor');
        $this->addArgument('pseudo', InputArgument::REQUIRED,'The pseudo of the actor .');
        $this->addArgument('email', InputArgument::REQUIRED,'The email of the actor .');
        $this->addArgument('password', InputArgument::REQUIRED,'The password of the actor .');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['Create Actor','==============','',   ]);
        $output->writeln('Whoa!');
        $output->write('You are about to ');
        $output->write('create Actor.');
        $output->writeln(' ');
        $output->writeln('pseudo :'. $input->getArgument('pseudo'));
        $output->writeln('email :'. $input->getArgument('email'));
        $output->writeln('password :'. $input->getArgument('password'));
        $this->manager->setUserAdmin(
            $input->getArgument('pseudo'),
            $input->getArgument('email'),
            $input->getArgument('password')
        );
    }
}
