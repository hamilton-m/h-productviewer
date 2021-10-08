<?php

class ProductTypeAttribute
{
	public $attributeId;
	private $attributeName;
	private $attributeValue;
	private $attributeUnit;
	
	public function setAttributeId($attributeId)
	{
		$this->attributeId = $attributeId;
	}
	public function getAttributeId()
	{
		return $this->attributeId;
	}
	
	public function setAttributeName($attributeName)
	{
		$this->attributeName = $attributeName;
	}
	public function getAttributeName()
	{
		return $this->attributeName;
	}
	
	public function setAttributeValue($attributeValue)
	{
		$this->attributeValue = $attributeValue;
	}
	public function getAttributeValue()
	{
		return $this->attributeValue;
	}
	
	public function setAttributeUnit($attributeUnit)
	{
		$this->attributeUnit = $attributeUnit;
	}
	public function getAttributeUnit()
	{
		return $this->attributeUnit;
	}
}


?>