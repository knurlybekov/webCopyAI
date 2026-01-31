<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.moodle_tru
 * @copyright   Copyright (C) 2026. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

/** @var Joomla\CMS\Document\HtmlDocument $this */

// Load Bootstrap framework (optional – remove if not needed)
HTMLHelper::_('bootstrap.framework');
?>
<!DOCTYPE html>

<html dir="<?php echo $this->direction; ?>" lang="<?php echo $this->language; ?>" xml:lang="en">
<head>

<link href="https://moodle.tru.ca/theme/image.php/tru/theme/1768328287/favicon" rel="shortcut icon"/>

<meta content="moodle, Home | TRU Moodle" name="keywords"/>
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/yui_combo.php" rel="stylesheet" type="text/css"/><script id="firstthemesheet" type="text/css">/** Required in order to fix style inclusion problems in IE with YUI **/</script><link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/all" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/styles.php" rel="stylesheet" type="text/css"/>
<script>
//<![CDATA[
var M = {}; M.yui = {};
M.pageloadstarttime = new Date();
M.cfg = {"wwwroot":"https:\/\/moodle.tru.ca","apibase":"https:\/\/moodle.tru.ca\/r.php\/api","homeurl":{},"sesskey":"W3VFc4obKJ","sessiontimeout":"7200","sessiontimeoutwarning":1200,"themerev":"1768328287","slasharguments":1,"theme":"tru","iconsystemmodule":"core\/icon_system_fontawesome","jsrev":"1759948476","admin":"admin","svgicons":true,"usertimezone":"America\/Vancouver","language":"en","courseId":1,"courseContextId":2,"contextid":2,"contextInstanceId":1,"langrev":1769603234,"templaterev":"1759948476","siteId":1,"userId":0};var yui1ConfigFn = function(me) {if(/-skin|reset|fonts|grids|base/.test(me.name)){me.type='css';me.path=me.path.replace(/\.js/,'.css');me.path=me.path.replace(/\/yui2-skin/,'/assets/skins/sam/yui2-skin')}};
var yui2ConfigFn = function(me) {var parts=me.name.replace(/^moodle-/,'').split('-'),component=parts.shift(),module=parts[0],min='-min';if(/-(skin|core)$/.test(me.name)){parts.pop();me.type='css';min=''}
if(module){var filename=parts.join('-');me.path=component+'/'+module+'/'+filename+min+'.'+me.type}else{me.path=component+'/'+component+'.'+me.type}};
YUI_config = {"debug":false,"base":"https:\/\/moodle.tru.ca\/lib\/yuilib\/3.18.1\/","comboBase":"https:\/\/moodle.tru.ca\/theme\/yui_combo.php?","combine":true,"filter":null,"insertBefore":"firstthemesheet","groups":{"yui2":{"base":"https:\/\/moodle.tru.ca\/lib\/yuilib\/2in3\/2.9.0\/build\/","comboBase":"https:\/\/moodle.tru.ca\/theme\/yui_combo.php?","combine":true,"ext":false,"root":"2in3\/2.9.0\/build\/","patterns":{"yui2-":{"group":"yui2","configFn":yui1ConfigFn}}},"moodle":{"name":"moodle","base":"https:\/\/moodle.tru.ca\/theme\/yui_combo.php?m\/1759948476\/","combine":true,"comboBase":"https:\/\/moodle.tru.ca\/theme\/yui_combo.php?","ext":false,"root":"m\/1759948476\/","patterns":{"moodle-":{"group":"moodle","configFn":yui2ConfigFn}},"filter":null,"modules":{"moodle-core-dragdrop":{"requires":["base","node","io","dom","dd","event-key","event-focus","moodle-core-notification"]},"moodle-core-notification":{"requires":["moodle-core-notification-dialogue","moodle-core-notification-alert","moodle-core-notification-confirm","moodle-core-notification-exception","moodle-core-notification-ajaxexception"]},"moodle-core-notification-dialogue":{"requires":["base","node","panel","escape","event-key","dd-plugin","moodle-core-widget-focusafterclose","moodle-core-lockscroll"]},"moodle-core-notification-alert":{"requires":["moodle-core-notification-dialogue"]},"moodle-core-notification-confirm":{"requires":["moodle-core-notification-dialogue"]},"moodle-core-notification-exception":{"requires":["moodle-core-notification-dialogue"]},"moodle-core-notification-ajaxexception":{"requires":["moodle-core-notification-dialogue"]},"moodle-core-event":{"requires":["event-custom"]},"moodle-core-handlebars":{"condition":{"trigger":"handlebars","when":"after"}},"moodle-core-lockscroll":{"requires":["plugin","base-build"]},"moodle-core-actionmenu":{"requires":["base","event","node-event-simulate"]},"moodle-core-blocks":{"requires":["base","node","io","dom","dd","dd-scroll","moodle-core-dragdrop","moodle-core-notification"]},"moodle-core-maintenancemodetimer":{"requires":["base","node"]},"moodle-core-chooserdialogue":{"requires":["base","panel","moodle-core-notification"]},"moodle-core_availability-form":{"requires":["base","node","event","event-delegate","panel","moodle-core-notification-dialogue","json"]},"moodle-course-categoryexpander":{"requires":["node","event-key"]},"moodle-course-dragdrop":{"requires":["base","node","io","dom","dd","dd-scroll","moodle-core-dragdrop","moodle-core-notification","moodle-course-coursebase","moodle-course-util"]},"moodle-course-util":{"requires":["node"],"use":["moodle-course-util-base"],"submodules":{"moodle-course-util-base":{},"moodle-course-util-section":{"requires":["node","moodle-course-util-base"]},"moodle-course-util-cm":{"requires":["node","moodle-course-util-base"]}}},"moodle-course-management":{"requires":["base","node","io-base","moodle-core-notification-exception","json-parse","dd-constrain","dd-proxy","dd-drop","dd-delegate","node-event-delegate"]},"moodle-form-dateselector":{"requires":["base","node","overlay","calendar"]},"moodle-form-shortforms":{"requires":["node","base","selector-css3","moodle-core-event"]},"moodle-question-chooser":{"requires":["moodle-core-chooserdialogue"]},"moodle-question-searchform":{"requires":["base","node"]},"moodle-availability_completion-form":{"requires":["base","node","event","moodle-core_availability-form"]},"moodle-availability_date-form":{"requires":["base","node","event","io","moodle-core_availability-form"]},"moodle-availability_grade-form":{"requires":["base","node","event","moodle-core_availability-form"]},"moodle-availability_group-form":{"requires":["base","node","event","moodle-core_availability-form"]},"moodle-availability_grouping-form":{"requires":["base","node","event","moodle-core_availability-form"]},"moodle-availability_profile-form":{"requires":["base","node","event","moodle-core_availability-form"]},"moodle-mod_assign-history":{"requires":["node","transition"]},"moodle-mod_attendance-groupfilter":{"requires":["base","node"]},"moodle-mod_checklist-linkselect":{"requires":["node","event-valuechange"]},"moodle-mod_quiz-toolboxes":{"requires":["base","node","event","event-key","io","moodle-mod_quiz-quizbase","moodle-mod_quiz-util-slot","moodle-core-notification-ajaxexception"]},"moodle-mod_quiz-dragdrop":{"requires":["base","node","io","dom","dd","dd-scroll","moodle-core-dragdrop","moodle-core-notification","moodle-mod_quiz-quizbase","moodle-mod_quiz-util-base","moodle-mod_quiz-util-page","moodle-mod_quiz-util-slot","moodle-course-util"]},"moodle-mod_quiz-quizbase":{"requires":["base","node"]},"moodle-mod_quiz-autosave":{"requires":["base","node","event","event-valuechange","node-event-delegate","io-form","datatype-date-format"]},"moodle-mod_quiz-modform":{"requires":["base","node","event"]},"moodle-mod_quiz-util":{"requires":["node","moodle-core-actionmenu"],"use":["moodle-mod_quiz-util-base"],"submodules":{"moodle-mod_quiz-util-base":{},"moodle-mod_quiz-util-slot":{"requires":["node","moodle-mod_quiz-util-base"]},"moodle-mod_quiz-util-page":{"requires":["node","moodle-mod_quiz-util-base"]}}},"moodle-mod_quiz-questionchooser":{"requires":["moodle-core-chooserdialogue","moodle-mod_quiz-util","querystring-parse"]},"moodle-mod_scheduler-saveseen":{"requires":["base","node","event"]},"moodle-mod_scheduler-studentlist":{"requires":["base","node","event","io"]},"moodle-mod_scheduler-delselected":{"requires":["base","node","event"]},"moodle-message_airnotifier-toolboxes":{"requires":["base","node","io"]},"moodle-editor_atto-rangy":{"requires":[]},"moodle-editor_atto-editor":{"requires":["node","transition","io","overlay","escape","event","event-simulate","event-custom","node-event-html5","node-event-simulate","yui-throttle","moodle-core-notification-dialogue","moodle-editor_atto-rangy","handlebars","timers","querystring-stringify"]},"moodle-editor_atto-plugin":{"requires":["node","base","escape","event","event-outside","handlebars","event-custom","timers","moodle-editor_atto-menu"]},"moodle-editor_atto-menu":{"requires":["moodle-core-notification-dialogue","node","event","event-custom"]},"moodle-report_eventlist-eventfilter":{"requires":["base","event","node","node-event-delegate","datatable","autocomplete","autocomplete-filters"]},"moodle-report_loglive-fetchlogs":{"requires":["base","event","node","io","node-event-delegate"]},"moodle-gradereport_history-userselector":{"requires":["escape","event-delegate","event-key","handlebars","io-base","json-parse","moodle-core-notification-dialogue"]},"moodle-qbank_editquestion-chooser":{"requires":["moodle-core-chooserdialogue"]},"moodle-tool_lp-dragdrop-reorder":{"requires":["moodle-core-dragdrop"]},"moodle-local_kaltura-ltiservice":{"requires":["base","node","node-event-simulate"]},"moodle-local_kaltura-ltipanel":{"requires":["base","node","panel","node-event-simulate"]},"moodle-local_kaltura-lticontainer":{"requires":["base","node"]},"moodle-local_kaltura-ltitinymcepanel":{"requires":["base","node","panel","node-event-simulate"]},"moodle-assignfeedback_editpdf-editor":{"requires":["base","event","node","io","graphics","json","event-move","event-resize","transition","querystring-stringify-simple","moodle-core-notification-dialog","moodle-core-notification-alert","moodle-core-notification-warning","moodle-core-notification-exception","moodle-core-notification-ajaxexception"]},"moodle-atto_accessibilitychecker-button":{"requires":["color-base","moodle-editor_atto-plugin"]},"moodle-atto_accessibilityhelper-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_align-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_bold-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_charmap-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_clear-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_collapse-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_count-button":{"requires":["io","json-parse","moodle-editor_atto-plugin"]},"moodle-atto_emojipicker-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_emoticon-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_equation-button":{"requires":["moodle-editor_atto-plugin","moodle-core-event","io","event-valuechange","tabview","array-extras"]},"moodle-atto_fontfamily-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_fullscreen-button":{"requires":["event-resize","moodle-editor_atto-plugin"]},"moodle-atto_h5p-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_html-button":{"requires":["promise","moodle-editor_atto-plugin","moodle-atto_html-beautify","moodle-atto_html-codemirror","event-valuechange"]},"moodle-atto_html-codemirror":{"requires":["moodle-atto_html-codemirror-skin"]},"moodle-atto_html-beautify":{},"moodle-atto_image-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_indent-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_italic-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_kalturamedia-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_link-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_managefiles-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_managefiles-usedfiles":{"requires":["node","escape"]},"moodle-atto_media-button":{"requires":["moodle-editor_atto-plugin","moodle-form-shortforms"]},"moodle-atto_noautolink-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_orderedlist-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_recordrtc-button":{"requires":["moodle-editor_atto-plugin","moodle-atto_recordrtc-recording"]},"moodle-atto_recordrtc-recording":{"requires":["moodle-atto_recordrtc-button"]},"moodle-atto_rtl-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_strike-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_styles-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_subscript-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_superscript-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_table-button":{"requires":["moodle-editor_atto-plugin","moodle-editor_atto-menu","event","event-valuechange"]},"moodle-atto_teamsmeeting-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_title-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_underline-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_undo-button":{"requires":["moodle-editor_atto-plugin"]},"moodle-atto_unorderedlist-button":{"requires":["moodle-editor_atto-plugin"]}}},"gallery":{"name":"gallery","base":"https:\/\/moodle.tru.ca\/lib\/yuilib\/gallery\/","combine":true,"comboBase":"https:\/\/moodle.tru.ca\/theme\/yui_combo.php?","ext":false,"root":"gallery\/1759948476\/","patterns":{"gallery-":{"group":"gallery"}}}},"modules":{"core_filepicker":{"name":"core_filepicker","fullpath":"https:\/\/moodle.tru.ca\/lib\/javascript.php\/1759948476\/repository\/filepicker.js","requires":["base","node","node-event-simulate","json","async-queue","io-base","io-upload-iframe","io-form","yui2-treeview","panel","cookie","datatable","datatable-sort","resize-plugin","dd-plugin","escape","moodle-core_filepicker","moodle-core-notification-dialogue"]},"core_comment":{"name":"core_comment","fullpath":"https:\/\/moodle.tru.ca\/lib\/javascript.php\/1759948476\/comment\/comment.js","requires":["base","io-base","node","json","yui2-animation","overlay","escape"]}},"logInclude":[],"logExclude":[],"logLevel":null};
M.yui.loader = {modules: {}};

