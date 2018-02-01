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
use Claroline\CoreBundle\Entity\Organization\Organization;
use Claroline\CoreBundle\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ApiMeta(class="FormaLibre\ReservationBundle\Entity\Resource")
 * @Route("/reservationresource")
 */
class ResourceController extends AbstractCrudController
{
    use HasOrganizationsTrait;

    private $resourceRepo;

    /**
     * @DI\InjectParams({
     *     "om" = @DI\Inject("claroline.persistence.object_manager")
     * })
     *
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->resourceRepo = $om->getRepository('FormaLibreReservationBundle:Resource');
    }

    public function getName()
    {
        return 'reservation_resource';
    }

    /**
     * List organizations of the collection.
     *
     * @Route("/{id}/organization")
     * @Method("GET")
     *
     * @param string  $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listOrganizationsAction($id, Request $request)
    {
        $resource = $this->resourceRepo->findOneBy(['uuid' => $id]);
        $organizations = !empty($resource) ? $resource->getOrganizations() : [];
        $organizationsUuids = array_map(function (Organization $organization) {
            return $organization->getUuid();
        }, $organizations);

        return new JsonResponse(
            $this->finder->search('Claroline\CoreBundle\Entity\Organization\Organization', array_merge(
                $request->query->all(),
                ['hiddenFilters' => ['whitelist' => $organizationsUuids]]
            ))
        );
    }
}
