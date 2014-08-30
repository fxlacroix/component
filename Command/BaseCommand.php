<?php

namespace FXL\Component\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand,
    Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends ContainerAwareCommand
{
    /**
     *
     * @var Logger
     */
    protected $logger;

    /**
     * log if verbose mode active
     *
     * @param OutputInterface $output The output
     * @param string $message The message
     */
    protected function log(OutputInterface $output, $message)
    {
        if (null === $this->logger) {
            $this->logger = new CommandLogger($output);
        }

        $this->logger->info($message);
    }

    /**
     * Get Entity Manager proxy
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getContainer()
            ->get('doctrine')
            ->getEntityManager();
    }

    /**
     * Get Repository proxy
     *
     * @return Repository
     */
    protected function getRepository($repository)
    {
        return $this->getEntityManager
            ->getRepository($repository);
    }

    /**
     * debugger
     * @param dump $var
     */
    protected function debug($var, $maxDepth = 2)
    {

        \Doctrine\Common\Util\Debug::dump($var, $maxDepth);
    }

    /*
     * flash
     * @param dump $var
     */
    protected function flash($var, $maxDepth = 2)
    {

        die($this->debug($var, $maxDepth));
    }
}