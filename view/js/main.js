function displayCountItems(count){
	var display ="";
	if(count > 0){
		if(count%10 == 1 && count != 11){
			display = "товар";
		}else{
			if(count%10>=2 && count%10<=4 && ( count < 5 || count>14)){
				display = "товара";
			}
			else{
				display = "товаров";
			}
			
		}
		$("#countItems").text(count + " " +display);
	}else{
		$("#countItems").text(" пуста");
	}

	
}

function add(id){
	$.post("/cart/add", {item_id: id},function(res){
		
		if(res.stat == "OK"){
			var count = res.count;
			
			displayCountItems(count);
		}
	});
}




function reSum(){
	total =0;
	if($("td#sum").length != 0){
		$("td#sum").each(function(index, el){
			total += Number($(el).text());
		});
		$("#total").text(total);
	}else{
		$("#total").text("");
	}
	
}

function changeCount(elem, id){
	var item = $(elem);
	console.log(item.parent());
	price = item.parent().prev().text();
	count = item.val();
	if(count >0){
		$.post("/cart/count",{item_id: id, count: count},function(res){
			if(res.stat == "OK"){
				sum = price*count;
				
				item.parent().next().text(sum);
				displayCountItems(res.gcount);
				reSum();
			}
		});
		
	}else{
		deleteItem(item.parent(), id);
	}
}

function deleteItem(el, id){
	$.post("/cart/delete",{item_id: id},function(res){
		if(res.stat=="OK"){
			$(el).parent().remove();
			reSum();
			displayCountItems(res.count);
			if(res.count==0){
				$("#orderBtn").remove();
			}
		}
	});
	
	
	
}



$(document).ready(function(){
	reSum();
});