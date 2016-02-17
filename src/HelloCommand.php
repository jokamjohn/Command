<?php
/**
 * Created by PhpStorm.
 * User: jokamjohn
 * Date: 2/17/2016
 * Time: 10:11 PM
 */

namespace Kagga;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command
{
    /**
     * Set up the Command
     */
    protected function configure()
    {
        $this->setName('hello')
            ->setDescription('Offer a greeting to a given person')
            ->addArgument('name', InputArgument::REQUIRED, 'Your name');
    }

    /**Execute the Command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $message = 'Hello ' . $name;



        $output->writeln("<info>{$message}</info>");
    }

}