<?php

include "includes/autoloader.inc.php";
/**
 * Handles database queries
 */

class DbManager
{
    private $url;
    private $server;
    private $username;
    private $password;
    private $db;

    public function __construct()
    {
        $this->url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $this->server = $this->url["host"];
        $this->username = $this->url["user"];
        $this->password = $this->url["pass"];
        $this->db = substr($this->url["path"], 1);
    }

    private function connect()
    {
        try {
            $conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->db, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }

    /**
     * Fetches all the products from database
     */
    public function getProducts()
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->connect()->query($sql);
        $products = $stmt->fetchAll();
        echo json_encode($products);
    }

    /**
     * Inserts a product into the database
     */
    public function addProduct()
    {
        $product_values = json_decode(file_get_contents("php://input"));
        $class_name = strtolower($product_values->productType);
        $product = new $class_name($product_values->sku, $product_values->name, $product_values->price, $product_values->attributeValue, $product_values->productType);
        $sql = "INSERT INTO products(sku, name, attribute, attribute_value, product_type, price) 
        VALUES (:sku, :name, :attribute, :attribute_value, :product_type, :price)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":sku", $product->getSku());
        $stmt->bindParam(":name", $product->getName());
        $stmt->bindParam(":attribute", $product->getAttribute());
        $stmt->bindParam(":attribute_value", $product->getAttributeValue());
        $stmt->bindParam(":product_type", $product->getProductType());
        $stmt->bindParam(":price", $product->getPrice());

        if ($stmt->execute()) {
            $response = ["status" => 1, "message" => "Record created successfully"];
        } else {
            $response = ["status" => 0, "message" => "Failded to create record"];
        }

        echo json_encode($response);
    }

    /**
     * Deletes a product from the database
     */
    public function deleteProduct()
    {
        $product_values = json_decode(file_get_contents("php://input"));
        $class_name = strtolower($product_values->product_type);
        $product = new $class_name($product_values->sku, $product_values->name, $product_values->price, $product_values->attribute_value, $product_values->product_type);
        $sql = "DELETE FROM products WHERE sku=:sku";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":sku", $product->getSku());
        if ($stmt->execute()) {
            $response = ["status" => 1, "message" => "Record deleted successfully"];
        } else {
            $response = ["status" => 0, "message" => "Failed to delete record"];
            echo $this->connect()->error;
        }
        echo json_encode($response);
    }
}
