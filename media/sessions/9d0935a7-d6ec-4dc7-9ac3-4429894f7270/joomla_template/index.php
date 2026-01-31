<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.joomla_template
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

<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)" dir="<?php echo $this->direction; ?>" lang="<?php echo $this->language; ?>">
<head>

<script type="text/javascript">
<!--
var ipjIsDebug=false;
var ipVirDir="/";
var ipSysImageDir="/system/images";
var ipSiteTemplateDir="/__shared/templates";
var ipDynamicFQDN="https://acm.tru.ca";
var ipCurrentPageClass="ContentPage";
var ipCurrentPageDefID="34917";
var ipCurrentTemplateID="1093";
//-->
</script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/ip-utilities.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
ipjPageSiteID=3;
ipjPageSiteGroupID=0;
//-->
</script>
<script type="text/javascript">
<!--
var ipActivePageDefIds_sectionMenuElementID_0=new Array();
//-->
</script>
<meta content="" name="keywords"/>
<meta content="" name="description">
<meta content="IronPoint v7" name="Generator"/>
<meta content="9/9/2025 2:41:06 PM" name="UpdateDateTime"/>

<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="Thompson Rivers University, www.tru.ca" name="author"/>
<meta content="http://tru.ca/forms/info-request" name="og:url"/>
<meta content="website" name="og:type"/>
<meta content="Thompson Rivers University" name="og:site_name"/>
<meta content="summary" name="twitter:card"/>
<meta content="@mytru" name="twitter:site"/>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NJF9FB');</script>
<!-- End Google Tag Manager -->
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/tru.css" rel="stylesheet" type="text/css"/>
<script crossorigin="anonymous" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/af980998cb.js"></script>
<link href="/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180"/>
<link href="/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png"/>
<link href="/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png"/>
<link href="/manifest.json" rel="manifest"/>
<link color="#003e51" href="/safari-pinned-tab.svg" rel="mask-icon"/>
<meta content="#ffffff" name="theme-color"/><jdoc:include type="head" />
</meta></head>
<body id="thebody"><!-- start IE ALERT--><!-- end IE ALERT-->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe height="0" src="https://www.googletagmanager.com/ns.html?id=GTM-NJF9FB" style="display:none;visibility:hidden" width="0"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/tru.css" rel="stylesheet" type="text/css"/>
<script crossorigin="anonymous" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/af980998cb.js"></script>
<link href="/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180"/>
<link href="/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png"/>
<link href="/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png"/>
<link href="/manifest.json" rel="manifest"/>
<link color="#003e51" href="/safari-pinned-tab.svg" rel="mask-icon"/>
<meta content="#ffffff" name="theme-color"/>
<body id="thebody"><!-- start IE ALERT--><!-- end IE ALERT-->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe height="0" src="https://www.googletagmanager.com/ns.html?id=GTM-NJF9FB" style="display:none;visibility:hidden" width="0"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<nav aria-label="Primary navigation" class="nav-wrapper"><jdoc:include name="menu" style="xhtml" type="modules" /></nav>
<header class="mainHeaderWrapper $html1Custom$"><jdoc:include name="header" style="xhtml" type="modules" /></header>
<section><jdoc:include type="message" />
<jdoc:include type="component" /></section>
<section>
<div class="row">
<div class="col">
<div class="blue-bg ph-4 pb-4 pt-2 border-radius-3">
<div class="row">
<div class="col col-lg-6">
<a class="btn white-bg rounded full-width" href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/MTFXPayMyTuitionPaymentCenter" title="Make a payment">Make a Payment (tuition and deposit)</a>
</div>
<div class="col col-lg-6">
<a class="btn outline white-bg rounded full-width" href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/TRU_Admissions" title="Check your application status">Check Your Application Status</a>
</div>
<div class="col col-lg-6">
<a class="btn outline white-bg rounded full-width" href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/zcustom_course_eval_pg" title="On-campus course evaluations">On-campus Course Evaluations</a>
</div>
<!-- div class="col col-lg-6">   
                        <a class="btn outline white-bg rounded full-width" href="https://ssb-prod.ec.tru.ca/ssomanager/saml/login?relayState=/c/auth/SSB?pkg=zcustom.pkg_course_evaluation.p_disp_course_eval" title="On-campus course evaluations">On-campus Course Evaluations</a>
                    </div -->