//]]>
</script>
<!-- Google font download code -->
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/css" rel="stylesheet" type="text/css"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/><jdoc:include type="head" />
</head>
<body class="limitedwidth format-site course path-site chrome dir-ltr lang-en yui-skin-sam yui3-skin-sam moodle-tru-ca pagelayout-frontpage course-1 context-2 notloggedin theme uses-drawers" id="page-site-index">
<div aria-live="polite" class="toast-wrapper mx-auto py-0 fixed-top" role="status"></div>
<div class="d-print-block" id="page-wrapper">
<div>
<a class="sr-only sr-only-focusable" href="#maincontent">Skip to main content</a>
</div><script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/polyfill.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/yui_combo.php"></script><script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/jquery-3.7.1.min.js"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/javascript-static.js"></script>
<script>
//<![CDATA[
document.body.className += ' jsenabled';
//]]>
</script>
<nav aria-label="Site navigation" class="navbar fixed-top navbar-expand"><jdoc:include name="menu" style="xhtml" type="modules" /></nav>
<div class="drawer drawer-left drawer-primary d-print-none not-initialized" data-close-on-resize="1" data-forceopen="0" data-preference="" data-region="fixed-drawer" data-state="show-drawer-primary" id="theme_boost-drawers-primary">
<div class="drawerheader">
<button class="btn drawertoggle icon-no-margin hidden" data-action="closedrawer" data-placement="right" data-target="theme_boost-drawers-primary" data-toggle="tooltip" data-toggler="drawers" title="Close drawer">
<i aria-hidden="true" class="icon fa fa-xmark fa-fw"></i>
</button>
<a class="aabtn text-reset d-flex align-items-center py-1 h-100" data-region="site-home-link" href="https://moodle.tru.ca/" title="TRU Moodle">
<img alt="TRU Moodle" class="logo py-1 h-100" src="https://moodle.tru.ca/pluginfile.php/1/core_admin/logocompact/300x300/1768328287/TRU_Logo_Left_moodle.png"/>
</a>
<div class="drawerheadercontent hidden">
</div>
</div>
<div class="drawercontent drag-container" data-usertour="scroller">
<div class="list-group">
<a aria-current="true" class="list-group-item list-group-item-action active" href="https://moodle.tru.ca/">
                    Home
                </a>
