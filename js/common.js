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
