// Set course color and SVG
function setCourseLayout(color, bgSVG) {

  var sheet = document.createElement('style');
  sheet.innerHTML = "#buttonsectioncontainer .buttonsection.current {background-color: " + color + "99 ;}";
  sheet.innerHTML += "#buttonsectioncontainer .buttonsection.sectionvisible {background-color: " + color + ";}";
  sheet.innerHTML += ".otp-module-local {fill: " + color + " !important; color: " + color + ";}";
  sheet.innerHTML += ".btn-primary { color: #fff !important;background-color:" + color + ";border-color:" + color + ";}";
  sheet.innerHTML += ".btn-primary:hover { color: #fff !important;background-color:" + color + "aa;border-color:" + color + ";}";
  sheet.innerHTML += ".pagelayout-course {background-color:" + color + "09;}";
  sheet.innerHTML += "h1,h2,h3,h4,h5 {font-color:" + color + ";}";

  sheet.innerHTML += ".inplaceeditable .quickeditlink {color:" + color + ";}";
  sheet.innerHTML += "a,a:active,a:visited {color:" + color + ";}";
// links in nav drawer should be white
  sheet.innerHTML += '[data-region="drawer"] a,a:active,a:visited {color:#ffffff;}';
  sheet.innerHTML += "h1,h2,h3,h4,h5 a,a:visited {color:" + color + ";}";
  sheet.innerHTML += "#sidepreopen-control {background-color: " + color + ";}";
  sheet.innerHTML += ".pagelayout-course #page-header {color: " + color + "; }";
  sheet.innerHTML += "#page-header .card {width: 100%;}";
  sheet.innerHTML += "#page-header .col-12 {display: flex !important;}";
  sheet.innerHTML += "#page-header .card-body {margin-left: -120px;}";
  sheet.innerHTML += ".drawer-toggle, #nav-drawer, #nav-drawer ul {background-color: " + color + " !important;}";
  sheet.innerHTML += '.tm-watermark {background-image: url("' + bgSVG + '");  background-size: contain; background-repeat: no-repeat; height: 100px; width: 120px; opacity: 0.1; margin: auto;}';
/* Center course title */
  sheet.innerHTML += '#page-header .mr-auto {margin-left: auto !important;}';

  document.body.appendChild(sheet);

  // Create a SVG Watermark in the background.
  var watermark = document.createElement('div')
  watermark.classList.add("tm-watermark")
  document.getElementById("page-header").firstElementChild.insertBefore(watermark, document.getElementById("page-header").firstElementChild.firstElementChild);


  // Put link from breadcrumb on title.
  var courseTitle = document.getElementsByClassName("page-header-headings")[0].firstChild
  var linkToCourse
  var tempLink

  if (courseTitle) {
    var breadcrumbs = document.getElementsByClassName("breadcrumb-item")
    for (var i = 0; i < breadcrumbs.length; i++) {
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
      var linkText = courseTitle.innerText
      courseTitle.innerText = ""
      courseTitle.innerHTML = '<a href="' + linkToCourse + '">' + linkText + '</a>'
    }
  }
}

// the script copied from the custom block on the ahk-otp site

let queryString = window.location.search;

let courseParams = new URLSearchParams(queryString);

//console.log('query string', queryString);
//console.log('course params', courseParams);


if(courseParams.get('courseThemeColor') !== null) {
    var courseThemeColor = decodeURIComponent(courseParams.get('courseThemeColor'));
} else {
    var courseThemeColor = "#ffb3b3";
}

console.log('course theme color', courseThemeColor);

var bgSVG = "data: image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 640 512'><path d='M256.455 8c66.269.119 126.437 26.233 170.859 68.685l35.715-35.715C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.75c-30.864-28.899-70.801-44.907-113.23-45.273-92.398-.798-170.283 73.977-169.484 169.442C88.764 348.009 162.184 424 256 424c41.127 0 79.997-14.678 110.629-41.556 4.743-4.161 11.906-3.908 16.368.553l39.662 39.662c4.872 4.872 4.631 12.815-.482 17.433C378.202 479.813 319.926 504 256 504 119.034 504 8.001 392.967 8 256.002 7.999 119.193 119.646 7.755 256.455 8z'/></svg>"
setCourseLayout(courseThemeColor, bgSVG)