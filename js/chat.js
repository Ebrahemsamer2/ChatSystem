$(document).ready(function(){
	let height = $(".msg_card_body > div").height();
	$("#"+$(".msg_card_body").attr("id")).animate({scrollTop: height})
		
	$('#action_menu_btn').click(function(){
		$('.action_menu').toggle();
	});

	setTimeout(function(){
		$(".message-hide").hide();
	}, 5000);

	$(document).on("click", ".contacts li", function(){
		let id = $(this).attr("id").split("_")[1];
		let url = "/?chat=1&cid="+id;
		window.location.href = url;
	});

	$(document).on("click", ".send_btn", function(){

		let the_message = $(this).parents(".send_area").find("textarea").val();
		let id;
		if( $("li.active").length > 0)
		{
			id = $("li.active").attr("id").split("_")[1];
		}
		else 
		{
			id = window.location.href.split("cid=")[1];
		}
		
		if(the_message !== "")
		{
			let formData = new FormData();
			formData.append("the_message", the_message)
			formData.append("id", id)
			formData.append("send_message", 1)

			$.ajax({
				url: "includes/chat.php",
				type: "POST",
				dataType: "JSON",
				processData: false,
				contentType: false,
				data: formData,
				success: function(data)
				{
					if(data.success)
					{
						let id = data.id;
						$("#send_input").val("");
						$("#"+id).load(location.href + " #"+id + " > div")
						
						let height = $(".msg_card_body > div").height();
						$("#"+$(".msg_card_body").attr("id")).animate({scrollTop: height})

						if( $("li.active").length === 0)
							$("#contact-list").load(location.href + " #contact-list > li")

					}else
					{
						if(data.status == 0)
							window.location.href = '/?login=1';
 					}
				}
			})
		}
	})
	setInterval(function(){
		$(".msg_card_body").load(location.href + " .msg_card_body > div")
	}, 5000);
});