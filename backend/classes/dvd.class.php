<?php

include "product.class.php";

class DVD extends Product
{
    public function __construct($sku, $name, $price, $attribute_value, $product_type)
    {
        parent::__construct($sku, $name, $price, "Size", $attribute_value, $product_type);
    }
}
