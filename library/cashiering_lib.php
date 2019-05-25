<?php

	class get_item{
		
		private $db;
	
		function __construct($con)
		{
				$this->db = $con;
		}
		public function get_invoice_number($get_invoice){
			try {
				$stmt = $this->db->prepare($get_invoice);
				$stmt->execute();
				if ($stmt->rowCount()>0) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$invoice_number = $row['invoice_number'];
						$invoice_number ++;
						$number = sprintf('%010d', $invoice_number);
						header('Location: sales.php?invoice='.$number);
					}
				}else{
					header('Location: sales.php?invoice=0000000001');
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		public function get_product($barcode){
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM `tbl_items` WHERE item_code = :barcode");
				$stmt->execute(array(":barcode"=>$barcode));				
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				if ($row > 0) {
					return $row;
				}else{
					return false;
					exit();
				}

			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

		public function insert_invoice_detail($invoice_number, $item_id, $item_quantity, $item_unit_price, $item_amount, $vat, $total_price){
			try
			{
				$stmt = $this->db->prepare("INSERT INTO `invoice_details` (`invoice_number`, `item_id`, `item_quantity`, `item_unit_price`, `item_amount`, `vat`, `total_price`) VALUES (:invoice_number, :item_id, :item_quantity, :item_unit_price, :item_amount, :vat, :total_price)");
				$stmt->bindParam(":invoice_number", $invoice_number);
				$stmt->bindParam(":item_id", $item_id);
				$stmt->bindParam(":item_quantity", $item_quantity);
				$stmt->bindParam(":item_unit_price", $item_unit_price);
				$stmt->bindParam(":item_amount", $item_amount);
				$stmt->bindParam(":vat", $vat);
				$stmt->bindParam(":total_price", $total_price);
				$stmt->execute();
				return true;
				
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}
		}

		public function load_items($invoice){
			try {
				$pre_load = $this->db->prepare("SELECT id.*, i.`item_name` FROM `invoice_details` id left join `tbl_items` i on id.`item_id` = i.`item_id` WHERE `invoice_number` = $invoice");
				$pre_load->execute();
				if ($pre_load->rowCount()>0) {
					$x = 1;
					while ($items = $pre_load->fetch(PDO::FETCH_ASSOC)) {
						?>
					        <tr>
					        	<td class="text-center"><?php echo $x++; ?></td>
								<td class="text-center"><?php echo $items['item_name']; ?></td>
								<td><i><img src="./demo/peso.png" width="12"></i><?php echo $items["item_unit_price"]?></td>
								<td>
									<!-- UNIT ITEM QUANTITY Default value 1 -->
									<input class="form-control form-control-sm" type="number" value="<?php echo $items["item_quantity"]; ?>" name="item_quantity[]">
								</td>

								<td><input type="name" name="item_price[]" id="" class="form-control form-control-sm unit_price" value="<?php echo $items['item_amount'];?>" readonly></td>
		                        <td><?php echo round($items["vat"], 2);?></td>
		                        <td><?php echo $items["total_price"]?></td>
								</td>
								<!-- <td><i><img src="./demo/peso.png" width="12"></i><a class="total_price_per_item" disabled><?php echo $items["item_price"]?></div></td> -->
								<td><a href="./remove_item.php?id=<?php echo $items['id']."&invoice=".$invoice."&item_id=".$items['item_id']; ?>" data-index="" id="" class="btn btn-icon btn-primary btn-danger btn-sm"><i class="fe fe-trash"></i></a></td>
							</tr>	
							<!-- <script>
								$(document).ready(function(){
									$('.quantity_<?php echo $items['id']; ?>').on('change',function(){								
										var quantity = $(this).val();
										var item_price = <?php echo $items['item_price']; ?>;
										var total_price_per_item = item_price * quantity;
										if (quantity < 1) {
											$(this).val(1);
											return false;
										}else{
											 $('#total_price_per_item_<?php echo $items['item_id']; ?>').val(total_price_per_item.toFixed(2));
											 $('#barcode').focus();
										}
									})
								});
								$(document).ready(function(){
								    $(".<?php echo 'remove_'.$items["id"];?>").click(function(){
								    	var value = $(this).data('index');
								        $("tr").remove("#<?php echo 'remove_'.$items["id"];?>");
								    });
								}); 
							</script> -->
						<?php
					}
				}
			} catch (PDOException $e) {
				echo $e->getMessage();	
				return false;
			}
		}
		public function update_stock_out_item_quantity($item_id, $quantity){
				$stmt = $this->db->prepare("UPDATE `tbl_items` SET `item_quantity`= `item_quantity` - :quantity WHERE `item_id` = :item_id");
				$stmt->bindParam(":quantity", $quantity);
				$stmt->bindParam(":item_id", $item_id);
				$stmt->execute();
				return true;
		}
		public function update_stock_in_item_quantity(){

		}

		public function get_total_payment($invoice){
			try
			{
				$stmt = $this->db->prepare("SELECT ROUND(SUM(`total_price`),2) as 'total_payment' FROM invoice_details WHERE `invoice_number` = $invoice");
				$stmt->execute();			
				if ($stmt->rowCount()>0) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$total_payment = $row['total_payment'];
						if(is_null($total_payment) || empty($total_payment)){
							echo '<input type="text" name="total_payment" id="total_payment" class="form-control form-control-lg text-right tst" value="0.00" autocomplete="none" readonly>';
						}else{
							echo '<input type="text" name="total_payment" id="total_payment" class="form-control form-control-lg text-right tst" value="'.$total_payment.'" autocomplete="none" readonly>';
						}
						
					}
				}

			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

		public function invoice_success($invoice_number, $total_payment, $cash_tendered, $change){
			try {
				$customer_name = "";
				$clerk_id = 1;
				$stmt = $this->db->prepare("INSERT INTO `invoice`(`invoice_number`, `customer_name`, `total_amount_p`, `amount_paid`, `cash_change`, `date_transaction`, `clerk_id`) VALUES (:invoice_number, :customer_name, :total_payment, :cash_tendered, :change, NOW(), :clerk_id)");
				$stmt->bindParam(":invoice_number", $invoice_number);
				$stmt->bindParam(":total_payment", $total_payment);
				$stmt->bindParam(":cash_tendered", $cash_tendered);
				$stmt->bindParam(":change", $change);
				$stmt->bindParam(":customer_name", $customer_name);
				$stmt->bindParam(":clerk_id", $clerk_id);
				$stmt->execute();
				return true;
			} catch (PDOException $e) {
				echo $e->getMessage();
			}

		}

		public function get_invoice_details($id){
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM `invoice_details` WHERE id = :id");
				$stmt->execute(array(":id"=>$id));				
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				if ($row > 0) {
					return $row;
				}else{
					return false;
					exit();
				}

			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

		public function remove_item($id){
			try {

				$stmt = $this->db->prepare("DELETE FROM `invoice_details` WHERE id = :id");
				$stmt->execute(array(":id"=>$id));
				if ($stmt) {
					return true;
				}else{
					return false;
				}

			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

		public function return_stock_quantity($item_id, $item_quantity){
			try {
				$stmt = $this->db->prepare("UPDATE `tbl_items` SET `item_quantity`= `item_quantity` + :item_quantity WHERE `item_id` = $item_id");
				$stmt->bindParam(":item_id", $item_id);
				$stmt->bindParam(":item_quantity", $item_quantity);
				if ($stmt) {
					return true;
				}else{
					return false;
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

	}
?>