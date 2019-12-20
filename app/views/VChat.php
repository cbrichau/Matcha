<h1 class="text-center">Chat with <?= $user_2->get_username(); ?></h1>
<span style="display:none;" id="id_user_1"><?= $user_1->get_id_user(); ?></span>
<span style="display:none;" id="id_user_2"><?= $user_2->get_id_user(); ?></span>

<div class="bg-white my-3 mx-auto" id="chat_window">
  <div id="messages">
  </div>

  <div id="send_box">
    <input type="text" id="message_content" placeholder="Write a message">
    <button type="submit" id="send_button" class="btn btn-primary">Send</button>
  </div>
</div>

<?php
/*
<div class="tab-pane" id="tab-chat">
  <div class="conversation-wrapper">

    <div class="conversation-content">
      <div id="slimScrollDiv" class="slimScrollDiv" style="overflow: scroll;position: relative; width: auto; height: 500px;">
        <div class="conversation-inner" style="width: auto; height: 500px;">
          <div id="MessageReceive"></div>
        </div>
        <div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div>
        <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
      </div>
    </div>

    <div class="conversation-new-message">
      <div class="form-group">
        <textarea id="message_value" class="form-control" onkeyup="clee(event,<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>);" name="message" rows="2" placeholder="Enter your message..."></textarea>
      </div>
      <div class="clearfix">
        <button  class="btn btn-success pull-right">Send message</button>
      </div>
    </div>

  </div>
</div>


foreach ($tabs as $key => $value)
{
  $value['message'] = str_replace(' ', '&nbsp;', $value['message']);
  if( $value['id_user_1'] != $_POST['id_user_1'])
  {
  echo '<div class="conversation-item item-left clearfix">';
  }
  else
  {
    echo '<div class="conversation-item item-right clearfix">';
  }
  echo '<div class="conversation-user">';
  echo '<img class="user-icon" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="">';
  echo '</div>';
  echo '<div class="conversation-body">';
  if ($value['id_user_1'] != $_POST['id_user_1'])
  {
    echo '<div class="name">' . $user_2->get_username() . '</div>';
  }
  else
  {
    echo '<div class="name">' . $_SESSION['username'] . '</div>';
  }
  echo '<div class="time hidden-xs">' . $tabs[$key]['message_date'] . ' </div>';
  echo '<div class="text">' . $value['message'] . ' </div>';
  echo '</div>';
  echo '</div>';
  echo '</div>';
}
*/
 ?>
