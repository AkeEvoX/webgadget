var news = {};

news.feeds = function(){
	
	
	var items = {
		"1":{"title":"ประกาศวันหยุดร้านโฟกัสแกดเจ็ต พ.ศ. 2560","types":"ข่าวสาร","date":"09-09-2560 10:15" }
		,"2":{"title":"วิธีติดฟิล์มกันรอยโฟกัส","types":"รีวิว","date":"09-09-2560 11:15" }
		,"3":{"title":"วีดีโอแนะนำ HERO Tempered Glass (High Quality)","types":" โปรโมชั่น","date":"09-09-2560 12:15" }
		} ;
	
	
	var view = $('#view_news');
	
	var content = "";
	
	/*set title */
	content += "<tr>";
	content += "<td>เรื่อง</td>";
	content += "<td>ประเภท</td>";
	content += "<td>วันที่</td>";
	content += "</tr>";
	
	$.each(items,function(i,val){
		
		//console.log(val.title);
		content += "<tr>";
		content += "<td>"+val.title+"</td>";
		content += "<td>"+val.types+"</td>";
		content += "<td>"+val.date+"</td>";
		content += "</tr>";
		
	});
	
	view.append(content);
	
	
	
	
	
}