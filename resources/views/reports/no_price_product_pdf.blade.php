<style>
table, th, td {
	border: none;
    border-collapse: collapse;
}
th, td {
    padding: 20px;
}
</style>
<table width="100%">
<?php foreach (array_chunk($pdfprodata, 3) as $row) { ?>
    <tr>
    <?php foreach ($row as $value) { ?>
    	<td>
			<?php 
        		if($value['Primaryimage']) {
				// added for external link.
					if($value['image_external_link']) {
						 $productImage = '';
					} else {
						$productImageUrl = url('/').'/public/uploads/product_images/' . $user_id . '/' . $value['Primaryimage'];
						if (@getimagesize($productImageUrl) !== false) {
							$productImage = '<img src="'.$productImageUrl.'" style="width:140px; height:140px;" />';
						} else {
							$newImageUrl = url('/').'/public/uploads/product_images/coming-soon.png';
                    		$productImage = '<img src="'.$newImageUrl.'" style="width:140px; height:140px;" />';
						}
                        
                    }
					
                } else {
                	$productImageUrl = url('/').'/public/uploads/product_images/coming-soon.png';
                    $productImage = '<img src="'.$productImageUrl.'" style="width:140px; height:140px;" />';
                }
            ?>
        <p style="text-align: center; padding: 0px; margin: 0px;">{!! $productImage !!}</p>
        <p style="text-align: center; font-size: 11px; padding: 0px; margin: 0px;"><?php echo $value['ProductName'] ?></p>
        <p style="text-align: center; font-size: 11px; padding: 0px; margin-top: 5px;"><?php echo $value['Sku'] ?></p>
    	</td>
    <?php } ?>
    </tr>
<?php } ?>
</table>