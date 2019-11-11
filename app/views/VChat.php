Chat
https://www.bootdey.com/snippets//User-profile-with-friends-and-chat

<div class="tab-pane" id="tab-chat">
    <div class="conversation-wrapper">
        <div class="conversation-content">
            <div id="slimScrollDiv" class="slimScrollDiv" style="overflow: scroll;position: relative; width: auto; height: 500px;">
                <div class="conversation-inner" style=" width: auto; height: 500px;">

					<div id="MessageReceive">

					</div>

                </div>
                <div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div>
                <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
            </div>
        </div>
        <div class="conversation-new-message">

                <div class="form-group">
                    <textarea id="message_value" class="form-control" onkeyup="clee(event,1,2);" name="message" rows="2" placeholder="Enter your message..."></textarea>
                </div>

                <div class="clearfix">

                    <button onclick="send_message(1,2);" type="submit" class="btn btn-success pull-right">Send message</button>
                </div>

        </div>
    </div>
</div>
