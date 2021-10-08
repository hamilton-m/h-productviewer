<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>

<?php

include_once 'classes/ProductDAO.php';

$productDAO = new ProductDAO();
$productList = $productDAO->getAllProductList();

echo '
<form method="post">
<div>
	<div>
	<span class="label_products_font">Product List</span>
	<input id="delete-product-btn" type="submit" formaction="/endpoints/deleteProduct.php" value="MASS DELETE" class="top_button right_align">
	<a href="/add-product">
		<input type="button" value="ADD" class="top_button right_align">
	</a>
	</div>
</div>
<hr>
<div class="container">
';

foreach($productList as $product)
{
	
		echo "
		<div class='product_box_border'>
		<div class='product_box'><div class='left_align'><input type='checkbox' class='delete-checkbox' name='checkBox[{$product->getId()}]'></input></div>
		";

	echo "<pre>";
	echo "{$product->getSKU()}\n";
	echo "{$product->getName()}\n";
	echo "{$product->getPrice()} $\n";
	
	echo "{$product->getTypeName()}: ";
	
	$attributesValuesList = array();
	
	foreach($product->getAttributesList() as $attribute)
	{
		$attributesValuesList[] = $attribute->getAttributeValue();
	}
	
	vprintf($product->getAttributeFormatString(), $attributesValuesList);
	
	echo "</pre>";
	
	echo '</div></div>';
}

echo "</div>
</form>
<hr>";

?> 
</html>
 
