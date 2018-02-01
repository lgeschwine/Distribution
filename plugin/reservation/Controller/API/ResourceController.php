<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FormaLibre\ReservationBundle\Controller\API;

use Claroline\CoreBundle\Annotations\ApiMeta;
use Claroline\CoreBundle\Controller\APINew\AbstractCrudController;
use Claroline\CoreBundle\Controller\APINew\Model\HasOrganizationsTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @ApiMeta(class="FormaLibre\ReservationBundle\Entity\Resource")
 * @Route("/reservationresource")
 */
class ResourceController extends AbstractCrudController
{
    public function getName()
    {
        return 'reservation_resource';
    }

    use HasOrganizationsTrait;
}
