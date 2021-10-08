<?php

include_once 'classes/Connection.php';
include 'classes/ProductType.php';
include 'classes/ProductTypeAttribute.php';

class ProductTypeDAO
{	
	public function getAllTypesData()
	{
		$conn = getDatabaseConnection();
		
		//Query: all Types
		$queryProducts = "
		select 
			product_type.product_type_name, 
			product_type.id,
			product_type.id as product_type_id,
			product_type.type_attributes_format_string,
			product_type.product_type_description,
			product_type_attribute.product_type_attribute_name,
			product_type_attribute.product_type_attribute_unit,
			product_type_attribute.id as product_attribute_id
		from  
			product_type, 
			product_type_attribute
		where 
			product_type.id = product_type_attribute.product_type_id
		";
		
		$result = $conn->query($queryProducts, MYSQLI_USE_RESULT);
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		
		$groupedTypesQueried = array();
		
		foreach ($rows as $row)
		{
			$groupedTypesQueried[$row["product_type_id"]][] = $row;
		}
		
		$typeList = array();
		
		
		foreach($groupedTypesQueried as $typeId => $typesGroup)
		{
			$typeInfo = $typesGroup[0];
			
			$productType = new ProductType();
			
			$productType->setProductTypeName($typeInfo['product_type_name']);
			$productType->setProductTypeDescription($typeInfo['product_type_description']);

			foreach ($typesGroup as $productTypeData)
			{
				$attribute = new ProductTypeAttribute();
				
				$attribute_id = $productTypeData['product_attribute_id'];
				$attribute->setAttributeId($attribute_id);
				
				$attribute_name = $productTypeData['product_type_attribute_name'];
				$attribute->setAttributeName($attribute_name);
				
				$attribute_value = $productTypeData['product_attribute_value'];
				$attribute->setAttributeValue($attribute_value);
				
				$attribute_unit = $productTypeData['product_type_attribute_unit'];
				$attribute->setAttributeUnit($attribute_unit);
				
				$productType->addAttribute($attribute);
			}
			$productType->sortAttributes();
			$typeList[$typeId] = $productType;
		}
		
		return $typeList;
	}
}

?>