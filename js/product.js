var product = {};


product.top_list = function(objName){
	
	var view = $('#'+objName);
	var content = "";
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"top_list","_":new Date().getMilliseconds()};
	utility.service(endpoint,method,args,function(resp){
		
		$.each(resp.data,function(i,val){
		
			content += "<li class='list-group-item'><a href='product_detail.html?id="+val.id+"'>"+val.title+"</a></li>";
		
		});
		view.append(content);
	});
	
	
	
	
}

product.list_brand = function(objName){
	
	var view = $('#'+objName);
	var content = "";
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"list_brand","_":new Date().getMilliseconds()};
	
	utility.service(endpoint,method,args,function(resp){
		
		$.each(resp.data,function(i,val){
		
			content += "<li class='list-group-item'><a href='product_category.html?service=view&view=type_product&hw_brand="+val.id+"'>"+val.name+"</a></li>";
		
		});
		
		view.append(content);	
	});

};

product.list = function(objName){

	var view = $('#'+objName);
	var content = "";
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"list","_":new Date().getMilliseconds()};
	
	utility.service(endpoint,method,args,function(resp){
		
		
		$.each(resp.data,function(i,val){
			
			content += "<li class='list-group-item'><a href='product_category.html?service=view&view=type_brand&t_prod="+val.id+"'>"+val.name+"</a></li>";
		
		});
		
		view.append(content);	
	});

	
	
	
}

