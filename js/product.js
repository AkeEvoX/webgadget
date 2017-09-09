var product = {};

product.load_lastupdate = function(objName){
	
	
	var items = "";
	
	for(var i =0 ; i < 10 ; i++){
		
		items += "<div class='col-md-4'>";
		items += "<div class='thumbnail'>";
		items += "<img src='images/products/8p.jpg' alt='sample'>";
		items += "<div class='caption'>";
		items += "<h3>shengo premium slim case (T129)</h3>";
		items += "<p>ราคา : 200 บาท</p>";
		items += "<p class='text-center'><a href='#' class='btn btn-primary' role='button'>เลือกสินค้า</a></p>";
		items += "</div>";
		items += "</div>";
		items += "</div>";
		
	}
	
	$('#'+objName).html(items);
	
}

product.relation = function(proid,obj){
	
	
	var result = "";
	
	
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
	
	for(var i = 0 ; i < 4 ; i++){
		result += "<li><a href='product_detail.html?id=321' ><div class='col-sm-12 col-md-12'>";
		result += "<div class='thumbnail'>";
		result += "<img src='images/products/8p.jpg' alt='iPhone 8'>";
		result += "<div class='caption'>";
		result += "<h3>Iphone 8</h3>";
		result += "<p>Price : 100 บาท</p>";
		result += "</div>";
		result += "</div>";
		result += "</div></a></li>";
	}
	
	$('#'+obj).html(result);
	
}
