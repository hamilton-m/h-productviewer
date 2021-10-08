<?php

class ProductType
{
	private $productTypeName;
	private $productTypeDescription;
	private $type_attributes;
	
	function __construct() 
	{
		$this->type_attributes = array();
	}
	
	function idComparator($aAttribute, $bAttribute)
	{
		if ($aAttribute->attributeId == $bAttribute->attributeId) return 0;
		return ($aAttribute->attributeId < $bAttribute->attributeId)?-1:1;
	}
	public function sortAttributes()
	{
		
		usort($this->type_attributes,[$this, "idComparator"]);
	}
	
	public function setProductTypeName($productTypeName)
	{
		$this->productTypeName = $productTypeName;
	}
	public function getProductTypeName()
	{
		return $this->productTypeName;
	}
	
	public function setProductTypeDescription($productTypeDescription)
	{
		$this->productTypeDescription = $productTypeDescription;
	}
	public function getProductTypeDescription()
	{
		return $this->productTypeDescription;
	}
	
	public function addAttribute($attribute)
	{
		$this->type_attributes[] = $attribute;
	}
	public function getAttributesList()
	{
		return $this->type_attributes;
	}
}

?>