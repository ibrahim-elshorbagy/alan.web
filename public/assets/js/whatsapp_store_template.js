/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./resources/assets/js/whatsapp_store/template.js ***!
  \********************************************************/
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