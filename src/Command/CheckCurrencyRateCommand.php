<?php

namespace App\Command;

use App\Service\CurrencyAPI\RequestTokenAuth;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckCurrencyRateCommand extends Command
{
    private $requestTokenAuth;

    public function __construct(RequestTokenAuth $requestTokenAuth)
    {
        parent::__construct();
        $this->requestTokenAuth = $requestTokenAuth;
    }

    protected static $defaultName = 'app:check-currency-rate';
    protected static $defaultDescription = 'Updates exchange rates and sends mail to users';

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->requestTokenAuth->sendRequest('https://127.0.0.1:8000/currency_api', 'GET');

        $io->success('Mission success!');

        return Command::SUCCESS;
    }
}
