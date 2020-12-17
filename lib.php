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
        tm-watermark {
            background-image: url(data: image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 640 512\'><path d=\'M149.333 216v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-80c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zM125.333 32H24C10.745 32 0 42.745 0 56v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24zm80 448H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm-24-424v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24zm24 264H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24z\'/></svg>);
            background-size: contain;
            background-repeat: no-repeat;
            height: 100px;
            width: 120px;
            opacity: 0.1;
            margin: auto;
        }
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

        

        #page-header .mr-auto {
            margin-left: auto !important;
        }

    </style>';

    /*
    .tm-watermark {
            background-image: url("' . $bgSVG . '");  
            background-size: contain; 
            background-repeat: no-repeat; 
            height: 100px; 
            width: 120px; 
            opacity: 0.1; 
            margin: auto;
        }
    */

    
}

function theme_moovechild_before_footer() {
    // echo the script for setting the svg

    //need to check which course we are in
    global $COURSE;
    global $CFG;
    $course_id = $COURSE->id;

    global $CFG;

    $theme = theme_config::load('moovechild');


    if($course_id > 1) {
        $context = context_course::instance($course_id);
        $courseSelector = 'courseSVG'.$course_id;
        $courseSVG = get_config('theme_moovechild', $courseSelector);
        //$courseSVG = theme_moovechild_pluginfile($COURSE, $context, 'courseSVG' . $course_id, [], 'false', []);
    } else {
        $courseSVG = false;
    }

    //$url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename(), false);


    if($courseSVG) {
        print_r($courseSVG);
        echo '
            <script> 
                // Put link from breadcrumb on title.
                let courseTitle = document.getElementsByClassName("page-header-headings")[0].firstChild
                let linkToCourse
                let tempLink

                console.log(courseTitle, linkToCourse, tempLink);
                
                if (courseTitle) {
                let breadcrumbs = document.getElementsByClassName("breadcrumb-item")
                for (let i = 0; i < breadcrumbs.length; i++) {
                    tempLink = breadcrumbs[i].firstChild.href
                    if(tempLink) {
                    if(tempLink.includes("/course/view.php")) {
                        linkToCourse = tempLink
                    }
                    if(tempLink.includes("#section")) {
                        linkToCourse = tempLink
                    }
                    }
                }
                
                if (linkToCourse) {
                    let linkText = courseTitle.innerText
                    courseTitle.innerText = ""
                    courseTitle.innerHTML = \'<a href="\' + linkToCourse + \'">\' + linkText + \'</a>\'
                }
                }
                // Create a SVG Watermark in the background.
                let watermark = document.createElement(\'div\');
                watermark.classList.add("tm-watermark");
                document.getElementById("page-header").firstElementChild.insertBefore(watermark, document.getElementById("page-header").firstElementChild.firstElementChild);
            </script>
            <style>
                .tm-watermark {
                    background-image: url("'. $CFG->wwwroot . $courseSVG . '");  
                    background-size: contain; 
                    background-repeat: no-repeat; 
                    height: 100px; 
                    width: 120px; 
                    opacity: 0.1; 
                    margin: auto;
                }
            </style>
        ';
    }
}

function theme_moovechild_update_settings_images($settingname) {
    global $CFG;

    // The setting name that was updated comes as a string like 's_theme_photo_loginbackgroundimage'.
    // We split it on '_' characters.
    $parts = explode('_', $settingname);
    // And get the last one to get the setting name..
    $settingname = end($parts);

    // Admin settings are stored in system context.
    $syscontext = context_system::instance();
    // This is the component name the setting is stored in.
    $component = 'theme_moovechild';


    // This is the value of the admin setting which is the filename of the uploaded file.
    $filename = get_config($component, $settingname);
    // We extract the file extension because we want to preserve it.
    $extension = substr($filename, strrpos($filename, '.') + 1);

    // This is the path in the moodle internal file system.
    $fullpath = "/{$syscontext->id}/{$component}/{$settingname}/0{$filename}";

    var_dump($fullpath);
    die();

    // This location matches the searched for location in theme_config::resolve_image_location.
    $pathname = $CFG->dataroot . '/pix_plugins/theme/moovechild/' . $settingname . '.' . $extension;

    // This pattern matches any previous files with maybe different file extensions.
    $pathpattern = $CFG->dataroot . '/pix_plugins/theme/moovechild/' . $settingname . '.*';

    // Make sure this dir exists.
    @mkdir($CFG->dataroot . '/pix_plugins/theme/moovechild/', $CFG->directorypermissions, true);

    // Delete any existing files for this setting.
    foreach (glob($pathpattern) as $filename) {
        @unlink($filename);
    }

    // Get an instance of the moodle file storage.
    $fs = get_file_storage();
    // This is an efficient way to get a file if we know the exact path.
    if ($file = $fs->get_file_by_hash(sha1($fullpath))) {
        // We got the stored file - copy it to dataroot.
        $file->copy_content_to($pathname);
    }

    // Reset theme caches.
    theme_reset_all_caches();
}

/**
 * Serve the files from the MYPLUGIN file areas
 *
 * @param stdClass $course the course object
 * @param stdClass $cm the course module object
 * @param stdClass $context the context
 * @param string $filearea the name of the file area
 * @param array $args extra arguments (itemid, path)
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if the file not found, just send the file otherwise and do not return anything
 */
function theme_moovechild_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    // Check the contextlevel is as expected - if your plugin is a block, this becomes CONTEXT_BLOCK, etc.
    if ($context->contextlevel != CONTEXT_MODULE) {
        return false; 
    }
 
    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'expectedfilearea' && $filearea !== 'anotherexpectedfilearea') {
        return false;
    }
 
    // Make sure the user is logged in and has access to the module (plugins that are not course modules should leave out the 'cm' part).
    require_login($course, true, $cm);
 
    // Check the relevant capabilities - these may vary depending on the filearea being accessed.
    if (!has_capability('mod/MYPLUGIN:view', $context)) {
        return false;
    }
 
    // Leave this line out if you set the itemid to null in make_pluginfile_url (set $itemid to 0 instead).
    $itemid = array_shift($args); // The first item in the $args array.
 
    // Use the itemid to retrieve any relevant data records and perform any security checks to see if the
    // user really does have access to the file in question.
 
    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
    }
 
    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'mod_MYPLUGIN', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false; // The file does not exist.
    }
 
    // We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering. 
    send_stored_file($file, 86400, 0, $forcedownload, $options);
}
