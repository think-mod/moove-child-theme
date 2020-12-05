<?php
 
// Every file should have GPL and copyright in the header - we skip it in tutorials but you should not skip it for real.
 
// This line protects the file from being accessed by a URL directly.                                                               
defined('MOODLE_INTERNAL') || die();
 
// We will add callbacks here as we add features to our theme.

function theme_moovechild_get_main_scss_content($theme) {                                                                                
    global $CFG;                                                                                                                    
 
    $scss = '';                                                                                                                     
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;                                                 
    $fs = get_file_storage();                                                                                                       
 
    $context = context_system::instance();                                                                                          
    if ($filename == 'default.scss') {                                                                                              
        // We still load the default preset files directly from the boost theme. No sense in duplicating them.                      
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');                                        
    } else if ($filename == 'plain.scss') {                                                                                         
        // We still load the default preset files directly from the boost theme. No sense in duplicating them.                      
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');                                          
 
    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_moovechild', 'preset', 0, '/', $filename))) {              
        // This preset file was fetched from the file area for theme_moovechild and not theme_boost (see the line above).                
        $scss .= $presetfile->get_content();                                                                                        
    } else {                                                                                                                        
        // Safety fallback - maybe new installs etc.                                                                                
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');                                        
    }     
    
    // Moove scss.
    $moovevariables = file_get_contents($CFG->dirroot . '/theme/moove/scss/moove/_variables.scss');
    $moove = file_get_contents($CFG->dirroot . '/theme/moove/scss/moove.scss');
 
    // Pre CSS - this is loaded AFTER any prescss from the setting but before the main scss.                                        
    $pre = file_get_contents($CFG->dirroot . '/theme/moovechild/scss/pre.scss');                                                         
    // Post CSS - this is loaded AFTER the main scss but before the extra scss from the setting.                                    
    $post = file_get_contents($CFG->dirroot . '/theme/moovechild/scss/post.scss');                                                       
 
    // Combine them together.                                                                                                       
    return $moovevariables . "\n" .$pre . "\n" . $scss . "\n" . $moove . "\n" . $post;                                                                                      
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_moovechild_get_pre_scss($theme) {
    // Load the settings from the parent.                                                                                           
    $theme = theme_config::load('moove');                                                                                           
    // Call the parent themes get_pre_scss function.                                                                                
    return theme_boost_get_pre_scss($theme); 
}

// Function to return the SCSS to append to our main SCSS for this theme.
// Note the function name starts with the component name because this is a global function and we don't want namespace clashes.
function theme_moovechild_get_extra_scss($theme) {
    // Load the settings from the parent.                                                                                           
    $theme = theme_config::load('moove');                                                                                           
    // Call the parent themes get_extra_scss function.                                                                                
    return theme_moove_get_extra_scss($theme);                         
}

function theme_moovechild_page_init(moodle_page $page) {

    //need to check which course we are in
    global $COURSE;
    $course_id = $COURSE->id;

    //$course_id -= 1;

    if($course_id > 1) {
        $context = context_course::instance($course_id);
        $courseSelector = 'courseColor'.$course_id;
        $coursecolor = get_config('theme_moovechild', $courseSelector);
    } else {
        $coursecolor = false;
    }

    if($coursecolor) {
        $courseThemeColor = get_config('theme_moovechild', 'courseColor'.$course_id); // insert get color from theme settings function 
        $bgSVG = 'data: image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 640 512\'><path d=\'M256.455 8c66.269.119 126.437 26.233 170.859 68.685l35.715-35.715C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.75c-30.864-28.899-70.801-44.907-113.23-45.273-92.398-.798-170.283 73.977-169.484 169.442C88.764 348.009 162.184 424 256 424c41.127 0 79.997-14.678 110.629-41.556 4.743-4.161 11.906-3.908 16.368.553l39.662 39.662c4.872 4.872 4.631 12.815-.482 17.433C378.202 479.813 319.926 504 256 504 119.034 504 8.001 392.967 8 256.002 7.999 119.193 119.646 7.755 256.455 8z\'/></svg>';

    } else {
        $courseThemeColor = '#ffb3b3'; // insert get color from theme settings function 
        $bgSVG = 'data: image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 640 512\'><path d=\'M256.455 8c66.269.119 126.437 26.233 170.859 68.685l35.715-35.715C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.75c-30.864-28.899-70.801-44.907-113.23-45.273-92.398-.798-170.283 73.977-169.484 169.442C88.764 348.009 162.184 424 256 424c41.127 0 79.997-14.678 110.629-41.556 4.743-4.161 11.906-3.908 16.368.553l39.662 39.662c4.872 4.872 4.631 12.815-.482 17.433C378.202 479.813 319.926 504 256 504 119.034 504 8.001 392.967 8 256.002 7.999 119.193 119.646 7.755 256.455 8z\'/></svg>';
    }

    echo '<style>
        .test-color {
            color: ' . $courseThemeColor . '99;
        }

        #buttonsectioncontainer .buttonsection.current {
            background-color:' . $courseThemeColor . ';
        }

        #buttonsectioncontainer .buttonsection.sectionvisible {
            background-color:' . $courseThemeColor . ';
        }

        .otp-module-local {
            fill:' . $courseThemeColor . ' !important; 
            color:' . $courseThemeColor . ';
        }

        .btn-primary { 
            color: #fff !important;
            background-color:' . $courseThemeColor . ';
            border-color:' . $courseThemeColor . ';
        }

        .btn-primary:hover { 
            color: #fff !important;
            background-color:' . $courseThemeColor . 'aa;
            border-color:' . $courseThemeColor . ';
        }

        .pagelayout-course {
            background-color:' . $courseThemeColor . '09;
        }

        h1,h2,h3,h4,h5 {
            color:' . $courseThemeColor . ';
        }

        .inplaceeditable .quickeditlink {
            color:' . $courseThemeColor . ';
        }

        a,a:active,a:visited {
            color:' . $courseThemeColor . ';
        }

        [data-region="drawer"] a,a:active,a:visited {
            color:#ffffff;
        }

        h1,h2,h3,h4,h5 a,a:visited {
            color:' . $courseThemeColor . ';
        }
        #sidepreopen-control {
            background-color:' . $courseThemeColor . ';
        }


        .pagelayout-course #page-header {
            color:' . $courseThemeColor . '; 
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
            background-color:' . $courseThemeColor . ' !important;
        }

        .tm-watermark {
            background-image: url("' . $bgSVG . '");  
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

    </style>';

    /*global $CFG;

    require_once($CFG->dirroot.'/course/lib.php');

    $courseColorSetting = new admin_settingpage('coursecolorsettings', new lang_string('coursecolorsettings'));
    $ADMIN->add('courses', $temp);*/
}