</div>
</div>
</div>
<div class="drawer drawer-right d-print-none not-initialized" data-close-on-resize="1" data-forceopen="" data-preference="drawer-open-block" data-region="fixed-drawer" data-state="show-drawer-right" id="theme_boost-drawers-blocks">
<div class="drawerheader">
<button class="btn drawertoggle icon-no-margin hidden" data-action="closedrawer" data-placement="left" data-target="theme_boost-drawers-blocks" data-toggle="tooltip" data-toggler="drawers" title="Close block drawer">
<i aria-hidden="true" class="icon fa fa-xmark fa-fw"></i>
</button>
<div class="drawerheadercontent hidden">
</div>
</div>
<div class="drawercontent drag-container" data-usertour="scroller">
<div class="d-print-none">
<aside aria-labelledby="side-pre-block-region-heading" class="block-region" data-blockregion="side-pre" data-droptarget="1" id="block-region-side-pre"><jdoc:include name="sidebar" style="xhtml" type="modules" />
<div class="card-text content mt-3"><jdoc:include type="message" />
<jdoc:include type="component" /></div>
</aside>
</div>
</div>
</div>
<div class="drawers TRU drag-container" data-region="mainpage" data-usertour="scroller" id="page">
<div class="main-inner" id="topofscroll">
<div class="drawer-toggles d-flex">
<div class="drawer-toggler drawer-right-toggle ms-auto d-print-none">
<button class="btn icon-no-margin" data-action="toggle" data-placement="right" data-target="theme_boost-drawers-blocks" data-toggle="tooltip" data-toggler="drawers" title="Open block drawer">
<span class="sr-only">Open block drawer</span>
<span class="dir-rtl-hide"><i aria-hidden="true" class="icon fa fa-chevron-left fa-fw"></i></span>
<span class="dir-ltr-hide"><i aria-hidden="true" class="icon fa fa-chevron-right fa-fw"></i></span>
</button>
</div>
</div>
<header class="header-maxwidth d-print-none" id="page-header"><jdoc:include name="header" style="xhtml" type="modules" /></header>
<div class="pb-3 d-print-block" id="page-content">
<div id="region-main-box">
<div id="region-main">
<span class="notifications" id="user-notifications"></span>
<div role="main"><span id="maincontent"></span><a class="skip-block skip aabtn" href="#skipsitenews">Skip site news</a><div id="site-news-forum"><h2>Site news</h2><div data-cmid="1083" data-contextid="1173" data-gradable-itemtype="forum" data-grading-component="" data-grading-component-subtype="" data-group="" data-initialuserid="17566" data-name="Site news" id="discussion-list-697a653cdcd83697a653ccbb495">
<div class="py-3">
</div>
<article aria-describedby="post-content-2567917" aria-labelledby="post-header-2567917-697a653cdcd83697a653ccbb495" class="forum-post-container mb-2" data-post-id="2567917" data-region="post" data-target="2567917-target" id="p2567917" tabindex="0">
<div aria-label="Kaltura Downtime January 25, Update Kaltura Capture by Brian Lamb" class="d-flex border p-2 mb-2 forumpost focus-target" data-content="forum-post" data-post-id="2567917">
<div class="d-flex flex-column w-100" data-region-content="forum-post-core">
<header class="mb-2 header row d-flex" id="post-header-2567917-697a653cdcd83697a653ccbb495">
<div class="me-2" style="width: 45px;">
<img alt="Picture of Brian Lamb" aria-hidden="true" class="rounded-circle w-100" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/f1" title="Picture of Brian Lamb"/>
</div>
<div class="d-flex flex-column">
<h3 class="h6 font-weight-bold mb-0" data-region-content="forum-post-core-subject" data-reply-subject="Re: Kaltura Downtime January 25, Update Kaltura Capture">Kaltura Downtime January 25, Update Kaltura Capture</h3>
<div class="mb-3" tabindex="-1">
                            by <a href="https://moodle.tru.ca/user/view.php?id=17566&amp;course=1">Brian Lamb</a> - <time datetime="2026-01-21T10:50:14-08:00">Wednesday, 21 January 2026, 10:50 AM</time>
