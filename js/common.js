var common = {};


/* initial image */
$(document).ready(function(){
	
	//load baner
	common.load_braner();	
	
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
var _slider;
//logoSlider
common.load_pic_slider = function(){
	
	var logo = $('#logoSlider');
	var _slider_state = 'wait';
	$.ajaxSetup({
	    async: false
	});
	
	$.getJSON("services/common.php?type=pic_slider",function(resp){
		
		
		$.each(resp.data,function(i,val){
			logo.append("<li class='item-"+char_index[i]+"'><img src='"+val.thumbnail+"' ></li>");
		});
			
		_slider = $('#logoSlider').lightSlider({
		autoWidth:true
		,auto:true
		,loop:true
		,adaptiveHeight:true });
			
		console.warn('load picture has complete');
		
	});
	
	setTimeout(
	function() 
	{
		_slider.refresh();
		console.warn('wait loader slider has complete');
	//do something special
	}, 1000);
	
	$.ajaxSetup({
	    async: true
	});
	
}

var char_index = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q"];