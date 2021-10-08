<?php

class Product
{
	private $id;
	private $sku;
	private $name;
	private $price;
	private $type_id;
	private $type_name;
	private $type_attributes;
	private $attributeFormatString;
	
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
	
	public function setId($id)
	{
		$this->id = $id;
	}
	public function getId()
	{
		return $this->id;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	public function getName()
	{
		return $this->name;
	}
	
	public function setSKU($sku)
	{
		$this->sku = $sku;
	}
	public function getSKU()
	{
		return $this->sku;
	}
	
	public function setPrice($price)
	{
		$this->price = $price;
	}
	public function getPrice()
	{
		return $this->price;
	}
	
	public function setTypeId($type_id)
	{
		$this->type_id = $type_id;
	}
	public function getType()
	{
		return $this->type_id;
	}
	
	public function setTypeName($type_name)
	{
		$this->type_name = $type_name;
	}
	public function getTypeName()
	{
		return $this->type_name;
	}
	
	public function addAttribute($attribute)
	{
		$this->type_attributes[] = $attribute;
	}
	public function getAttributesList()
	{
		return $this->type_attributes;
	}
	
	public function setAttributeFormatString($attributeFormatString)
	{
		$this->attributeFormatString = $attributeFormatString;
	}
	public function getAttributeFormatString()
	{
		return $this->attributeFormatString;
	}
}

?>