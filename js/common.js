var common = {};

common.load_province = function(view){
	var obj = $('#'+view);
	obj.html("");
	$.getJSON("js/data/province.json",function(items){
		
		$.each(items,function(i,val){
				obj.append("<option value='"+val.name+"'>"+val.name+"</option>")
		});
		
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
		/*
		$.each(items,function(i,val){
				obj.append("<option value='"+val.name+"'>"+val.name+"</option>")
		});*/
		
	});
	
}
