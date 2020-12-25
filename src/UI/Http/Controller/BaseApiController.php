<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseApiController extends AbstractController
{
    /**
     * @var ArrayTransformerInterface
     */
    private $serializer;

    public function __construct(ArrayTransformerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function arrayResponse($data, array $contextGroups = [])
    {
        if (!$data) {
            return null;
        }

        if ($data instanceof ArrayCollection) {
            $data = $data->toArray();
        }

        $serializationContext = $this->serializationContext ?? SerializationContext::create();

        if ($contextGroups) {
            $serializationContext->setGroups($contextGroups);
        }

        return $this->serializer->toArray($data, $serializationContext);
    }
}
