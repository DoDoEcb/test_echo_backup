<?php
$id    = @mysql_real_escape_string($_GET["id"]);
$sql   = @mysql_query("SELECT * FROM Tickets WHERE `id`=$id");
$owner = @mysql_result($sql, 0, "user_id");
if ($loggedInUser->user_id == $owner OR isUserAdmin($loggedInUser->user_id) OR isUserMod($loggedInUser->user_id)) {
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "closev") {
            echo "<h3>Are you sure?</h3><br \><a href=\"index.php?page=viewticket&action=closey&id=" . $id . "\"><input type=\"submit\" class=\"blues\" value=\"Yes\"/></a><br /><a href=\"index.php?page=viewticket&id=$id\"><input type=\"submit\" class=\"blues\" value=\"No\"/></a><br />";
        }
        if ($_GET["action"] == "closey") {
            mysql_query("UPDATE Tickets SET opened=0 WHERE `id`='$id'");
            echo "Your ticket has been closed.";
        }
if ($_GET["action"] == "open")
{
            mysql_query("UPDATE Tickets SET opened=1 WHERE `id`='$id'");
            echo "Your ticket has been reopened.";
}
    } else {
        $subject = mysql_result($sql, 0, "subject");
        if (isset($_POST["post"])) {
            $post   = mysql_real_escape_string(strip_tags($_POST["post"]));
            $uid    = $loggedInUser->user_id;
            $posted = date("F j, Y, g:i a");
            @mysql_query("INSERT INTO `TicketReplies` (`ticket_id` ,`user_id` ,`body` ,`posted`) VALUES ('$id', '$uid', '$post', '$posted');");
        }
        $subject = mysql_result($sql, 0, "subject");
        $post    = mysql_result($sql, 0, "body");
        $posted  = mysql_result($sql, 0, "posted");
        $opened  = mysql_result($sql, 0, "opened");
if ($opened == 0) { 
<a href="index.php?page=viewticket&id=<? echo $id;?>&action=open"><input type="button" class="blues" value="Open" /></a>
<? } else { ?>
<a href="index.php?page=viewticket&id=<?echo $id;?>&action=closev"><input type="button" class="blues"value="Close" /></a>
<?  } ?>
<div id="support-thread">
<b>Started By:</b><? echo GetUser($owner);?> <b>On:</b> <?echo $posted;?></br>
</form>
<?    
$replies = @mysql_query("SELECT * FROM TicketReplies WHERE `ticket_id`='$id' ORDER BY `id` ASC");
$num2    = @mysql_num_rows($replies);
for ($i = 0; $i < $num2; $i++) {
$post   = mysql_result($replies, $i, "body");
$owner  = mysql_result($replies, $i, "user_id");
$posted = mysql_result($replies, $i, "posted");
?>
<div class="balloon right">
</form>
<? } ?>
<textarea name="post" class="shadowfield message-reply"></textarea>
<input type="submit" class="blues" />
<?
}
} else {
echo "This is not a valid ticket.";
}
?> 