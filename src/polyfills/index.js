let plugin = {}
export default plugin.install = function () {
  /* Added the following polyfills from MDN: */
  //
  /* - Array.forEach */
  /* - Array.includes */
  /* - NodeList.forEach */
  /* - String.includes */

  /* Array.forEach polyfill */
  if (!Array.prototype.forEach) {
    /* eslint no-extend-native: "off" */
    Array.prototype.forEach = function (callback /* , thisArg */) {
      var T, k
      if (this == null) {
        throw new TypeError('this is null or not defined')
      }
      var O = Object(this)
      var len = O.length >>> 0
      if (typeof callback !== 'function') {
        throw new TypeError(callback + ' is not a function')
      }
      if (arguments.length > 1) {
        T = arguments[1]
      }
      k = 0
      while (k < len) {
        var kValue
        if (k in O) {
          kValue = O[k]
          callback.call(T, kValue, k, O)
        }
        k++
      }
    }
  }

  /* Array.includes polyfill */
  if (!Array.prototype.includes) {
    /* eslint no-extend-native: "off" */
    Object.defineProperty(Array.prototype, 'includes', {
      value: function (searchElement, fromIndex) {
        if (this == null) {
          throw new TypeError('"this" is null or not defined')
        }
        var o = Object(this)
        var len = o.length >>> 0
        if (len === 0) {
          return false
        }
        var n = fromIndex | 0
        var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0)
        function sameValueZero (x, y) {
          return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y))
        }
        while (k < len) {
          if (sameValueZero(o[k], searchElement)) {
            return true
          }
          k++
        }
        return false
      }
    })
  }

  /* NodeList.forEach polyfill */
  if (window.NodeList && !NodeList.prototype.forEach) {
    /* eslint no-extend-native: "off" */
    NodeList.prototype.forEach = function (callback, thisArg) {
      thisArg = thisArg || window
      for (var i = 0; i < this.length; i++) {
        callback.call(thisArg, this[i], i, this)
      }
    }
  }

  /* String.includes polyfill */
  if (!String.prototype.includes) {
    /* eslint no-extend-native: "off" */
    String.prototype.includes = function (search, start) {
      'use strict'
      if (typeof start !== 'number') {
        start = 0
      }
      if (start + search.length > this.length) {
        return false
      } else {
        return this.indexOf(search, start) !== -1
      }
    }
  }
}