product.load_lastupdate = function(objName){
	
	var items = [
		{"id":"1","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
		,{"id":"2","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
		,{"id":"3","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
		,{"id":"4","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
		,{"id":"5","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
		,{"id":"6","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
		,{"id":"7","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
		,{"id":"8","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
		,{"id":"9","title":"shengo premium slim case (T129)","price":"200","image":"images/products/8p.jpg"}
	];
	
	var content = "";
	
	$.each(items,function(i,val){
		content += "<div class='col-md-4'>";
		content += "<div class='thumbnail'>";
		content += "<a href='product_detail.html?id="+val.id+"' >";
		content += "<img src='"+val.image+"' alt='sample'>";
		content += "<div class='caption'>";
		content += "<h3>"+val.title+"</h3>";
		content += "<p>ราคา : "+val.price+" บาท</p><a/>";
		content += "<p class='text-center'><a href='product_detail.html?id="+val.id+"' class='btn btn-primary' role='button'>เลือกสินค้า</a></p>";
		content += "</div>";
		content += "</div>";
		content += "</div>";
		
	});
	
	$('#'+objName).html(content);
	
}

product.relation = function(proid,obj){
	
	
	var items = [
	{"id":"1","title":"","price":"100","date":"09-09-2560 09:23"}
	,{"id":"2","title":"","price":"100","date":"09-09-2560 09:23"}
	,{"id":"3","title":"","price":"100","date":"09-09-2560 09:23"}
	,{"id":"4","title":"","price":"100","date":"09-09-2560 09:23"}
	,{"id":"5","title":"","price":"100","date":"09-09-2560 09:23"}
	,{"id":"6","title":"","price":"100","date":"09-09-2560 09:23"}
	];
	
	var content = "";
	$.each(items,function(i,val){
		content += "<li><a href='product_detail.html?id=321' ><div class='col-sm-12 col-md-12'>";
		content += "<div class='thumbnail'>";
		content += "<img src='images/products/8p.jpg' alt='iPhone 8'>";
		content += "<div class='caption'>";
		content += "<h3>Iphone 8</h3>";
		content += "<p>Price : 100 บาท</p>";
		content += "</div>";
		content += "</div>";
		content += "</div></a></li>";
	});
	
	
	$('#'+obj).html(content);
	
}

product.load_item = function(id){
	
	var code = $('#inpCode');
	var title = $('#inpName');
	var last_update = $('#inpUpdate');
	var status = $('#inpStatus');
	var price = $('#inpPrice');
	var detail = $('#product_detail');
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"item","id":id,"_":new Date().getMilliseconds()};
	
	utility.service(endpoint,method,args,function(resp){
		
		code.html(resp.data.code);
		title.html(resp.data.title);
		detail.html(resp.data.detail);
		
		if(resp.data.active=="1")
		{
			status.html("<span class='btn btn-success'><span class='glyphicon glyphicon-ok-circle'></span> มีสินค้า</span>");
		}
		else{
			status.html("<span class='btn btn-danger'><span class='glyphicon glyphicon-ok-circle'></span> สินค้าหมด</span>");
		}
		
		price.html(resp.data.price);
		last_update.html(resp.data.update);
		
		
	});
	
	//load gallery;
	product.load_gallery(id);
}

product.load_gallery = function(id){
	
	var gallery = $('#product_gallery');
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"gallery","id":id,"_":new Date().getMilliseconds()};
	var item = "";
	utility.service(endpoint,method,args,function(resp){
		
		
		if(resp.data == undefined){
			$('#product_detail').html("ขออภัย !! ไม่พบรายละเอียดสินค้า.");
			return;
		}
		$.each(resp.data,function(i,val){
			
			item +="<img alt='image' src='"+val.url+"' data-image='"+val.url+"' data-description='image'>";
			
		});
		
		gallery.append(item);
		
		//setting gallery
		$('#product_gallery').unitegallery({
			theme_panel_position: "bottom"
			//,gallery_height:470
			//,gallery_width:400
			,gallery_theme: "grid"
			,slider_scale_mode: "fit"  
			,thumb_width:120
			,thumb_height:100
			,thumb_fixed_size:false
			,thumb_loader_type:"light"
			,grid_num_cols:1
			,grid_num_rows:2
			,gridpanel_grid_align: "top"
		});
	});
	
}

product.select = function(){
	
	var id = utility.querystr("id");
	var title = $('#inpName').html();
	var price = $('#inpPrice').html();
	var unit = $('#inpAmount').val();
	
	if(unit==""){
		alert('กรุณาระบุจำนวนสินค้าที่ต้องการ');
	}
	else{
		window.location='services/cart.php?type=add&id='+id+"&title="+title+"&price="+price+"&unit="+unit;	
	}
	
	
	
}

product.view_list = function(service,view,t_prod,t_brand,hw_brand,hw_model){
	
	var title = $('#product_mode');
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	var endpoint = "services/products.php";
	var method = "get";
	
	/*force redirect*/
		console.warn("current view is " + view);
		if(view=="hardware_brand" && hw_brand!="null"){
			console.warn("redirect view hardware_brand to product_model");
			view = "hardward_modal";
		}
	
	var args = {"service":service,"view":view,"t_prod":t_prod,"t_brand":t_brand,"hw_brand":hw_brand,"hw_model":hw_model,"_":new Date().getMilliseconds()};
	var item ="";
	var index = 0;
	var content = "";
	var param = "";//"&t_prod="+t_prod+"&t_brand="+t_brand+"&hw_brand="+hw_brand+"&hw_model="+hw_model
	var navi = "";
	utility.service(endpoint,method,args,function(resp){
		
		
		if(resp==undefined || resp.data==null){ console.warn("view "+view+" response is empty") ;return ;} 
		
		/*set title */
		content = "<tr>";
		content += "<td class='col-sm-1 col-md-1'>No.</td>";
		content += "<td>รายการ</td>";
		content += "<td class='col-sm-1 col-md-1'></td>";
		content += "</tr>";
		view_item.append(content);
		
		$.each(resp.data,function(i,val){		
		
		console.log("item : " + JSON.stringify(val));
			index +=1;
			switch(view){
				case "type_product":
					title.html("ประเภทสินค้า");
					
					//navi = "<li >ประเภทสินค้า</li>";
					navi = "<li class='active'> "+val.hw_brand_name+"</li>";
					param = "&t_prod="+val.type_pro_id+"&hw_brand="+val.hw_brand_id;
					item+= "<tr>";
					item+= "<td>"+index+"</td>";
					item+= "<td><a href='product_category.html?service=view&view=type_brand"+param+"' >"+val.type_pro_name+"</a></td>";
					item+= "<td></td>";
					item+= "</tr>";
				break;
				case "type_brand":
				
					title.html("ยี่ห้อตามประเภทสินค้า");
					navi = "<li > "+val.type_pro_name+"</li>";
					navi += "<li class='active'>ประเภทยี่ห้อ "+val.hw_brand_name+"</li>";
					param = "&t_prod="+t_prod+"&t_brand="+val.type_brand_id+"&hw_brand="+hw_brand;
					item+= "<tr>";
					item+= "<td>"+index+"</td>";
					item+= "<td><a href='product_category.html?service=view&view=hardware_brand"+param+"' >"+val.type_brand_name+"</a></td>";
					item+= "<td></td>";
					item+= "</tr>";
					
				break;
				case "hardware_brand":
					title.html("ยี่ห้อสินค้า");
					navi = "<li > "+val.type_pro_name+"</li>";
					navi = "<li > "+val.type_brand_name+"</li>";
					param = "&t_prod="+t_prod+"&t_brand="+t_brand+"&hw_brand="+hw_brand;
					item+= "<tr>";
					item+= "<td>"+index+"</td>";
					item+= "<td><a href='product_category.html?service=view&view=hardward_modal"+param+"' >"+val.name+"</a></td>";
					item+= "<td></td>";
					item+= "</tr>";
				break;
				case "hardward_modal":
					title.html("รุ่นสินค้า");
					
					
					navi = "<li > "+val.type_pro_name+"</li>";
					navi += "<li > "+val.type_brand_name+"</li>";
					navi += "<li class='active'> "+val.hw_brand_name+"</li>";
					
					param = "&t_prod="+t_prod+"&t_brand="+t_brand+"&hw_brand="+hw_brand+"&hw_model="+val.hw_model_id;
					item+= "<tr>";
					item+= "<td>"+index+"</td>";
					item+= "<td><a href='product_category.html?service=view&view=product"+param+"' >"+val.hw_model_name+"</a></td>";
					item+= "<td></td>";
					item+= "</tr>";
				break;
				case "product":
					title.html("รายการสินค้า");
					navi = "<li > "+val.type_pro_name+"</li>";
					navi += "<li > "+val.type_brand_name+"</li>";
					navi += "<li > "+val.hw_brand_name+"</li>";
					navi += "<li class='active'> "+val.hw_model_name+"</li>";
					
					item+= "<tr>";
					item+= "<td>"+index+"</td>";
					item+= "<td><a href='product_detail.html?id="+val.pro_id+"'>"+val.pro_name+"</a></a>";
					item+= "<td>"+val.price+"</td>";
					item+= "</tr>";
				break;
			}
	
		
		});
		menu.append(navi);
		view_item.append(item);
		
	});
	
	
}