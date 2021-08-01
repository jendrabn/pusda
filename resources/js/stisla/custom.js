/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

if (document.getElementsByTagName('nav')) {
  const scrollTopElement = document.querySelector('.scroll-top');
  const headerHeight = document.getElementsByTagName('nav')[0].clientHeight;

  scrollTopElement.addEventListener('click', function () {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0; // for safari
  });

  window.addEventListener('scroll', function () {
    if (pageYOffset > headerHeight) {
      scrollTopElement.classList.add('show');
    } else {
      scrollTopElement.classList.remove('show');
    }
  });
}

