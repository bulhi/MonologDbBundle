<?php

namespace Bulhi\MonologDbBundle\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Dynamically configure LogEntry entity mapping to configured User entity.
 */
class LogEntryMetadataSubscriber implements EventSubscriber
{
    /**
     * Service container instance, used to retrieve configuration
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
        );
    }

    /**
     * Configures association of LogEntry entity to user class defined in configuration.
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        // the $metadata is the whole mapping info for this class
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->getName() != 'Bulhi\MonologDbBundle\Entity\LogEntry') {
            return;
        }

        $metadata->mapManyToOne([
            'targetEntity' => $this->container->getParameter('bulhi_monolog_db.user_class'),
            'fieldName' => 'user',
        ]);
    }
}
