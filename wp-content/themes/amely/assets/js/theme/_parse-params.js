/**
 * $.parseParams - parse query string paramaters into an object.
 */
!function(n){var r=/([^&=]+)=?([^&]*)/g,e=/\+/g,t=function(n){return decodeURIComponent(n.replace(e," "))};n.parseParams=function(n){for(var e,u={};e=r.exec(n);){var a=t(e[1]),o=t(e[2]);"[]"===a.substring(a.length-2)?(a=a.substring(0,a.length-2),(u[a]||(u[a]=[])).push(o)):u[a]=o}return u}}(jQuery);
