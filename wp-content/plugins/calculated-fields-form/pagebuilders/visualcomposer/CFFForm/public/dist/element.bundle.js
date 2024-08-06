(window["vcvWebpackJsonp4x"] = window["vcvWebpackJsonp4x"] || []).push([["element"],{

/***/ "./CFFForm/component.js":
/*!******************************!*\
  !*** ./CFFForm/component.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nObject.defineProperty(exports, \"__esModule\", {\n\tvalue: true\n});\n\nvar _extends2 = __webpack_require__(/*! babel-runtime/helpers/extends */ \"./node_modules/babel-runtime/helpers/extends.js\");\n\nvar _extends3 = _interopRequireDefault(_extends2);\n\nvar _getPrototypeOf = __webpack_require__(/*! babel-runtime/core-js/object/get-prototype-of */ \"./node_modules/babel-runtime/core-js/object/get-prototype-of.js\");\n\nvar _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);\n\nvar _classCallCheck2 = __webpack_require__(/*! babel-runtime/helpers/classCallCheck */ \"./node_modules/babel-runtime/helpers/classCallCheck.js\");\n\nvar _classCallCheck3 = _interopRequireDefault(_classCallCheck2);\n\nvar _createClass2 = __webpack_require__(/*! babel-runtime/helpers/createClass */ \"./node_modules/babel-runtime/helpers/createClass.js\");\n\nvar _createClass3 = _interopRequireDefault(_createClass2);\n\nvar _possibleConstructorReturn2 = __webpack_require__(/*! babel-runtime/helpers/possibleConstructorReturn */ \"./node_modules/babel-runtime/helpers/possibleConstructorReturn.js\");\n\nvar _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);\n\nvar _get2 = __webpack_require__(/*! babel-runtime/helpers/get */ \"./node_modules/babel-runtime/helpers/get.js\");\n\nvar _get3 = _interopRequireDefault(_get2);\n\nvar _inherits2 = __webpack_require__(/*! babel-runtime/helpers/inherits */ \"./node_modules/babel-runtime/helpers/inherits.js\");\n\nvar _inherits3 = _interopRequireDefault(_inherits2);\n\nvar _react = __webpack_require__(/*! react */ \"./node_modules/react/index.js\");\n\nvar _react2 = _interopRequireDefault(_react);\n\nvar _vcCake = __webpack_require__(/*! vc-cake */ \"./node_modules/vc-cake/index.js\");\n\nvar _vcCake2 = _interopRequireDefault(_vcCake);\n\nfunction _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }\n\nvar vcvAPI = _vcCake2.default.getService('api');\n\nvar CFFFormElement = function (_vcvAPI$elementCompon) {\n\t(0, _inherits3.default.default)(CFFFormElement, _vcvAPI$elementCompon);\n\n\tfunction CFFFormElement() {\n\t\t(0, _classCallCheck3.default.default)(this, CFFFormElement);\n\t\treturn (0, _possibleConstructorReturn3.default.default)(this, (CFFFormElement.__proto__ || (0, _getPrototypeOf2.default)(CFFFormElement)).apply(this, arguments));\n\t}\n\n\t(0, _createClass3.default.default)(CFFFormElement, [{\n\t\tkey: 'sanitize',\n\t\tvalue: function sanitize(str, args) {\n\t\t\tif (typeof args == 'undefined') args = {};\n\t\t\tif (!('quotes' in args)) args['quotes'] = false;\n\t\t\tif (!('spaces' in args)) args['spaces'] = false;\n\n\t\t\tstr = str.replace(/[^a-zA-Z0-9\\.\\-_\\s\"'=]/g, '');\n\t\t\tif (!args.quotes) str = str.replace(/'\"/g, '');\n\t\t\tif (!args.spaces) str = str.replace(/\\s/g, '');\n\n\t\t\treturn str;\n\t\t}\n\t}, {\n\t\tkey: 'getTheShortcode',\n\t\tvalue: function getTheShortcode(atts) {\n\t\t\t// Generates the form's shortcode\n\t\t\tvar _atts$fId = atts.fId,\n\t\t\t    fId = _atts$fId === undefined ? \"\" : _atts$fId,\n\t\t\t    _atts$clssName = atts.clssName,\n\t\t\t    clssName = _atts$clssName === undefined ? \"\" : _atts$clssName,\n\t\t\t    _atts$attrs = atts.attrs,\n\t\t\t    attrs = _atts$attrs === undefined ? \"\" : _atts$attrs;\n\n\t\t\tif (fId == '') return '';\n\t\t\tvar shortcode = '[CP_CALCULATED_FIELDS id=\"' + this.sanitize(fId) + '\"';\n\t\t\tif (clssName != '') shortcode += ' class=\"' + this.sanitize(clssName, { spaces: true }) + '\"';\n\t\t\tif (attrs != '') shortcode += ' ' + this.sanitize(attrs, { quotes: true, spaces: true });\n\t\t\tshortcode += ']';\n\n\t\t\treturn shortcode;\n\t\t}\n\t}, {\n\t\tkey: 'addFormGeneratorForVSEditor',\n\t\tvalue: function addFormGeneratorForVSEditor(base) {\n\t\t\treturn base != '' ? base + '<script>delete fbuilderjQuery.fbuilderGeneratorFlag; if(\"fbuilderjQuery\" in window && \"fbuilderjQueryGenerator\" in fbuilderjQuery) fbuilderjQuery.fbuilderjQueryGenerator();</script>' : base;\n\t\t}\n\t}, {\n\t\tkey: 'componentDidMount',\n\t\tvalue: function componentDidMount() {\n\n\t\t\tvar shortcode = this.addFormGeneratorForVSEditor(this.getTheShortcode(this.props.atts));\n\t\t\t(0, _get3.default.default)(CFFFormElement.prototype.__proto__ || (0, _getPrototypeOf2.default)(CFFFormElement.prototype), 'updateShortcodeToHtml', this).call(this, shortcode, this.refs.vcvhelper);\n\t\t\tif (!window.wp || !window.wp.shortcode || !window.VCV_API_WPBAKERY_WPB_MAP) {\n\t\t\t\treturn;\n\t\t\t}\n\n\t\t\tthis.multipleShortcodesRegex = window.wp.shortcode.regexp(window.VCV_API_WPBAKERY_WPB_MAP().join('|'));\n\t\t\tthis.localShortcodesRegex = new RegExp(this.multipleShortcodesRegex.source);\n\t\t}\n\t}, {\n\t\tkey: 'componentDidUpdate',\n\t\tvalue: function componentDidUpdate(props) {\n\n\t\t\tvar shortcode = this.addFormGeneratorForVSEditor(this.getTheShortcode(this.props.atts));\n\t\t\tvar shortcodeCmp = this.getTheShortcode(props.atts);\n\t\t\t// update only if shortcode changed\n\t\t\tif (shortcode !== shortcodeCmp) {\n\t\t\t\t(0, _get3.default.default)(CFFFormElement.prototype.__proto__ || (0, _getPrototypeOf2.default)(CFFFormElement.prototype), 'updateShortcodeToHtml', this).call(this, shortcode, this.refs.vcvhelper);\n\t\t\t}\n\t\t}\n\t}, {\n\t\tkey: 'render',\n\t\tvalue: function render() {\n\t\t\tvar _props = this.props,\n\t\t\t    id = _props.id,\n\t\t\t    atts = _props.atts,\n\t\t\t    editor = _props.editor;\n\n\n\t\t\tvar shortcode = this.getTheShortcode(atts);\n\t\t\tvar elementClasses = 'vce-cff-form';\n\t\t\tvar wrapperClasses = 'vce-cff-form-wrapper vce';\n\t\t\tvar customProps = {};\n\n\t\t\tvar doAll = this.applyDO('all');\n\n\t\t\treturn _react2.default.createElement(\n\t\t\t\t'div',\n\t\t\t\t(0, _extends3.default.default)({ className: elementClasses }, editor, customProps),\n\t\t\t\t_react2.default.createElement(\n\t\t\t\t\t'div',\n\t\t\t\t\t(0, _extends3.default.default)({ className: wrapperClasses, id: 'el-' + id }, doAll),\n\t\t\t\t\t_react2.default.createElement('style', { className: 'vcvhelper', ref: 'style' }),\n\t\t\t\t\t_react2.default.createElement('div', { className: 'vcvhelper', ref: 'vcvhelper', 'data-vcvs-html': shortcode })\n\t\t\t\t)\n\t\t\t);\n\t\t}\n\t}]);\n\treturn CFFFormElement;\n}(vcvAPI.elementComponent);\n\nexports.default = CFFFormElement;\n\n//# sourceURL=webpack:///./CFFForm/component.js?");

/***/ }),

