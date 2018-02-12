<?php
namespace Olla\Json;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class View {
	protected $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }
    public function render(string $format, array $data, string $template = null, array $options = []) {
        $response = [];
        if(is_array($data)) {
            foreach ($data as $key => $object) {
                $serialized = $this->serializer->serialize($object, $format, $options);
                $response[] = $this->serializer->decode($serialized, $format);
            }
        } else {
            $response = $this->serializer->serialize($data, $format, $options);
        }
        return new JsonResponse($response);
    }
}
