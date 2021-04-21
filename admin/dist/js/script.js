$(function(){

	let conversation_height = 0;
	$(".chat-list li").each(function(index, elelment){
		conversation_height += $(elelment).height();
	})
	$("#messages-container").animate({scrollTop: conversation_height + 1000})

	$(document).on("click", ".send_btn", function(){

		let the_message = $("#message-content").val();
		let id;
		if( $("#contact-list li.active").length > 0)
		{
			id = $("#contact-list li.active").attr("id").split("_")[1];
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
				url: "/admin/chat.php",
				type: "POST",
				dataType: "JSON",
				processData: false,
				contentType: false,
				data: formData,
				success: function(data)
				{
					let id = data.id;
					let conversation_height = 0;
					$("#"+id + " li").each(function(index, elelment){
						conversation_height += $(elelment).height();
					})
					
					$("#message-content").val("");
					$("#"+id).load(location.href + " #"+id + " li")
					$("#messages-container").animate({scrollTop: conversation_height + 1000})

					if( $("li.active").length === 0)
						$("#contact-list").load(location.href + " #contact-list > li")
						
				}
			})
		}
	})
	
	setInterval(function(){
		$(".chat-rbox").load(location.href + " .chat-rbox > ul")
	}, 5000);	
})