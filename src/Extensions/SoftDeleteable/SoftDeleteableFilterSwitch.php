<?php declare(strict_types=1);

namespace Olml89\Extensions\SoftDeleteable;

use UnexpectedValueException;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\SoftDeleteable\SoftDeleteableListener;

/**
 * Class SoftDeleteableFilterSwitch
 * @package Olml89\Extensions\SoftDeleteable
 */
class SoftDeleteableFilterSwitch
{
    private const EVENT_NAME = 'onFlush';
    private const FILTER_NAME = 'softdeleteable';

    private ?SoftDeleteableListener $originalEventListener = null;

    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {}

    public function disable() : void
    {
        $this->entityManager->getFilters()->disable(self::FILTER_NAME);

        foreach ($this->entityManager->getEventManager()->getListeners() as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof SoftDeleteableListener && $eventName === self::EVENT_NAME) {
                    $this->originalEventListener = $listener;
                    $this->entityManager->getEventManager()->removeEventListener($eventName, $listener);
                }
            }
        }
    }

    /**
     * @throws UnexpectedValueException
     */
    public function enable() : void
    {
        if (!$this->originalEventListener) {
            throw new UnexpectedValueException(
                sprintf('"%s" was not removed', SoftDeleteableListener::class)
            );
        }
        $this->entityManager->getEventManager()->addEventListener(self::EVENT_NAME, $this->originalEventListener);
        $this->entityManager->getFilters()->enable(self::FILTER_NAME);
    }

}