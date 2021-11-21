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

/***/ "./resources/js/edit-board.js":
/*!************************************!*\
  !*** ./resources/js/edit-board.js ***!
  \************************************/
/***/ (() => {

eval("function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar Field = /*#__PURE__*/function () {\n  function Field(_x, _y) {\n    _classCallCheck(this, Field);\n\n    this.x = _x;\n    this.y = _y;\n  }\n\n  _createClass(Field, [{\n    key: \"getX\",\n    value: function getX() {\n      return this.x;\n    }\n  }, {\n    key: \"getY\",\n    value: function getY() {\n      return this.y;\n    }\n  }, {\n    key: \"position\",\n    value: function position() {\n      return this.x + this.y;\n    }\n  }, {\n    key: \"inject\",\n    value: function inject(see) {\n      var X = String.fromCharCode(this.x + 64);\n      var Y = this.y;\n      see.X.Y = \"S\";\n    }\n  }]);\n\n  return Field;\n}();\n\nvar Ship = /*#__PURE__*/function () {\n  function Ship(size) {\n    _classCallCheck(this, Ship);\n\n    this.size = size;\n    this.fields = [];\n  }\n\n  _createClass(Ship, [{\n    key: \"addField\",\n    value: function addField(field) {\n      if (this.fields.length < this.size) {\n        // need to insert some validation rules\n        this.fields.push(field);\n        $('#' + field.position() + '').append('<img id=\"theImg\" src=\"' + baseUrl + '/storage/img/cross-green.png\" style=\"width:100%; height: 100%; object-fit: cover;\" />');\n      } else {\n        alert('ZIOMUŚ! Nie można już więcej pól dodać do tego statku!');\n      }\n    }\n  }, {\n    key: \"getSize\",\n    value: function getSize() {\n      return this.size;\n    }\n  }, {\n    key: \"launch\",\n    value: function launch(see) {\n      $.each(this.fields, function (index, value) {\n        value.inject(see);\n      });\n    }\n  }]);\n\n  return Ship;\n}();\n\nvar fields;\n\nfunction readBoard(board_id) {\n  $.ajax({\n    url: baseUrl + '/board/' + board_id,\n    method: \"get\"\n  }).done(function (response) {\n    console.log(response);\n    console.log(response.fields.A[1]);\n    fields = response.fields;\n  }).fail(function (response) {\n    console.log('fail!');\n    console.log(response);\n  });\n}\n\n$(function () {\n  readBoard($('#save-board').data(\"id\"));\n  var four_master = new Ship(+4);\n  var three_master = [new Ship(+3), new Ship(+3)];\n  var two_master = [new Ship(+2), new Ship(+2), new Ship(+2)];\n  var one_master = [new Ship(+1), new Ship(+1), new Ship(+1), new Ship(+1)];\n  var current_ship = four_master; //alert('script loaded!');\n\n  $('.tic-box').click(function () {\n    var field = new Field($(this).data(\"x\"), $(this).data(\"y\"));\n    console.log('Dodawanie pola ' + field.position() + \" do statku \" + current_ship.getSize() + \"-masztowego\");\n    current_ship.addField(field);\n  });\n  $('.ship-picker').click(function () {\n    var size = $(this).data(\"size\");\n    var order = $(this).data(\"order\");\n\n    switch (size) {\n      case 4:\n        current_ship = four_master;\n        break;\n\n      case 3:\n        current_ship = three_master[order - 1];\n        break;\n\n      case 2:\n        current_ship = two_master[order - 1];\n        break;\n\n      case 1:\n        current_ship = one_master[order - 1];\n        break;\n\n      default:\n        alert(\"Coś nie tak :/\");\n    }\n\n    console.log('Wybrano statek ' + size + \"-masztowy nr \" + order);\n  });\n  $('#save-board').click(function () {\n    var board_id = $(this).data(\"id\");\n    console.log(\"Fields to be saved:\");\n    console.log(fields); //four_master.launch(fields);\n\n    $.each(four_master.fields, function (index, value) {\n      var poziomo = value.getX();\n      var pionowo = value.getY();\n      console.log(\"poziomo: \" + poziomo + \", pionowo: \" + pionowo); //fields.poziomo = \"S\";\n    });\n    $.ajaxSetup({\n      headers: {\n        'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')\n      }\n    });\n    console.log('zapisywanie planszy nr ' + board_id);\n    fields.A[1] = \"X\";\n    $.ajax({\n      method: 'put',\n      url: baseUrl + '/board/' + board_id,\n      dataType: 'json',\n      data: {\n        \"fields\": JSON.stringify(fields),\n        \"four_master\": JSON.stringify(four_master),\n        \"three_master\": JSON.stringify(three_master),\n        \"two_master\": JSON.stringify(two_master),\n        \"one_master\": JSON.stringify(one_master)\n      }\n    }).done(function (response) {\n      console.log(\"Well done! \" + response.message);\n      console.log(\"Board:\");\n      console.log(response.board.fields);\n      Swal.fire('Udało się utworzyć planszę! Jak tylko wszyscy gracze będą gotowi możemy zaczynać!');\n    }).fail(function (response) {\n      console.log(\"Shit happened! \" + response.message);\n    });\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZWRpdC1ib2FyZC5qcz82MzNjIl0sIm5hbWVzIjpbIkZpZWxkIiwiX3giLCJfeSIsIngiLCJ5Iiwic2VlIiwiWCIsIlN0cmluZyIsImZyb21DaGFyQ29kZSIsIlkiLCJTaGlwIiwic2l6ZSIsImZpZWxkcyIsImZpZWxkIiwibGVuZ3RoIiwicHVzaCIsIiQiLCJwb3NpdGlvbiIsImFwcGVuZCIsImJhc2VVcmwiLCJhbGVydCIsImVhY2giLCJpbmRleCIsInZhbHVlIiwiaW5qZWN0IiwicmVhZEJvYXJkIiwiYm9hcmRfaWQiLCJhamF4IiwidXJsIiwibWV0aG9kIiwiZG9uZSIsInJlc3BvbnNlIiwiY29uc29sZSIsImxvZyIsIkEiLCJmYWlsIiwiZGF0YSIsImZvdXJfbWFzdGVyIiwidGhyZWVfbWFzdGVyIiwidHdvX21hc3RlciIsIm9uZV9tYXN0ZXIiLCJjdXJyZW50X3NoaXAiLCJjbGljayIsImdldFNpemUiLCJhZGRGaWVsZCIsIm9yZGVyIiwicG96aW9tbyIsImdldFgiLCJwaW9ub3dvIiwiZ2V0WSIsImFqYXhTZXR1cCIsImhlYWRlcnMiLCJhdHRyIiwiZGF0YVR5cGUiLCJKU09OIiwic3RyaW5naWZ5IiwibWVzc2FnZSIsImJvYXJkIiwiU3dhbCIsImZpcmUiXSwibWFwcGluZ3MiOiI7Ozs7OztJQUFNQSxLO0FBQ0YsaUJBQVlDLEVBQVosRUFBZ0JDLEVBQWhCLEVBQW9CO0FBQUE7O0FBQ2hCLFNBQUtDLENBQUwsR0FBU0YsRUFBVDtBQUNBLFNBQUtHLENBQUwsR0FBU0YsRUFBVDtBQUNIOzs7O1dBQ0QsZ0JBQU07QUFBQyxhQUFPLEtBQUtDLENBQVo7QUFBZTs7O1dBQ3RCLGdCQUFNO0FBQUMsYUFBTyxLQUFLQyxDQUFaO0FBQWU7OztXQUV0QixvQkFBVTtBQUNOLGFBQU8sS0FBS0QsQ0FBTCxHQUFPLEtBQUtDLENBQW5CO0FBQ0g7OztXQUVELGdCQUFPQyxHQUFQLEVBQVc7QUFDUCxVQUFJQyxDQUFD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Q0FBQ1csSUFBRixDQUFPO0FBQ0hFLE1BQUFBLE1BQU0sRUFBRSxLQURMO0FBRUhELE1BQUFBLEdBQUcsRUFBRVQsT0FBTyxHQUFHLFNBQVYsR0FBb0JPLFFBRnRCO0FBR0gyQixNQUFBQSxRQUFRLEVBQUUsTUFIUDtBQUlIakIsTUFBQUEsSUFBSSxFQUFDO0FBQ0Qsa0JBQVVrQixJQUFJLENBQUNDLFNBQUwsQ0FBZTNDLE1BQWYsQ0FEVDtBQUVELHVCQUFlMEMsSUFBSSxDQUFDQyxTQUFMLENBQWVsQixXQUFmLENBRmQ7QUFHRCx3QkFBZ0JpQixJQUFJLENBQUNDLFNBQUwsQ0FBZWpCLFlBQWYsQ0FIZjtBQUlELHNCQUFjZ0IsSUFBSSxDQUFDQyxTQUFMLENBQWVoQixVQUFmLENBSmI7QUFLRCxzQkFBY2UsSUFBSSxDQUFDQyxTQUFMLENBQWVmLFVBQWY7QUFMYjtBQUpGLEtBQVAsRUFZR1YsSUFaSCxDQVlRLFVBQVNDLFFBQVQsRUFBa0I7QUFDdEJDLE1BQUFBLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLGdCQUFnQkYsUUFBUSxDQUFDeUIsT0FBckM7QUFDQXhCLE1BQUFBLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLFFBQVo7QUFDQUQsTUFBQUEsT0FBTyxDQUFDQyxHQUFSLENBQVlGLFFBQVEsQ0FBQzBCLEtBQVQsQ0FBZTdDLE1BQTNCO0FBQ0E4QyxNQUFBQSxJQUFJLENBQUNDLElBQUwsQ0FBVSxtRkFBVjtBQUNILEtBakJELEVBaUJHeEIsSUFqQkgsQ0FpQlEsVUFBU0osUUFBVCxFQUFrQjtBQUN0QkMsTUFBQUEsT0FBTyxDQUFDQyxHQUFSLENBQVksb0JBQW9CRixRQUFRLENBQUN5QixPQUF6QztBQUNILEtBbkJEO0FBb0JILEdBdkNEO0FBd0NILENBM0VBLENBQUQiLCJzb3VyY2VzQ29udGVudCI6WyJjbGFzcyBGaWVsZCB7XG4gICAgY29uc3RydWN0b3IoX3gsIF95KSB7XG4gICAgICAgIHRoaXMueCA9IF94O1xuICAgICAgICB0aGlzLnkgPSBfeTtcbiAgICB9XG4gICAgZ2V0WCgpe3JldHVybiB0aGlzLng7fVxuICAgIGdldFkoKXtyZXR1cm4gdGhpcy55O31cblxuICAgIHBvc2l0aW9uKCl7XG4gICAgICAgIHJldHVybiB0aGlzLngrdGhpcy55O1xuICAgIH1cblxuICAgIGluamVjdChzZWUpe1xuICAgICAgICB2YXIgWCA9IFN0cmluZy5mcm9tQ2hhckNvZGUodGhpcy54KzY0KTtcbiAgICAgICAgdmFyIFkgPXRoaXMueTtcbiAgICAgICAgc2VlLlguWSA9IFwiU1wiO1xuICAgIH1cbn1cblxuY2xhc3MgU2hpcCB7XG4gICAgY29uc3RydWN0b3Ioc2l6ZSkge1xuICAgICAgICB0aGlzLnNpemUgPSBzaXplO1xuICAgICAgICB0aGlzLmZpZWxkcyA9IFtdO1xuICAgIH1cblxuICAgIGFkZEZpZWxkKGZpZWxkKXtcbiAgICAgICAgaWYoKHRoaXMuZmllbGRzLmxlbmd0aCA8IHRoaXMuc2l6ZSkpIHsgLy8gbmVlZCB0byBpbnNlcnQgc29tZSB2YWxpZGF0aW9uIHJ1bGVzXG4gICAgICAgICAgICB0aGlzLmZpZWxkcy5wdXNoKGZpZWxkKTtcbiAgICAgICAgICAgICQoJyMnK2ZpZWxkLnBvc2l0aW9uKCkrJycpLmFwcGVuZCgnPGltZyBpZD1cInRoZUltZ1wiIHNyYz1cIicrYmFzZVVybCsnL3N0b3JhZ2UvaW1nL2Nyb3NzLWdyZWVuLnBuZ1wiIHN0eWxlPVwid2lkdGg6MTAwJTsgaGVpZ2h0OiAxMDAlOyBvYmplY3QtZml0OiBjb3ZlcjtcIiAvPicpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgYWxlcnQoJ1pJT01VxZohIE5pZSBtb8W8bmEganXFvCB3acSZY2VqIHDDs2wgZG9kYcSHIGRvIHRlZ28gc3RhdGt1IScpO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgZ2V0U2l6ZSgpe1xuICAgICAgICByZXR1cm4gdGhpcy5zaXplO1xuICAgIH1cblxuICAgIGxhdW5jaChzZWUpe1xuICAgICAgICAkLmVhY2godGhpcy5maWVsZHMsIGZ1bmN0aW9uKGluZGV4LCB2YWx1ZSl7XG4gICAgICAgICAgICB2YWx1ZS5pbmplY3Qoc2VlKTtcbiAgICAgICAgfSlcbiAgICB9XG59XG5cbmxldCBmaWVsZHM7XG5cbmZ1bmN0aW9uIHJlYWRCb2FyZChib2FyZF9pZCl7XG4gICAgJC5hamF4KHtcbiAgICAgICAgdXJsOiBiYXNlVXJsICsgJy9ib2FyZC8nICsgYm9hcmRfaWQsXG4gICAgICAgIG1ldGhvZDogXCJnZXRcIixcbiAgICB9KS5kb25lKGZ1bmN0aW9uKHJlc3BvbnNlKXtcbiAgICAgICAgY29uc29sZS5sb2cocmVzcG9uc2UpO1xuICAgICAgICBjb25zb2xlLmxvZyhyZXNwb25zZS5maWVsZHMuQVsxXSk7XG4gICAgICAgIGZpZWxkcyA9IHJlc3BvbnNlLmZpZWxkcztcbiAgICB9KS5mYWlsKGZ1bmN0aW9uKHJlc3BvbnNlKXtcbiAgICAgICAgY29uc29sZS5sb2coJ2ZhaWwhJyk7XG4gICAgICAgIGNvbnNvbGUubG9nKHJlc3BvbnNlKTtcbiAgICB9KTtcbn1cblxuJChmdW5jdGlvbigpe1xuICAgIHJlYWRCb2FyZCgkKCcjc2F2ZS1ib2FyZCcpLmRhdGEoXCJpZFwiKSlcbiAgICBsZXQgZm91cl9tYXN0ZXIgPSBuZXcgU2hpcCgrNCkgO1xuICAgIGxldCB0aHJlZV9tYXN0ZXIgPSBbbmV3IFNoaXAoKzMpLCBuZXcgU2hpcCgrMyldO1xuICAgIGxldCB0d29fbWFzdGVyID0gW25ldyBTaGlwKCsyKSxuZXcgU2hpcCgrMiksbmV3IFNoaXAoKzIpXTtcbiAgICBsZXQgb25lX21hc3RlciA9IFtuZXcgU2hpcCgrMSksbmV3IFNoaXAoKzEpLG5ldyBTaGlwKCsxKSxuZXcgU2hpcCgrMSldO1xuICAgIGxldCBjdXJyZW50X3NoaXAgPSBmb3VyX21hc3RlcjtcbiAgICAvL2FsZXJ0KCdzY3JpcHQgbG9hZGVkIScpO1xuICAgICQoJy50aWMtYm94JykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAgICAgdmFyIGZpZWxkID0gbmV3IEZpZWxkKCQodGhpcykuZGF0YShcInhcIiksJCh0aGlzKS5kYXRhKFwieVwiKSk7XG4gICAgICAgIGNvbnNvbGUubG9nKCdEb2Rhd2FuaWUgcG9sYSAnKyBmaWVsZC5wb3NpdGlvbigpICsgXCIgZG8gc3RhdGt1IFwiICsgY3VycmVudF9zaGlwLmdldFNpemUoKStcIi1tYXN6dG93ZWdvXCIpO1xuICAgICAgICBjdXJyZW50X3NoaXAuYWRkRmllbGQoZmllbGQpO1xuICAgIH0pO1xuICAgICQoJy5zaGlwLXBpY2tlcicpLmNsaWNrKGZ1bmN0aW9uKCl7XG4gICAgICAgIHZhciBzaXplID0gJCh0aGlzKS5kYXRhKFwic2l6ZVwiKTtcbiAgICAgICAgdmFyIG9yZGVyID0gJCh0aGlzKS5kYXRhKFwib3JkZXJcIik7XG4gICAgICAgIHN3aXRjaCAoc2l6ZSl7XG4gICAgICAgICAgICBjYXNlIDQ6XG4gICAgICAgICAgICAgICAgY3VycmVudF9zaGlwID0gZm91cl9tYXN0ZXI7XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlIDM6XG4gICAgICAgICAgICAgICAgY3VycmVudF9zaGlwID0gdGhyZWVfbWFzdGVyW29yZGVyLTFdO1xuICAgICAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgICAgY2FzZSAyOlxuICAgICAgICAgICAgICAgIGN1cnJlbnRfc2hpcCA9IHR3b19tYXN0ZXJbb3JkZXItMV07XG4gICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICBjYXNlIDE6XG4gICAgICAgICAgICAgICAgY3VycmVudF9zaGlwID0gb25lX21hc3RlcltvcmRlci0xXTtcbiAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgYWxlcnQoXCJDb8WbIG5pZSB0YWsgOi9cIik7XG4gICAgICAgIH1cbiAgICAgICAgY29uc29sZS5sb2coJ1d5YnJhbm8gc3RhdGVrICcrc2l6ZStcIi1tYXN6dG93eSBuciBcIisgb3JkZXIpO1xuICAgIH0pO1xuXG4gICAgJCgnI3NhdmUtYm9hcmQnKS5jbGljayhmdW5jdGlvbigpe1xuICAgICAgICB2YXIgYm9hcmRfaWQgPSAkKHRoaXMpLmRhdGEoXCJpZFwiKTtcbiAgICAgICAgY29uc29sZS5sb2coXCJGaWVsZHMgdG8gYmUgc2F2ZWQ6XCIpO1xuICAgICAgICBjb25zb2xlLmxvZyhmaWVsZHMpO1xuICAgICAgICAvL2ZvdXJfbWFzdGVyLmxhdW5jaChmaWVsZHMpO1xuICAgICAgICAkLmVhY2goZm91cl9tYXN0ZXIuZmllbGRzLCBmdW5jdGlvbihpbmRleCx2YWx1ZSl7XG4gICAgICAgICAgICB2YXIgcG96aW9tbyA9IHZhbHVlLmdldFgoKTtcbiAgICAgICAgICAgIHZhciBwaW9ub3dvID0gdmFsdWUuZ2V0WSgpO1xuICAgICAgICAgICAgY29uc29sZS5sb2coXCJwb3ppb21vOiBcIisgcG96aW9tbyArIFwiLCBwaW9ub3dvOiBcIisgcGlvbm93byk7XG4gICAgICAgICAgICAvL2ZpZWxkcy5wb3ppb21vID0gXCJTXCI7XG4gICAgICAgIH0pXG4gICAgICAgICQuYWpheFNldHVwKHtcbiAgICAgICAgICAgIGhlYWRlcnM6IHtcbiAgICAgICAgICAgICAgICAnWC1DU1JGLVRPS0VOJzogJCgnbWV0YVtuYW1lPVwiY3NyZi10b2tlblwiXScpLmF0dHIoJ2NvbnRlbnQnKVxuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgICAgICBjb25zb2xlLmxvZygnemFwaXN5d2FuaWUgcGxhbnN6eSBuciAnK2JvYXJkX2lkKTtcbiAgICAgICAgZmllbGRzLkFbMV0gPSBcIlhcIjtcbiAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgIG1ldGhvZDogJ3B1dCcsXG4gICAgICAgICAgICB1cmw6IGJhc2VVcmwgKyAnL2JvYXJkLycrYm9hcmRfaWQsXG4gICAgICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgICAgICAgZGF0YTp7XG4gICAgICAgICAgICAgICAgXCJmaWVsZHNcIjogSlNPTi5zdHJpbmdpZnkoZmllbGRzKSxcbiAgICAgICAgICAgICAgICBcImZvdXJfbWFzdGVyXCI6IEpTT04uc3RyaW5naWZ5KGZvdXJfbWFzdGVyKSxcbiAgICAgICAgICAgICAgICBcInRocmVlX21hc3RlclwiOiBKU09OLnN0cmluZ2lmeSh0aHJlZV9tYXN0ZXIpLFxuICAgICAgICAgICAgICAgIFwidHdvX21hc3RlclwiOiBKU09OLnN0cmluZ2lmeSh0d29fbWFzdGVyKSxcbiAgICAgICAgICAgICAgICBcIm9uZV9tYXN0ZXJcIjogSlNPTi5zdHJpbmdpZnkob25lX21hc3RlciksXG5cbiAgICAgICAgICAgIH1cbiAgICAgICAgfSkuZG9uZShmdW5jdGlvbihyZXNwb25zZSl7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhcIldlbGwgZG9uZSEgXCIgKyByZXNwb25zZS5tZXNzYWdlKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKFwiQm9hcmQ6XCIpO1xuICAgICAgICAgICAgY29uc29sZS5sb2cocmVzcG9uc2UuYm9hcmQuZmllbGRzKTtcbiAgICAgICAgICAgIFN3YWwuZmlyZSgnVWRhxYJvIHNpxJkgdXR3b3J6ecSHIHBsYW5zesSZISBKYWsgdHlsa28gd3N6eXNjeSBncmFjemUgYsSZZMSFIGdvdG93aSBtb8W8ZW15IHphY3p5bmHEhyEnKVxuICAgICAgICB9KS5mYWlsKGZ1bmN0aW9uKHJlc3BvbnNlKXtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKFwiU2hpdCBoYXBwZW5lZCEgXCIgKyByZXNwb25zZS5tZXNzYWdlKTtcbiAgICAgICAgfSk7XG4gICAgfSk7XG59KVxuIl0sImZpbGUiOiIuL3Jlc291cmNlcy9qcy9lZGl0LWJvYXJkLmpzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/edit-board.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/edit-board.js"]();
/******/ 	
/******/ })()
;