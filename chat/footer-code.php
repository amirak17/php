<style type="text/css">
	.onlinechat-button { border-radius: 5px; cursor: pointer; bottom: 50px; right: 20px; padding: 20px; position: fixed; background-color: rgba(255,255,255,.95); text-align: center; }
	.onlinechat-window { border-radius: 5px; background-color: #fff; display: none; bottom: 150px; right: 20px; padding: 3px; position: fixed; border: 0px solid #ddd; }
</style>
<div onclick="jQuery('#chat-frame').toggle();" class="onlinechat-button">
  <img width="35" src="/chat/chat.png" /><br />
  <span style="color: #333;">Online<br />Chat</span>
</div>
<iframe id="chat-frame" class="onlinechat-window" src="https://abc.com/chat" width="350" height="460" frameborder="0"></iframe>
