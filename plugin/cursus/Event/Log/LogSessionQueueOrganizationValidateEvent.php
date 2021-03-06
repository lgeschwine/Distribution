<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CursusBundle\Event\Log;

use Claroline\CoreBundle\Event\Log\LogGenericEvent;
use Claroline\CursusBundle\Entity\CourseSessionRegistrationQueue;

class LogSessionQueueOrganizationValidateEvent extends LogGenericEvent
{
    const ACTION = 'cursusbundle-session-queue-organization-validate';

    public function __construct(CourseSessionRegistrationQueue $queue)
    {
        $session = $queue->getSession();
        $course = $session->getCourse();
        $user = $queue->getUser();
        $organizationAdmin = $queue->getOrganizationAdmin();
        $details = [];
        $details['userId'] = $user->getId();
        $details['username'] = $user->getUsername();
        $details['firsName'] = $user->getFirstName();
        $details['lastName'] = $user->getLastName();
        $details['courseId'] = $course->getId();
        $details['courseTitle'] = $course->getTitle();
        $details['courseCode'] = $course->getCode();
        $details['sessionId'] = $session->getId();
        $details['sessionName'] = $session->getName();
        $details['sessionStatus'] = $session->getSessionStatus();
        $details['sessionType'] = $session->getType();
        $details['organizationAdminId'] = $organizationAdmin->getId();
        $details['organizationAdminUsername'] = $organizationAdmin->getUsername();
        $details['organizationAdminFirsName'] = $organizationAdmin->getFirstName();
        $details['organizationAdminLastName'] = $organizationAdmin->getLastName();
        $details['organizationValidationDate'] = $queue->getOrganizationValidationDate();

        parent::__construct(
            self::ACTION,
            $details,
            $user
        );
    }

    /**
     * @return array
     */
    public static function getRestriction()
    {
        return [self::DISPLAYED_ADMIN];
    }
}
