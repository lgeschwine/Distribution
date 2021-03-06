<?php

namespace Icap\LessonBundle;

use Claroline\CoreBundle\Library\DistributionPluginBundle;
use Claroline\KernelBundle\Bundle\ConfigurationBuilder;
use Icap\LessonBundle\Installation\AdditionalInstaller;

class IcapLessonBundle extends DistributionPluginBundle
{
    public function getConfiguration($environment)
    {
        $config = new ConfigurationBuilder();

        return $config->addRoutingResource(__DIR__.'/Resources/config/routing.yml', null, 'icap_lesson');
    }

    public function getAdditionalInstaller()
    {
        return new AdditionalInstaller();
    }

    public function getRequiredPlugins()
    {
        return ['Icap\\NotificationBundle\\IcapNotificationBundle'];
    }
}
