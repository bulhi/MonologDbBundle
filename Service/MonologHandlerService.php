<?php

namespace Bulhi\MonologDbBundle\Service;

use Bulhi\MonologDbBundle\Entity\LogEntry;
use Doctrine\Bundle\DoctrineBundle\Registry;
use FOS\UserBundle\Model\User;
use Monolog\Handler\AbstractProcessingHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * This service provides custom channel handler for Monolog, see:
 * https://github.com/Seldaek/monolog/blob/master/doc/04-extending.md
 */
class MonologHandlerService extends AbstractProcessingHandler
{
    /**
     * Doctrine registry instance, used to retrieve entity manager
     */
    protected $doctrine;

    /**
     * Security token storage, used to retrieve current user.
     */
    protected $tokenStorage;

    /**
     * TokenStorage instance allows us to get current user here, without the need
     * to pass it every time in the message context when the logger service is called.
     * 
     * @param Registry $doctrine 
     * @param TokenStorage $tokenStoragee
     */
    public function __construct(Registry $doctrine, TokenStorage $tokenStorage)
    {
        $this->doctrine = $doctrine;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $logEntry = new LogEntry;
        $logEntry->setLevel($record['level']);
        $logEntry->setMessage($record['message']);
        $logEntry->setCreatedAt($record['datetime']);

        // set current user as author of this log entry
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User) {
            $logEntry->setUser( $user );
        }

        $entityManager = $this->doctrine->getManager();        
        $entityManager->persist($logEntry);

        // this entity manager is passed everywhere throughout the application, so we need to flush just this one particular entity,
        // not every pending query, which would happen when flush() is called without parameters
        $entityManager->flush($logEntry);
    }
}