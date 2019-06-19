<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('uri:remove')->setDescription('Remove expired link entries from the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $current_datetime = new \DateTime();
        
        $entityManager = $this->getContainer()->get('doctrine')->getManager();
        $query = $entityManager->createQuery("DELETE FROM App\Entity\Link link WHERE link.expire_timestamp != 0 AND link.expire_timestamp <= CURRENT_TIMESTAMP()");
        $entries_removed = $query->execute();
        
        $output->writeln('Job is passed successfully. Removed entries amount: ' . $entries_removed);
    }
}