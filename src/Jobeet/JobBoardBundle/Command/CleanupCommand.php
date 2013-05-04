<?php

namespace Jobeet\JobBoardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('jobeet:jobboard:cleanup')
            ->setDescription('Cleanup Jobeet database')
            ->setHelp(<<<EOF
The <info>jobeet:jobboard:cleanup</info> command cleans up the Jobeet database:

<info>php app/console jobeet:jobboard:cleanup --days=90</info>
EOF
            )
            ->addOption(
               'days',
               null,
               InputOption::VALUE_OPTIONAL,
               'A job is considered stale if older than this number of days.',
               90
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $nJobsRemoved = $em->getRepository('JobeetJobBoardBundle:Job')->cleanUp($input->getOption('days'));

        $output->writeln(sprintf('Removed %d stale jobs', $nJobsRemoved));
    }
}
