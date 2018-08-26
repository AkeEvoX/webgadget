var product = {};

$(document).ready(function(){

	$('#txt_search').on('keypress',function(e){

		if(e.which ===13){
			console.log('press enter on text search.');
			$('#btn_search').click();

		}
	});
	
	$('#btn_search').click(function(){
		var find = $('#txt_search').val();
		window.location='product_search.html?find='+find;
	});
	

});

product.top_product = function(objName){
	
	var view = $('#'+objName);
	var content = "";
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"list_top_product","_":new Date().getMilliseconds()};
	utility.service(endpoint,method,args,function(resp){
		
		$.each(resp.data,function(i,val){
		
			content += "<li class='list-group-item'><a href='product_detail.html?cate_pro_id="+val.id+"'>"+val.name+"</a></li>";
		
		});
		view.append(content);
	});
	
}

product.list_top_pro_brand = function(){
	
	var view = $('#view_top_pro_brand');
	var content = "";
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"list_top_pro_brand","_":new Date().getMilliseconds()};
	
	utility.service(endpoint,method,args,function(resp){
		
		
		
		$.each(resp.data,function(i,val){
		//pro_brand_id
			content += "<li class='list-group-item'><a href='product_model.html?pro_brand_id="+val.id+"'>"+val.name+"</a></li>";
		
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

product.search = function(find){
	
	$('#product_mode').html("รายการรสินค้า");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"search","find":find,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td class='col-sm-4 col-md-4'>ยี่ห้อ</td>";
	content += "<td>รายการ</td>";
	content += "</tr>";
	
		utility.service(endpoint,method,args,function(resp){
			
		if(resp==undefined || resp.data==null){ 
			console.warn("list product model is empty") ;
			content = "<tr><td colspan='3' class='text-center'>ไม่พบข้อมูลสินค้า</td></tr>"
		} 
		else{
			$.each(resp.data,function(index,val){		
				index+=1;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td>"+val.brand_name+"</td>";
				content+= "<td><a href='product_detail.html?cate_pro_id="+val.id+"' >"+val.name+"</a></td>";
				content+= "</tr>";
			});
		
		}
		
		
		view_item.append(content);
	});
	
	
}

product.load_lastupdate = function(objName){
	
	var view = $('#'+objName);
	var content = "";
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"list_pro_update","_":new Date().getMilliseconds()};
	
	utility.service(endpoint,method,args,function(resp){
		
		$.each(resp.data,function(i,val){
		
			content += "<div class='col-md-4'>";
			content += "<div class='thumbnail' style='height:450px;'>";
			content += "<a href='product_detail.html?cate_pro_id="+val.id+"' >";
			//content += "<div style='height:200px;' > ";
			content += "<img src='"+val.thumbnail+"' style='height:250px;' alt='sample'>";
			//content += "</div>";
			content += "<div class='caption'>";
			content += "<h3>"+val.name+"</h3>";
			content += "<p>ราคา : "+val.price+" บาท</p><a/>";
			content += "<p class='text-center'><a href='product_detail.html?cate_pro_id="+val.id+"' class='btn btn-primary' role='button'>เลือกสินค้า</a></p>";
			content += "</div>";
			content += "</div>";
			content += "</div>";
		
		});
		$('#'+objName).html(content);
		//view.append(content);	
	});
	
}
/* pending */
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

product.load_item = function(){
	
	var cate_pro_id = utility.querystr("cate_pro_id");
	var pro_model_id = utility.querystr("pro_model_id");
	var pro_brand_id = utility.querystr("pro_brand_id");
	var cate_id = utility.querystr("cate_id");
	
	var result = "-1";
	var menu = $('#menu_bar');
	var pro_name = $('#product_name');
	var code = $('#inpCode');
	var title = $('#inpName');
	var brand = $('#inpBrand');
	var last_update = $('#inpUpdate');
	var status = $('#inpStatus');
	var price = $('#inpPrice');
	var detail = $('#product_detail');
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"item","cate_pro_id":cate_pro_id,"pro_model_id":pro_model_id,"pro_brand_id":pro_brand_id,"cate_id":cate_id,"_":new Date().getMilliseconds()};
	
	utility.service(endpoint,method,args,function(resp){
		
		//console.log(resp.navi);
		if(resp.navi != undefined){
			menu.append("<li><a href='product_brand.html?cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>");
			//category_brand_model.html?pro_brand_id=1&cate_id=1
			menu.append("<li><a href='category_brand_model.html?pro_brand_id="+resp.navi.lv2_id+"&cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv2_name+"</a></li>");
			menu.append("<li class='active'>"+resp.navi.lv4_name+"</li>");
		}
		
		if(resp==undefined || resp.data==null){ 
			console.warn("product not found.");
			return result; 
		}

		/*  show product info */
		$('#pro_info').css("display","block");
		
		var code_data = resp.data.code == undefined ? "-" : resp.data.code ;
		
		code.html(code_data);
		brand.html(resp.data.brand_name);
		pro_name.html(resp.data.name);
		title.html(resp.data.name);
		detail.html(resp.data.detail);
		
		if(resp.data.status=="1")
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
	product.load_gallery(cate_pro_id);
	//load color
	product.load_color(cate_pro_id);
	
	console.warn("load product complete.");

}

product.load_brand_model_pro_detail = function(){
	
	var cate_pro_id = utility.querystr("cate_pro_id");
	var pro_model_id = utility.querystr("pro_model_id");
	var pro_brand_id = utility.querystr("pro_brand_id");
	
	var result = "-1";
	var menu = $('#menu_bar');
	var pro_name = $('#product_name');
	var code = $('#inpCode');
	var title = $('#inpName');
	var brand = $('#inpBrand');
	var last_update = $('#inpUpdate');
	var status = $('#inpStatus');
	var price = $('#inpPrice');
	var detail = $('#product_detail');
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"brand_model_pro_detail_item","cate_pro_id":cate_pro_id,"pro_model_id":pro_model_id,"pro_brand_id":pro_brand_id,"_":new Date().getMilliseconds()};
	
	utility.service(endpoint,method,args,function(resp){
		
		//console.log(resp.navi);
		if(resp.navi != undefined){
			menu.append("<li><a href='product_model.html?pro_brand_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>");
			menu.append("<li><a href='product_model_category.html?pro_brand_id="+resp.navi.lv1_id+"&pro_model_id="+resp.navi.lv2_id+"'>"+resp.navi.lv2_name+"</a></li>");
			menu.append("<li class='active'>"+resp.navi.lv3_name +"</li>");
		}
		
		if(resp==undefined || resp.data==null){ 
			console.warn("product not found.");
			return result; 
		}

		/*  show product info */
		$('#pro_info').css("display","block");
		
		var code_data = resp.data.code == undefined ? "-" : resp.data.code ;
		
		code.html(code_data);
		brand.html(resp.data.brand_name);
		pro_name.html(resp.data.name);
		title.html(resp.data.name);
		
		if(resp.data.detail == ""){
			detail.html("ขออภัย !! ทางร้านอยู่ระหว่างการอัพเดจข้อมูลค่ะ.");
		}else{
			detail.html(resp.data.detail);	
		}
		
		
		if(resp.data.status=="1")
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
	product.load_gallery(cate_pro_id);

	console.warn("load product complete.");

}

product.load_gallery = function(id){
	
	var gallery = $('#product_gallery');
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"gallery","id":id,"_":new Date().getMilliseconds()};
	var item = "";
	utility.service(endpoint,method,args,function(resp){
		
		
		if(resp.data == undefined){
			gallery.html("ขออภัย !! ไม่พบข้อมูลรูปสินค้า.");
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

product.load_color = function(id){
	
	var color_list = $('.pagination');
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"color","id":id,"_":new Date().getMilliseconds()};
	var item = "";


	color_list.html(""); //clear item color 

	utility.service(endpoint,method,args,function(resp){
		
		if(resp.data == undefined || resp.data ==null){
			
			$('#color_set').css('display','none'); /* hide color set */
			return;
		}
		
		$.each(resp.data,function(i,val){
			
			//item +="<li id='color_"+val.id+"' data-id='"+val.id+"' data-name='"+val.name+"' ><a href='#menu_bar' style='background-color: "+val.code+";'>&nbsp;</a></li>";
			//example :: <li id="color_1" data-name='pink'><a href="#" style='background-color: #ff99ff;'>&nbsp;</a></li>
			item +="<li id='color_"+val.id+"' data-id='"+val.id+"' data-name='"+val.name+"'  ><span style='cursor:pointer ;background-color: "+val.code+";'>&nbsp;</span></li>";
			
		});

		color_list.append(item);
		
		
		
		/* event pick color */
		$('.pagination span').click(function(e){
		
			/*unactive*/
			$('.pagination li.active').removeClass('active');
			/*active*/
			var item = $(this).closest('li');
			item.addClass('active');	
			$('#inpColor').val(item.attr('data-id'));
			$('#nameColor').html(item.attr('data-name'));
			//console.log("pick color is " + $('#inpColor').val());
			
		});

		
	});
	
}

product.show_color = function(obj){

}

product.select = function(){
	
	var id = utility.querystr("cate_pro_id");
	var title = $('#inpName').html();
	var price = $('#inpPrice').html();
	var unit = $('#inpAmount').val();
	var color = $('#inpColor').val();
	var colorName = $('#nameColor').html();
	var colorVisible = $('#color_set').css('display');
	if(unit=="" || unit=="0"){
		alert('กรุณาระบุจำนวนสินค้าที่ต้องการ');
	}
	else if (colorVisible == "block")
	{
		alert('กรุณาเลือกสีสินค้า.');
		return;
	}
	else{
		window.location='services/cart.php?type=add&id='+id+"&title="+title+"&price="+price+"&unit="+unit+"&color="+color + "&colorName="+ colorName;
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

product.list_cate = function(objName){
	var menu = $('#menu_bar');
	var view = $('#'+objName);
	var content = "";
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_cate","_":new Date().getMilliseconds()};
	
	utility.service(endpoint,method,args,function(resp){
		
		
		
		if(resp.navi != null)
			menu.append("<li class='active'>"+resp.navi.lv1_name+"</li>");
		
		
		$.each(resp.data,function(i,val){
			
			//content += "<li class='list-group-item'><a href='category_brand.html?cate_id="+val.id+"'>"+val.name+"</a></li>";
			content += "<li class='list-group-item'><a href='product_brand.html?cate_id="+val.id+"'>"+val.name+"</a></li>";
		
		});
		
		view.append(content);	
	});

}

product.list_cate_brand = function(cate_id){
	
	$('#product_mode').html("รายการยี่ห้อ ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_cate_brand","cate_id":cate_id,"_":new Date().getMilliseconds()};
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td>รายการ</td>";
	content += "<td class='col-sm-1 col-md-1'></td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		menu.append("<li class='active'>"+resp.navi.lv1_name+"</li>");
		
		if(resp==undefined || resp.data==null){ 
			console.warn("list cate brand is empty") ;
			content = "<tr><td colspan='3' class='text-center'>ไม่พบข้อมูลยี่ห้อ</td></tr>"
		} else{
		
			$.each(resp.data,function(index,val){
				index+=1;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td><a href='category_model.html?cate_brand_id="+val.id+"' >"+val.name+"</a></td>";
				content+= "<td></td>";
				content+= "</tr>";
			
			});
		}
		
		view_item.append(content);
		
	});
	
}

product.list_cate_model = function(cate_brand_id){
	
	$('#product_mode').html("รายการประเภทสินค้า ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_cate_model","cate_brand_id":cate_brand_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td>รายการ</td>";
	content += "<td class='col-sm-1 col-md-1'></td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		menu.append("<li><a href='category_brand.html?cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>");
		menu.append("<li class='active'>"+resp.navi.lv2_name+"</li>");
		
		if(resp==undefined || resp.data==null){ 
		
			console.warn("list cate model is empty") ;
			content = "<tr><td colspan='3' class='text-center'>ไม่พบข้อมูลรุ่นสินค้า</td></tr>"
			
		} else {
		
			$.each(resp.data,function(index,val){		
				index+=1;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td><a href='category_product.html?cate_model_id="+val.id+"' >"+val.name+"</a></td>";
				content+= "<td></td>";
				content+= "</tr>";
			});
		}
		
		
		view_item.append(content);
	});
	
}

product.list_cate_product = function(cate_model_id){
	
	$('#product_mode').html("รายการประเภทสินค้า ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_cate_product","cate_model_id":cate_model_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td>รายการ</td>";
	content += "<td>ยี่ห้อ</td>";
	content += "<td>ราคา</td>";
	content += "<td>ปรับปรุง</td>";
	content += "<td class='col-sm-1 col-md-1'></td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		if(resp.navi != null){
			menu.append("<li><a href='category_brand.html?cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>");
			menu.append("<li><a href='category_model.html?cate_brand_id="+resp.navi.lv2_id+"'>"+resp.navi.lv2_name+"</a></li>");
			menu.append("<li class='active'>"+resp.navi.lv3_name+"</li>");
		}
		
		if(resp==undefined || resp.data==null){ 
		
			console.warn("list cate model is empty") ;
			content = "<tr><td colspan='3' class='text-center'>ไม่พบข้อมูลรุ่นสินค้า</td></tr>"
			
		} else {
		
			$.each(resp.data,function(index,val){		
				index+=1;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td><a href='product_detail.html?cate_pro_id="+val.id+"' >"+ val.name + "</a></td>";
				content+= "<td>"+val.brand_name+"</td>";
				content+= "<td>"+val.price+"</td>";
				content+= "<td>"+val.update+"</td>";
				content+= "</tr>";
			});
		}
		
		
		view_item.append(content);
	});
	
}

product.list_cate_model_by_id = function(pro_model_id){
	
	var pro_model_id = utility.querystr("pro_model_id");
	var pro_brand_id = utility.querystr("pro_brand_id");
	var cate_id = utility.querystr("cate_id");
	
	$('#product_mode').html("รายการประเภทสินค้า ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_cate_model_by_id","pro_model_id":pro_model_id,"pro_brand_id":pro_brand_id,"cate_id":cate_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td>รายการ</td>";
	content += "<td >รุ่น</td>";
	content += "<td >ราคา</td>";
	content += "<td >ปรับปรุง</td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		if(resp.navi != null){
			menu.append("<li><a href='product_brand.html?cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>"); // case TPU
			menu.append("<li><a href='product_model.html?pro_brand_id="+resp.navi.lv2_id+"&cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv2_name+"</a></li>"); // Iphone
			menu.append("<li class='active'>"+resp.navi.lv3_name+"</li>"); //iphone 7 
		}
		
		if(resp==undefined || resp.data==null){ 
		
			console.warn("list cate model is empty") ;
			content = "<tr><td colspan='3' class='text-center'>ไม่พบข้อมูลรุ่นสินค้า</td></tr>"
			
		} else {
		
			$.each(resp.data,function(index,val){		
				index+=1;
				navi = "product_detail.html?cate_pro_id="+val.cate_pro_id + "&pro_model_id=" + pro_model_id +"&pro_brand_id="+pro_brand_id+"&cate_id=" + cate_id;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td><a href='"+navi+"' >"+val.model_name+"</a></td>";
				content+= "<td>"+val.brand_name+"</td>";
				content+= "<td>"+val.price+"</td>";
				content+= "<td>"+val.update+"</td>";
				content+= "</tr>";
			});
		}
		
		
		view_item.append(content);
	});
	
}

product.list_product_model = function(cate_model_id){
	
	$('#product_mode').html("รายการรุ่นสินค้า ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_cate_product","cate_model_id":cate_model_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td class='col-sm-1 col-md-1'>ยี่ห้อ</td>";
	content += "<td>รายการ</td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		menu.append("<li><a href='category_brand.html?cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>");
		menu.append("<li><a href='category_model.html?cate_brand_id="+resp.navi.lv2_id+"'>"+resp.navi.lv2_name+"</a></li>");
		menu.append("<li class='active'>"+resp.navi.lv3_name+"</li>");
		
		if(resp==undefined || resp.data==null){ 
			console.warn("list product model is empty") ;
			content = "<tr><td colspan='3' class='text-center'>ไม่พบข้อมูลสินค้า</td></tr>"
		} 
		else{
			$.each(resp.data,function(index,val){		
				index+=1;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td>"+val.brand_name+"</td>";
				content+= "<td><a href='product_detail.html?cate_pro_id="+val.id+"' >"+val.name+"</a></td>";
				content+= "</tr>";
			});
		
		}
		
		
		view_item.append(content);
	});
	
}

product.list_product_model_category = function(pro_model_id){
	
	var pro_model_id = utility.querystr("pro_model_id");
	var pro_brand_id = utility.querystr("pro_brand_id");
	// var cate_id = utility.querystr("cate_id");
	
	$('#product_mode').html("รายการประเภทสินค้า ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_product_model_category","pro_model_id":pro_model_id,"pro_brand_id":pro_brand_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td>รายการ</td>";
	content += "<td >รุ่น</td>";
	content += "<td >ราคา</td>";
	content += "<td >ปรับปรุง</td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		if(resp.navi != null){
			
			menu.append("<li><a href='product_model.html?pro_brand_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>"); // Iphone
			menu.append("<li class='active'>"+resp.navi.lv2_name+"</li>"); //iphone 7 
			
		}
		
		if(resp==undefined || resp.data==null){ 
		
			console.warn("list cate model is empty") ;
			content = "<tr><td colspan='3' class='text-center'>ไม่พบข้อมูลรุ่นสินค้า</td></tr>"
			
		} else {
		
			$.each(resp.data,function(index,val){		
				index+=1;
				navi = "brand_model_product_detail.html?cate_pro_id="+val.cate_pro_id + "&pro_model_id=" + pro_model_id +"&pro_brand_id="+pro_brand_id;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td><a href='"+navi+"' >"+val.model_name+"</a></td>";
				content+= "<td>"+val.brand_name+"</td>";
				content+= "<td>"+val.price+"</td>";
				content+= "<td>"+val.update+"</td>";
				content+= "</tr>";
			});
		}
		
		
		view_item.append(content);
	});
	
}

product.list_product = function(pro_brand_id){
	
	$('#product_mode').html("รายการรสินค้า");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_pro_brand","pro_brand_id":pro_brand_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td class='col-sm-1 col-md-1'>ยี่ห้อ</td>";
	content += "<td>รายการ</td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		console.log(" navi path = " + JSON.stringify(resp.navi));
		menu.append("<li class='active'>"+resp.navi.name+"</li>");
		
		if(resp==undefined || resp.data==null){ 
			console.warn("list product model is empty") ;
			content = "<tr><td colspan='3' class='text-center'>ไม่พบข้อมูลสินค้า</td></tr>"
		} 
		else{
			$.each(resp.data,function(index,val){		
				index+=1;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td>"+val.brand_name+"</td>";
				content+= "<td><a href='product_detail.html?cate_pro_id="+val.id+"' >"+val.name+"</a></td>";
				content+= "</tr>";
			});
		}
		view_item.append(content);
	});
	
}