</div>
</div>
</header>
<div class="d-flex body-content-container">
<div class="me-2 author-groups-container" style="width: 45px; flex-shrink: 0">
</div>
<div class="no-overflow w-100 content-alignment-container">
<div class="post-content-container" id="post-content-2567917">
<p>Hello,</p>
<p>Server work on the Kaltura video platform will be taking place the night of Sunday, January 25. We are told to expect 3-5 hours of disruption. We advise users avoid uploading new videos that night, even if platform and videos seem available.</p>
<p>We also suggest that users of the Kaltura Capture tools upgrade to the latest version, as older versions may not work with the updated platform.</p>
<p><a href="https://knowledge.kaltura.com/help/kaltura-capture-release-notes">https://knowledge.kaltura.com/help/kaltura-capture-release-notes</a></p>
<p>Brian Lamb</p>
<p>Director, Learning Technology &amp; Innovation <br/>Thompson Rivers University</p>
<p></p>
</div>
<div class="d-flex flex-wrap">
<div aria-controls="p2567917" aria-label="Kaltura Downtime January 25, Update Kaltura Capture by Brian Lamb" class="post-actions d-flex align-self-end justify-content-end flex-wrap ms-auto p-1" data-region="post-actions-container" role="menubar">
<a aria-label="Permanent link to this post" class="btn btn-link" data-region="post-action" href="https://moodle.tru.ca/mod/forum/discuss.php?d=1155002#p2567917" role="menuitem" title="Permanent link to this post">
                                                    Permalink
                                                </a>