/***/ "./CFFForm/index.js":
/*!**************************!*\
  !*** ./CFFForm/index.js ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nvar _vcCake = __webpack_require__(/*! vc-cake */ \"./node_modules/vc-cake/index.js\");\n\nvar _vcCake2 = _interopRequireDefault(_vcCake);\n\nvar _component = __webpack_require__(/*! ./component */ \"./CFFForm/component.js\");\n\nvar _component2 = _interopRequireDefault(_component);\n\nfunction _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }\n\nvar vcvAddElement = _vcCake2.default.getService('cook').add;\n\nvcvAddElement(__webpack_require__(/*! ./settings.json */ \"./CFFForm/settings.json\"),\n// Component callback\nfunction (component) {\n  component.add(_component2.default);\n}, {\n  css: false,\n  editorCss: __webpack_require__(/*! raw-loader!./editor.css */ \"./node_modules/raw-loader/index.js!./CFFForm/editor.css\")\n});\n\n//# sourceURL=webpack:///./CFFForm/index.js?");

/***/ }),

/***/ "./CFFForm/settings.json":
/*!*******************************!*\
  !*** ./CFFForm/settings.json ***!
  \*******************************/
/*! exports provided: fId, clssName, attrs, designOptions, editFormTab1, metaEditFormTabs, relatedTo, tag, default */
/***/ (function(module) {

eval("module.exports = {\"fId\":{\"type\":\"number\",\"access\":\"public\",\"options\":{\"label\":\"Enter the form id (Required)\",\"description\":\"Enter the integer number representing the form's id to insert.\"}},\"clssName\":{\"type\":\"string\",\"access\":\"public\",\"options\":{\"label\":\"Class name (Optional)\",\"description\":\"Enter the custom class names to apply the form (separated by space)\"}},\"attrs\":{\"type\":\"string\",\"access\":\"public\",\"options\":{\"label\":\"Additional attributes (Optional)\",\"description\":\"Enter the additional parameters to include in the form's shortcode. Ex. attr_1=\\\"value1\\\" attr_2=\\\"value2\\\"\"}},\"designOptions\":{\"type\":\"designOptions\",\"access\":\"public\",\"value\":{},\"options\":{\"label\":\"Design Options\"}},\"editFormTab1\":{\"type\":\"group\",\"access\":\"protected\",\"value\":[\"fId\",\"clssName\",\"attrs\"],\"options\":{\"label\":\"General\"}},\"metaEditFormTabs\":{\"type\":\"group\",\"access\":\"protected\",\"value\":[\"editFormTab1\",\"designOptions\"]},\"relatedTo\":{\"type\":\"group\",\"access\":\"protected\",\"value\":[\"General\"]},\"tag\":{\"access\":\"protected\",\"type\":\"string\",\"value\":\"CFFForm\"}};\n\n//# sourceURL=webpack:///./CFFForm/settings.json?");

/***/ }),

