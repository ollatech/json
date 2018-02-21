<?php
namespace Olla\Json\Serializer;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer as BaseObjectNormalizer;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;


class  ObjectSerializer extends BaseObjectNormalizer {


    protected $propertyAccessor;
    protected $metadataOperator;
    public function __construct(PropertyAccessorInterface $propertyAccessor = null, NameConverterInterface $nameConverter = null, ClassMetadataFactoryInterface $classMetadataFactory = null)
    {
        parent::__construct($classMetadataFactory, $nameConverter);
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
        $this->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
    }


    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
      
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return parent::normalize($object, $format, $context);
    }

    /**
     * Implement allowed attributes. Allowed attributes should be base on select request only.
     * @param  [type]  $classOrObject      [description]
     * @param  array   $context            [description]
     * @param  boolean $attributesAsString [description]
     * @return [type]                      [description]
     */
    protected function getAllowedAttributes($classOrObject, array $context, $attributesAsString = false)
    {
        $allowedAttributes = [];
        if(isset($context['select'])) {
            $allowedAttributes = $context['select'];
        }
        return $allowedAttributes;
    }




    /**
     * {@inheritdoc}
     */
    public function setAttributeValue($object, $attribute, $value, $format = null, array $context = [])
    {
        try {
            $this->propertyAccessor->setValue($object, $attribute, $value);
        } catch (NoSuchPropertyException $exception) {
            // Properties not found are ignored
        }
        
    }
    /**
     * {@inheritdoc}
     *
     * @throws NoSuchPropertyException
     */
    public function getAttributeValue($object, $attribute, $format = null, array $context = [])
    {
        try {
            $attributeValue = $this->propertyAccessor->getValue($object, $attribute);
        } catch (NoSuchPropertyException $e) {
            $attributeValue = null;
        }
       return $attributeValue;
   }

    /**
     * @param PropertyMetadata $propertyMetadata
     * @param mixed            $relatedObject
     * @param string           $resourceClass
     * @param string|null      $format
     * @param array            $context
     *
     * @return string|array
     */
    private function normalizeRelation(string $resourceClass, $attributeValue, string $format = null, array $context)
    {
        $currentDepth = isset($context['depth']) ? $context['depth'] : 1;
        return null;
    }
}