</div>
</div>
<div class="link text-end">
<a aria-label="Discuss the topic: Kaltura Downtime January 25, Update Kaltura Capture" href="https://moodle.tru.ca/mod/forum/discuss.php?d=1155002">
                           Discuss this topic
                       </a> (0 replies so far)
                   </div>
</div>
</div>
</div>
</div>
<div data-region="replies-container">
</div>
</article>
<article aria-describedby="post-content-2467585" aria-labelledby="post-header-2467585-697a653cdcd83697a653ccbb495" class="forum-post-container mb-2" data-post-id="2467585" data-region="post" data-target="2467585-target" id="p2467585" tabindex="0">
<div aria-label="Moodle app discontinued: how to use mobile by Brian Lamb" class="d-flex border p-2 mb-2 forumpost focus-target" data-content="forum-post" data-post-id="2467585">
<div class="d-flex flex-column w-100" data-region-content="forum-post-core">
<header class="mb-2 header row d-flex" id="post-header-2467585-697a653cdcd83697a653ccbb495">
<div class="me-2" style="width: 45px;">
<img alt="Picture of Brian Lamb" aria-hidden="true" class="rounded-circle w-100" src="https://moodle.tru.ca/theme/image.php/tru/core/1768328287/u/f1" title="Picture of Brian Lamb"/>
</div>
<div class="d-flex flex-column">
<h3 class="h6 font-weight-bold mb-0" data-region-content="forum-post-core-subject" data-reply-subject="Re: Moodle app discontinued: how to use mobile">Moodle app discontinued: how to use mobile</h3>
<div class="mb-3" tabindex="-1">
                            by <a href="https://moodle.tru.ca/user/view.php?id=17566&amp;course=1">Brian Lamb</a> - <time datetime="2025-09-03T13:15:30-07:00">Wednesday, 3 September 2025, 1:15 PM</time>
