var common = {};


/* initial image */
$(document).ready(function(){
	
	//load baner
	common.load_braner();	
	
	//loan picture slider
	common.load_pic_slider();
	
	
});

common.load_province = function(view){
	var obj = $('#'+view);
	obj.html("");
	$.getJSON("js/data/province.json",function(items){
		
		$.each(items,function(i,val){
				obj.append("<option value='"+val.name+"'>"+val.name+"</option>")
		});
		
	});
	
}

common.load_content = function(){
	 var content = $('#home_content');
	//home_content
	
	$.getJSON("services/common.php?type=content",function(resp){
		
		if(resp.data.detail !='' )
			content.html(resp.data.detail);
		
	});
}

common.load_certificate = function(){
	
	var info = $('#certificate_info');
	var img = $('#certificate_img');
	
	
	$.getJSON("services/common.php?type=certificate",function(resp){
		
		console.log(resp.data.detail);
		
		if(resp.data.detail==null){
			$('#certificate_view').hide();
			return;
		}
		
		if(resp.data.detail !='' )
			info.val(resp.data.detail);
		
		if(resp.data.thumbnail != '')
			img.attr('src',resp.data.thumbnail);
		
	});
	
}

common.load_braner = function(){

	var logo = $('#page_braner');
	$.getJSON("services/common.php?type=braner",function(resp){
		logo.attr('src',resp.data.thumbnail);
	});
	
	
};

//logoSlider
common.load_pic_slider = function(){
	
	var logo = $('#logoSlider');

	$.ajaxSetup({
	    async: false
	});
	$.getJSON("services/common.php?type=pic_slider",function(resp){
		
		
		$.each(resp.data,function(i,val){
			logo.append("<li class='item-"+char_index[i]+"'><img src='"+val.thumbnail+"' ></li>");
		});
			
			/*
			style='width:100%;height:200px;' 
			$('#logoSlider').lightSlider({
				auto:true,
				autoWidth:true,
				loop:true,
				speed:600
			});	
			*/
		
	});

	$.ajaxSetup({
	    async: true
	});

	$('#logoSlider').lightSlider({
	auto:true
	,autoWidth:true
	,loop:true
	,speed:600});
	
		
	
	console.warn('load picture complete');
		
}

var char_index = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q"];