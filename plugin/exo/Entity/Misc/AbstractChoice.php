<?php

namespace UJM\ExoBundle\Entity\Misc;

use Doctrine\ORM\Mapping as ORM;
use UJM\ExoBundle\Library\Model\ContentTrait;
use UJM\ExoBundle\Library\Model\FeedbackTrait;
use UJM\ExoBundle\Library\Model\ScoreTrait;
use Claroline\CoreBundle\Library\Model\UuidTrait;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractChoice
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    use UuidTrait;

    use ScoreTrait;

    use FeedbackTrait;

    use ContentTrait;

    public function __construct()
    {
        $this->refreshUuid();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
