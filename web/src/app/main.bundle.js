webpackJsonp(["main"],{

/***/ "./src/$$_lazy_route_resource lazy recursive":
/***/ (function(module, exports) {

function webpackEmptyAsyncContext(req) {
	// Here Promise.resolve().then() is used instead of new Promise() to prevent
	// uncatched exception popping up in devtools
	return Promise.resolve().then(function() {
		throw new Error("Cannot find module '" + req + "'.");
	});
}
webpackEmptyAsyncContext.keys = function() { return []; };
webpackEmptyAsyncContext.resolve = webpackEmptyAsyncContext;
module.exports = webpackEmptyAsyncContext;
webpackEmptyAsyncContext.id = "./src/$$_lazy_route_resource lazy recursive";

/***/ }),

/***/ "./src/app/app.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"price\" *ngIf=\"price\">{{price}} грн. <span *ngIf=\"oldPrice\">{{oldPrice}} грн.</span></div>\r\n<form (ngSubmit)=\"onSubmit()\">\r\n    <div *ngFor=\"let field of fields\" class=\"form-group\" >\r\n        <label>{{field.option_name}}</label>\r\n        <div *ngIf=\"field.type === 'radio'\">\r\n            <div class=\"form-check radio\" *ngFor=\"let option of field.values\">\r\n                <label class=\"form-check-label\" for=\"{{'field_' + field.option_id}}\">\r\n                    <input\r\n                        [(ngModel)]=\"selectedData[field.option_id]\"\r\n                        (change)=\"select(field.option_id)\"\r\n                        name=\"{{'field_' + field.option_id}}\"\r\n                        type=\"radio\"\r\n                        class=\"form-check-input\"\r\n                        value=\"{{option.option_value_id}}\"\r\n                        [attr.disabled]=\"!option.status ? true : null\"\r\n                        [checked]=\"selectedData[field.option_id] === option.option_value_id\">\r\n                        >\r\n                    {{option.option_value_name}} ({{ option.price }} грн.)\r\n                </label>\r\n            </div>\r\n        </div>\r\n        <div *ngIf=\"field.type === 'select'\" >\r\n            <select\r\n                [(ngModel)]=\"selectedData[field.option_id]\"\r\n                (change)=\"select(field.option_id)\"\r\n                name=\"{{'field_' + field.option_id}}\"\r\n                class=\"form-control\">\r\n                    <option *ngFor=\"let option of field.values\"\r\n                    value=\"{{option.option_value_id}}\"\r\n                    [attr.disabled]=\"!option.status ? true : null\"\r\n                    [selected]=\"selectedData[field.option_id] === option.option_value_id\">\r\n                        {{option.option_value_name}}\r\n                    </option>\r\n            </select>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"form-group form-group-actions\">\r\n        <label class=\"control-label\" for=\"input-quantity\">Количество</label>\r\n        <input\r\n            [(ngModel)]=\"selectedData.quantity\"\r\n            type=\"number\"\r\n            name=\"quantity\"\r\n            value=\"1\"\r\n            size=\"2\"\r\n            id=\"input-quantity\"\r\n            class=\"form-control\">\r\n        <button type=\"submit\" id=\"button-cart\" data-loading-text=\"Загрузка...\" class=\"btn btn-primary btn-lg btn-block\"><span>Купить</span></button>\r\n\r\n        <div class=\"add-to-links\">\r\n            <div class=\"btn-group\">\r\n                <div class=\"wishlist\">\r\n                    <button type=\"button\" class=\"btn btn-default\" title=\"В закладки\">\r\n                        <span>В закладки</span></button>\r\n                </div>\r\n                <div class=\"compare\">\r\n                    <button type=\"button\" class=\"btn btn-default\" title=\"В сравнение\">\r\n                        <span>В сравнение</span></button>\r\n                </div>\r\n            </div>\r\n            <a class=\"dashed\" (click)=\"open(content)\">Наличие в магазинах</a>\r\n        </div>\r\n    </div>\r\n</form>\r\n<div class=\"product-massage\">\r\n    <p *ngFor=\"let alert of alerts\">\r\n      <ngb-alert *ngIf=\"alert.message\" [type]=\"alert.type\" (close)=\"alert.message = null\"><span [innerHTML]=\"alert.message\"></span></ngb-alert>\r\n    </p>\r\n</div>\r\n\r\n<ng-template #content let-c=\"close\" let-d=\"dismiss\">\r\n    <div class=\"modal-header\">\r\n        <h4 class=\"modal-title\">Наличие в магазинах</h4>\r\n        <button type=\"button\" class=\"close\" aria-label=\"Close\" (click)=\"d('Cross click')\">\r\n            <span aria-hidden=\"true\">&times;</span>\r\n        </button>\r\n    </div>\r\n    <div class=\"modal-body\">\r\n        <div class=\"row\" *ngIf=\"selectedVariant.availability\">\r\n            <div class=\"col-md-6\">\r\n                <div class=\"row store-item\" *ngFor=\"let item of selectedVariant.availability\">\r\n                    <div class=\"col-md-3\"><img src=\"image/{{item.stock.image}}\" width=\"100\" alt=\"{{item.stock.name}}\"> </div>\r\n                    <div class=\"col-md-9\">\r\n                        <p *ngIf=\"item.stock.name\"><b>{{item.stock.name}}</b></p>\r\n                        <p *ngIf=\"item.stock.address\"><i>{{item.stock.address}}</i></p>\r\n                        <p *ngIf=\"item.stock.open\">{{item.stock.open}}</p>\r\n                        <p *ngIf=\"item.stock.telephone\">{{item.stock.telephone}}</p>\r\n                        <p *ngIf=\"item.stock.comment\">{{item.stock.comment}}</p>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"col-md-6\">\r\n                <ngui-map zoom=\"11\" center=\"Киев, Цум\">\r\n                    <marker *ngFor=\"let pos of selectedVariant.availability\"\r\n                        (click)=\"showInfoWindow($event)\"\r\n                        [position]=\"[pos.stock.geocode.lat, pos.stock.geocode.lng]\"></marker>\r\n\r\n                    <info-window id=\"iw\">\r\n                        test\r\n                    </info-window>\r\n                </ngui-map>\r\n            </div>\r\n        </div>\r\n\r\n    </div>\r\n</ng-template>\r\n\r\n"

/***/ }),

