function ems_check(name,change,submit)
{
	
	if(change) //form data change
	{
		validate[name] = change;
		return true;
	}
	var error = 0;
	var form_id = "form";
	var first = "";
	
	
	//Name
	if(name == null){fname = "tracking"; validate["tracking"] = true;}else fname = name;
	if(fname == "tracking" && validate["tracking"] == true){
		id = "#"+form_id+" input[name="+fname+"]";
		var str = $(id).val();
		var n = str.length;
		var nfirst = str.substring(0,2);
		var ncenter = str.substring(2,11);
		var nlast = str.substring(12,13);
		
		if($(id).val() == "")
		{			
			if(tip_list[form_id+"_"+fname] == true)
			{
				$(id).qtip("enable");
				$(id).qtip("api").set("content.text","à¸à¸£à¸¸à¸“à¸²à¸à¸£à¸­à¸à¸‚à¹‰à¸­à¸¡à¸¹à¸¥");
			}else
			{
				tip(id,"input_error","à¸à¸£à¸¸à¸“à¸²à¸à¸£à¸­à¸à¸‚à¹‰à¸­à¸¡à¸¹à¸¥");
				tip_list[form_id+"_"+fname] = true;
			}
			$(id).addClass("input_error");
			error = 1;
		}else
		if(regExp14.exec(nfirst)!=undefined)
		{
			if(tip_list[form_id+"_"+fname] == true)
			{
				$(id).qtip("enable");
				$(id).qtip("api").set("content.text","à¸£à¸¹à¸›à¹à¸šà¸šà¹„à¸¡à¹ˆà¸–à¸¹à¸à¸•à¹‰à¸­à¸‡");
			}else
			{
				tip(id,"input_error","à¸£à¸¹à¸›à¹à¸šà¸šà¹„à¸¡à¹ˆà¸–à¸¹à¸à¸•à¹‰à¸­à¸‡");
				tip_list[form_id+"_"+fname] = true;
			}
			$(id).addClass("input_error");
			error = 1;
		}else
		if(regExp4.exec(ncenter)!=undefined)
		{			
			if(tip_list[form_id+"_"+fname] == true)
			{
				$(id).qtip("enable");
				$(id).qtip("api").set("content.text","à¸£à¸¹à¸›à¹à¸šà¸šà¹„à¸¡à¹ˆà¸–à¸¹à¸à¸•à¹‰à¸­à¸‡");
			}else
			{
				tip(id,"input_error","à¸£à¸¹à¸›à¹à¸šà¸šà¹„à¸¡à¹ˆà¸–à¸¹à¸à¸•à¹‰à¸­à¸‡");
				tip_list[form_id+"_"+fname] = true;
			}
			$(id).addClass("input_error");
			error = 1;
		}else
		if(regExp14.exec(nlast)!=undefined)
		{			
			if(tip_list[form_id+"_"+fname] == true)
			{
				$(id).qtip("enable");
				$(id).qtip("api").set("content.text","à¸£à¸¹à¸›à¹à¸šà¸šà¹„à¸¡à¹ˆà¸–à¸¹à¸à¸•à¹‰à¸­à¸‡");
			}else
			{
				tip(id,"input_error","à¸£à¸¹à¸›à¹à¸šà¸šà¹„à¸¡à¹ˆà¸–à¸¹à¸à¸•à¹‰à¸­à¸‡");
				tip_list[form_id+"_"+fname] = true;
			}
			$(id).addClass("input_error");
			error = 1;
		}else
		if(regExp1.exec($(id).val())!=undefined)
		{
			if(tip_list[form_id+"_"+fname] == true)
			{
				$(id).qtip("enable");
				$(id).qtip("api").set("content.text","à¹€à¸‰à¸žà¸²à¸°à¸ à¸²à¸©à¸²à¸­à¸±à¸‡à¸à¸¤à¸©à¹à¸¥à¸°à¸•à¸±à¸§à¹€à¸¥à¸‚");
			}else
			{
				tip(id,"input_error","à¹€à¸‰à¸žà¸²à¸°à¸ à¸²à¸©à¸²à¸­à¸±à¸‡à¸à¸¤à¸©à¹à¸¥à¸°à¸•à¸±à¸§à¹€à¸¥à¸‚");
				tip_list[form_id+"_"+fname] = true;
			}
			$(id).addClass("input_error");
			error = 1;
		}else
		if(n!=13)
		{
			if(tip_list[form_id+"_"+fname] == true)
			{
				$(id).qtip("enable");
				$(id).qtip("api").set("content.text","à¸žà¸´à¸¡à¸žà¹Œà¸«à¸¡à¸²à¸¢à¹€à¸¥à¸‚à¸ªà¸´à¹ˆà¸‡à¸‚à¸­à¸‡à¸ˆà¸³à¸™à¸§à¸™ 13 à¸«à¸¥à¸±à¸");
			}else
			{
				tip(id,"input_error","à¸žà¸´à¸¡à¸žà¹Œà¸«à¸¡à¸²à¸¢à¹€à¸¥à¸‚à¸ªà¸´à¹ˆà¸‡à¸‚à¸­à¸‡à¸ˆà¸³à¸™à¸§à¸™ 13 à¸«à¸¥à¸±à¸");
				tip_list[form_id+"_"+fname] = true;
			}
			$(id).addClass("input_error");
			error = 1;
		}else	
		if($(id).hasClass("input_error"))
		{
			$(id).qtip("hide").qtip("disable");
			$(id).removeClass("input_error");
		}
		if(error == 1 && first == "")
			first = fname;
	}
	if(error)
	{
		if(name == null)
			$("#"+form_id+" input[name="+first+"]").focus();
		return false;
	}else
	{
		if($("#"+form_id+" input").hasClass("input_error") || $("#"+form_id+" div").hasClass("area_error") || $('#form input[type=submit]').hasClass('submitted'))
		{
			return false
		}else
		{
			return true;
		}
		return true;
	}
}
titleDefault = '';
$(document).ready(function(){
	// $('.copy-block').mouseleave(function(){
	// 	$('#btn-copy img').css('opacity','0');
	// 	clearTimeout(copy_timeout);
	// });
	titleDefault = $('title').html();
});
function print_tracking_page(){
	var html = $('head').html()+$('#step-block').html()+'<br>'+$('#map-block')[0].innerHTML;
	WinPrint = window.open('', '', 'left=0,top=0,width=780,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(html);
	WinPrint.focus();
	WinPrint.document.close();
	setTimeout(function(){
		WinPrint.print();
		WinPrint.close();
	},100);
}
var num_retry = 0,
	max_retry = 3;
function start_tracking(tracking){
	num_retry++;
	tracking_submit(tracking,function(json){
		if(typeof json === 'undefined' || json == false || (json.status != 'success' && json.status !== 'invalid') ){
			if(num_retry < max_retry) {
				start_tracking(tracking);
			}else{
				num_retry = 0;
			}
		}
	});
}
keyupTrackingTimeout=false;
form2Timeout = false;
function start_tracking_iframe(tracking,keyup){
	clearTimeout(keyupTrackingTimeout);
	var pw = generatePass(32);
	var dragKey = '';
	for(var i=0;i<randomNumber(25,15);i++){
		dragKey+=generateDragBlock();
	}
	$('#btn-clear').hide();
	$('#loading-block').show();
	if(!keyup){
		$('#form input[name=tracking]').prop('disabled',true);
	}
	$('#form input[type=submit]').prop('disabled', true).addClass('submitted').val('à¸à¸£à¸¸à¸“à¸²à¸£à¸­à¸ªà¸±à¸à¸„à¸£à¸¹à¹ˆ...');
	$('title').html('à¸à¸³à¸¥à¸±à¸‡à¹‚à¸«à¸¥à¸”à¸‚à¹‰à¸­à¸¡à¸¹à¸¥...');
	$('#content-block').html('<form id="form_step1" action="http://track.thailandpost.co.th/tracking/Server.aspx" method="post" target="ems_step1" class="hide">' +
		'<input type="hidden" name="action" value="qaptcha" />' +
		'<input type="hidden" name="qaptcha_key" value="'+pw+'" />' +
		'</form>' +
		'<form id="form_step2" action="http://track.thailandpost.co.th/tracking/default.aspx" method="post" target="_blank" class="hide">' +
		'<input type="hidden" name="CaptchaCTL1$submit" value="Submit Query" />' +
		'<input type="hidden" name="TextBarcode" value="'+tracking+'" />' +
		'<input type="hidden" name="__EVENTARGUMENT" value="" />' +
		'<input type="hidden" name="__EVENTTARGET" value="" />' +
		'<input type="hidden" name="__VIEWSTATE" value="" />' +
		'<input type="hidden" name="__VIEWSTATEGENERATOR" value="240189C6" />' +
		'<input type="hidden" name="textkey" value="'+dragKey+'" />' +
		'<input type="hidden" name="'+pw+'" value="" />' +
		'</form>' +
		'<iframe name="ems_step1" id="ems_step1" src="about:blank" style="display: none;"></iframe><br />');
	/* +
	 '<iframe name="ems_step2" id="ems_step2" src="about:blank" width="780" height="740" frameborder="0" style="display: none;" ></iframe>');*/
	function form2_event(){
		$('#form input[name=tracking]').prop('disabled',false);
		$('#form button').prop('disabled', false).removeClass('submitted').val('à¸•à¸£à¸§à¸ˆà¸ªà¸­à¸šà¸ªà¸–à¸²à¸™à¸°à¸žà¸±à¸ªà¸”à¸¸ EMS');
		$('title').html(titleDefault);
		$('#loading-block').hide();
		$('#btn-clear').show();
		$('#form button').off('click').on('click',function(){
			if(ems_check(null,null,1)) {
				$('#form_step2').submit();
			}
		});
	}
	form2Timeout = setTimeout(function(){
		//just in case, form1 not load on some browser
		//add event submit to form2
		form2_event();
	},2500);
	$("#ems_step1").off('load').on("load",function(){
		/*$("#form_step2").submit();*/
		clearTimeout(form2Timeout);
		form2_event();
	});
	$('#form_step2').off('submit').on('submit',function(){
                if(!is_mobile)
                {
                    window.open('about:blank','Popup_Window','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=960,height=800,left = 312,top = 234');
                    $('#form_step2').attr('target','Popup_Window');
                }else
                {
                    $('#form_step2').attr('target','_self');
                }
            setTimeout(function(){
                start_tracking_iframe(tracking);
            },100);
	});
	$("#form_step1").submit();
	// $("#ems_step2").on("load",function(){
	// 	$('#loading-block').hide();
	// 	$('#ems_step2').show();
	// 	$('#form input[name=tracking]').prop('disabled',false);
	// 	$('#form input[type=submit]').prop('disabled', false).removeClass('submitted').val('à¸•à¸£à¸§à¸ˆà¸ªà¸­à¸šà¸ªà¸–à¸²à¸™à¸°à¸žà¸±à¸ªà¸”à¸¸ EMS');
	// 	$("html, body").animate({ scrollTop: $('#ems_step2').offset().top-120 }, 500);
	// 	$('title').html(titleDefault);
	// });
}
function generateDragBlock(){
	return '['+randomNumber(250,10)+','+randomNumber(50,10)+'],' ;
}
function randomNumber(max,min){
	return Math.round(Math.random() * (max - min) + min);
}
function generatePass(nb) {
	var chars = 'azertyupqsdfghjkmwxcvbn23456789AZERTYUPQSDFGHJKMWXCVBN_-#@';
	var pass = '';
	for(i=0;i<nb;i++){
		var wpos = Math.round(Math.random()*chars.length);
		pass += chars.substring(wpos,wpos+1);
	}
	return pass;
}
function tracking_submit(tracking,callback){
	$('#btn-clear').hide();
	$('#form').removeClass('active');
	$('#loading-block').show();
	$('#content-block').html('');
	$('#form input[name=tracking]').prop('disabled',true);
	$('#form input[type=submit]').prop('disabled', true).addClass('submitted').val('à¸à¸£à¸¸à¸“à¸²à¸£à¸­à¸ªà¸±à¸à¸„à¸£à¸¹à¹ˆ...');
	$('title').html('à¸à¸³à¸¥à¸±à¸‡à¹‚à¸«à¸¥à¸”à¸‚à¹‰à¸­à¸¡à¸¹à¸¥...');
	$.post(pre_dir+'process.php',{act:'tracking_ems',tracking:tracking,mobile_view:$('input[name=mobile_view]').val()},function(data){
		$('#loading-block').hide();
		$('#form input[name=tracking]').prop('disabled',false);
		$('#form input[type=submit]').prop('disabled', false).removeClass('submitted').val('à¸•à¸£à¸§à¸ˆà¸ªà¸­à¸šà¸ªà¸–à¸²à¸™à¸°à¸žà¸±à¸ªà¸”à¸¸ EMS');
		try{
			var json = $.parseJSON(data);
			if(json.status == 'switchToIframe'){
				window.location.reload();
				return;
			}
			$('#content-block').html(json.html);
			if(json.status =='success'){
				$('#form').addClass('active');
				$('#btn-clear').show();
				num_retry = max_retry;
			}
		}catch(e){
			console.log(e);
		}
		$('title').html(titleDefault);
		if(typeof callback == 'function'){
			callback(json);
		}
	}).fail(function(){
		$('#loading-block').hide();
		$('#form input[name=tracking]').prop('disabled',false);
		$('#form input[type=submit]').prop('disabled', false).removeClass('submitted').val('à¸•à¸£à¸§à¸ˆà¸ªà¸­à¸šà¸ªà¸–à¸²à¸™à¸°à¸žà¸±à¸ªà¸”à¸¸ EMS');
	});
}

var copy_timeout = false;
function copyToClipboard(elem) {
	// create hidden text element, if it doesn't already exist
	var targetId = "_hiddenCopyText_";
	var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
	var origSelectionStart, origSelectionEnd;
	if (isInput) {
		// can just use the original source element for the selection and copy
		target = elem;
		origSelectionStart = elem.selectionStart;
		origSelectionEnd = elem.selectionEnd;
	} else {
		// must use a temporary form element for the selection and copy
		target = document.getElementById(targetId);
		if (!target) {
			var target = document.createElement("textarea");
			target.style.position = "absolute";
			target.style.left = "-9999px";
			target.style.top = "0";
			target.id = targetId;
			document.body.appendChild(target);
		}
		target.textContent = elem.textContent;
	}
	// select the content
	var currentFocus = document.activeElement;
	target.focus();
	target.setSelectionRange(0, target.value.length);

	// copy the selection
	var succeed;
	try {
		succeed = document.execCommand("copy");
	} catch(e) {
		succeed = false;
	}
	// restore original focus
	if (currentFocus && typeof currentFocus.focus === "function") {
//				currentFocus.focus();
	}

	if (isInput) {
		// restore prior selection
		elem.setSelectionRange(origSelectionStart, origSelectionEnd);
	} else {
		// clear temporary content
		target.textContent = "";
	}
	$('#btn-copy img').css('opacity','1');
	clearTimeout(copy_timeout);
	copy_timeout = setTimeout((function(){$('#btn-copy img').hide()}),1500);
	return succeed;
}