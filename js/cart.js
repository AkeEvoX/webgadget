var my_cart = {};

my_cart.list = function(){
	
	console.log('my list order');
	
	var list = $('#list_order');
	list.html("");
	/* column order */
	var column ="";
	column += "<tr>";
	column += "<th class='col-md-1'>ลำดับ</th>";
	column += "<th>รายการสินค้า</th>";
	column += "<th class='col-md-1'>ราคา</th>";
	column += "<th class='col-md-1'>จำนวน</th>";
	column += "<th class='col-md-1'>รวม</th>";
	column += "<th class='col-md-1'>&nbsp;</th>";
	column += "</tr>";
	
	list.append(column);
	
	/* list order detail */
	var endpoint = "services/cart.php";
	var method = "get";
	var data = {"type":"list","_":new Date().getMilliseconds()};
	var row = "";
	utility.service(endpoint,method,data,function(resp){
		console.warn(resp.items);
		if(resp.items == undefined) return ;
		$.each(resp.items,function(i,val){
			row += "<tr>";
			row += "<td>"+(i+1)+"</td>";
			row += "<td>"+val.title+"</td>";
			row += "<td>"+val.price+"</td>";
			row += "<td>"+val.unit+"</td>";
			row += "<td>"+val.net+"</td>";
			row += "<td><a href='javascript:void(0);' onclick=my_cart.remove('"+val.id+"') class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> ยกเลิก</a></td>";
			row += "</tr>";
		
		});
		list.append(row);
	});
	
}

my_cart.info = function(){
	
	var endpoint = "services/cart.php";
	var method = "get";
	var data = {"type":"info","_":new Date().getMilliseconds()};
	utility.service(endpoint,method,data,function(resp){
		console.warn("view cart");
		console.warn(resp);
		if(resp.items != undefined){
			$('#order_unit').html(resp.items.unit);
			$('#order_summary').html(resp.items.price);
		}
	});
	
}

my_cart.summarize = function(){
	
	var price_delivery = $('input[name=type_delivery]:checked').attr('price');
	//get total from info
	
	//calculate price include price delivery
	var endpoint = "services/cart.php";
	var method = "get";
	var data = {"type":"info","_":new Date().getMilliseconds()};
	utility.service(endpoint,method,data,function(resp){
		
		//resp.items.price
		var totel_net = parseFloat(resp.items.price) + parseFloat(price_delivery);
		$('#total_unit').val(resp.items.unit);
		$('#total_price').val(resp.items.price);
		$('#total_deliver').val(price_delivery);
		$('#total_net').val(totel_net);
	});
	
}

my_cart.add = function(item){
	
	var item = $('#'+item);
	var endpoint = "services/cart.php";
	var method = "get";
	var data = {"id":"","title":"","price":""};
	utility.service(endpoint,method,data,function(resp){
		
	});
	
}

my_cart.remove = function(id){
	
	var endpoint = "services/cart.php";
	var method = "get";
	var data = {"type":"remove","id":id,"_":new Date().getMilliseconds()};
	utility.service(endpoint,method,data,function(resp){
		
		my_cart.info();
		my_cart.list();
		my_cart.summarize();
	});
	
}