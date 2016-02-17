<?php


namespace Kagga;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RenderTabular extends Command
{

    /**
     * Set up the Command
     */
    protected function configure()
    {
        $this->setName('render')
            ->setDescription('Render some tabular data');
    }

    /**Execute the Command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);

        $table->setHeaders(['Name', 'Age'])
            ->setRows([
                ['John Kagga', '23'],
                ['Jose Kagga', '21'],
                ['Bridge', '23']
            ])
            ->render();
    }

}