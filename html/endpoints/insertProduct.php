
<html>
<?php
set_include_path($_SERVER['DOCUMENT_ROOT']);

include_once 'classes/ProductDAO.php';

$post = $_POST;
$product = new Product();
$productDAO = new ProductDAO();

$product->setSKU($post['sku']);
$product->setName($post['name']);
$product->setPrice($post['price']);

$_typeIdAndName = explode('|', $post['productType']);
$productTypeId = $_typeIdAndName[0];
$productTypeName= $_typeIdAndName[1];

$product->setTypeId($productTypeId);
$product->setTypeName($productTypeName);

$typeAttributes = $post['typeAttributes'];
foreach($typeAttributes as $attributeIdAndName => $attributeValue)
{
	$_attributeIdAndName = explode('|', $attributeIdAndName);
	$attributeId = $_attributeIdAndName[0];
	$attributeName = $_attributeIdAndName[1];
	
	$attribute = new ProductTypeAttribute();
	$attribute->setAttributeName($attributeName);
	$attribute->setAttributeId($attributeId);
	$attribute->setAttributeValue($attributeValue);
	
	$product->addAttribute($attribute);
}

$productDAO = new ProductDAO();
$productDAO->insertProduct($product);


?>
<script>
window.location.replace("/");
</script>
</html>