</div>
</div>
</header>
<div class="d-flex body-content-container">
<div class="me-2 author-groups-container" style="width: 45px; flex-shrink: 0">
</div>
<div class="no-overflow w-100 content-alignment-container">
<div class="post-content-container" id="post-content-2467585">
<p>Hello - we are receiving reports that there are students using the Moodle mobile app and experiencing errors. That is because the Moodle is app is not supported and cannot connect.</p>
<p>To access Moodle on a smartphone or tablet, use a browser to go to <a href="https://moodle.tru.ca">https://moodle.tru.ca</a> and log in with your TRU ID - <span lang="en-us" xml:lang="en-us">TRUID@myTRU.ca (students) or username@tru.ca (for employees)</span>.</p>
<p>We had discontinued support for the app some time ago because there were reports the app was unreliable, that assignments/exams were not being submitted and other features not working. We are a bit surprised that some had been able to keep using it, but now that Moodle's authentication has been updated that is no longer possible. Please access Moodle through the browser, not the app.</p>
</div>
<div class="d-flex flex-wrap">
<div aria-controls="p2467585" aria-label="Moodle app discontinued: how to use mobile by Brian Lamb" class="post-actions d-flex align-self-end justify-content-end flex-wrap ms-auto p-1" data-region="post-actions-container" role="menubar">
<a aria-label="Permanent link to this post" class="btn btn-link" data-region="post-action" href="https://moodle.tru.ca/mod/forum/discuss.php?d=1103352#p2467585" role="menuitem" title="Permanent link to this post">
                                                    Permalink
                                                </a>
