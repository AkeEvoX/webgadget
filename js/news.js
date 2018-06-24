var news = {};

news.feeds = function(){
	
	var view = $('#view_news');
	var content = "";
	
	/*set title */
	content = initial_column_news();
	

	var endpoint = "services/news.php?type=list&_=" + new Date().getMilliseconds();

	$.get(endpoint,function(resp){

		console.warn(resp.data);

		$.each(resp.data,function(i,val){
			
			//console.log(val.title);
			content += "<tr>";
			content += "<td><a href='news_detail.html?type=item&id="+val.id+"' >"+val.title+"</a></td>";
			content += "<td>"+val.news_type+"</td>";
			content += "<td>"+val.update+"</td>";
			content += "</tr>";
			
		});

		view.append(content);

	},"JSON");
	
	
	
	
	
}


news.top = function(){
	
	
	
}

news.views = function(){

	

	var id = utility.querystr("id");
	var title = $('#news_title');
	var detail = $('#news_detail');
	var update = $('#news_update');
	var source = "services/news.php?type=item&id=" + id + "&_="+ new Date().getMilliseconds();
	$.get(source,function(resp){

		console.warn(resp);

		if(resp.data==null) 
		{
			console.warn("data is empty.");
			return;
		}

		var thumbnail = "";
		if(resp.data.thumbnail!=null)
			thumbnail = '<center><img src="'+ resp.data.thumbnail +'"></img></center></br>';
		//title

		$('#news_title').html(resp.data.title);

		//detail
		$('#news_detail').html(thumbnail + resp.data.detail);
		//update
		$('#news_update').html(resp.data.update);

	},"JSON");


}

function initial_column_news(){

	var column = "";

	column += "<tr>";
	column += "<td>เรื่อง</td>";
	column += "<td>ประเภท</td>";
	column += "<td>วันที่</td>";
	column += "</tr>";

	return column;

}