/***/ "./src/app/app.component.scss":
/***/ (function(module, exports) {

module.exports = ""

/***/ }),

/***/ "./src/app/app.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AppComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__app_service__ = __webpack_require__("./src/app/app.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__model_variant_collection__ = __webpack_require__("./src/app/model/variant-collection.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__model_alert__ = __webpack_require__("./src/app/model/alert.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__model_marker__ = __webpack_require__("./src/app/model/marker.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__ng_bootstrap_ng_bootstrap__ = __webpack_require__("./node_modules/@ng-bootstrap/ng-bootstrap/index.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["_11" /* enableProdMode */])();
var AppComponent = /** @class */ (function () {
    function AppComponent(mainService, modalService) {
        this.mainService = mainService;
        this.modalService = modalService;
        this.price = null;
        this.oldPrice = null;
        this.alerts = [];
        this.selectedData = { quantity: 1 };
        this.fields = [];
        this.positions = [];
        this.variants = new __WEBPACK_IMPORTED_MODULE_2__model_variant_collection__["a" /* VariantCollection */]();
        this.marker = new __WEBPACK_IMPORTED_MODULE_4__model_marker__["a" /* Marker */];
    }
    AppComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.mainService
            .getSpecifications(product_id)
            .then(function (variants) { return _this.variants.setData(variants); }).then(function (e) {
            _this.setData(_this.variants);
            _this.setDefaultValues();
        });
    };
    AppComponent.prototype.select = function (optionId) {
        this.setChoice();
        this.setOptionsStatus(optionId);
    };
    AppComponent.prototype.onSubmit = function () {
        var _this = this;
        var query = this.prepareRequestAddToCart();
        var alert = new __WEBPACK_IMPORTED_MODULE_3__model_alert__["a" /* Alert */]();
        alert.message = '';
        this.mainService.addToCart(query).then(function (response) {
            if (response.error !== undefined) {
                alert.type = 'error';
                response.error.option.forEach(function (msg) { alert.message += msg + ' '; });
            }
            else if (response.success !== undefined) {
                alert.type = 'success';
                alert.message = response.success;
            }
            _this.setAlert(alert);
        });
    };
    AppComponent.prototype.open = function (content) {
        this.modalService.open(content, { size: 'lg' }).result.then(function (result) {
        }, function (reason) {
        });
    };
    AppComponent.prototype.setChoice = function () {
        this.setSelectedOptions();
        this.setCaption();
    };
    AppComponent.prototype.setSelectedOptions = function () {
        var _this = this;
        var data = [];
        this.fields.forEach(function (variant) {
            if (_this.selectedData[variant.option_id]) {
                var option = variant.values.find(function (item) { return (item.option_value_id === _this.selectedData[variant.option_id]); });
                _this.variants.setAvailableVariants(option);
                data.push(option);
            }
        });
        this.selectedVariant = this.variants.findBy(data);
        if (this.selectedVariant === undefined) {
            this.selectedVariant = this.variants.getFirstBy(data[0]);
            this.selectedVariant.options.forEach(function (option) {
                _this.selectedData[option.option_id] = option.option_value_id;
            });
        }
        this.setPrice();
    };
    AppComponent.prototype.setPrice = function () {
        this.oldPrice = this.selectedVariant.price_old;
        this.price = this.selectedVariant.price;
    };
    AppComponent.prototype.setCaption = function () {
        var _this = this;
        var caption = '';
        this.fields.forEach(function (field) {
            var option = field.values.find(function (item) { return (item.option_value_id === _this.selectedData[field.option_id]); });
            if (option !== undefined) {
                caption += caption.length > 0 ? '; ' : '';
                caption += field.option_name + ': ' + option.option_value_name;
            }
        });
    };
    AppComponent.prototype.setData = function (variants) {
        var _this = this;
        variants.getAll().forEach(function (variant) {
            variant.options.forEach(function (option) {
                _this.setOptionItem(option);
            });
        });
    };
    AppComponent.prototype.setOptionItem = function (option) {
        var group_index = this.fields.findIndex(function (item) { return option.option_id === item.option_id; });
        if (group_index < 0) {
            this.fields.push({
                option_id: option.option_id,
                option_name: option.option_name,
                product_option_id: option.product_option_id,
                type: option.type,
                status: true,
                values: [option]
            });
        }
        else {
            if (!this.fields[group_index].values.find(function (item) { return item.option_value_id === option.option_value_id; })) {
                this.fields[group_index].values.push(option);
            }
        }
    };
    AppComponent.prototype.setDefaultValues = function () {
        var _this = this;
        this.variants.getFirst().options.forEach(function (option) {
            _this.selectedData[option.option_id] = option.option_value_id;
        });
        this.setChoice();
        this.setOptionsStatus(this.selectedVariant.options[0].option_id);
    };
    AppComponent.prototype.setOptionsStatus = function (optionId) {
        var _this = this;
        var itsAfterSelectedOption = false;
        var queryData = [];
        this.selectedVariant.options.forEach(function (option) {
            if (itsAfterSelectedOption) {
                _this.setOptionsStatusForNextFields(option.option_id, queryData);
            }
            else {
                queryData.push(option);
            }
            if (option.option_id === optionId) {
                itsAfterSelectedOption = true;
            }
        });
    };
    AppComponent.prototype.setOptionsStatusForNextFields = function (option_id, query) {
        var _this = this;
        var findBy;
        this.fields.forEach(function (field, fi) {
            if (field.option_id !== option_id)
                return false;
            field.values.forEach(function (option, fiv) {
                findBy = Object.assign([], query);
                findBy.push(option);
                _this.fields[fi].values[fiv].status = _this.variants.findBy(findBy) === undefined ? false : true;
            });
        });
    };
    AppComponent.prototype.prepareRequestAddToCart = function () {
        var request = {};
        request['quantity'] = this.selectedData['quantity'];
        request['product_id'] = product_id;
        request['option'] = [];
        var body = 'quantity=' + this.selectedData['quantity'];
        body += '&product_id=' + product_id;
        this.selectedVariant.options.forEach(function (option) {
            request['option'][option.product_option_id] = option.option_value_id;
            body += '&option[' + option.product_option_id + ']=' + option.option_value_id;
        });
        console.log(this.selectedVariant);
        console.log(this.selectedData);
        console.log(body);
        return body;
    };
    AppComponent.prototype.setAlert = function (alert) {
        var index = this.alerts.findIndex(function (find) { return find.type === alert.type; });
        if (index < 0) {
            this.alerts.push(alert);
        }
        else {
            this.alerts[index] = alert;
        }
    };
    AppComponent.prototype.showInfoWindow = function (_a) {
        var marker = _a.target;
    };
    AppComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["m" /* Component */])({
            selector: 'app-product-options',
            template: __webpack_require__("./src/app/app.component.html"),
            styles: [__webpack_require__("./src/app/app.component.scss")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__app_service__["a" /* MainService */], __WEBPACK_IMPORTED_MODULE_5__ng_bootstrap_ng_bootstrap__["b" /* NgbModal */]])
    ], AppComponent);
    return AppComponent;
}());