product.list_model_of_brand = function(){
	
	var pro_brand_id = utility.querystr("pro_brand_id");
	var cate_id = utility.querystr("cate_id");
	
	$('#product_mode').html("รายการรุ่นสินค้า ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_model_of_brand","pro_brand_id":pro_brand_id,"cate_id":cate_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td class='col-sm-11 col-md-11'>รุ่นสินค้า</td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		if(resp.navi != null){
			
			if(resp.navi.lv2_id != undefined){
				menu.append("<li ><a href='product_brand.html?cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>");
				menu.append("<li class='active'>"+resp.navi.lv2_name+"</li>");
			}
			else{
				menu.append("<li class='active'>"+resp.navi.lv1_name+"</li>");
			}
			
		}
		
		if(resp==undefined || resp.data==null){ 
			console.warn("list product model is empty") ;
			content = "<tr><td colspan='2' class='text-center'>ไม่พบข้อมูลสินค้า</td></tr>"
		} 
		else{
			$.each(resp.data,function(index,val){		
				index+=1;
				
				if(resp.navi.lv2_id != undefined){
					navi = "category_brand_model.html?pro_model_id="+val.id+"&pro_brand_id="+pro_brand_id +"&cate_id="+cate_id;
				}
				else{
					navi = "product_model_category.html?pro_model_id="+val.id+"&pro_brand_id="+pro_brand_id;
				}
				
				
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td><a href='"+navi+"' >"+val.name+"</a></td>";
				content+= "</tr>";
			});
		
		}
		
		
		view_item.append(content);
	});
	
}


