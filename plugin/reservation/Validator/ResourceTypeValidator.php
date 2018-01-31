<?php

namespace FormaLibre\ReservationBundle\Validator;

use Claroline\CoreBundle\API\ValidatorInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service()
 * @DI\Tag("claroline.validator")
 */
class ResourceTypeValidator implements ValidatorInterface
{
    public function validate($data)
    {
        return [];
    }

    //not sure yet if using this or deduce from getUnique()
    //note to myself: it should be deduced from getUnique
    public function validateBulk(array $users)
    {
    }

    public function getUniqueFields()
    {
        return [
          'name' => 'name',
        ];
    }

    public function getClass()
    {
        return 'FormaLibre\ReservationBundle\Entity\ResourceType';
    }
}