/***/ }),

/***/ "./src/app/app.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AppModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_platform_browser__ = __webpack_require__("./node_modules/@angular/platform-browser/esm5/platform-browser.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__app_component__ = __webpack_require__("./src/app/app.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_service__ = __webpack_require__("./src/app/app.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__angular_common_http__ = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__ng_bootstrap_ng_bootstrap__ = __webpack_require__("./node_modules/@ng-bootstrap/ng-bootstrap/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__ngui_map__ = __webpack_require__("./node_modules/@ngui/map/dist/@ngui/map.es5.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};








var AppModule = /** @class */ (function () {
    function AppModule() {
    }
    AppModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_1__angular_core__["G" /* NgModule */])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__app_component__["a" /* AppComponent */]
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_0__angular_platform_browser__["a" /* BrowserModule */],
                __WEBPACK_IMPORTED_MODULE_4__angular_forms__["a" /* FormsModule */],
                __WEBPACK_IMPORTED_MODULE_5__angular_common_http__["b" /* HttpClientModule */],
                __WEBPACK_IMPORTED_MODULE_6__ng_bootstrap_ng_bootstrap__["c" /* NgbModalModule */].forRoot(),
                __WEBPACK_IMPORTED_MODULE_6__ng_bootstrap_ng_bootstrap__["a" /* NgbAlertModule */].forRoot(),
                __WEBPACK_IMPORTED_MODULE_7__ngui_map__["a" /* NguiMapModule */].forRoot({
                    apiUrl: 'https://maps.google.com/maps/api/js?libraries=visualization,places,drawing&key=AIzaSyCLMYSWmhRhzAMf-hLcMafs3S-E3ifStjE'
                })
            ],
            providers: [__WEBPACK_IMPORTED_MODULE_3__app_service__["a" /* MainService */]],
            bootstrap: [__WEBPACK_IMPORTED_MODULE_2__app_component__["a" /* AppComponent */]]
        })
    ], AppModule);
    return AppModule;
}());