product.list_model_of_category = function(){
	
	var pro_brand_id = utility.querystr("pro_brand_id");
	var cate_id = utility.querystr("cate_id");
	
	$('#product_mode').html("รายการรุ่นสินค้า ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_model_of_category","pro_brand_id":pro_brand_id,"cate_id":cate_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td class='col-sm-2 col-md-3'>สินค้า</td>";
	content += "<td class='col-sm-5 col-md-4'>รุ่นสินค้า</td>";
	content += "<td class='col-sm-2 col-md-1'>ราคา</td>";
	content += "<td class='col-sm-2 col-md-2'>ปรับปรุงวันที่</td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		if(resp.navi != null){
		
			menu.append("<li ><a href='product_brand.html?cate_id="+resp.navi.lv1_id+"'>"+resp.navi.lv1_name+"</a></li>");
			menu.append("<li class='active'>"+resp.navi.lv2_name+"</li>");
		
		}
		
		if(resp==undefined || resp.data==null){ 
			console.warn("list product model is empty") ;
			content = "<tr><td colspan='2' class='text-center'>ไม่พบข้อมูลสินค้า</td></tr>"
		} 
		else{
			$.each(resp.data,function(index,val){		
				index+=1;
				
				navi = "product_detail.html?pro_model_id="+val.model_id+"&pro_brand_id="+pro_brand_id +"&cate_id="+cate_id+"&cate_pro_id="+val.pro_id;
				
				/*
				"cate_pro_id":cate_pro_id,
				"pro_model_id":pro_model_id
				,"pro_brand_id":pro_brand_id
				,"cate_id":cate_id
				*/
				
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td>"+val.cate_name+"</td>";
				content+= "<td><a href='"+navi+"' >"+val.model_name+"</a></td>";
				content+= "<td>"+val.price+"</td>";
				content+= "<td>"+val.update+"</td>";
				content+= "</tr>";
			});
		
		}
		
		
		view_item.append(content);
	});
	
}

