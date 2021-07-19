<?php

namespace App\Command;

use App\Entity\User;
use App\Service\EntityService\RemoveEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PurgeUserTableCommand extends Command
{
    private $removeEntity;
    private $entityManager;

    public function __construct(RemoveEntity $removeEntity, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->removeEntity = $removeEntity;
        $this->entityManager = $entityManager;
    }

    protected static $defaultName = 'app:purge-user-table';
    protected static $defaultDescription = 'Purge user table?';

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $this->removeEntity->remove($user);
        }

        $io->success('Cool!');

        return Command::SUCCESS;
    }
}
