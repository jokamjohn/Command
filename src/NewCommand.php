<?php
/**
 * Created by PhpStorm.
 * User: jokamjohn
 * Date: 2/17/2016
 * Time: 10:11 PM
 */

namespace Kagga;


use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZipArchive;

class NewCommand extends Command
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * NewCommand constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    /**
     * Set up the Command
     */
    protected function configure()
    {
        $this->setName('new')
            ->setDescription('Create a new laravel application')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the application');
    }

    /**Execute the Command
     * Check for the existence of the director.
     * Make a unique zip file name.
     * Download the zip from the given url.
     * Alert the user that the installation is done.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = getcwd() . "/" . $input->getArgument('name');

        $this->assertApplicationDirectoryDoesNotExist($output, $directory);

        $zipFile = $this->makeFileName();

        $output->writeln("<info>Crafting Application .....</info>");

        $this->download($zipFile)
            ->extract($zipFile, $directory)
            ->cleanUp($zipFile);

        $output->writeln("<comment>Application ready!!</comment>");
    }

    /**Directory exists so alert the user and throw an error.
     *
     * @param OutputInterface $output
     * @param $directory
     */
    private function assertApplicationDirectoryDoesNotExist(OutputInterface $output, $directory)
    {
        if (is_dir($directory)) {
            $output->writeln('<error>The application already exists</error>');

            exit(1);
        }
    }

    /**Download a zip file from the internet and temporarily store it.
     * Return this to enable method chaining.
     *
     * @param $zipFile
     * @return $this
     */
    private function download($zipFile)
    {
        $response = $this->client->request('GET', "http://cabinet.laravel.com/latest.zip")->getBody();

        file_put_contents($zipFile, $response);

        return $this;
    }

    /**Make a temporary zip filename where the zip from the website is to be stored.
     *
     * @return string
     */
    private function makeFileName()
    {
        return getcwd() . "/laravel_" . md5(time() . uniqid()) . ".zip";
    }

    /**Extract the zip to the cwd.
     * @param $zipName
     * @param $directory
     * @return $this
     */
    private function extract($zipName, $directory)
    {
        $archive = new ZipArchive();

        $archive->open($zipName);

        $archive->extractTo($directory);

        $archive->close();

        return $this;
    }

    /**Check file permissions and delete the file.
     * Suppress any warnings.
     *
     * @param $zipFile
     * @return $this
     */
    private function cleanUp($zipFile)
    {
        @chmod($zipFile, 0777);

        @unlink($zipFile);

        return $this;
    }

}