product.list_pro_brand_of_category = function(){
	
	var cate_id = utility.querystr("cate_id");
	
	$('#product_mode').html("รายการรุ่นสินค้า ");
	var menu = $('#menu_bar');
	var view_item = $('#view_products');
	
	var endpoint = "services/products.php";
	var method = "get";
	var args = {"service":"view_pro_brand_of_category","cate_id":cate_id,"_":new Date().getMilliseconds()};
	
	var item ="";
	var index = 0;
	var content = "";
	var navi = "";
	
	var content = "<tr>";
	content += "<td class='col-sm-1 col-md-1'>No.</td>";
	content += "<td class='col-sm-11 col-md-11'>ยี่ห้อสินค้า</td>";
	content += "</tr>";
	
	utility.service(endpoint,method,args,function(resp){
		
		if(resp.navi != null){
			menu.append("<li class='active'>"+resp.navi.lv1_name+"</li>");
		}
		
		if(resp==undefined || resp.data==null){ 
			console.warn("list product model is empty") ;
			content = "<tr><td colspan='2' class='text-center'>ไม่พบช้อมูลยี่ห้อสินค้า</td></tr>"
		} 
		else{
			$.each(resp.data,function(index,val){		
				navi = "category_brand_model.html?pro_brand_id="+val.id+"&cate_id="+cate_id;
				
				index+=1;
				content+= "<tr>";
				content+= "<td>"+index+"</td>";
				content+= "<td><a href='"+navi+"' >"+val.name+"</a></td>";
				content+= "</tr>";
			});
		
		}
		
		
		view_item.append(content);
	});
}

product.upload_images = function(args){
	
	var endpoint = "services/cate_product_service.php?type=upload_gallery";
	var method = "POST";
	utility.data(endpoint,method,args,function(data){
		
		
		var response = JSON.parse(data);
		console.debug(response);
		
		//$('#result').css('display','none');
		alert(response.result);
		//control.pagetab('gallery-manager.html');
		
	});
	
}
