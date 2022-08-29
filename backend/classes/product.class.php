<?php
/**
 * Class containing product logic
 * It is extended by sub classes
 */
abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $attribute;
    protected $attribute_value;
    protected $product_type;

    function __construct($sku, $name, $price, $attribute, $attribute_value, $product_type)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->attribute = $attribute;
        $this->attribute_value = $attribute_value;
        $this->product_type = $product_type;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getAttributeValue()
    {
        return $this->attribute_value;
    }

    public function getProductType()
    {
        return $this->product_type;
    }
}