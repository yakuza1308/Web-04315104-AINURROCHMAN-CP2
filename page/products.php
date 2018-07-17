<?php
	$sql = "SELECT * FROM product";
	$product_list = $conn->query($sql);
	$sql = "SELECT * FROM product_type";
	$product_type = $conn->query($sql);

	function mask_productcode($product_id){
		$code = 135000000;
		$code+=$product_id;
		echo "P".$code;
	}

	function get_type_name($type_id,$product_type){
		$type_name = "";
		foreach ($product_type as $d) {
		    if($d["id"] == $type_id){
		    	$type_name = $d["name"];
		    }
		}
		echo $type_name;
	}
?>
<script type="text/javascript">
	var Product = {
		Mode:ko.observable(""),
		Data:{
			code:ko.observable(""),
			name:ko.observable(""),
			type:ko.observable(""),
			description:ko.observable(""),
			color:ko.observable(""),
		},
	}
	Product.Reset = function(){

	}
	Product.Cancel = function(){
		Product.Mode("");
	}
	Product.Add = function(){
		Product.Mode("add");
		model.page_subtitle("Add New")
	}
	Product.Edit = function(code,name,type,description,color){
		Product.Mode("edit");
		model.page_subtitle("Edit");
		var d = Product.Data;
		d.code(code);
		d.name(name);
		d.type(type);
		d.description(description);
		d.color(color);
	}
	Product.Save = function(){
		var parm = model.get_parameter("product",Product.Data,"code");
		var url = "insert.php";
		if(Product.Mode()=="edit"){
			url = "update.php";
			var set = "name='"+Product.Data.name()+"',type='"+Product.Data.type()+"',description='"+Product.Data.description()+"',color='"+Product.Data.color()+"'"
			parm = {
				table:"product",
				set:set,
				where:"code="+Product.Data.code(),
			}
		}
		$.post(url,parm,function(res){
			if(res.indexOf("Error")==0){
				alert(res);
				return false;
			}
			alert("Product successfully saved");
			location.reload();
		})
	}
	Product.Delete = function(id){
		var parm = {table:"product",id:id};
		$.post("delete.php",parm,function(res){
			if(res.indexOf("Error")==0){
				alert(res);
				return false;
			}
			alert("Product successfully removed");
			location.reload();
		})
	}
</script>
<div class="col-md-12" data-bind="with:Product">
	<div class="row" data-bind="if:Mode()!==''">
		<div class="col-md-8"">
			<div class="row">
				<div class="col-md-12 form" data-bind="with:Data">
					<div class="row">
						<div class="col-md-5">
							<input type="text" class="form-control input-sm" data-bind="value:name" placeholder="Input Product Name"/>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
							<select class="form-control input-sm" data-bind="value:type" >
							 <option value="">Select Product Type</option>
						  	<?php
						  	if ($product_type->num_rows > 0) {
							    while($row = $product_type->fetch_assoc()) {
							        ?>
								<option value="<?=$row['id']?>"><?=$row['name']?></option>
								<?php
								}
							}
						  	?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<textarea data-bind="text:description" class="form-control input-sm" placeholder="Input Product Description"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="text" class="form-control input-sm" data-bind="value:color" placeholder="Input Product Color (use '/' for multiple color)"/>
						</div>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<button class="btn btn-sm btn-outline-secondary" data-bind="click:Reset">Reset</button>
					<button class="btn btn-sm btn-outline-secondary" data-bind="click:Cancel">Cancel</button>
					<button class="btn btn-sm btn-success" data-bind="click:Save">Save</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row" data-bind="if:Mode()==''">
		<div class="col-md-12 action-table">
			<div class="row">
				<div class="col-md-10">
					<button class="btn btn-sm btn-outline-secondary" data-bind="click:Add">Add New Product</button>
				</div>
				<div class="col-md-2 text-right">
					<div class="btn-group ml-2">
						<button class="btn btn-sm btn-outline-secondary">PDF</button>
						<button class="btn btn-sm btn-outline-secondary">XLS</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped table-sm">
				  <thead>
				    <tr>
				      <th width="50px">#</th>
				      <th width="100px">Code</th>
				      <th width="150px">Type</th>
				      <th>Name</th>
				      <th width="200px">Available Color</th>
				      <th width="50px">Stock</th>
				      <th width="100px">&nbsp;</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php
				  	if ($product_list->num_rows > 0) {
					    // output data of each row
					    $no = 1;
					    while($row = $product_list->fetch_assoc()) {
					        ?>
					        <tr>
						      <td><?=$no?></td>
						      <td><?=mask_productcode($row["code"])?></td>
						      <td><?=get_type_name($row["type"],$product_type)?></td>
						      <td><?=$row["name"]?></td>
						      <td><?=$row["color"]?></td>
						      <td>10000</td>
						      <td class="text-center">
									<div class="btn-group mr-2">
										<button class="btn btn-sm btn-outline-secondary" onclick="Product.Edit('<?=$row["code"]?>','<?=$row["name"]?>','<?=$row["type"]?>','<?=$row["description"]?>','<?=$row["color"]?>')">
											<span data-feather="edit"></span>
										</button>
										<button class="btn btn-sm btn-outline-secondary" onclick="Product.Delete('<?=$row["code"]?>')">
											<span data-feather="delete"></span>
										</button>
									</div>
						      </td>
						    </tr>
					        <?php
					        $no++;
					    }
					} else {
						?>
					    <tr>
				      		<td colspan="7">No data to display</td>
				  		</tr>
					<?php
					}
				  	?>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>