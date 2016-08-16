$(window).on('load resize', function(){
	//写真の高さ取得
	var sw_photoH = $("#sw_photo>img").innerHeight();
	$("#sw_photo").css("height",sw_photoH+"px");
});
$(function(){
	var click_flg = false;
	$("#sw_navi a").click(function(){
	 if(click_flg == false) {
			click_flg = true;
			$("#sw_photo img").before("<img class='demo' src='"+$(this).attr("href")+"' alt=''>");
			$("#sw_photo img:last").stop(true, false).fadeOut("fast",function(){
			 $(this).remove();click_flg = false;});
				return false;
		}else{
			return false;
		}
	});
});


//1ページに複数の場合
$(window).on('load resize', function(){
	//写真の高さ取得
	var sw_photoH = $(".mod_gallery_sw_photo>img").innerHeight();
	$(".mod_gallery_sw_photo").css("height",sw_photoH+"px");
});
$(function(){
	var click_flg = false;
	$(".mod_gallery_sw_navi a").click(function(){
	 if(click_flg == false) {
			click_flg = true;
			var classname = $(this).attr("class");
			$("div."+classname+" img").before("<img class='demo' src='"+$(this).attr("href")+"' alt=''>");
			$("div."+classname+" img:last").stop(true, false).fadeOut("fast",function(){
			 $(this).remove();click_flg = false;});
				 return false;
		}else{
			return false;
		}
	});
});

