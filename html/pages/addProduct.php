<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/style.css">
</head>
<body>

<?php

include_once 'classes/ProductTypeDAO.php';

$productTypeDAO = new ProductTypeDAO();
$typeList = $productTypeDAO->getAllTypesData();

echo "
<div id='notification_empty' class='notification_style'>Please, submit required data</div>
<div id='notification_notnumber' class='notification_style'>Please, provide the data of indicated type</div>


<form action='/endpoints/insertProduct.php' id='product_form' method='post'>
<div>
	<div>
	<span class='label_products_font'>Product Add</span>
	<a href='/'><input type='button' value='Cancel' class='top_button right_align'></a>
	<input type='button' onclick='submitForm();' value='Save' class='top_button right_align'>
	</div>
</div>
<hr>";

echo '
<br>
<table>
	<tr>
		<td>SKU</td>
		<td><input class="product_box" id="sku" name="sku"></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><input class="product_box" id="name" name="name"></td>
	</tr>
	<tr>
		<td>Price ($)</td>
		<td><input class="product_box" id="price" name="price"></td>
	</tr>
</table> 

<br>
Type Switcher
<select class="product_box" name="productType" id="productType">
<option value="" disabled selected></option>
';

foreach ($typeList as $typeId => $productType)
{
	$typeName = $productType->getProductTypeName();
	echo "<option value='{$typeId}|{$typeName}'>{$typeName}</option>";
}

echo '
</select>
';

//dynamic attributes
echo '<div id="dynamicForm">';
foreach ($typeList as $typeId => $productType)
{
	$typeName = $productType->getProductTypeName();
	echo("<div style='display:none' id='{$typeName}'><table>");
	
	foreach ($productType->getAttributesList() as $attribute)
	{
		$attributeName = $attribute->getAttributeName();
		$attributeId = $attribute->getAttributeId();
		$attributeUnit = $attribute->getAttributeUnit();
		$attributeNameLowerCase = strtolower($attributeName);
		echo "
			<tr>
				<td>{$attributeName} ({$attributeUnit})</td>
				<td>
					<input class='product_box' 
						id='{$attributeNameLowerCase}' 
						name='typeAttributes[{$attributeId}|{$attributeNameLowerCase}]'>
				</td>
			</tr>";
	}
	$typeDescription = $productType->getProductTypeDescription();
	
	echo "
	<tr>
	<td colspan='2'>Please, provide {$typeDescription}</td>
	</tr>";
	
	echo "</table>";
	
	echo "</div>";
	
}

echo '</div>';

echo "
</form>
<hr>";
?> 

<script>

function isNumber(value)
{
	if (value.trim() == "")
	{
		return false;
		
	}
	
	if (!isNaN(Number(value)))
	{
		return true;
	}
	
	return false;
}
	
var emptyWarning = false;
var numberWarning = false;

function validateNumber(element)
{
	if (isNumber(element.value))
	{
		
		element.classList.remove("validation_warning");
		return true;
	}
	else
	{
		element.classList.add("validation_warning");
		numberWarning = true;
		return false;
	}
}

function validateEmpty(element)
{
	if (element.value.trim() == "")
	{
		element.classList.add("validation_warning");
		emptyWarning = true;
		return false;
	}
	else
	{
		element.classList.remove("validation_warning");
		return true;
	}
}

function validateEmptyElement(elementId)
{
	element = document.getElementById(elementId);
	return validateEmpty(element);
}

function validateForm()
{
	
	emptyWarning = false;
	numberWarning = false;
	
	result = true;
	
	result &= validateEmptyElement('sku');
	result &= validateEmptyElement('name');
	result &= validateEmptyElement('price');
	
	productType = document.getElementById('productType');
	result &= validateEmpty(productType);

	price = document.forms["product_form"]['price'];
	
	result &= validateNumber(price);
	
	document.getElementById('dynamicForm').querySelectorAll('div').forEach(function(eachDiv)
	{
		if (eachDiv.style.display == 'inline')
		{
			eachDiv.querySelectorAll('input').forEach(function(element)
			{
				result &= validateEmpty(element);
				result &= validateNumber(element);
			});
		}
	});
	
	notificationEmpty = document.getElementById('notification_empty');
	notificationNotNumber = document.getElementById('notification_notnumber');
	
	if (emptyWarning)
	{
		notificationEmpty.style.display = 'block';
	}
	else
	{
		notificationEmpty.style.display = 'none';
	}
	
	if (numberWarning)
	{
		notificationNotNumber.style.display = 'block';
	}
	else
	{
		notificationNotNumber.style.display = 'none';
	}
	
	console.log(emptyWarning);
	return result;
}

function submitForm()
{
	validation = validateForm();
	if (validation)
	{
		document.forms['product_form'].submit();
	}
}

function toggleDivElements(divName)
{
	document.getElementById(divName).querySelectorAll('input').forEach(function(element)
	{
		element.disabled=!element.disabled;
	});
}

//don't send all form elements
toggleDivElements('dynamicForm');

var productType = document.getElementById("productType");
var productTypeOldValue = productType.value;


//set select option to blank
productType.value = "";
function getElementSplitValue(value)
{
	return value.split("|")[1];
}
productType.onchange = function()
{
	var oldSubFormHide = document.getElementById(productTypeOldValue);
	if (oldSubFormHide)
	{
		oldSubFormHide.style.display = "none"; 
		toggleDivElements(productTypeOldValue);
		//console.log("hide:", productTypeOldValue);
	}
	
	var typeName = getElementSplitValue(this.value);
	
	var newSubFormShow = document.getElementById(typeName);
	toggleDivElements(typeName);
	
	newSubFormShow.style.display = "inline";
	//console.log("show:", typeName);
	
	productTypeOldValue = typeName;
};

</script>
</body>
</html>
 