</div>
</div>
<div class="link text-end">
<a aria-label="Discuss the topic: Moodle app discontinued: how to use mobile" href="https://moodle.tru.ca/mod/forum/discuss.php?d=1103352">
                           Discuss this topic
                       </a> (0 replies so far)
                   </div>
</div>
</div>
</div>
</div>
<div data-region="replies-container">
</div>
</article>
<article aria-describedby="post-content-2462828" aria-labelledby="post-header-2462828-697a653cdcd83697a653ccbb495" class="forum-post-container mb-2" data-post-id="2462828" data-region="post" data-target="2462828-target" id="p2462828" tabindex="0">
<div aria-label="New Moodle login, interface by Brian Lamb" class="d-flex border p-2 mb-2 forumpost focus-target" data-content="forum-post" data-post-id="2462828">
<div class="d-flex flex-column w-100" data-region-content="forum-post-core">
<header class="mb-2 header row d-flex" id="post-header-2462828-697a653cdcd83697a653ccbb495">
<div class="me-2" style="width: 45px;">
<img alt="Picture of Brian Lamb" aria-hidden="true" class="rounded-circle w-100" src="https://moodle.tru.ca/theme/image.php/tru/core/1768328287/u/f1" title="Picture of Brian Lamb"/>
</div>
<div class="d-flex flex-column">
<h3 class="h6 font-weight-bold mb-0" data-region-content="forum-post-core-subject" data-reply-subject="Re: New Moodle login, interface">New Moodle login, interface</h3>
<div class="mb-3" tabindex="-1">
                            by <a href="https://moodle.tru.ca/user/view.php?id=17566&amp;course=1">Brian Lamb</a> - <time datetime="2025-08-13T15:59:11-07:00">Wednesday, 13 August 2025, 3:59 PM</time>
