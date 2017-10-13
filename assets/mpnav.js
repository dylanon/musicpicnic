/*
 * Script for navbar dropdown
 * Uses code written by Todd Motto on this personal website
 * https://toddmotto.com/building-an-html5-responsive-menu-with-media-queries-javascript/
*/

var menuIcon = document.createElement('div');
menuIcon.className = 'mp-nav-icon';
document.querySelector('.site-header').appendChild(menuIcon);

// hasClass
function hasClass(elem, className) {
    return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
}

// toggleClass
function toggleClass(elem, className) {
    var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
    if (hasClass(elem, className)) {
        while (newClass.indexOf(' ' + className + ' ') >= 0) {
            newClass = newClass.replace(' ' + className + ' ', ' ');
        }
        elem.className = newClass.replace(/^\s+|\s+$/g, '');
    } else {
        elem.className += ' ' + className;
    }
}

// Mobile nav function
var mobileNav = document.querySelector('.mp-nav-icon');
var toggle = document.querySelector('.nav-primary');
mobileNav.onclick = function () {
    toggleClass(this, 'mp-nav-open');
    toggleClass(toggle, 'mp-nav-active');
};