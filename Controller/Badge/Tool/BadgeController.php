<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Controller\Badge\Tool;

use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Entity\Workspace\AbstractWorkspace;
use Claroline\CoreBundle\Entity\Badge\Badge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BadgeController extends Controller
{
    public function myWorkspaceBadgeAction(AbstractWorkspace $workspace, User $loggedUser, $badgePage)
    {
        /** @var \Claroline\CoreBundle\Entity\Badge\Badge[] $workspaceBadges */
        $workspaceBadges = $this->getDoctrine()->getManager()->getRepository('ClarolineCoreBundle:Badge\Badge')->findByWorkspace($workspace);

        $ownedBadges = array();
        $availableBadges = array();
        $displayedBadges = array();

        foreach ($workspaceBadges as $workspaceBadge) {
            $isOwned = false;
            foreach ($workspaceBadge->getUserBadges() as $userBadge) {
                if ($loggedUser->getId() === $userBadge->getUser()->getId()) {
                    $ownedBadges[] = $userBadge;
                    $isOwned = true;
                }
            }

            if (!$isOwned) {
                $availableBadges[] = $workspaceBadge;
            }
        }

        // Create badge list to display (owned badge first, then other badge)
        $displayedBadges = array();
        foreach ($ownedBadges as $ownedBadge) {
            $displayedBadges[] = array(
                'type'  => 'owned',
                'badge' => $ownedBadge
            );
        }

        foreach ($availableBadges as $availableBadge) {
            $displayedBadges[] = array(
                'type'  => 'available',
                'badge' => $availableBadge
            );
        }

        /** @var \Claroline\CoreBundle\Pager\PagerFactory $pagerFactory */
        $pagerFactory = $this->get('claroline.pager.pager_factory');
        $badgePager   = $pagerFactory->createPagerFromArray($displayedBadges, $badgePage, 10);

        return $this->render(
            'ClarolineCoreBundle:Badge:Template/Tool/list.html.twig',
            array(
                'badgePager' => $badgePager,
                'workspace'  => $workspace,
                'badgePage'  => $badgePage
            )
        );
    }
}
