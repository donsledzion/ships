/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/online-check.js":
/*!**************************************!*\
  !*** ./resources/js/online-check.js ***!
  \**************************************/
/***/ (() => {

eval("/*\nwindow.Echo.channel('game.' + tableId)\n    .listen('PlayerMoved', function(response){\n        console.log('echo works');\n\n    });\n*/\n$(function () {\n  console.log('Online checker script loaded');\n  setInterval(function () {\n    $('.online-status').each(function () {\n      var userId = $(this).data(\"id\");\n      console.log(\"Testing user with id: \" + userId);\n      $.ajax({\n        url: baseUrl + '/user/' + userId + '/online-status'\n      }).done(function (response) {\n        console.log(\"success: \" + response.message);\n        var status = response.color;\n        /*let interval = response.interval;\n        if(interval) {\n            if (interval < 10) {\n                status = 'green';\n            } else if (interval < 30) {\n                status = 'yellow';\n            } else if (interval < 45) {\n                status = 'orange';\n            }\n        }*/\n\n        $('#status-' + response.user_id).html('<img src=\"' + baseAsset + '/' + status + '-dot.png\" style=\"width: 30px; height:30px;\" />');\n      }).fail(function (response) {\n        console.log(\"fail: \" + response);\n      });\n    });\n  }, 1000 * 60);\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvb25saW5lLWNoZWNrLmpzPzBmYmEiXSwibmFtZXMiOlsiJCIsImNvbnNvbGUiLCJsb2ciLCJzZXRJbnRlcnZhbCIsImVhY2giLCJ1c2VySWQiLCJkYXRhIiwiYWpheCIsInVybCIsImJhc2VVcmwiLCJkb25lIiwicmVzcG9uc2UiLCJtZXNzYWdlIiwic3RhdHVzIiwiY29sb3IiLCJ1c2VyX2lkIiwiaHRtbCIsImJhc2VBc3NldCIsImZhaWwiXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUFBLENBQUMsQ0FBQyxZQUFVO0FBQ1JDLEVBQUFBLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLDhCQUFaO0FBQ0FDLEVBQUFBLFdBQVcsQ0FBQyxZQUFVO0FBQ2xCSCxJQUFBQSxDQUFDLENBQUMsZ0JBQUQsQ0FBRCxDQUFvQkksSUFBcEIsQ0FBeUIsWUFBVTtBQUMvQixVQUFJQyxNQUFNLEdBQUdMLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUU0sSUFBUixDQUFhLElBQWIsQ0FBYjtBQUNBTCxNQUFBQSxPQUFPLENBQUNDLEdBQVIsQ0FBWSwyQkFBMkJHLE1BQXZDO0FBQ0FMLE1BQUFBLENBQUMsQ0FBQ08sSUFBRixDQUFPO0FBQ0hDLFFBQUFBLEdBQUcsRUFBRUMsT0FBTyxHQUFHLFFBQVYsR0FBcUJKLE1BQXJCLEdBQThCO0FBRGhDLE9BQVAsRUFFR0ssSUFGSCxDQUVRLFVBQVNDLFFBQVQsRUFBa0I7QUFDdEJWLFFBQUFBLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLGNBQWNTLFFBQVEsQ0FBQ0MsT0FBbkM7QUFDQSxZQUFJQyxNQUFNLEdBQUdGLFFBQVEsQ0FBQ0csS0FBdEI7QUFDQTtBQUNoQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRWdCZCxRQUFBQSxDQUFDLENBQUMsYUFBV1csUUFBUSxDQUFDSSxPQUFyQixDQUFELENBQStCQyxJQUEvQixDQUFvQyxlQUFhQyxTQUFiLEdBQXVCLEdBQXZCLEdBQTJCSixNQUEzQixHQUFrQyxnREFBdEU7QUFDSCxPQWpCRCxFQWlCR0ssSUFqQkgsQ0FpQlEsVUFBU1AsUUFBVCxFQUFrQjtBQUN0QlYsUUFBQUEsT0FBTyxDQUFDQyxHQUFSLENBQVksV0FBV1MsUUFBdkI7QUFDSCxPQW5CRDtBQXFCSCxLQXhCRDtBQTBCSCxHQTNCVSxFQTJCVCxPQUFLLEVBM0JJLENBQVg7QUE0QkgsQ0E5QkEsQ0FBRCIsInNvdXJjZXNDb250ZW50IjpbIi8qXG53aW5kb3cuRWNoby5jaGFubmVsKCdnYW1lLicgKyB0YWJsZUlkKVxuICAgIC5saXN0ZW4oJ1BsYXllck1vdmVkJywgZnVuY3Rpb24ocmVzcG9uc2Upe1xuICAgICAgICBjb25zb2xlLmxvZygnZWNobyB3b3JrcycpO1xuXG4gICAgfSk7XG4qL1xuXG4kKGZ1bmN0aW9uKCl7XG4gICAgY29uc29sZS5sb2coJ09ubGluZSBjaGVja2VyIHNjcmlwdCBsb2FkZWQnKTtcbiAgICBzZXRJbnRlcnZhbChmdW5jdGlvbigpe1xuICAgICAgICAkKCcub25saW5lLXN0YXR1cycpLmVhY2goZnVuY3Rpb24oKXtcbiAgICAgICAgICAgIGxldCB1c2VySWQgPSAkKHRoaXMpLmRhdGEoXCJpZFwiKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKFwiVGVzdGluZyB1c2VyIHdpdGggaWQ6IFwiICsgdXNlcklkKTtcbiAgICAgICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICAgICAgdXJsOiBiYXNlVXJsICsgJy91c2VyLycgKyB1c2VySWQgKyAnL29ubGluZS1zdGF0dXMnXG4gICAgICAgICAgICB9KS5kb25lKGZ1bmN0aW9uKHJlc3BvbnNlKXtcbiAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhcInN1Y2Nlc3M6IFwiICsgcmVzcG9uc2UubWVzc2FnZSk7XG4gICAgICAgICAgICAgICAgbGV0IHN0YXR1cyA9IHJlc3BvbnNlLmNvbG9yO1xuICAgICAgICAgICAgICAgIC8qbGV0IGludGVydmFsID0gcmVzcG9uc2UuaW50ZXJ2YWw7XG4gICAgICAgICAgICAgICAgaWYoaW50ZXJ2YWwpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKGludGVydmFsIDwgMTApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0YXR1cyA9ICdncmVlbic7XG4gICAgICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoaW50ZXJ2YWwgPCAzMCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgc3RhdHVzID0gJ3llbGxvdyc7XG4gICAgICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoaW50ZXJ2YWwgPCA0NSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgc3RhdHVzID0gJ29yYW5nZSc7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9Ki9cblxuICAgICAgICAgICAgICAgICQoJyNzdGF0dXMtJytyZXNwb25zZS51c2VyX2lkKS5odG1sKCc8aW1nIHNyYz1cIicrYmFzZUFzc2V0KycvJytzdGF0dXMrJy1kb3QucG5nXCIgc3R5bGU9XCJ3aWR0aDogMzBweDsgaGVpZ2h0OjMwcHg7XCIgLz4nKTtcbiAgICAgICAgICAgIH0pLmZhaWwoZnVuY3Rpb24ocmVzcG9uc2Upe1xuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKFwiZmFpbDogXCIgKyByZXNwb25zZSk7XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9KTtcblxuICAgIH0sMTAwMCo2MCk7XG59KTtcblxuIl0sImZpbGUiOiIuL3Jlc291cmNlcy9qcy9vbmxpbmUtY2hlY2suanMuanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/online-check.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/online-check.js"]();
/******/ 	
/******/ })()
;