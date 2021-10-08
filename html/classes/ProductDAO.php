<?php

include_once 'classes/Connection.php';

include 'classes/Product.php';
include 'classes/ProductTypeAttribute.php';

class ProductDAO
{	
	public function massDelete($productList)
	{
		$conn = getDatabaseConnection();
		
		
		foreach ($productList as $productId)
		{
			$queryDeleteAttribute = '
			delete from 
				product_and_product_attribute_value 
			where 
				product_and_product_attribute_value.product_id=?;
			';
				
			$queryDeleteProduct = 'delete from product where product.id=?;';
			
			$statementProduct = $conn->prepare($queryDeleteAttribute);
			$statementProduct->bind_param("i", $productId);
			$statementProduct->execute();
			
			$statementProduct = $conn->prepare($queryDeleteProduct);
			$statementProduct->bind_param("i", $productId);
			$statementProduct->execute();
			
		}
	}
	
	public function insertProduct($product)
	{
		$conn = getDatabaseConnection();
		
		$queryProduct = '
		insert into product
		(product_sku, product_name, product_price, product_type) values
		(?, ?, ?, ?);';
		
		$queryAttribute = 'insert into product_and_product_attribute_value
		(product_attribute_id, product_id, product_attribute_value) values
		(?, LAST_INSERT_ID(), ?);';
		
		$statementProduct = $conn->prepare($queryProduct);
		
		$statementProduct->bind_param(
		"ssdi", 
		$product->getSku(), 
		$product->getName(), 
		$product->getPrice(),
		$product->getType()
		);
		
		$statementProduct->execute();
		
		foreach($product->getAttributesList() as $attribute)
		{
			
			$attributeValue = $attribute->getAttributeValue();
			
			$statementAttribute = $conn->prepare($queryAttribute);
			$statementAttribute->bind_param(
			"id", 
			$attribute->getAttributeId(), 
			$attribute->getAttributeValue()
			);
			
			$statementAttribute->execute();
		}
	}
	
	public function getAllProductList()
	{
		$conn = getDatabaseConnection();
		
		//Query: all products
		$queryProducts = "
		select 
			product.id as product_id, 
			product.product_sku,
			product.product_name, 
			product.product_price,
			product_type.product_type_name, 
			product_type.id,
			product_type.id as product_type_id,
			product_type.type_attributes_format_string,
			product_type_attribute.product_type_attribute_name,
			product_and_product_attribute_value.product_attribute_value,
			product_and_product_attribute_value.product_attribute_id
		from 
			product, 
			product_type, 
			product_type_attribute,
			product_and_product_attribute_value
		where 
				product.product_type = product_type.id 
			and
				product_type.id = product_type_attribute.product_type_id
			and
				product.id = product_and_product_attribute_value.product_id
			and
				product_and_product_attribute_value.product_attribute_id = product_type_attribute.id
		order by product.id asc;
		";
		
		$result = $conn->query($queryProducts, MYSQLI_USE_RESULT);
		$rows = $result->fetch_all(MYSQLI_ASSOC);

		$groupedProductsQueried = array();
		
		foreach ($rows as $row)
		{
			$groupedProductsQueried[$row["product_id"]][] = $row;
		}
		
		$productList = array();
		
		foreach($groupedProductsQueried as $productGroup)
		{
			$productInfo = $productGroup[0];
			
			$product = new Product();
			
			$product->setId($productInfo['product_id']);
			$product->setSKU($productInfo['product_sku']);
			$product->setName($productInfo['product_name']);
			$product->setPrice($productInfo['product_price']);
			$product->setTypeName($productInfo['product_type_name']);
			$product->setTypeId($productInfo['product_type_id']);
			$product->setAttributeFormatString($productInfo['type_attributes_format_string']);
			
			foreach ($productGroup as $productTypeData)
			{
				$attribute = new ProductTypeAttribute();
				
				$attribute_id = $productTypeData['product_attribute_id'];
				$attribute->setAttributeId($attribute_id);
				
				$attribute_name = $productTypeData['product_type_attribute_name'];
				$attribute->setAttributeName($attribute_name);
				
				$attribute_value = $productTypeData['product_attribute_value'];
				$attribute->setAttributeValue($attribute_value);
				
				$product->addAttribute($attribute);
			}
			$product->sortAttributes();
			$productList[] = $product;
		}
		
		return $productList;
	}
}

?>