/***/ }),

/***/ "./src/app/app.service.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MainService; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_common_http__ = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_rxjs_add_operator_toPromise__ = __webpack_require__("./node_modules/rxjs/_esm5/add/operator/toPromise.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_rxjs_add_operator_toPromise___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_rxjs_add_operator_toPromise__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__environments_environment__ = __webpack_require__("./src/environments/environment.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var MainService = /** @class */ (function () {
    function MainService(http) {
        this.http = http;
    }
    MainService.prototype.getSpecifications = function (id_product) {
        var url = __WEBPACK_IMPORTED_MODULE_3__environments_environment__["a" /* environment */].apiUrl + "index.php?route=product/product/options/&product_id=" + id_product;
        return this.http.get(url)
            .toPromise()
            .then(function (response) { return response; })
            .catch(this.handleError);
    };
    MainService.prototype.addToCart = function (data) {
        var headers = new __WEBPACK_IMPORTED_MODULE_1__angular_common_http__["c" /* HttpHeaders */]({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' });
        return this.http.post(__WEBPACK_IMPORTED_MODULE_3__environments_environment__["a" /* environment */].apiUrl + "index.php?route=checkout/cart/add", data, { headers: headers })
            .toPromise()
            .then(function (response) { return response; })
            .catch(this.handleError);
    };
    MainService.prototype.handleError = function (error) {
        console.error('An error occurred', error);
        return Promise.reject(error.message || error);
    };
    MainService = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["y" /* Injectable */])(),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_common_http__["a" /* HttpClient */]])
    ], MainService);
    return MainService;
}());



