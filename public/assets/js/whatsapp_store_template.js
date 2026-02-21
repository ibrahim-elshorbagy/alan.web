/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./resources/assets/js/whatsapp_store/template.js ***!
  \********************************************************/
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
document.addEventListener("DOMContentLoaded", function () {
  var storeId = $("#whatsappStoreId").val();
  loadPhoneInput();
  Lang.setLocale(lang);
  productCount(storeId);
});
listenClick(".addToCartBtn", function (event) {
  event.preventDefault();
  var button = $(this);
  var originalContent = button.html();
  button.html(" ✓ ").addClass("animate-btn");
  button.prop("disabled", true);
  setTimeout(function () {
    button.removeClass("animate-btn");
    button.prop("disabled", false);
    button.html(originalContent);
  }, 2000);
  var storeId = $("#whatsappStoreId").val();
  var productId = $(this).attr("data-id");
  var productCard = $(this).closest(".item-card, .product-card, .details, .product-detail-content, .product-box-section");
  var priceWithCurrency = productCard.find(".selling_price").text().trim();
  var currency_icon = "";
  var price = "";

  // Check if currency is prefix (non-digit chars at start)
  var prefixMatch = priceWithCurrency.match(/^[^\d]+/);
  if (prefixMatch) {
    currency_icon = prefixMatch[0];
    price = priceWithCurrency.slice(currency_icon.length).trim();
  } else {
    // Otherwise check for suffix (non-digit chars at end)
    var suffixMatch = priceWithCurrency.match(/[^\d]+$/);
    if (suffixMatch) {
      currency_icon = suffixMatch[0];
      price = priceWithCurrency.slice(0, -currency_icon.length).trim();
    } else {
      // No currency found, assume full string is price
      price = priceWithCurrency;
    }
  }
  var product = {
    id: $(this).data("id"),
    name: productCard.find(".product-name").text().trim(),
    available_stock: productCard.find(".available-stock").val(),
    image_url: productCard.find(".product-image").attr("src") || productCard.find(".product-image").val(),
    currency_icon: currency_icon,
    category_name: productCard.find(".product-category").text().trim() || productCard.find(".product-category").val(),
    qty: 1,
    price: price,
    total_price: price
  };
  addToCart(storeId, product);
});
function addToCart(storeId, product) {
  var cart = JSON.parse(localStorage.getItem("cart")) || {};
  var templateType = templateName;
  if (!cart["store_".concat(storeId)]) {
    cart["store_".concat(storeId)] = {
      grand_total: 0
    };
  }
  var storeCart = cart["store_".concat(storeId)];
  if (storeCart[product.id] && storeCart[product.id].qty >= product.available_stock) {
    if (typeof templateType !== "undefined" && templateType !== null && templateType === "travel") {
      displayErrorMessage(Lang.get("js.no_more_quantity_package"));
      return;
    } else {
      displayErrorMessage(Lang.get("js.no_more_quantity"));
      return;
    }
    // displayErrorMessage(Lang.get("js.no_more_quantity"));
    // return;
  }

  if (typeof templateType !== "undefined" && templateType !== null && templateType === "travel") {
    displaySuccessMessage(Lang.get("js.package_added_to_cart"));
  } else {
    displaySuccessMessage(Lang.get("js.product_added_to_cart"));
  }
  // displaySuccessMessage(Lang.get("js.product_added_to_cart"));
  if (storeCart[product.id]) {
    storeCart[product.id].qty += 1;
    storeCart[product.id].total_price = storeCart[product.id].price * storeCart[product.id].qty;
  } else {
    storeCart[product.id] = _objectSpread({}, product);
  }
  storeCart.grand_total = Object.values(storeCart).filter(function (p) {
    return _typeof(p) === "object";
  }).reduce(function (sum, p) {
    return sum + Number(p.total_price);
  }, 0);
  localStorage.setItem("cart", JSON.stringify(cart));
  productCount(storeId);
}
listenClick("#addToCartViewBtn", function () {
  var _cart$grand_total;
  var storeId = $("#whatsappStoreId").val();
  var cartData = JSON.parse(localStorage.getItem("cart")) || {};
  var cart = cartData["store_".concat(storeId)] || {};
  var grandTotal = (_cart$grand_total = cart === null || cart === void 0 ? void 0 : cart.grand_total) !== null && _cart$grand_total !== void 0 ? _cart$grand_total : 0;
  var cartArray = Object.values(cart).filter(function (item) {
    return item && item.id != null;
  });
  var cartItems = $("#cartItems");
  cartItems.html("");
  var locale = Lang.getLocale();
  var rtlClass = locale == "ar" || locale == "fa" ? "rtl" : "";
  var totalDetails = $("#totalDetails");
  totalDetails.html("");
  var cartItemsCloth = $("#cartItemsCloth");
  cartItemsCloth.html("");
  if (cartArray.length === 0) {
    cartItems.html("\n              <tr>\n           <td colspan=\"5\">\n            <div class=\"d-flex py-3 justify-content-center align-items-center w-100\" >\n                    <h4 class=\"fs-18  text-muted mb-0\">".concat(Lang.get("js.item_not_addded_to_cart"), "</h4>\n                </div>\n           </td>\n       </tr>\n        "));
    cartItemsCloth.html("\n       <tr>\n           <td colspan=\"5\">\n            <div class=\"d-flex py-3 justify-content-center align-items-center w-100\" >\n                    <h4 class=\"fs-18  text-muted mb-0\">".concat(Lang.get("js.item_not_addded_to_cart"), "</h4>\n                </div>\n           </td>\n       </tr>\n        "));
    totalDetails.html("\n            <div class=\"text-center py-3 w-100\">\n                <h4 class=\"fs-18 text-muted\">".concat(Lang.get("js.item_not_addded_to_cart"), "</h4>\n            </div>\n        "));
  } else {
    $.each(cartArray, function (index, item) {
      cartItems.append("\n            <tr class=\"".concat(rtlClass, "\">\n                <td class=\"fw-6 fs-14\">\n                    <div class=\"d-flex gap-lg-4 gap-3 align-items-center\">\n                        <div class=\"product-img\">\n                            <img  src=\"").concat(item.image_url, "\" alt=\"product\" style=\"width: 50px ; height: 50px;\" class=\" object-fit-cover rounded\"  loading=\"lazy\" />\n                        </div>\n                        <div>\n                            <h5 class=\"fs-18 fw-6 mb-0\">").concat(item.name, "</h5>\n                            <p class=\"mb-0 fs-14\">").concat(item.category_name, "</p>\n                        </div>\n                    </div>\n                </td>\n                <td class=\"fw-6 fs-14\">").concat(item.currency_icon, " ").concat(item.price, "</td>\n                <td class=\"text-center\">\n                    <div class=\"btn-group gap-1 justify-content-center\">\n                        <button type=\"button\" class=\"btn minus-btn\" data-id=\"").concat(item.id, "\">-</button>\n                        <button type=\"button\" class=\"btn count-btn bg-white\" id=\"qty_").concat(item.id, "\">").concat(item.qty, "</button>\n                        <button type=\"button\" class=\"btn plus-btn\" data-id=\"").concat(item.id, "\">+</button>\n                    </div>\n                </td>\n                <td class=\"fw-6 fs-14 text-end\" id=\"total_").concat(item.id, "\">").concat(item.currency_icon, " ").concat(item.total_price, "</td>\n                 <td class=\"text-center\">\n                <button type=\"button\" class=\"btn delete-btn\" data-id=\"").concat(item.id, "\" style=\"padding:4px 8px;\">\n                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 256 256\">\n                              <g fill=\"#f00808\" fill-rule=\"nonzero\">\n                    <g transform=\"scale(8.53333,8.53333)\">\n                 <path d=\"M14.98438,2.48633c-0.55152,0.00862 -0.99193,0.46214 -0.98437,1.01367v0.5h-5.5c-0.26757,-0.00363 -0.52543,0.10012 -0.71593,0.28805c-0.1905,0.18793 -0.29774,0.44436 -0.29774,0.71195h-1.48633c-0.36064,-0.0051 -0.69608,0.18438 -0.87789,0.49587c-0.18181,0.3115 -0.18181,0.69676 0,1.00825c0.18181,0.3115 0.51725,0.50097 0.87789,0.49587h18c0.36064,0.0051 0.69608,-0.18438 0.87789,-0.49587c0.18181,-0.3115 0.18181,-0.69676 0,-1.00825c-0.18181,-0.3115 -0.51725,-0.50097 -0.87789,-0.49587h-1.48633c0,-0.26759 -0.10724,-0.52403 -0.29774,-0.71195c-0.1905,-0.18793 -0.44836,-0.29168 -0.71593,-0.28805h-5.5v-0.5c0.0037,-0.2703 -0.10218,-0.53059 -0.29351,-0.72155c-0.19133,-0.19097 -0.45182,-0.29634 -0.72212,-0.29212zM6,9l1.79297,15.23438c0.118,1.007 0.97037,1.76563 1.98438,1.76563h10.44531c1.014,0 1.86538,-0.75862 1.98438,-1.76562l1.79297,-15.23437z\"></path>\n                     </g>\n                 </g>\n                     </svg>\n                </button>\n\n                </td>\n            </tr>\n        "));
      cartItemsCloth.append("\n <tr>\n   <td>\n      <div class=\"product-card-box d-flex align-items-center gap-20\">\n         <div class=\"product-img\">\n            <img src=\"".concat(item.image_url, "\" alt=\"images\"\n               class=\"h-100 w-100 object-fit-cover\" loading=\"lazy\" />\n         </div>\n         <div>\n            <p class=\"fs-18 fw-5 mb-1 restaurant-white\">").concat(item.name, "</p>\n            <p class=\"fs-14 text-gray-200 fw-5 mb-0 restaurant-white\">").concat(item.category_name, "</p>\n\n         </div>\n      </div>\n   </td>\n   <td>\n      <div class=\"d-flex count-btn w-100 mx-auto align-items-center\">\n         <button type=\"button\" class=\"btn minus-btn count-modal-btn restaurant-white home-decor-white-bg\"  data-id=\"").concat(item.id, "\">-</button>\n         <p class=\"fs-14 fw-5 mb-0 text-black w-100 text-center restaurant-white home-decor-white home-decor-padding\" id=\"qty_").concat(item.id, "\">").concat(item.qty, "</p>\n         <button type=\"button\" class=\"btn plus-btn count-modal-btn restaurant-white home-decor-white-bg\" data-id=\"").concat(item.id, "\">+</button>\n      </div>\n   </td>\n\n    <td class=\"fs-16 fw-5 text-center text-nowrap restaurant-white\">\n      ").concat(item.currency_icon, " ").concat(item.price, "\n   </td>\n\n   <td class=\"text-center\">\n      <button type=\"button\" class=\"btn delete-btn\" data-id=\"").concat(item.id, "\" style=\"padding:4px 8px;\">\n         <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 256 256\">\n            <g fill=\"#f00808\" fill-rule=\"nonzero\">\n               <g transform=\"scale(8.53333,8.53333)\">\n                  <path d=\"M14.98438,2.48633c-0.55152,0.00862 -0.99193,0.46214 -0.98437,1.01367v0.5h-5.5c-0.26757,-0.00363 -0.52543,0.10012 -0.71593,0.28805c-0.1905,0.18793 -0.29774,0.44436 -0.29774,0.71195h-1.48633c-0.36064,-0.0051 -0.69608,0.18438 -0.87789,0.49587c-0.18181,0.3115 -0.18181,0.69676 0,1.00825c0.18181,0.3115 0.51725,0.50097 0.87789,0.49587h18c0.36064,0.0051 0.69608,-0.18438 0.87789,-0.49587c0.18181,-0.3115 0.18181,-0.69676 0,-1.00825c-0.18181,-0.3115 -0.51725,-0.50097 -0.87789,-0.49587h-1.48633c0,-0.26759 -0.10724,-0.52403 -0.29774,-0.71195c-0.1905,-0.18793 -0.44836,-0.29168 -0.71593,-0.28805h-5.5v-0.5c0.0037,-0.2703 -0.10218,-0.53059 -0.29351,-0.72155c-0.19133,-0.19097 -0.45182,-0.29634 -0.72212,-0.29212zM6,9l1.79297,15.23438c0.118,1.007 0.97037,1.76563 1.98438,1.76563h10.44531c1.014,0 1.86538,-0.75862 1.98438,-1.76562l1.79297,-15.23437z\"></path>\n               </g>\n            </g>\n         </svg>\n      </button>\n   </td>\n</tr>\n            "));
      totalDetails.append("\n            <div class=\"d-flex justify-content-between total-details align-items-center gap-2 my-3\" id=\"product_".concat(item.id, "\">\n                                        <p class=\"fs-16 fw-5 text-black mb-0 restaurant-white\">").concat(item.name, "</p>\n                                        <p class=\"fs-16 fw-5 text-black mb-0 restaurant-white text-nowrap\">").concat(item.currency_icon, " <span id=\"product_cart_").concat(item.id, "\">").concat(item.total_price, "</span></p>\n\n                                    </div>\n            "));
    });
  }
  $("#grandTotal").text("".concat(grandTotal));
  $("#cartModal").modal("show");
});
listenClick(".delete-btn", function () {
  var storeId = $("#whatsappStoreId").val();
  var productId = $(this).attr("data-id");
  $("#product_" + productId).remove();
  var templateType = templateName;
  if (typeof templateType !== "undefined" && templateType !== null && templateType === "travel") {
    displaySuccessMessage(Lang.get("js.package_deleted_from_cart"));
  } else {
    displaySuccessMessage(Lang.get("js.product_deleted_from_cart"));
  }

  // displaySuccessMessage(Lang.get("js.product_deleted_from_cart"));

  var cart = JSON.parse(localStorage.getItem("cart")) || {};
  if (cart["store_".concat(storeId)] && cart["store_".concat(storeId)][productId]) {
    var _cart$grand_total2, _cart;
    delete cart["store_".concat(storeId)][productId];
    cart["store_".concat(storeId)].grand_total = Object.values(cart["store_".concat(storeId)]).filter(function (p) {
      return _typeof(p) === "object";
    }).reduce(function (sum, p) {
      return sum + Number(p.total_price);
    }, 0);
    if (Object.keys(cart["store_".concat(storeId)]).length === 1) {
      delete cart["store_".concat(storeId)];
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    $(this).closest("tr").remove();
    productCount(storeId);
    $("#grandTotal").text(" ".concat((_cart$grand_total2 = (_cart = cart["store_".concat(storeId)]) === null || _cart === void 0 ? void 0 : _cart.grand_total) !== null && _cart$grand_total2 !== void 0 ? _cart$grand_total2 : 0));
  }
});
listenClick(".plus-btn", function () {
  var storeId = $("#whatsappStoreId").val();
  var productId = $(this).attr("data-id");
  var templateType = templateName;
  var cart = JSON.parse(localStorage.getItem("cart")) || {};
  var storeCart = cart["store_".concat(storeId)];
  if (storeCart[productId].qty >= storeCart[productId].available_stock) {
    if (typeof templateType !== "undefined" && templateType !== null && templateType === "travel") {
      displayErrorMessage(Lang.get("js.no_more_quantity_package"));
      return;
    } else {
      displayErrorMessage(Lang.get("js.no_more_quantity"));
      return;
    }
    // displayErrorMessage(Lang.get('js.no_more_quantity'));
    // return;
  }

  if (storeCart && storeCart[productId]) {
    storeCart[productId].qty += 1;
    storeCart[productId].total_price = storeCart[productId].qty * storeCart[productId].price;
    storeCart.grand_total = Object.values(storeCart).filter(function (p) {
      return _typeof(p) === "object";
    }).reduce(function (sum, p) {
      return sum + Number(p.total_price);
    }, 0);
    localStorage.setItem("cart", JSON.stringify(cart));
    productCount(storeId);
    $("#qty_".concat(productId)).text(storeCart[productId].qty);
    $("#total_".concat(productId)).text("".concat(storeCart[productId].currency_icon, " ").concat(storeCart[productId].total_price));
    $("#product_cart_" + productId).text(storeCart[productId].total_price);
    $("#grandTotal").text("".concat(storeCart.grand_total));
  }
});
listenClick(".minus-btn", function () {
  var storeId = $("#whatsappStoreId").val();
  var productId = $(this).attr("data-id");
  var cart = JSON.parse(localStorage.getItem("cart")) || {};
  var storeCart = cart["store_".concat(storeId)];
  if (storeCart && storeCart[productId]) {
    if (storeCart[productId].qty === 1) {
      return;
    }
    storeCart[productId].qty -= 1;
    storeCart[productId].total_price = storeCart[productId].qty * storeCart[productId].price;
    storeCart.grand_total = Object.values(storeCart).filter(function (p) {
      return _typeof(p) === "object";
    }).reduce(function (sum, p) {
      return sum + Number(p.total_price);
    }, 0);
    localStorage.setItem("cart", JSON.stringify(cart));
    productCount(storeId);
    $("#qty_".concat(productId)).text(storeCart[productId].qty);
    $("#total_".concat(productId)).text("".concat(storeCart[productId].currency_icon, " ").concat(storeCart[productId].total_price));
    $("#product_cart_" + productId).text(storeCart[productId].total_price);
    $("#grandTotal").text("".concat(storeCart.grand_total));
  }
});
function productCount(storeId) {
  var cart = JSON.parse(localStorage.getItem("cart")) || {};
  var storeCart = cart["store_".concat(storeId)] || {};
  var productCount = Object.values(storeCart).filter(function (item) {
    return item && item.id;
  }).length;
  var count = productCount > 0 ? productCount : 0;
  if (count == 0) {
    var cartItems = $("#cartItems");
    cartItems.html("");
    var totalDetails = $("#totalDetails");
    totalDetails.html("");
    var cartItemsCloth = $("#cartItemsCloth");
    cartItemsCloth.html("");
    cartItems.html("\n              <tr>\n           <td colspan=\"5\">\n            <div class=\"d-flex py-3 justify-content-center align-items-center w-100\" >\n                    <h4 class=\"fs-18  text-muted mb-0\">".concat(Lang.get("js.item_not_addded_to_cart"), "</h4>\n                </div>\n           </td>\n       </tr>\n        "));
    cartItemsCloth.html("\n       <tr>\n           <td colspan=\"5\">\n            <div class=\"d-flex py-3 justify-content-center align-items-center w-100\" >\n                    <h4 class=\"fs-18  text-muted mb-0\">".concat(Lang.get("js.item_not_addded_to_cart"), "</h4>\n                </div>\n           </td>\n       </tr>\n        "));
    totalDetails.html("\n            <div class=\"text-center py-3 w-100\">\n                <h4 class=\"fs-18 text-muted\">".concat(Lang.get("js.item_not_addded_to_cart"), "</h4>\n            </div>\n        "));
    $(".order-btn").prop("disabled", true);
  } else {
    $(".order-btn").prop("disabled", false);
  }
  $(".product-count-badge").text(count);
}
function loadPhoneInput() {
  var phoneInput = document.querySelector("#phoneNumber");
  var regionCodeInput = document.querySelector("#prefix_code");
  if (phoneInput) {
    var iti = window.intlTelInput(phoneInput, {
      initialCountry: defaultCountryCodeValue,
      preferredCountries: ["us", "gb", "in"],
      separateDialCode: true
    });
    phoneInput.addEventListener("countrychange", function () {
      var countryData = iti.getSelectedCountryData();
      regionCodeInput.value = countryData.dialCode;
    });

    // phoneInput.addEventListener("blur", function () {
    //     if (iti.isValidNumber()) {

    //         document.getElementById("valid-msg").classList.remove("d-none");
    //         document.getElementById("error-msg").classList.add("d-none");
    //     } else {
    //         document.getElementById("valid-msg").classList.add("d-none");
    //         document.getElementById("error-msg").classList.remove("d-none");
    //     }
    // });
  }
}

listenSubmit("#orderForm", function (event) {
  event.preventDefault();
  $(this).find(".btn").prop("disabled", true);
  var storeId = $("#whatsappStoreId").val();
  var cart = JSON.parse(localStorage.getItem("cart")) || {};
  var storeCart = cart["store_".concat(storeId)];
  var grandTotal = (storeCart === null || storeCart === void 0 ? void 0 : storeCart.grand_total) || 0;
  var products = [];
  if (storeCart) {
    products = Object.values(storeCart).filter(function (p) {
      return _typeof(p) === "object";
    }).filter(function (item) {
      return item && item.id != null;
    }).map(function (p) {
      return {
        id: p.id,
        price: p.price,
        qty: p.qty,
        total_price: p.total_price
      };
    });
  }
  var orderDetails = $(this).serialize() + "&wp_store_id=" + storeId + "&grand_total=" + grandTotal + "&products=" + encodeURIComponent(JSON.stringify(products)) + "&language=" + lang;
  var url = $("#productBuyUrl").val();
  setTimeout(function () {
    $.ajax({
      url: url,
      type: "POST",
      data: orderDetails,
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      success: function success(response) {
        if (response.success) {
          prepareAndSendWpMessage(response.data);
          localStorage.removeItem("cart");
          productCount(storeId);
          displaySuccessMessage(Lang.get("js.order_placed"));
          setTimeout(function () {
            window.location.reload();
          }, 3000);
        }
      },
      error: function error(response) {
        $(this).find(".btn").prop("disabled", false);
        displayErrorMessage(response.responseJSON.message);
        setTimeout(function () {
          window.location.reload();
        }, 4000);
      }
    });
  }, 3000);
});
function prepareAndSendWpMessage(order) {
  var baseUrl = $("#baseUrl").val();
  var storeAlias = $("#storeAlias").val();
  var wpRegionCode = $("#wpRegionCode").val();
  var whatsappNumber = $("#whatsappNo").val();
  var message = Lang.get("js.customer_details") + ":\n";
  message += "------------------------------\n";
  message += Lang.get('js.name') + ": ".concat(order.name, "\n");
  message += Lang.get('js.phone') + ": +".concat(order.region_code, " ").concat(order.phone, "\n");
  message += Lang.get('js.address') + ": ".concat(order.address, "\n\n");
  message += Lang.get('js.order_id') + ": ".concat(order.order_id, "\n");
  message += "------------------------------\n";
  message += Lang.get('js.product_details') + ":\n";
  message += "------------------------------\n";
  order.products.forEach(function (product, index) {
    var productUrl = "".concat(baseUrl, "/whatsapp-store/").concat(storeAlias, "/").concat(product.product_id, "/product-details");
    message += "".concat(index + 1, ".\n");
    message += Lang.get('js.product_name') + ": ".concat(product.product ? product.product.name : "Unknown", "\n");
    message += Lang.get('js.product_url') + " : ".concat(productUrl, "\n");
    message += Lang.get('js.price') + " : ".concat(product.product.currency.currency_icon, " ").concat(product.price, "\n");
    message += Lang.get('js.quantity') + " : ".concat(product.qty, "\n");
    message += Lang.get('js.total_price') + " : ".concat(product.product.currency.currency_icon, " ").concat(product.total_price, "\n");
    message += "------------------------------\n";
  });
  message += "\n".concat(Lang.get("js.grand_total"), ": ").concat(order.grand_total, "\n");
  var encodedMessage = encodeURIComponent(message);
  var recipientPhone = "+".concat(wpRegionCode).concat(whatsappNumber);
  var whatsappUrl = "https://wa.me/".concat(recipientPhone, "?text=").concat(encodedMessage);
  window.open(whatsappUrl, "_blank");
}
listenClick("#languageName", function () {
  var languageName = $(this).attr("data-name");
  $.ajax({
    url: languageChange + "/" + languageName + "/" + vcardAlias,
    type: "GET",
    success: function success(result) {
      location.reload();
    },
    error: function error(result) {
      alert(result.responseJSON.message);
    }
  });
});
window.displaySuccessMessage = function (message) {
  toastr.options = {
    positionClass: "toast-top-right",
    progressBar: true,
    closeButton: true,
    timeOut: 5000,
    extendedTimeOut: 2000
  };
  toastr.success(message, Lang.get("js.successful"));
};
window.displayErrorMessage = function (message) {
  toastr.options = {
    positionClass: "toast-top-right",
    progressBar: true,
    closeButton: true,
    timeOut: 5000,
    extendedTimeOut: 2000
  };
  toastr.error(message, Lang.get("js.error"));
};
listenClick(".drop-item-select", function () {
  $(".drop-item-select").removeClass("active");
  $(this).addClass("active");
});
listenClick(".custom-select-option", function () {
  $(".custom-select-option").removeClass("active");
  $(this).addClass("active");
});
listenClick(".pwa-close", function () {
  $(".pwa-support").addClass("d-none");
});

// PWA install prompt handling
(function () {
  function isAppInstalled() {
    return window.matchMedia && window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
  }
  function hidePwaModal() {
    var modal = document.getElementById('pwa-modal');
    if (!modal) return;
    modal.style.display = 'none';
    modal.classList.add('d-none');
    var parentContainer = modal.parentElement;
    if (parentContainer && parentContainer.classList.contains('mt-0')) {
      parentContainer.style.display = 'none';
    }
    document.body.classList.remove('modal-open');
    document.querySelectorAll('.modal-backdrop').forEach(function (b) {
      b.remove();
    });
  }

  // Store deferredPrompt at a higher scope so it persists
  var deferredPrompt = null;

  // Listen for beforeinstallprompt as early as possible (before DOMContentLoaded)
  window.addEventListener('beforeinstallprompt', function (e) {
    e.preventDefault();
    deferredPrompt = e;
    // If button already exists, show it
    var btn = document.getElementById('installPwaBtn');
    if (btn) btn.style.display = 'block';
  });
  window.addEventListener('appinstalled', function () {
    deferredPrompt = null;
    var btn = document.getElementById('installPwaBtn');
    if (btn) btn.style.display = 'none';
    hidePwaModal();
  });
  document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('installPwaBtn');
    var pwaModal = document.getElementById('pwa-modal');
    if (!btn && !pwaModal) return;
    if (isAppInstalled()) {
      if (btn) btn.style.display = 'none';
      hidePwaModal();
      return;
    }

    // If beforeinstallprompt already fired before DOMContentLoaded, button is ready
    if (deferredPrompt && btn) {
      btn.style.display = 'block';
    }
    if (btn) {
      btn.addEventListener('click', /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var registrations, choice;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              if (deferredPrompt) {
                _context.next = 18;
                break;
              }
              // Fallback: if no deferred prompt, try to guide the user
              // This can happen if the browser doesn't support beforeinstallprompt
              // or if the manifest/SW requirements aren't met yet
              console.log('PWA: No install prompt available. Checking requirements...');

              // Check if service worker is registered
              if (!('serviceWorker' in navigator)) {
                _context.next = 17;
                break;
              }
              _context.next = 5;
              return navigator.serviceWorker.getRegistrations();
            case 5:
              registrations = _context.sent;
              if (!(registrations.length === 0)) {
                _context.next = 17;
                break;
              }
              console.log('PWA: No service worker registered. Registering now...');
              _context.prev = 8;
              _context.next = 11;
              return navigator.serviceWorker.register('/sw.js');
            case 11:
              console.log('PWA: Service worker registered. Please try again.');
              _context.next = 17;
              break;
            case 14:
              _context.prev = 14;
              _context.t0 = _context["catch"](8);
              console.log('PWA: Service worker registration failed:', _context.t0);
            case 17:
              return _context.abrupt("return");
            case 18:
              _context.prev = 18;
              deferredPrompt.prompt();
              _context.next = 22;
              return deferredPrompt.userChoice;
            case 22:
              choice = _context.sent;
              if (choice && choice.outcome === 'accepted') {
                if (btn) btn.style.display = 'none';
                hidePwaModal();
              }
              _context.next = 29;
              break;
            case 26:
              _context.prev = 26;
              _context.t1 = _context["catch"](18);
              console.log('PWA: Install prompt error:', _context.t1);
            case 29:
              deferredPrompt = null;
            case 30:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[8, 14], [18, 26]]);
      })));
    }
    window.addEventListener('load', function () {
      if (isAppInstalled()) {
        if (btn) btn.style.display = 'none';
        hidePwaModal();
      }
    });
  });
})();
listenSubmit('#newsLetterForm', function (event) {
  event.preventDefault();
  $('#newsLetterModal').prop('disabled', true);
  $.ajax({
    url: emailSubscriptionUrl,
    type: 'POST',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#emailSubscription').val('');
        $('#newsLetterModal').modal('hide');
        $('#newsLetterModal').addClass('d-none');
        var now = new Date();
        var expires = new Date(now.getTime() + 10 * 365 * 24 * 60 * 60 * 1000);
        document.cookie = "newsletter_popup=2; expires=" + expires.toUTCString();
      }
    },
    error: function error(result) {
      displayErrorMessage(result.responseJSON.message);
    }
  });
});
window.onload = function () {
  var currentPageUrl = window.location.href;
  $.ajax({
    url: getCookieUrl,
    type: "GET",
    data: {
      url: currentPageUrl
    },
    success: function success(result) {
      if (result.success) {
        setTimeout(function () {
          if (document.cookie.includes("newsletter_popup")) {
            $('#newsLetterModal').modal('hide');
          } else {
            $('#newsLetterModal').removeClass('d-none').modal('show');
          }
        }, result.data);
      }
    },
    error: function error(result) {
      displayErrorMessage(result.responseJSON.message);
    }
  });
};
listenClick('#closeNewsLetterModal', function () {
  $('#newsLetterModal').modal('hide');
});
listenHiddenBsModal("#newsLetterModal", function () {
  var now = new Date();
  var expires = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);
  document.cookie = "newsletter_popup=2; expires=" + expires.toUTCString();
});
listenClick(".bars-btn", function () {
  $(".sub-btn").fadeToggle();
  var sub_btn = $(".sub-btn");
  if (sub_btn.hasClass("d-none")) {
    sub_btn.removeClass("d-none");
  }
});
listenClick(".bars-btn", function () {
  var os = navigator.platform;
  if (os == "MacIntel" || "ios" || 0) {
    $("#videobtn").removeClass("d-none");
  }
});
listenClick(".whatsapp-store-share", function () {
  $("#whatsapp-store-shareModel").modal("show");
});
listenClick(".share", function () {
  $("#whatsapp-store-shareModel").modal("hide");
});
listen("click", ".whatsapp-store-qr-code-btn", function (event) {
  event.preventDefault();
  var $button = $(this);
  // Look for the QR code in the same container or parent
  var $qrCodeDiv = $button.siblings('.qr-code-image').first();
  var svg = $qrCodeDiv.find('svg')[0];
  if (!svg) {
    console.error("No QR code found for this button.");
    alert('QR code not found. Please try again.');
    return;
  }
  var svgData = new XMLSerializer().serializeToString(svg);
  var svgBlob = new Blob([svgData], {
    type: "image/svg+xml;charset=utf-8"
  });
  var url = URL.createObjectURL(svgBlob);
  var img = new Image();
  img.src = url;
  img.onload = function () {
    var canvas = document.createElement('canvas');
    canvas.width = img.width;
    canvas.height = img.height;
    var context = canvas.getContext('2d');
    context.fillStyle = 'white';
    context.fillRect(0, 0, canvas.width, canvas.height);
    context.drawImage(img, 0, 0);
    var pngUrl = canvas.toDataURL('image/png');
    var link = document.createElement('a');
    link.href = pngUrl;
    link.download = 'whatsapp_store_qr_code.png';
    link.click();
    URL.revokeObjectURL(url);
  };
  img.onerror = function () {
    console.error("Error loading QR code image");
    alert('Error processing QR code. Please try again.');
    URL.revokeObjectURL(url);
  };
});
listenClick(".copy-whatsapp-store-clipboard", function () {
  var whatsappStoreId = $(this).data("id");
  var $temp = $("<input>");
  $("#whatsapp-store-shareModel .social-link-modal").append($temp);
  $temp.val($("#whatsappStoreUrlCopy" + whatsappStoreId).text()).select();
  document.execCommand("copy");
  $temp.remove();
  displaySuccessMessage(Lang.get("js.copied_successfully"));
});
/******/ })()
;
