<?php 
    global $THEME;
    global $CFG;
    global $DB;

    $courseThemeColor = '#ffb3b3'; // insert get color from theme settings function 
    $bgSVG = 'data: image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 640 512\'><path d=\'M256.455 8c66.269.119 126.437 26.233 170.859 68.685l35.715-35.715C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.75c-30.864-28.899-70.801-44.907-113.23-45.273-92.398-.798-170.283 73.977-169.484 169.442C88.764 348.009 162.184 424 256 424c41.127 0 79.997-14.678 110.629-41.556 4.743-4.161 11.906-3.908 16.368.553l39.662 39.662c4.872 4.872 4.631 12.815-.482 17.433C378.202 479.813 319.926 504 256 504 119.034 504 8.001 392.967 8 256.002 7.999 119.193 119.646 7.755 256.455 8z\'/></svg>';

    //if(in_course_context()) {

    //header("Content-type: text/css; charset: UTF-8");

    var_dump($CFG->settings);
?>
<style>
    .test-color {
        color: <?php echo $courseThemeColor; ?>;
    }

    #buttonsectioncontainer .buttonsection.current {
        background-color:<?php echo $courseThemeColor; ?>;
    }

    #buttonsectioncontainer .buttonsection.sectionvisible {
        background-color:<?php echo $courseThemeColor; ?>;
    }

    .otp-module-local {
        fill:<?php echo $courseThemeColor; ?> !important; 
        color:<?php echo $courseThemeColor; ?>;
    }

    .btn-primary { 
        color: #fff !important;
        background-color:<?php echo $courseThemeColor; ?>;
        border-color:<?php echo $courseThemeColor; ?>;
    }

    .btn-primary:hover { 
        color: #fff !important;
        background-color:<?php echo $courseThemeColor; ?>aa;
        border-color:<?php echo $courseThemeColor; ?>;
    }

    .pagelayout-course {
        background-color:<?php echo $courseThemeColor; ?>09;
    }

    h1,h2,h3,h4,h5 {
        color:<?php echo $courseThemeColor; ?>;
    }

    .inplaceeditable .quickeditlink {
        color:<?php echo $courseThemeColor; ?>;
    }

    a,a:active,a:visited {
        color:<?php echo $courseThemeColor; ?>;
    }

    [data-region="drawer"] a,a:active,a:visited {
        color:#ffffff;
    }

    h1,h2,h3,h4,h5 a,a:visited {
        color:<?php echo $courseThemeColor; ?>;
    }
    #sidepreopen-control {
        background-color:<?php echo $courseThemeColor; ?>;
    }


    .pagelayout-course #page-header {
        color:<?php echo $courseThemeColor; ?>; 
    }

    #page-header .card {
        width: 100%;
    }

    #page-header .col-12 {
        display: flex !important;
    }

    #page-header .card-body {
        margin-left: -120px;
    }

    .drawer-toggle, #nav-drawer, #nav-drawer ul {
        background-color:<?php echo $courseThemeColor; ?> !important;
    }

    .tm-watermark {
        background-image: url("<?php $bgSVG ?>");  
        background-size: contain; 
        background-repeat: no-repeat; 
        height: 100px; 
        width: 120px; 
        opacity: 0.1; 
        margin: auto;
    }

    #page-header .mr-auto {
        margin-left: auto !important;
    }

</style>