/***/ "./node_modules/babel-runtime/core-js/object/get-own-property-descriptor.js":
/*!**********************************************************************************!*\
  !*** ./node_modules/babel-runtime/core-js/object/get-own-property-descriptor.js ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = { \"default\": __webpack_require__(/*! core-js/library/fn/object/get-own-property-descriptor */ \"./node_modules/core-js/library/fn/object/get-own-property-descriptor.js\"), __esModule: true };\n\n//# sourceURL=webpack:///./node_modules/babel-runtime/core-js/object/get-own-property-descriptor.js?");

/***/ }),

/***/ "./node_modules/babel-runtime/helpers/get.js":
/*!***************************************************!*\
  !*** ./node_modules/babel-runtime/helpers/get.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nexports.__esModule = true;\n\nvar _getPrototypeOf = __webpack_require__(/*! ../core-js/object/get-prototype-of */ \"./node_modules/babel-runtime/core-js/object/get-prototype-of.js\");\n\nvar _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);\n\nvar _getOwnPropertyDescriptor = __webpack_require__(/*! ../core-js/object/get-own-property-descriptor */ \"./node_modules/babel-runtime/core-js/object/get-own-property-descriptor.js\");\n\nvar _getOwnPropertyDescriptor2 = _interopRequireDefault(_getOwnPropertyDescriptor);\n\nfunction _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }\n\nexports.default = function get(object, property, receiver) {\n  if (object === null) object = Function.prototype;\n  var desc = (0, _getOwnPropertyDescriptor2.default)(object, property);\n\n  if (desc === undefined) {\n    var parent = (0, _getPrototypeOf2.default)(object);\n\n    if (parent === null) {\n      return undefined;\n    } else {\n      return get(parent, property, receiver);\n    }\n  } else if (\"value\" in desc) {\n    return desc.value;\n  } else {\n    var getter = desc.get;\n\n    if (getter === undefined) {\n      return undefined;\n    }\n\n    return getter.call(receiver);\n  }\n};\n\n//# sourceURL=webpack:///./node_modules/babel-runtime/helpers/get.js?");

/***/ }),

/***/ "./node_modules/core-js/library/fn/object/get-own-property-descriptor.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/core-js/library/fn/object/get-own-property-descriptor.js ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("__webpack_require__(/*! ../../modules/es6.object.get-own-property-descriptor */ \"./node_modules/core-js/library/modules/es6.object.get-own-property-descriptor.js\");\nvar $Object = __webpack_require__(/*! ../../modules/_core */ \"./node_modules/core-js/library/modules/_core.js\").Object;\nmodule.exports = function getOwnPropertyDescriptor(it, key) {\n  return $Object.getOwnPropertyDescriptor(it, key);\n};\n\n\n//# sourceURL=webpack:///./node_modules/core-js/library/fn/object/get-own-property-descriptor.js?");

/***/ }),

/***/ "./node_modules/raw-loader/index.js!./CFFForm/editor.css":
/*!******************************************************!*\
  !*** ./node_modules/raw-loader!./CFFForm/editor.css ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = \".vce-cff-form {\\n  min-height: 1em;\\n}\\n.vce-cff-form .vcvhelper:empty{min-height:1em; background:#DEDEDE;}\\n.vce-cff-form .vcvhelper *{pointer-events: none;}\"\n\n//# sourceURL=webpack:///./CFFForm/editor.css?./node_modules/raw-loader");

/***/ })

},[['./CFFForm/index.js']]]);