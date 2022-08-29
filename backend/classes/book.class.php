<?php

include "product.class.php";

class Book extends Product
{
    public function __construct($sku, $name, $price, $attribute_value, $product_type)
    {
        parent::__construct($sku, $name, $price, "Weight", $attribute_value, $product_type);
    }
}
