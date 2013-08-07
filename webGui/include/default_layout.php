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
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=$var['NAME']?>/<?=$myPage['Name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="robots" content="noindex">
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="/plugins/webGui/images/<?=$var['mdColor']?>.gif">
        <!--
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/plugins/webGui/images/ico/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/plugins/webGui/images/ico/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/plugins/webGui/images/ico/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="/plugins/webGui/images/ico/apple-touch-icon-57x57-precomposed.png">
        //-->

        <link type="text/css" rel="stylesheet" href="/plugins/webGui/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="/plugins/webGui/css/default_layout.css">
        <link type="text/css" rel="stylesheet" href="/plugins/webGui/css/jquery.jgrowl.css">
        <link type="text/css" rel="stylesheet" href="/plugins/webGui/css/ui.dropdown.checklist.css">
        <link type="text/css" rel="stylesheet" href="/plugins/webGui/css/shadowbox.css">

        <style type="text/css">
        <!--
        <?if (!$display['icons']):?>
        #title img.icon {display: none;}
        <?endif;?>

        <?if (!$display['help']):?>
        blockquote {display: none;}
        <?endif;?>
        //--> 
        </style>

        <script type="text/javascript" src="/plugins/webGui/js/jquery.js"></script>
        <script type="text/javascript" src="/plugins/webGui/js/jquery.jgrowl.js"></script>
        <script type="text/javascript" src="/plugins/webGui/js/jquery.ui.custom.js"></script>
        <script type="text/javascript" src="/plugins/webGui/js/ui.dropdown.checklist.js"></script>
        <script type="text/javascript" src="/plugins/webGui/js/shadowbox.js"></script>

<script type="text/javascript" charset="utf-8">
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