</div>
</div>
</header>
<div class="d-flex body-content-container">
<div class="me-2 author-groups-container" style="width: 45px; flex-shrink: 0">
</div>
<div class="no-overflow w-100 content-alignment-container">
<div class="post-content-container" id="post-content-2462828">
<p dir="ltr" style="text-align:left;"></p>
<p><span lang="en-us" xml:lang="en-us">Moodle has been upgraded to version 4.5, and has an updated login process.</span></p>
<ul>
<li><span lang="en-us" xml:lang="en-us">Just click the “Login” button in the top-right corner.</span></li>
<li><span lang="en-us" xml:lang="en-us">If you're already signed into another TRU service (like email), you’ll be logged in automatically.</span></li>
<li><span lang="en-us" xml:lang="en-us">If not, you’ll sign in using your TRU ID and password and may be prompted for multi-factor authentication (MFA).  <a class="fui-Link ___1q1shib f2hkw1w f3rmtva f1ewtqcl fyind8e f1k6fduh f1w7gpdv fk6fouc fjoy568 figsok6 f1s184ao f1mk8lai fnbmjn9 f1o700av f13mvf36 f1cmlufx f9n3di6 f1ids18y f1tx3yz7 f1deo86v f1eh06m1 f1iescvh fhgqx19 f1olyrje f1p93eir f1nev41a f1h8hb77 f1lqvz6u f10aw75t fsle3fq f17ae5zn" href="mailto:TRUID@myTRU.ca" rel="noreferrer noopener" target="_blank" title="mailto:truid@mytru.ca">TRUID@myTRU.ca</a> (students) or <a class="fui-Link ___1q1shib f2hkw1w f3rmtva f1ewtqcl fyind8e f1k6fduh f1w7gpdv fk6fouc fjoy568 figsok6 f1s184ao f1mk8lai fnbmjn9 f1o700av f13mvf36 f1cmlufx f9n3di6 f1ids18y f1tx3yz7 f1deo86v f1eh06m1 f1iescvh fhgqx19 f1olyrje f1p93eir f1nev41a f1h8hb77 f1lqvz6u f10aw75t fsle3fq f17ae5zn" href="mailto:username@tru.ca" rel="noreferrer noopener" target="_blank" title="mailto:username@tru.ca">username@tru.ca</a> (for employees).</span></li>
</ul>
<ul type="disc">
<li><span lang="en-us" xml:lang="en-us">You will see new interface changes including smaller icons that give Moodle a cleaner, more modern look and feel, and reduces scrolling. </span><span lang="en-us" xml:lang="en-us">This<a href="https://media.tru.ca/id/0_sd3grh2m?width=608&amp;height=402&amp;playerId=23449441" title="https://media.tru.ca/id/0_sd3grh2m?width=608&amp;height=402&amp;playerId=23449441"> short video demonstrates the new interface and features.</a> This <a href="https://media.tru.ca/media/Moodle+Updgrade+to+4.5/0_c52uguwi">video is targeted to Open Learning Faculty Members.</a></span></li>
</ul>
<p><span lang="en-us" xml:lang="en-us">This upgrade improves security and makes accessing Moodle easier. </span></p>
<p><span lang="en-us" xml:lang="en-us">If you require assistance, </span><span lang="en-us" xml:lang="en-us"><a href="https://moodleorientation.trubox.ca/wp-content/uploads/sites/1240/2025/07/FAQ-Moodle-Upgrade.pdf">read the attached FAQs (PDF)</a> </span> or contact IT Services at <a href="mailto:itservicedesk@tru.ca">itservicedesk@tru.ca</a> or 250-852-6800.</p>
<div> </div>
</div>
<div class="d-flex flex-wrap">
<div aria-controls="p2462828" aria-label="New Moodle login, interface by Brian Lamb" class="post-actions d-flex align-self-end justify-content-end flex-wrap ms-auto p-1" data-region="post-actions-container" role="menubar">
<a aria-label="Permanent link to this post" class="btn btn-link" data-region="post-action" href="https://moodle.tru.ca/mod/forum/discuss.php?d=1100168#p2462828" role="menuitem" title="Permanent link to this post">
                                                    Permalink
                                                </a>
</div>
</div>
<div class="link text-end">
<a aria-label="Discuss the topic: New Moodle login, interface" href="https://moodle.tru.ca/mod/forum/discuss.php?d=1100168">
                           Discuss this topic
                       </a> (0 replies so far)
                   </div>
</div>
</div>
</div>
</div>
<div data-region="replies-container">
</div>
</article>
<a href="https://moodle.tru.ca/mod/forum/view.php?id=1083">Older topics...</a>
</div></div><span class="skip-block-to" id="skipsitenews"></span><br/></div>
</div>
</div>
</div>
</div>
<footer id="page-footer"><jdoc:include name="footer" style="xhtml" type="modules" /></footer> </div>
</div>
</body></html>