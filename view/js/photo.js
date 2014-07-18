function getView(e){
	var view = $("#view");
	var big_img = $(".big_view");
	big_img.attr("src", $(e).attr("src"));
	var tags = $("#tags", view);
	var date = $(".photo_date", view);
	tags.text($(e).data("tags"));
	date.text($(e).data("date"));
	$("#photo_num").text($(e).data("number"));
	view.css({"display":'block'});
	$("#view_transparent").css({"display":"block"});
}

function hideView(){
	var view = document.getElementById("view");
	view.style.display = 'none';
	$("#view_transparent").css({"display":"none"});
}

function sort(){
	$("#not_found").remove();
	var type = $("input[name=sort]:radio:checked").val();
	if(type=="by_date"){
		sortByDate();
	}

	if(!checkPhotos()){
		$(".albom").append("<div id='not_found'>Такие фотографии не найдены =(</div>");
	}
}

function sortByDate(){
	var date = $("#date_field").val();

	$(".albom").children().each(function(e){
		//console.log($(this));
		if($(this).find("img").data("date") != date){
			$(this).css({"display":"none"});
		}else{
			$(this).css({"display":"block"});
		}
	});
	
}

function resetSort(){
	$(".albom").children().each(function(e){
		$(this).css({"display":"block"});
	});
	$("#not_found").remove();
}

function checkPhotos(){
	var f = false;
	$(".albom").children().each(function(e){
		if($(this).css("display") != "none"){
			f = true;
		}
	});
	
	return f;
}
	
function deletePhoto(){
	var id_p = $("#photo_num").text();

	$.post("photos/delete", {id:id_p},function(res){
		var result = $.parseJSON(res);
		if(result.res=="ok"){
			$(".photo").find("img[data-number="+id_p+"]").parent().remove()
		}
		hideView();
	});

}

function editTags(e){
	console.log($(e).text());
	$(e).parent().append("<div id='inp'><input id='input_tags' type='text' name='tags'><img id='ok' src='view/img/ok.png'></div>");
	$("#input_tags").val($(e).text());
	$(e).css({"display":"none"});
}


$(document).ready(function () {
	
	function setTags(){
		var id_p = $("#photo_num").text();
		var tags_p = $("#inp").val();

		$.post("photos/set", {action:"tags", id:id_p, tags: tags_p},function(res){
			var result = $.parseJSON(res);
			if(result.res=="ok"){
				lonsole.log(result);
				$("#tags").text(result.tegs);
			}
		});
	}

	$(".photo_tags").on('click', '#ok', 
		function(){
			var new_tags = $("#input_tags");
			console.log(new_tags.val());
			var id_p = $("#photo_num").text();
			var tags_p = $("#inp").val();

			$.post("photos/set", {action:"tags", id:id_p, tags: new_tags.val()},function(res){
				console.log(res);
				var result = $.parseJSON(res);
				if(result.res=="ok"){
					console.log(result);
					$("#tags").text(result.tags);
				}
			});
			var container = $(this).parent().parent();
			console.log(container);
			
			$(container).find("#tags").css({'display':'block'});
			$(container).find("#inp").remove();
			$(container).find("#tags").css({'display':'block'});
			
		}
	);	
	
	
	
	
});
