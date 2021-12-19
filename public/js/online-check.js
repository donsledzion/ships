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

eval("/*\r\nwindow.Echo.channel('game.' + tableId)\r\n    .listen('PlayerMoved', function(response){\r\n        console.log('echo works');\r\n\r\n    });\r\n*/\n$(function () {\n  console.log('Online checker script loaded');\n  setInterval(function () {\n    $('.online-status').each(function () {\n      var userId = $(this).data(\"id\");\n      console.log(\"Testing user with id: \" + userId);\n      $.ajax({\n        url: baseUrl + '/user/' + userId + '/online-status'\n      }).done(function (response) {\n        console.log(\"success: \" + response.message);\n        var status = response.color;\n        /*let interval = response.interval;\r\n        if(interval) {\r\n            if (interval < 10) {\r\n                status = 'green';\r\n            } else if (interval < 30) {\r\n                status = 'yellow';\r\n            } else if (interval < 45) {\r\n                status = 'orange';\r\n            }\r\n        }*/\n\n        $('#status-' + response.user_id).html('<img src=\"' + baseAsset + '/' + status + '-dot.png\" style=\"width: 30px; height:30px;\" />');\n      }).fail(function (response) {\n        console.log(\"fail: \" + response);\n      });\n    });\n  }, 1000 * 60);\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvb25saW5lLWNoZWNrLmpzPzBmYmEiXSwibmFtZXMiOlsiJCIsImNvbnNvbGUiLCJsb2ciLCJzZXRJbnRlcnZhbCIsImVhY2giLCJ1c2VySWQiLCJkYXRhIiwiYWpheCIsInVybCIsImJhc2VVcmwiLCJkb25lIiwicmVzcG9uc2UiLCJtZXNzYWdlIiwic3RhdHVzIiwiY29sb3IiLCJ1c2VyX2lkIiwiaHRtbCIsImJhc2VBc3NldCIsImZhaWwiXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUFBLENBQUMsQ0FBQyxZQUFVO0FBQ1JDLEVBQUFBLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLDhCQUFaO0FBQ0FDLEVBQUFBLFdBQVcsQ0FBQyxZQUFVO0FBQ2xCSCxJQUFBQSxDQUFDLENBQUMsZ0JBQUQsQ0FBRCxDQUFvQkksSUFBcEIsQ0FBeUIsWUFBVTtBQUMvQixVQUFJQyxNQUFNLEdBQUdMLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUU0sSUFBUixDQUFhLElBQWIsQ0FBYjtBQUNBTCxNQUFBQSxPQUFPLENBQUNDLEdBQVIsQ0FBWSwyQkFBMkJHLE1BQXZDO0FBQ0FMLE1BQUFBLENBQUMsQ0FBQ08sSUFBRixDQUFPO0FBQ0hDLFFBQUFBLEdBQUcsRUFBRUMsT0FBTyxHQUFHLFFBQVYsR0FBcUJKLE1BQXJCLEdBQThCO0FBRGhDLE9BQVAsRUFFR0ssSUFGSCxDQUVRLFVBQVNDLFFBQVQsRUFBa0I7QUFDdEJWLFFBQUFBLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLGNBQWNTLFFBQVEsQ0FBQ0MsT0FBbkM7QUFDQSxZQUFJQyxNQUFNLEdBQUdGLFFBQVEsQ0FBQ0csS0FBdEI7QUFDQTtBQUNoQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRWdCZCxRQUFBQSxDQUFDLENBQUMsYUFBV1csUUFBUSxDQUFDSSxPQUFyQixDQUFELENBQStCQyxJQUEvQixDQUFvQyxlQUFhQyxTQUFiLEdBQXVCLEdBQXZCLEdBQTJCSixNQUEzQixHQUFrQyxnREFBdEU7QUFDSCxPQWpCRCxFQWlCR0ssSUFqQkgsQ0FpQlEsVUFBU1AsUUFBVCxFQUFrQjtBQUN0QlYsUUFBQUEsT0FBTyxDQUFDQyxHQUFSLENBQVksV0FBV1MsUUFBdkI7QUFDSCxPQW5CRDtBQXFCSCxLQXhCRDtBQTBCSCxHQTNCVSxFQTJCVCxPQUFLLEVBM0JJLENBQVg7QUE0QkgsQ0E5QkEsQ0FBRCIsInNvdXJjZXNDb250ZW50IjpbIi8qXHJcbndpbmRvdy5FY2hvLmNoYW5uZWwoJ2dhbWUuJyArIHRhYmxlSWQpXHJcbiAgICAubGlzdGVuKCdQbGF5ZXJNb3ZlZCcsIGZ1bmN0aW9uKHJlc3BvbnNlKXtcclxuICAgICAgICBjb25zb2xlLmxvZygnZWNobyB3b3JrcycpO1xyXG5cclxuICAgIH0pO1xyXG4qL1xyXG5cclxuJChmdW5jdGlvbigpe1xyXG4gICAgY29uc29sZS5sb2coJ09ubGluZSBjaGVja2VyIHNjcmlwdCBsb2FkZWQnKTtcclxuICAgIHNldEludGVydmFsKGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgJCgnLm9ubGluZS1zdGF0dXMnKS5lYWNoKGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgIGxldCB1c2VySWQgPSAkKHRoaXMpLmRhdGEoXCJpZFwiKTtcclxuICAgICAgICAgICAgY29uc29sZS5sb2coXCJUZXN0aW5nIHVzZXIgd2l0aCBpZDogXCIgKyB1c2VySWQpO1xyXG4gICAgICAgICAgICAkLmFqYXgoe1xyXG4gICAgICAgICAgICAgICAgdXJsOiBiYXNlVXJsICsgJy91c2VyLycgKyB1c2VySWQgKyAnL29ubGluZS1zdGF0dXMnXHJcbiAgICAgICAgICAgIH0pLmRvbmUoZnVuY3Rpb24ocmVzcG9uc2Upe1xyXG4gICAgICAgICAgICAgICAgY29uc29sZS5sb2coXCJzdWNjZXNzOiBcIiArIHJlc3BvbnNlLm1lc3NhZ2UpO1xyXG4gICAgICAgICAgICAgICAgbGV0IHN0YXR1cyA9IHJlc3BvbnNlLmNvbG9yO1xyXG4gICAgICAgICAgICAgICAgLypsZXQgaW50ZXJ2YWwgPSByZXNwb25zZS5pbnRlcnZhbDtcclxuICAgICAgICAgICAgICAgIGlmKGludGVydmFsKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGludGVydmFsIDwgMTApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc3RhdHVzID0gJ2dyZWVuJztcclxuICAgICAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKGludGVydmFsIDwgMzApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc3RhdHVzID0gJ3llbGxvdyc7XHJcbiAgICAgICAgICAgICAgICAgICAgfSBlbHNlIGlmIChpbnRlcnZhbCA8IDQ1KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0YXR1cyA9ICdvcmFuZ2UnO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0qL1xyXG5cclxuICAgICAgICAgICAgICAgICQoJyNzdGF0dXMtJytyZXNwb25zZS51c2VyX2lkKS5odG1sKCc8aW1nIHNyYz1cIicrYmFzZUFzc2V0KycvJytzdGF0dXMrJy1kb3QucG5nXCIgc3R5bGU9XCJ3aWR0aDogMzBweDsgaGVpZ2h0OjMwcHg7XCIgLz4nKTtcclxuICAgICAgICAgICAgfSkuZmFpbChmdW5jdGlvbihyZXNwb25zZSl7XHJcbiAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhcImZhaWw6IFwiICsgcmVzcG9uc2UpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfSk7XHJcblxyXG4gICAgfSwxMDAwKjYwKTtcclxufSk7XHJcblxyXG4iXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL29ubGluZS1jaGVjay5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/online-check.js\n");

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