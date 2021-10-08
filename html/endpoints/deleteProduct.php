<html>

<?php
set_include_path($_SERVER['DOCUMENT_ROOT']);

include_once 'classes/ProductDAO.php';

$post = $_POST;
$deleteBoxes = $post['checkBox'];

$productDAO = new ProductDao();

$productDeleteList = array();
foreach($deleteBoxes as $productId => $boxStatus)
{
	$productDeleteList[] = $productId;
}

$productDAO->massDelete($productDeleteList);

?>
<script>
window.location.replace("/");
</script>

</html>