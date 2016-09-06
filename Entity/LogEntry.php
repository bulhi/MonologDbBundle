<?php

namespace Bulhi\MonologDbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class LogEntry
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Monolog log level - https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md#log-levels
     * 
     * @ORM\Column(type="smallint", options={"unsigned": true})
     */
    protected $level;

    /**
     * Message displayed to the user in log entry
     * 
     * @ORM\Column(type="text")
     */
    protected $message;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * User who triggered the action which created the log entry.
     * 
     * This association is configured dynamically, see:
     * Bulhi\MonologDbBundle\EventSubscriber\EntityMetadataSubscriber
     */
    protected $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return LogEntry
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Get level code in format for template
     *
     * @return string
     */
    public function getReadableLevel()
    {
        // we need to keep LEVEL array in this inverted format because of Symfony form elements
        return array_search($this->level, self::LEVELS);
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return LogEntry
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LogEntry
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return LogEntry
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
