<?PHP
/* Copyright Lime Technology LLC.
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2, or (at your option)
 * any later version.
 */
/* Modifications made to GUI, Copyright 2012, Andrew Hamer-Adams. */
/* Adapted by Bergware International (November 2012) */
?>
<?
include "helpers.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<title><?=$var['NAME']?>/<?=$myPage['Name']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no">
<link type="image/gif" rel="shortcut icon" href="/plugins/webGui/images/<?=$var['mdColor']?>.gif">
<link type="text/css" rel="stylesheet" href="/plugins/webGui/css/default_layout.css">
<link type="text/css" rel="stylesheet" href="/plugins/webGui/css/jquery.jgrowl.css">
<link type="text/css" rel="stylesheet" href="/plugins/webGui/css/ui.dropdown.checklist.css">
<link type="text/css" rel="stylesheet" href="/plugins/webGui/css/shadowbox.css">

<?if (!$display['icons']):?>
<style>#title img.icon {display: none;}</style>
<?endif;?>

<?if (!$display['help']):?>
<style>blockquote {display: none;}</style>
<?endif;?>

<script type="text/javascript" src="/plugins/webGui/js/jquery.js"></script>
<script type="text/javascript" src="/plugins/webGui/js/jquery.jgrowl.js"></script>
<script type="text/javascript" src="/plugins/webGui/js/jquery.ui.custom.js"></script>
<script type="text/javascript" src="/plugins/webGui/js/ui.dropdown.checklist.js"></script>
<script type="text/javascript" src="/plugins/webGui/js/shadowbox.js"></script>
<script>
Shadowbox.init({
  handleOversize: "resize",
  displayNav: true,
  onClose: function() { enableInput() }
});

function disableInput() {
  for (var i=0,input; input=top.document.getElementsByTagName('input')[i]; i++) { input.disabled = true; }
  for (var i=0,button; button=top.document.getElementsByTagName('button')[i]; i++) { button.disabled = true; }
  for (var i=0,select; select=top.document.getElementsByTagName('select')[i]; i++) { select.disabled = true; }
  for (var i=0,link; link=top.document.getElementsByTagName('a')[i]; i++) { link.style.color = "gray"; } //fake disable
}
function enableInput() {
  for (var i=0,input; input=top.document.getElementsByTagName('input')[i]; i++) { input.disabled = false; }
  for (var i=0,button; button=top.document.getElementsByTagName('button')[i]; i++) { button.disabled = false; }
  for (var i=0,select; select=top.document.getElementsByTagName('select')[i]; i++) { select.disabled = false; }
  for (var i=0,link; link=top.document.getElementsByTagName('a')[i]; i++) { link.style.color = "#3B5998"; }
  for (var i=0,link; link=top.document.getElementById("menu").getElementsByTagName('a')[i]; i++) { link.style.color = "#FFFFFF"; }
  for (var i=0,link; link=top.document.getElementById("header").getElementsByTagName('a')[i]; i++) { link.style.color = "#6FA239"; }
  for (var i=0,link; link=top.document.getElementById("title").getElementsByTagName('a')[i]; i++) { link.style.color = "#333333"; }
}
function refresh() {
  disableInput();
  window.location = window.location;
}
function done() {
  var path = window.location.pathname;
  var x = path.indexOf("/",1);
  if (x!=-1) path = path.substring(0,x);
  window.location.replace(path);
}
function chkDelete(form, button) {
  button.value = form.confirmDelete.checked ? 'Delete' : 'Apply';
}

$(document).ready(function() {
  updateTime();
  $.jGrowl.defaults.closer = false;
<?if ($confirm['warn']):?>
  $('form').each(function(){$(this).change(function(){$.jGrowl('You have uncommitted form changes',{sticky:false, theme:'bottom', position:'bottom', life:5000});});});
<?endif;?>
});

var mobiles=['ipad','iphone','ipod','android'];
var device=navigator.platform.toLowerCase();
for (var i=0,mobile; mobile=mobiles[i]; i++){
  if (device.indexOf(mobile)>=0) {$('.footer').css('position','static'); break;}
}
</script>
</head>
<body>
  <div id="template">
   <div id="header-container">
   <div id="header" class="<?=$display['banner']?>">
    <div class="logo">
     <a href="http://lime-technology.com"><img src="/plugins/webGui/logo.png" title="unRAID" border="0"/><br/>
     <strong>unRAID Server <em><?=$var['regTy']?></em></strong></a>
    </div>
    <div class="block"><span class="text-left"><strong>
     Server<br/>
     Description<br/>
     Version<br/>
     Status
     </strong></span>
     <span class="text-right">
     <?=$var['NAME'].($var['IPADDR'] ? " -- {$var['IPADDR']}" : "")?><br/>
     <?=$var['COMMENT']?><br/>
     <?=$var['version']?><br/>
     <?if ($var['fsState']=="Started") { echo '<span class="green-text">Started</span>'; }
  if ($var['fsState']=="Stopped") { echo '<span class="red-text"><strong>Stopped</strong></span>'; }
  if ($var['mdResync']!=0) {
    echo '|<span class="orange-text">';
    if ($var['mdNumInvalid']==0) {
      echo 'Parity-Check:';
    } else {
      if ($var['mdInvalidDisk']==0) {
        echo 'Parity-Sync:';
      } else {
        echo 'Data-Rebuild:';
      }
    }
    echo ' '.round(($var['mdResyncPos']/($var['mdResync']/100+1)), 1).' %';
    echo '</span>';
  }?>
     </span>
    </div>
   </div>
   <div id="menu">
    <div id="nav_block">
     <div id="nav_left">
<?    $pages = find_pages("Tasks");
      foreach ($pages as $page):
        $link = "/{$page['Name']}";
        if ($page['Name']==$task):
?>        <div id="nav_item" class="active"><a href="<?=$link?>"><?=$page['Title']?></a></div>
<?      else:?>
          <div id="nav_item"><a href="<?=$link?>"><?=$page['Title']?></a></div>
<?      endif;
      endforeach;
?>   </div>
     <div id="nav_right">
<?    $pages = find_pages( "Buttons");
      foreach ($pages as $page):
       eval("?>{$page['text']}");
?>     <div id="nav_item" class="<?=$page['Name'];?>_button"><a href="#" onclick="<?=$page['Name'];?>(); return false;"><img src="/<?=icon_file($page);?>">&nbsp;<?=$page['Title'];?></a></div>
<?    endforeach;
?>   </div>
    </div>
   </div>
   <div id="header-transition"></div>
   </div>
   <div id="page-container">

<? include "myPage_content.php";
?>
   </div>
  </div>
  <iframe id="progressFrame" name="progressFrame" frameborder="0"></iframe>
  <div id="footer">
<?
  echo "<div id='copyright'>unRAID&#8482; webGui &copy; Lime Technology";
  if ($myPage['Author']) echo "&nbsp;|&nbsp;page author: {$myPage['Author']}";
  if ($myPage['Version']) echo "&nbsp;|&nbsp;page version: {$myPage['Version']}";
  echo "</div>"?>
  </div>
</body>
</html>
