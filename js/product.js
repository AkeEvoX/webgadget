var product = {};

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
		content += "<img src='"+val.image+"' alt='sample'>";
		content += "<div class='caption'>";
		content += "<h3>"+val.title+"</h3>";
		content += "<p>ราคา : "+val.price+" บาท</p>";
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

	/*
	  <div class="col-sm-6 col-md-4">
			<div class="thumbnail">
			  <img src="..." alt="...">
			  <div class="caption">
				<h3>Thumbnail label</h3>
				<p>...</p>
				<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
			  </div>
			</div>
		  </div>
	*/
	
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
	/*
	for(var i = 0 ; i < 4 ; i++){
		content += "<li><a href='product_detail.html?id=321' ><div class='col-sm-12 col-md-12'>";
		content += "<div class='thumbnail'>";
		content += "<img src='images/products/8p.jpg' alt='iPhone 8'>";
		content += "<div class='caption'>";
		content += "<h3>Iphone 8</h3>";
		content += "<p>Price : 100 บาท</p>";
		content += "</div>";
		content += "</div>";
		content += "</div></a></li>";
	}*/
	
	$('#'+obj).html(content);
	
}