/***/ }),

/***/ "./src/app/model/alert.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Alert; });
var Alert = /** @class */ (function () {
    function Alert() {
    }
    return Alert;
}());



/***/ }),

/***/ "./src/app/model/marker.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Marker; });
var Marker = /** @class */ (function () {
    function Marker() {
    }
    return Marker;
}());



/***/ }),

/***/ "./src/app/model/variant-collection.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return VariantCollection; });
var VariantCollection = /** @class */ (function () {
    function VariantCollection() {
        this.data = [];
    }
    VariantCollection.prototype.setData = function (data) {
        this.data = data;
    };
    VariantCollection.prototype.getAll = function () {
        return this.data;
    };
    VariantCollection.prototype.getFirst = function () {
        return this.data[0];
    };
    VariantCollection.prototype.getFirstBy = function (option) {
        return this.data.filter(function (variant) {
            return variant.options.find(function (option_variant) { return option_variant.option_value_name === option.option_value_name; });
        })[0];
    };
    VariantCollection.prototype.getActiveItems = function () {
        return this.data.filter(function (variant) { return variant.status === true; });
    };
    VariantCollection.prototype.getCountItems = function () {
        return this.getAll().length;
    };
    VariantCollection.prototype.getCountActiveItems = function () {
        return this.getActiveItems().length;
    };
    VariantCollection.prototype.setAvailableVariants = function (data) {
        var _this = this;
        this.data.forEach(function (variant, index) {
            _this.data[index].status = _this.data[index].options.find(function (option) { return option.option_value_id === data.option_value_id; }) ? true : false;
        });
    };
    VariantCollection.prototype.findBy = function (options) {
        var variants = this.data;
        options.forEach(function (option) {
            variants = variants.filter(function (variant) {
                return variant.options.find(function (option_variant) { return option_variant.option_value_name === option.option_value_name; });
            });
        });
        return variants[0];
    };
    return VariantCollection;
}());



/***/ }),

/***/ "./src/environments/environment.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return environment; });
// The file contents for the current environment will overwrite these during build.
// The build system defaults to the dev environment which uses `environment.ts`, but if you do
// `ng build --env=prod` then `environment.prod.ts` will be used instead.
// The list of which env maps to which file can be found in `.angular-cli.json`.
var environment = {
    production: false,
    apiUrl: 'http://lh.loc:802/'
};


/***/ }),

/***/ "./src/main.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_platform_browser_dynamic__ = __webpack_require__("./node_modules/@angular/platform-browser-dynamic/esm5/platform-browser-dynamic.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__app_app_module__ = __webpack_require__("./src/app/app.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__environments_environment__ = __webpack_require__("./src/environments/environment.ts");




if (__WEBPACK_IMPORTED_MODULE_3__environments_environment__["a" /* environment */].production) {
    Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["_11" /* enableProdMode */])();
}
Object(__WEBPACK_IMPORTED_MODULE_1__angular_platform_browser_dynamic__["a" /* platformBrowserDynamic */])().bootstrapModule(__WEBPACK_IMPORTED_MODULE_2__app_app_module__["a" /* AppModule */]);


/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./src/main.ts");


/***/ })

},[0]);
//# sourceMappingURL=main.bundle.js.map