<div class="col col-lg-6">
<a class="btn outline white-bg rounded full-width" href="https://tru.ca/alerts.html" title="Sign up for TRU Alerts">Sign up for TRU Alerts</a>
</div>
<div class="col col-lg-6">
<a class="btn outline white-bg rounded full-width" href="https://reg-prod.ec.tru.ca/StudentRegistrationSsb/" title="On-campus course registration">On-campus Course Registration</a>
</div>
<div class="col col-lg-6">
<a class="btn outline white-bg rounded full-width" href="https://generalssb-prod.ec.tru.ca/BannerGeneralSsb/ssb/personalInformation#/personalInformationMain" title="Update contact information">Update Contact Information</a>
</div>
</div>
</div>
</div>
</div></section>
<section>
<div class="row">
<div class="col col-md-6 col-2xl-4 mb-4">
<div class="border-1 border-radius-3 p-3 full-height">
<h4 class="mt-0">Course Registration</h4>
<p class="size-16">Kamloops and Williams Lake students</p>
<ul class="mt-1 ml-0" style="list-style-type:none;">
<li><a href="https://www.tru.ca/current/enrolment-services/course-registration.html" target="nw09" title="How to Register">How to Register</a></li>
<li><a href="https://reg-prod.ec.tru.ca/StudentRegistrationSsb/ssb/registration" target="nw10" title="Course Planning and Registration">Course Planning and Registration</a></li>
<li><a href="https://reg-prod.ec.tru.ca/StudentRegistrationSsb/ssb/registrationHistory/registrationHistory" target="nw11" title="Course Timetable">Course Timetable</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/zcustom_course_eval_pg" target="_blank" title="Course Evaluations">Course Evaluations</a></li>
<!-- li><a target="_blank" title="Course Evaluations" href="https://ssb-prod.ec.tru.ca/ssomanager/saml/login?relayState=/c/auth/SSB?pkg=zcustom.pkg_course_evaluation.p_disp_course_eval">Course Evaluations</a></li -->
</ul>
</div>
</div>
<div class="col col-md-6 col-2xl-4 mb-4">
<div class="border-1 border-radius-3 p-3 full-height">
<h4 class="mt-0">Open Learning Services</h4>
<ul class="mt-1 ml-0" style="list-style-type:none;">
<li><a href="https://www.tru.ca/distance/courses" target="nw12" title="register for open learning courses">Register for Courses</a></li>
<li><a href="https://reg-prod.ec.tru.ca/StudentRegistrationSsb/ssb/registrationHistory/registrationHistory" target="nw13" title="current registrations">Current Registrations</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/studentGrades/" target="nw14" title="assignment marks">Assignment Marks</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/OLCourseExtension" target="nw15" title="course extension request">Course Extension Request</a></li>
<li><a href="https://www.tru.ca/distance/services/exams.html" target="nw16" title="exam applications">Exam applications</a></li>
<li><a class="size-14" href="https://www.tru.ca/distance/services.html" target="nw17" title="more open learning services">&gt;&gt; More Services for Open Learning Students</a></li>
</ul>
</div>
</div>
<div class="col col-md-6 col-2xl-4 mb-4">
<div class="border-1 border-radius-3 p-3 full-height">
<h4 class="mt-0">Academic Record</h4>
<ul class="mt-1 ml-0" style="list-style-type:none;">
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/studentProfile" target="nw18" title="academic profile">Academic Profile</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/studentGrades/" target="nw19" title="final grades">Final Grades</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/StudentTransferCredit" target="nw20" title="Transfer Credit Summary">Transfer Credit Summary</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/graduationApplication" target="nw21" title="apply to graduate">Apply to Graduate</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/SZRRDAT_launch" target="nw22" title="Course Registration Data Form">Course Registration Data Form</a></li>
<li><a href="https://dw-prod.ec.tru.ca/responsiveDashboard" target="nw23" title="Degree Works">Degree Works (TRU Program Plan)</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/ChangeOfProgram" target="nw24" title="Change of Program">Change of Program (Campus programs)</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/DeclarationOfMajor" target="nw25" title="Declaration of Major">Declaration of Major (Campus Programs)</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/DeclarationOfMinor" target="nw26" title="Declaration of Minor">Declaration of Minor (Campus Programs)</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/DeclarationOfConcentration" target="nw27" title="Declaration of Concentration">Declaration of Concentration (Campus Programs)</a></li>
<li><a class="size-14" href="https://www.tru.ca/current/enrolment-services.html" target="nw26" title="more academic record services">&gt;&gt; More Services</a></li>
</ul>
</div>
</div>
<div class="col col-md-6 col-2xl-4 mb-4">
<div class="border-1 border-radius-3 p-3 full-height">
<h4 class="mt-0">Awards and Financial Aid</h4>
<ul class="mt-1 ml-0" style="list-style-type:none;">
<li><a href="https://studentssb-prod.ec.tru.ca/BcFinaidSelfService/ssb/webApplication" target="nw27" title="apply for an award">Apply for an Award</a></li>
<li><a href="     https://studentssb-prod.ec.tru.ca/BcFinaidSelfService/ssb/awardGuide#!/welcome/awardCriteriaSelection/awardList" target="nw28" title="Browse awards">Browse Awards</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/BcFinaidSelfService/ssb/institutionalAppendix#!/welcome/selectionCriteria" target="nw29" title="Program costs calculator">Program Cost Calculator</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/BcFinaidSelfService/ssb/disbursements#!/" target="nw30" title="Awards and funds received">Awards and Funds Received</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/BcFinaidSelfService/ssb/commitments#!/offersList" target="nw31" title="Commitments and offers">Award Offers</a></li>
<li><a class="size-14" href="https://tru.ca/awards.html" target="nw32" title="More financial awards services">&gt;&gt; More Services</a></li>
</ul>
</div>
</div>
<div class="col col-md-6 col-2xl-4 mb-4">
<div class="border-1 border-radius-3 p-3 full-height">
<h4 class="mt-0">Financial</h4>
<ul class="mt-1 ml-0" style="list-style-type:none;">
<li><a href="https://www.tru.ca/future/tuition/pay.html">Learn How to Pay</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/MTFXPayMyTuitionPaymentCenter" target="nw33" title="Pay tuition and deposit">Pay Tuition and Deposit</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/accountSummary#!/accountSummaryTerm" target="nw34" title="account summary">My Account Summary</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/MedicalDentalOptOut" target="nw35" title="medical and dental opt-out">Medical and Dental Opt-out</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/ZcustomSpbpersSSN" target="_blank" title="sin">SIN for T2202</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/t2202a#/pChooset2202akey" target="nw36" title="t2202 tax form">T2202 Tax Form</a></li>
<li><a href="https://generalssb-prod.ec.tru.ca/BannerExtensibility/customPage/page/TRU_T2202_letter" target="_blank" title="t2202 explanation letter">T2202 Explanation Letter</a></li>
<li><a href="https://www.tru.ca/current/enrolment-services/tuition/refunds.html" target="nw37" title="request a refund">Request a Refund</a></li>
<li><a class="size-14" href="https://www.tru.ca/current/enrolment-services/tuition.html" target="nw39" title="more tuition services">&gt;&gt; More Services</a></li>
</ul>
</div>
</div>
<div class="col col-md-6 col-2xl-4 mb-4">
<div class="border-1 border-radius-3 p-3 full-height">
<h4 class="mt-0">Transcripts</h4>
<ul class="mt-1 ml-0" style="list-style-type:none;">
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/academicTranscript" target="nw40" title="view your transcript">View Your Transcript</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/requestPrintedTranscript" target="nw41" title="order a transcript">Order Printed Transcript</a></li>
<li><a href="https://studentssb-prod.ec.tru.ca/StudentSelfService/ssb/transcriptOrderDate" target="nw42" title="view status of ordered transcript">View Status of Transcript Requests</a></li>
<li><a class="size-14" href="https://www.tru.ca/current/enrolment-services/academic-records.html" target="nw43" title="more transcript services">&gt;&gt; More Services</a></li>
</ul>
</div>
</div>
</div>
</section>
<div class="footer-wrapper"><jdoc:include name="footer" style="xhtml" type="modules" /></div>
<style>

  .footer-wrapper {

    display: flex;

    flex-direction: column;

    width: 100%;

  }



  .footer-wrapper a {

    transition: all 0.25s ease;

  }



  .moto-column {

    width: 100%;

    text-align: center;

    margin-bottom: 30px;

    padding-right: 0 !important;

  }



  .footer-moto {

    display: block;

    margin-bottom: 5px;

    line-height: 1;

  }



  .moto-desc {

    display: block;

    margin-bottom: 15px;

  }



  .footer-links {

    background-color: var(--dblue);

    padding: 30px 15px;

    width: 100%;

    display: flex;

    flex-wrap: wrap;

    justify-content: space-evenly;

  }



  .links-column {

    padding-right: 15px;

  }



  .links-column:last-child {

    padding-right: 0;

    width: auto !important;

  }



  .links-title {

    display: block;

    margin-bottom: 15px;

    font-size: 18px;

  }



  .footer-logo {

    background-color: #00b3ba;

    padding: 30px;

    width: 100%;

    display: flex;

    flex-direction: column;

    align-items: center;

    text-align: center;

  }



  .footer-logo img {

    width: 100%;

    max-width: 290px;

  }



  .links-column ul {

    list-style-type: none;

    padding: 0;

    margin: 0;

  }



  .links-column ul li {

    padding: 4px 0;

    font-size: 12px;

  }



  .links-column a,

  .logo-links a,

  .logo-social a {

    color: white !important;

    text-decoration: none !important;

    border-bottom: 0 !important;

  }

  

  .social-wolfpack {

    display: flex;

  }



  .social-wolfpack img {

    width: 45px;

    filter: grayscale(1) brightness(100);

    margin-top: -3px;

  }



  .links-column a:hover,

  .links-column a:focus,

  .logo-links a:hover,

  .logo-links a:focus,

  .logo-social a:hover,

  .logo-social a:focus {

    opacity: 0.75;

  }



  .logo-links {

    margin: 30px 0;

    display: flex;

    flex-direction: column;

  }



  .logo-social {

    display: flex;

    align-items: center;

  }



  .logo-social a {

    font-size: 30px;

    margin-right: 17px;

  }



  .logo-social a:last-child {

    margin-right: 0;

  }



  @media only screen and (min-width: 1025px) {

    .footer-wrapper {

      flex-direction: row;

    }



    .moto-column {

      padding-right: inherit !important;

      margin-bottom: 0 !important;

    }



    .footer-logo {

      align-items: flex-start;

      text-align: left;

    }



    .footer-logo img {

      max-width: 200px;

    }



    .moto-column {

      text-align: left;

      width: auto;

    }



    .footer-links {

      width: 70%;

      padding: 30px;

    }



    .footer-logo {

      width: 30%;

    }



    .logo-social a {

      font-size: 20px;

    }

  }



  @media only screen and (min-width: 1200px) {

    .footer-links {

      justify-content: flex-end;

      padding: 45px 45px 15px;

    }



    .footer-logo {

      padding: 45px 45px 15px;

    }



    .links-column {

      padding-right: 45px;

      width: 25%;

    }



    .links-column ul li {

      font-size: 14px;

    }

    

    .logo-social a {

      font-size: 24px;

    }

  }



  @media only screen and (min-width: 1500px) {

    .footer-links {

      padding: 60px 60px 45px;

    }



    .footer-logo {

      padding: 60px 60px 30px;

    }



    .footer-logo img {

      max-width: 250px;



    .links-column {

      padding-right: 60px;

    }



    .links-title {

      font-size: 24px;

    }



    .links-column ul li {

      font-size: 16px;

    }



    .logo-social a {

      font-size: 30px;

    }

  }



  @media only screen and (min-width: 1680px) {

    .footer-links {

      width: 65%;

      padding: 60px 90px 45px;

    }



    .footer-logo {

      width: 35%;

      padding: 60px 90px 30px;

    }



    .links-column {

      padding-right: 90px;

    }

  }

</style>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/tru.js" type="text/javascript"></script><script type="text/javascript">ipjMoveViewstateFromFooter()</script>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1039981959;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "PVxPCLXkl3IQh7vz7wM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/conversion.js" type="text/javascript">
</script>
<noscript>
<div style="display:inline;">
<img alt="" height="1" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/1039981959" style="border-style:none;" width="1"/>
</div>
</noscript>
<!-- Bing Ads Tracking Code for TRU Campus - Future Students - Contact Us -->
<script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"4044402"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","https://bat.bing.com/bat.js","uetq");</script><noscript><img height="0" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/0" style="display:none; visibility: hidden;" width="0"/></noscript><script type="text/javascript">ipjMoveViewstateFromFooter()</script>
</body>
</body></html>
