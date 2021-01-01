var lastTimeID = 0;

$(document).ready(function() {
	$('#chatInput').focus();
	$('#btnSend').click(function(){
		sendChatText();
		$('#chatInput').val("");
		$('#chatInput').focus();
	});
	startChat();

	var input = document.getElementById("chatInput");
	input.addEventListener("keyup", function(event) {
	  if(event.keyCode === 13) {
	    sendChatText();
	    $('#chatInput').val('');
		$('#chatInput').focus();
	  }
	});
});

function sendChatText() {
	var chatInput = $('#chatInput').val();
	if(chatInput != "") {
		$.ajax({
			type: "GET",
			url: "submit.php?chattext=" + encodeURIComponent( chatInput ) + '&hash='+hash
		});
	}
}

function startChat() {
	setInterval(function(){ getChatText(); }, 2000);
}

function getChatText() {
	$.ajax({
		type: "GET",
		url: "refresh.php?lastTimeID="+lastTimeID+'&hash='+hash
	}).done(function( data ) {
		var jsonData = JSON.parse(data);
		var jsonLength = jsonData.results.length;
		var html = '';
		for (var i = 0; i < jsonLength; i++) {
			var result = jsonData.results[i];
			if(lastTimeID != result.id)
	        document.getElementById('alarm').muted = false;
			document.getElementById('alarm').play();

			html += '<div style="clear: both;">';
				html += '<span style="color:#333; font-size: 20px;"><b>' + result.usrname +'</b>: '+result.chattext+ '<br />';
				html += '<span style="color:#aaa; font-size: 14px;">' + result.chattime + '</span></span></div>';
			html += '</div><br /><br />';
			lastTimeID = result.id;
		}
		$('#view_ajax').append(html);
		$("#view_ajax").scrollTop($("#view_ajax")[0].scrollHeight);
	});
}
