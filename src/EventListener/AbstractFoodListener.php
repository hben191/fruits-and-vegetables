<?php

namespace App\EventListener;

use App\Entity\AbstractFood;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: Events::postPersist, method: 'postPersist')]
class AbstractFoodListener
{
    /**
     * Update quantity if it is expressed in kilograms, as it is specified to persist it in grams
     */
    public function postPersist(PostPersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof AbstractFood) {
            return;
        }

        if ('kg' == $entity->getUnit()) {
            $quantityInKg = $entity->getQuantity();
            $entity->setQuantity($quantityInKg * 1000);
        }
    }
}
