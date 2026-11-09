(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/app"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AddDeviceComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AddDeviceComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue_phone_number_input__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-phone-number-input */ "./node_modules/vue-phone-number-input/dist/vue-phone-number-input.common.js");
/* harmony import */ var vue_phone_number_input__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_phone_number_input__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_phone_number_input_dist_vue_phone_number_input_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-phone-number-input/dist/vue-phone-number-input.css */ "./node_modules/vue-phone-number-input/dist/vue-phone-number-input.css");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["package"],
  components: {
    VuePhoneNumberInput: (vue_phone_number_input__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      server: null,
      servers: [],
      version: "multidevice",
      phone: "",
      phoneString: "",
      errors: [],
      message: "",
      loading: false,
      step: 1,
      otp: {
        pin: null,
        nextRequestIn: 0 // seconds

      }
    };
  },
  computed: {
    serverList: function serverList() {
      return this.servers.filter(function (item, key) {
        return item.active_device_limit > item.devices_count;
      });
    }
  },
  mounted: function mounted() {
    this.getServer(); // this.sendOtp();
  },
  methods: {
    countDownTimer: function countDownTimer() {
      var _this2 = this;

      if (this.otp.nextRequestIn > 0) {
        setTimeout(function () {
          _this2.otp.nextRequestIn -= 1;

          _this2.countDownTimer();
        }, 1000);
      }
    },
    sendOtp: function sendOtp() {
      axios.post(this.$parent.MakeUrl("secure/devices/send-otp"), {
        phone_number: this.phone
      }).then(function (response) {
        return console.log(response);
      });
      this.otp.nextRequestIn = 59; // Implement wait

      this.countDownTimer();
    },
    submitOtp: function submitOtp() {
      var _this3 = this;

      this.loading = true;
      axios.post(this.$parent.MakeUrl("secure/devices/verify-otp"), {
        phone_number: this.phone,
        otp: this.otp.pin
      }).then(function (response) {
        _this3.addDevice();
      })["catch"](function (e) {
        return _this3.$iosAlert(e.response.data.message);
      }).then(function () {
        _this3.loading = false;
      });
    },
    onPhoneNumberUpdated: function onPhoneNumberUpdated(update) {
      if ("formattedNumber" in update) {
        this.phone = update.formattedNumber.replace("+", "");
      }
    },
    getServer: function getServer() {
      var _this4 = this;

      axios.get(this.$parent.MakeUrl("secure/devices/servers")).then(function (response) {
        return _this4.servers = response.data;
      });
    },
    nextStep: function nextStep() {
      var _this5 = this;

      // Device Cheker
      var _this = this;

      _this.errors = [];
      _this.message = "";
      _this.loading = true;
      axios.post(this.$parent.MakeUrl("secure/devices/checker"), {
        server: this.server,
        phone: this.phone,
        package_id: this["package"].id,
        version: this.version
      }).then(function (res) {
        // _this.loading = false;
        _this.resetForm();

        _this.message = "Device is Available, we will redirect you to Verification Page. Please wait!";
        setTimeout(function () {
          _this.loading = false;
          _this5.step = 2;

          _this5.sendOtp();
        }, 2000);
      })["catch"](function (err) {
        _this.errors = err.response.data.errors;
        _this5.loading = false;
      });
    },
    addDevice: function addDevice() {
      var _this6 = this;

      var _this = this;

      _this.errors = [];
      _this.message = "";
      _this.loading = true;
      axios.post(this.$parent.MakeUrl("secure/devices"), {
        server: this.server,
        phone: this.phone,
        package_id: this["package"].id,
        version: this.version
      }).then(function (res) {
        // _this.loading = false;
        _this.resetForm();

        _this.message = "Device has been successfully created, we will redirect you to device page. Please wait!";
        setTimeout(function () {
          window.location.href = _this6.$parent.MakeUrl("secure/devices");
        }, 2000);
      })["catch"](function (err) {
        _this.errors = err.response.data.errors;
        _this6.loading = false;
      });
    },
    resetForm: function resetForm() {// this.phone = "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AdduserComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AdduserComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      errors: [],
      role: '',
      roles: '',
      message: '',
      loading: false
    };
  },
  mounted: function mounted() {
    this.getRoles();
  },
  methods: {
    getRoles: function getRoles() {
      var _this2 = this;

      axios.get(this.$parent.MakeUrl('secure/users/roles')).then(function (res) {
        _this2.roles = res.data;
      })["catch"](function (err) {});
    },
    addUser: function addUser() {
      var _this = this;

      _this.errors = [];
      _this.message = '';
      _this.loading = true;
      axios.post(this.$parent.MakeUrl('secure/users'), {
        'name': this.name,
        'role': this.role,
        'email': this.email,
        'current_password': this.current_password,
        'password': this.password,
        'password_confirmation': this.password_confirmation
      }).then(function (res) {
        _this.loading = false;

        _this.resetForm();

        _this.message = 'User account has been successfully created!';
      })["catch"](function (err) {
        _this.errors = err.response.data.errors;
        _this.loading = false;
      });
    },
    resetForm: function resetForm() {
      this.name = '';
      this.email = '';
      this.password = '';
      this.role = '';
      this.password_confirmation = '';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DevicesComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DevicesComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var io = __webpack_require__(/*! socket.io-client */ "./node_modules/socket.io-client/lib/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      devices: [],
      total: 0,
      loading: false,
      loadingmore: false,
      query: '',
      url: ''
    };
  },
  mounted: function mounted() {
    var query = location.search.split('query=')[1];

    if (query !== undefined) {
      this.query = query;
    }

    this.url = BaseUrl('secure/devices?q=' + this.query);
    this.loadDevices();
  },
  methods: {
    pairedClass: function pairedClass(item) {
      return {
        'badge-success': item.paired_status === 'PAIRED',
        'badge-warning': item.paired_status === 'UNPAIRED',
        'badge-danger': item.status === 'INACTIVE'
      };
    },
    loadDevices: function loadDevices() {
      var _this2 = this;

      this.loading = true;
      axios.get(this.url).then(function (res) {
        console.log(res.data);
        _this2.devices = res.data.data;
        _this2.total = res.data.total;
        _this2.loading = false;
        _this2.url = res.data.next_page_url;
      })["catch"](function (err) {
        _this2.loading = false;
      });
    },
    deleteDevice: function deleteDevice(userId, index) {
      var _this = this;

      this.$iosConfirm({
        title: 'Are you sure?',
        text: 'This device and their associated data will be permanently deleted. Proceed?'
      }).then(function () {
        axios["delete"](_this.$parent.MakeUrl('secure/devices/' + userId)).then(function (res) {
          _this.devices.splice(index, 1);

          _this.total = _this.total - 1;

          _this.loadDevices();
        })["catch"](function (error) {
          _this.$iosAlert({
            'title': 'Error',
            'text': error.response.data.message
          });
        });
      });
    },
    reconnect: function reconnect(id) {
      window.location.href = this.$parent.MakeUrl('secure/devices/' + id + '/pair');
    },
    sendMessage: function sendMessage(id) {
      window.location.href = this.$parent.MakeUrl('secure/devices/' + id + '/message');
    },
    configDevice: function configDevice(id) {
      window.location.href = this.$parent.MakeUrl('secure/devices/' + id + '/config');
    },
    stopDevice: function stopDevice(item) {
      var _this3 = this;

      this.loading = true;
      item.paired_status = 'UNPAIRED';
      this.$iosConfirm({
        title: 'Are you sure?',
        text: 'This device and their associated data will be stopped. Proceed?'
      }).then(function () {
        axios.post(_this3.$parent.MakeUrl("secure/devices/".concat(item.id, "/stop"))).then(function (response) {
          _this3.message = "This device already pairing :), you can using this device now, you will redirect to device page ...";
          _this3.loading = false;
        })["catch"](function (err) {
          _this3.loading = false;
        });
      })["catch"](function () {
        return _this3.loading = false;
      });
    },
    search: function search() {
      this.url = BaseUrl('secure/devices?q=' + this.query);
      this.loadDevices();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/GroupComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/GroupComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["devices"],
  data: function data() {
    return {
      items: [],
      total: 0,
      loading: false,
      loadingmore: false,
      query: "",
      url: "",
      device: ""
    };
  },
  mounted: function mounted() {
    if (this.devices.length > 0) {
      this.device = this.devices[0].id;
    }

    var query = location.search.split("query=")[1];

    if (query !== undefined) {
      this.query = query;
    }

    this.url = BaseUrl("secure/groups?device_id=" + this.device);
    this.fetchData();
  },
  computed: {
    canPullData: function canPullData() {
      var _this = this;

      var obj = this.devices.find(function (o) {
        return o.id === _this.device;
      });

      if (obj["package"].code != "STARTUP240K") {
        return false;
      }

      return true;
    }
  },
  methods: {
    onChangeDevice: function onChangeDevice() {
      this.url = BaseUrl("secure/groups?device_id=" + this.device);
      this.fetchData();
    },
    fetchData: function fetchData() {
      var _this2 = this;

      this.loading = true;
      axios.get(this.url).then(function (res) {
        // this.items = res.data.data;
        _this2.items = _this2.items.concat(res.data.data);
        _this2.total = res.data.total;
        _this2.loading = false;
        _this2.loadingmore = res.data.next_page_url != null; // this.loadingmore = true;

        _this2.url = res.data.next_page_url;
      })["catch"](function (err) {
        _this2.loading = false;
      });
    },
    pullData: function pullData() {
      var _this3 = this;

      this.url = BaseUrl("secure/groups/pull/" + this.device);
      this.loading = true;
      axios.post(this.url).then(function (res) {
        _this3.items = res.data.data;
        _this3.total = res.data.total;
        _this3.loading = false;
        _this3.loadingmore = res.data.next_page_url == "";
        _this3.url = res.data.next_page_url;
      })["catch"](function (err) {
        _this3.loading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InboxComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InboxComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      inbox: [],
      total: 0,
      loading: false,
      loadingmore: false,
      query: '',
      url: ''
    };
  },
  mounted: function mounted() {
    var query = location.search.split('query=')[1];

    if (query !== undefined) {
      this.query = query;
    }

    this.url = BaseUrl('secure/inbox?q=' + this.query);
    this.loadInbox();
  },
  methods: {
    approve: function approve(item) {
      var _this2 = this;

      this.$iosConfirm('Confirmation').then(function () {
        axios.post(_this2.$parent.MakeUrl("secure/inbox/".concat(item.id, "/approve"))).then(function (response) {
          _this2.loadInbox();

          _this2.$iosAlert('Success');
        });
      })["catch"](function () {});
    },
    pairedClass: function pairedClass(item) {
      return {
        'badge-success': item.status === 'PAID',
        'badge-warning': item.status === 'PENDING',
        'badge-danger': item.status === 'EXPIRED'
      };
    },
    loadInbox: function loadInbox() {
      var _this3 = this;

      this.loading = true;
      axios.get(this.url).then(function (res) {
        _this3.inbox = _this3.inbox.concat(res.data.data);
        _this3.total = res.data.total;
        _this3.loading = false;
        _this3.url = res.data.next_page_url;
      })["catch"](function (err) {
        _this3.loading = false;
      });
    },
    deleteDevice: function deleteDevice(userId, index) {
      var _this = this;

      this.$iosConfirm({
        title: 'Are you sure?',
        text: 'This device and their associated data will be permanently deleted. Proceed?'
      }).then(function () {
        axios["delete"](_this.$parent.MakeUrl('secure/inbox/' + userId)).then(function (res) {
          _this.inbox.splice(index, 1);

          _this.total = _this.total - 1;

          _this.loadInbox();
        })["catch"](function (error) {
          _this.$iosAlert({
            'title': 'Error',
            'text': error.response.data.message
          });
        });
      });
    },
    reconnect: function reconnect(id) {
      window.location.href = this.$parent.MakeUrl('secure/inbox/' + id + '/pair');
    },
    sendMessage: function sendMessage(id) {
      window.location.href = this.$parent.MakeUrl('secure/inbox/' + id + '/message');
    },
    configDevice: function configDevice(id) {
      window.location.href = this.$parent.MakeUrl('secure/inbox/' + id + '/config');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InvoiceComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InvoiceComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      invoices: [],
      total: 0,
      loading: false,
      loadingmore: false,
      query: null,
      url: ''
    };
  },
  mounted: function mounted() {
    var query = location.search.split('query=')[1];

    if (query !== undefined) {
      this.query = query;
    }

    this.url = BaseUrl('secure/invoices?q=' + this.query);
    this.loadInvoices();
  },
  methods: {
    approve: function approve(item) {
      var _this2 = this;

      this.$iosConfirm('Confirmation').then(function () {
        axios.post(_this2.$parent.MakeUrl("secure/invoices/".concat(item.id, "/approve"))).then(function (response) {
          _this2.loadInvoices();

          _this2.$iosAlert('Success');
        });
      })["catch"](function () {});
    },
    pairedClass: function pairedClass(item) {
      return {
        'badge-success': item.status === 'PAID',
        'badge-warning': item.status === 'PENDING',
        'badge-danger': item.status === 'EXPIRED'
      };
    },
    loadInvoices: function loadInvoices() {
      var _this3 = this;

      this.loading = true;
      axios.get(this.url).then(function (res) {
        // console.log(this.invoices.concat(res.data.data))
        _this3.invoices = res.data.data;
        _this3.total = res.data.total;
        _this3.loading = false;
        _this3.url = res.data.next_page_url;
      })["catch"](function (err) {
        _this3.loading = false;
      });
    },
    deleteDevice: function deleteDevice(userId, index) {
      var _this = this;

      this.$iosConfirm({
        title: 'Are you sure?',
        text: 'This device and their associated data will be permanently deleted. Proceed?'
      }).then(function () {
        axios["delete"](_this.$parent.MakeUrl('secure/invoices/' + userId)).then(function (res) {
          _this.invoices.splice(index, 1);

          _this.total = _this.total - 1;

          _this.loadInvoices();
        })["catch"](function (error) {
          _this.$iosAlert({
            'title': 'Error',
            'text': error.response.data.message
          });
        });
      });
    },
    reconnect: function reconnect(id) {
      window.location.href = this.$parent.MakeUrl('secure/invoices/' + id + '/pair');
    },
    sendMessage: function sendMessage(id) {
      window.location.href = this.$parent.MakeUrl('secure/invoices/' + id + '/message');
    },
    configDevice: function configDevice(id) {
      window.location.href = this.$parent.MakeUrl('secure/invoices/' + id + '/config');
    },
    search: function search() {
      this.url = BaseUrl('secure/invoices?q=' + this.query);
      this.loadInvoices();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _chenfengyuan_vue_qrcode__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @chenfengyuan/vue-qrcode */ "./node_modules/@chenfengyuan/vue-qrcode/dist/vue-qrcode.js");
/* harmony import */ var _chenfengyuan_vue_qrcode__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_chenfengyuan_vue_qrcode__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var io = __webpack_require__(/*! socket.io-client */ "./node_modules/socket.io-client/lib/index.js");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['device'],
  components: {
    VueQrcode: (_chenfengyuan_vue_qrcode__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      qrCode: '',
      message: '',
      socket: null,
      loading: true
    };
  },
  created: function created() {
    var _this = this;

    this.socket = io.connect(this.$parent.getSocketUrl() + "?device=" + this.device.id);
    this.socket.on('qrCode', function (response) {
      _this.qrCode = response;
      _this.loading = false;
    });
    this.socket.on('deviceOnline', function (response) {
      // Stopping Device if not active
      if (_this.device.status === 'INACTIVE') {
        axios.post(_this.$parent.MakeUrl("secure/devices/".concat(_this.device.id, "/stop"))).then(function (response) {
          _this.message = "This device already pairing :), you can using this device now, you will redirect to device page ...";
          _this.loading = false;
          setTimeout(function () {
            window.location.href = _this.$parent.MakeUrl('secure/devices');
          }, 2000);
        })["catch"](function (err) {
          _this.loading = false;
        });
      } else if (_this.device.status === 'ACTIVE') {
        _this.message = "This device already pairing :), you can using this device now, you will redirect to device page ...";
        _this.loading = false;
        setTimeout(function () {
          window.location.href = _this.$parent.MakeUrl('secure/devices');
        }, 2000);
      }
    });
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['qr'],
  components: {},
  data: function data() {
    return {
      timeout: 20
    };
  },
  mounted: function mounted() {
    var _this = this;

    var interval = setInterval(function () {
      _this.timeout -= 1;

      if (_this.timeout <= 0) {
        clearInterval(interval);
        window.document.location.reload();
      }
    }, 1000);
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProfileComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProfileComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['user'],
  data: function data() {
    return {
      name: this.getUserdata('name'),
      email: this.getUserdata('email'),
      token: this.getUserdata('api_token'),
      current_password: '',
      password: '',
      password_confirmation: '',
      role: this.getUserdata('roles').length ? this.getUserdata('roles')[0].id : '',
      roles: [],
      errors: [],
      message: '',
      loading: false
    };
  },
  mounted: function mounted() {
    this.getRoles();
  },
  methods: {
    getUserdata: function getUserdata(key) {
      return JSON.parse(this.user)[key];
    },
    getRoles: function getRoles() {
      var _this2 = this;

      axios.get(this.$parent.MakeUrl('secure/users/roles')).then(function (res) {
        _this2.roles = res.data;
      })["catch"](function (err) {});
    },
    updateUser: function updateUser() {
      var _this = this;

      _this.errors = [];
      _this.message = '';
      _this.loading = true;
      axios.post(this.$parent.MakeUrl('secure/users/' + this.getUserdata('id')), {
        'name': this.name,
        'email': this.email,
        'current_password': this.current_password,
        'role': this.role,
        'password': this.password,
        'password_confirmation': this.password_confirmation,
        '_method': 'PATCH'
      }).then(function (res) {
        _this.loading = false;
        _this.message = 'Profile details have been updated successfully!';
      })["catch"](function (err) {
        _this.errors = err.response.data.errors;
        _this.loading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/SendMessageComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/SendMessageComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var io = __webpack_require__(/*! socket.io-client */ "./node_modules/socket.io-client/lib/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['device'],
  data: function data() {
    return {
      server: 'Demo Server',
      phone: '',
      errors: [],
      message: '',
      receiver: '',
      loading: false,
      tempMessage: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.socket = io.connect(this.$parent.getSocketUrl() + "?device=" + this.device.id);
    this.socket.on('newMessage', function (response) {
      console.log(response);

      _this.tempMessage.push(response);
    });
  },
  methods: {
    sendMessage: function sendMessage() {
      var _this2 = this;

      if (this.receiver === '' || this.message === '') {
        this.$iosAlert("Enter receiver and message :p");
        return;
      } // Insert into database


      axios.post(this.$parent.MakeUrl('secure/messages'), {
        device_id: this.device.id,
        message_to: this.receiver,
        message_body: this.message
      }).then(function (res) {
        _this2.$iosAlert("Your message will send to ".concat(_this2.receiver));

        _this2.message = '';
      })["catch"](function (err) {
        _this2.$iosAlert("Error :(");

        _this2.message = '';
      });
    },
    getFrom: function getFrom(from) {
      return from.split('@')[0];
    },
    getTimes: function getTimes(time) {
      return new Date(time).toDateString();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UsersComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UsersComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      users: [],
      total: 0,
      loading: false,
      loadingmore: false,
      query: '',
      url: ''
    };
  },
  mounted: function mounted() {
    var query = location.search.split('query=')[1];

    if (query !== undefined) {
      this.query = query;
    }

    this.url = BaseUrl('secure/users?q=' + this.query);
    this.loadUsers();
  },
  methods: {
    loadUsers: function loadUsers() {
      var _this2 = this;

      this.loading = true;
      axios.get(this.url).then(function (res) {
        _this2.users = res.data.data;
        _this2.total = res.data.total;
        _this2.loading = false;
        _this2.url = res.data.next_page_url;
      })["catch"](function (err) {
        _this2.loading = false;
      });
    },
    deleteUser: function deleteUser(userId, index) {
      var _this = this;

      this.$iosConfirm({
        title: 'Are you sure?',
        text: 'The user and their associated data will be permanently deleted. Proceed?'
      }).then(function () {
        axios["delete"](_this.$parent.MakeUrl('secure/users/' + userId)).then(function (res) {
          _this.users.splice(index, 1);

          _this.total = _this.total - 1;

          _this.loadUsers();
        })["catch"](function (error) {
          _this.$iosAlert({
            'title': 'Error',
            'text': error.response.data.message
          });
        });
      });
    },
    loginAs: function loginAs(userId, index) {
      window.location.href = this.$parent.MakeUrl('secure/users/login-as/' + userId);
    },
    search: function search() {
      this.url = BaseUrl('secure/users?q=' + this.query);
      this.loadUsers();
    }
  }
});

/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vue_ios_alertview__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-ios-alertview */ "./node_modules/vue-ios-alertview/dist/vue-ios-alertview.js");
/* harmony import */ var vue_ios_alertview__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_ios_alertview__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_InvoiceComponent__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/InvoiceComponent */ "./resources/js/components/InvoiceComponent.vue");
/* harmony import */ var _components_UsersComponent__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/UsersComponent */ "./resources/js/components/UsersComponent.vue");
/* harmony import */ var _components_AdduserComponent__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/AdduserComponent */ "./resources/js/components/AdduserComponent.vue");
/* harmony import */ var _components_ProfileComponent__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/ProfileComponent */ "./resources/js/components/ProfileComponent.vue");
/* harmony import */ var _components_DevicesComponent__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/DevicesComponent */ "./resources/js/components/DevicesComponent.vue");
/* harmony import */ var _components_AddDeviceComponent__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/AddDeviceComponent */ "./resources/js/components/AddDeviceComponent.vue");
/* harmony import */ var _components_PairingDeviceComponent__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/PairingDeviceComponent */ "./resources/js/components/PairingDeviceComponent.vue");
/* harmony import */ var _components_PairingDeviceNewComponent__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./components/PairingDeviceNewComponent */ "./resources/js/components/PairingDeviceNewComponent.vue");
/* harmony import */ var _components_SendMessageComponent__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./components/SendMessageComponent */ "./resources/js/components/SendMessageComponent.vue");
/* harmony import */ var _components_InboxComponent__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./components/InboxComponent */ "./resources/js/components/InboxComponent.vue");
/* harmony import */ var _components_GroupComponent__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./components/GroupComponent */ "./resources/js/components/GroupComponent.vue");
__webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");



var moment = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");






;







vue__WEBPACK_IMPORTED_MODULE_12__["default"].use((vue_ios_alertview__WEBPACK_IMPORTED_MODULE_0___default()));
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('users-component', _components_UsersComponent__WEBPACK_IMPORTED_MODULE_2__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('profile-component', _components_ProfileComponent__WEBPACK_IMPORTED_MODULE_4__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('adduser-component', _components_AdduserComponent__WEBPACK_IMPORTED_MODULE_3__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('devices-component', _components_DevicesComponent__WEBPACK_IMPORTED_MODULE_5__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('add-device-component', _components_AddDeviceComponent__WEBPACK_IMPORTED_MODULE_6__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('pairing-device-component', _components_PairingDeviceComponent__WEBPACK_IMPORTED_MODULE_7__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('pairing-device', _components_PairingDeviceNewComponent__WEBPACK_IMPORTED_MODULE_8__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('send-message-component', _components_SendMessageComponent__WEBPACK_IMPORTED_MODULE_9__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('invoice-component', _components_InvoiceComponent__WEBPACK_IMPORTED_MODULE_1__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('inbox-component', _components_InboxComponent__WEBPACK_IMPORTED_MODULE_10__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].component('group-component', _components_GroupComponent__WEBPACK_IMPORTED_MODULE_11__["default"]);
vue__WEBPACK_IMPORTED_MODULE_12__["default"].filter('toCurrency', function (value) {
  if (typeof value !== "number") {
    return value;
  }

  var formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  });
  return formatter.format(value);
});
vue__WEBPACK_IMPORTED_MODULE_12__["default"].filter('formatDate', function (value) {
  var isOnlyDate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  var utc = moment.utc(value).toDate();
  return moment(utc).local().format('LL');
});
var app = new vue__WEBPACK_IMPORTED_MODULE_12__["default"]({
  el: '#app',
  data: function data() {
    return {
      user: AuthUser,
      socketUrl: window.MIX_APP_SOCKET_URL
    };
  },
  methods: {
    userCan: function userCan(permission) {
      if (this.user && this.user.allPermissions.includes(permission)) {
        return true;
      }

      return false;
    },
    MakeUrl: function MakeUrl(path) {
      return BaseUrl(path);
    },
    getSocketUrl: function getSocketUrl() {
      return this.socketUrl;
    }
  }
});

/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var laravel_echo__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! laravel-echo */ "./node_modules/laravel-echo/dist/echo.js");
window._ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.Popper = (__webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js")["default"]);
  window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

  __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
} catch (e) {}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */



window.io = __webpack_require__(/*! socket.io-client */ "./node_modules/socket.io-client/lib/index.js");
window.Echo = new laravel_echo__WEBPACK_IMPORTED_MODULE_0__["default"]({
  broadcaster: 'socket.io',
  host: window.WS_URL
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.card-pairing {\n    position: absolute;\n    width: 80%;\n    top: 50%;\n    left: 50%;\n    transform: translate(-50%, -50%);\n}\n.header-green {\n    background-color: #2ca02c;\n    min-height: 10rem;\n}\n.body-inner {\n    background-color: #1d2124;\n    min-height: 30rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/moment/locale sync recursive ^\\.\\/.*$":
/*!***************************************************!*\
  !*** ./node_modules/moment/locale/ sync ^\.\/.*$ ***!
  \***************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	"./af": "./node_modules/moment/locale/af.js",
	"./af.js": "./node_modules/moment/locale/af.js",
	"./ar": "./node_modules/moment/locale/ar.js",
	"./ar-dz": "./node_modules/moment/locale/ar-dz.js",
	"./ar-dz.js": "./node_modules/moment/locale/ar-dz.js",
	"./ar-kw": "./node_modules/moment/locale/ar-kw.js",
	"./ar-kw.js": "./node_modules/moment/locale/ar-kw.js",
	"./ar-ly": "./node_modules/moment/locale/ar-ly.js",
	"./ar-ly.js": "./node_modules/moment/locale/ar-ly.js",
	"./ar-ma": "./node_modules/moment/locale/ar-ma.js",
	"./ar-ma.js": "./node_modules/moment/locale/ar-ma.js",
	"./ar-sa": "./node_modules/moment/locale/ar-sa.js",
	"./ar-sa.js": "./node_modules/moment/locale/ar-sa.js",
	"./ar-tn": "./node_modules/moment/locale/ar-tn.js",
	"./ar-tn.js": "./node_modules/moment/locale/ar-tn.js",
	"./ar.js": "./node_modules/moment/locale/ar.js",
	"./az": "./node_modules/moment/locale/az.js",
	"./az.js": "./node_modules/moment/locale/az.js",
	"./be": "./node_modules/moment/locale/be.js",
	"./be.js": "./node_modules/moment/locale/be.js",
	"./bg": "./node_modules/moment/locale/bg.js",
	"./bg.js": "./node_modules/moment/locale/bg.js",
	"./bm": "./node_modules/moment/locale/bm.js",
	"./bm.js": "./node_modules/moment/locale/bm.js",
	"./bn": "./node_modules/moment/locale/bn.js",
	"./bn-bd": "./node_modules/moment/locale/bn-bd.js",
	"./bn-bd.js": "./node_modules/moment/locale/bn-bd.js",
	"./bn.js": "./node_modules/moment/locale/bn.js",
	"./bo": "./node_modules/moment/locale/bo.js",
	"./bo.js": "./node_modules/moment/locale/bo.js",
	"./br": "./node_modules/moment/locale/br.js",
	"./br.js": "./node_modules/moment/locale/br.js",
	"./bs": "./node_modules/moment/locale/bs.js",
	"./bs.js": "./node_modules/moment/locale/bs.js",
	"./ca": "./node_modules/moment/locale/ca.js",
	"./ca.js": "./node_modules/moment/locale/ca.js",
	"./cs": "./node_modules/moment/locale/cs.js",
	"./cs.js": "./node_modules/moment/locale/cs.js",
	"./cv": "./node_modules/moment/locale/cv.js",
	"./cv.js": "./node_modules/moment/locale/cv.js",
	"./cy": "./node_modules/moment/locale/cy.js",
	"./cy.js": "./node_modules/moment/locale/cy.js",
	"./da": "./node_modules/moment/locale/da.js",
	"./da.js": "./node_modules/moment/locale/da.js",
	"./de": "./node_modules/moment/locale/de.js",
	"./de-at": "./node_modules/moment/locale/de-at.js",
	"./de-at.js": "./node_modules/moment/locale/de-at.js",
	"./de-ch": "./node_modules/moment/locale/de-ch.js",
	"./de-ch.js": "./node_modules/moment/locale/de-ch.js",
	"./de.js": "./node_modules/moment/locale/de.js",
	"./dv": "./node_modules/moment/locale/dv.js",
	"./dv.js": "./node_modules/moment/locale/dv.js",
	"./el": "./node_modules/moment/locale/el.js",
	"./el.js": "./node_modules/moment/locale/el.js",
	"./en-au": "./node_modules/moment/locale/en-au.js",
	"./en-au.js": "./node_modules/moment/locale/en-au.js",
	"./en-ca": "./node_modules/moment/locale/en-ca.js",
	"./en-ca.js": "./node_modules/moment/locale/en-ca.js",
	"./en-gb": "./node_modules/moment/locale/en-gb.js",
	"./en-gb.js": "./node_modules/moment/locale/en-gb.js",
	"./en-ie": "./node_modules/moment/locale/en-ie.js",
	"./en-ie.js": "./node_modules/moment/locale/en-ie.js",
	"./en-il": "./node_modules/moment/locale/en-il.js",
	"./en-il.js": "./node_modules/moment/locale/en-il.js",
	"./en-in": "./node_modules/moment/locale/en-in.js",
	"./en-in.js": "./node_modules/moment/locale/en-in.js",
	"./en-nz": "./node_modules/moment/locale/en-nz.js",
	"./en-nz.js": "./node_modules/moment/locale/en-nz.js",
	"./en-sg": "./node_modules/moment/locale/en-sg.js",
	"./en-sg.js": "./node_modules/moment/locale/en-sg.js",
	"./eo": "./node_modules/moment/locale/eo.js",
	"./eo.js": "./node_modules/moment/locale/eo.js",
	"./es": "./node_modules/moment/locale/es.js",
	"./es-do": "./node_modules/moment/locale/es-do.js",
	"./es-do.js": "./node_modules/moment/locale/es-do.js",
	"./es-mx": "./node_modules/moment/locale/es-mx.js",
	"./es-mx.js": "./node_modules/moment/locale/es-mx.js",
	"./es-us": "./node_modules/moment/locale/es-us.js",
	"./es-us.js": "./node_modules/moment/locale/es-us.js",
	"./es.js": "./node_modules/moment/locale/es.js",
	"./et": "./node_modules/moment/locale/et.js",
	"./et.js": "./node_modules/moment/locale/et.js",
	"./eu": "./node_modules/moment/locale/eu.js",
	"./eu.js": "./node_modules/moment/locale/eu.js",
	"./fa": "./node_modules/moment/locale/fa.js",
	"./fa.js": "./node_modules/moment/locale/fa.js",
	"./fi": "./node_modules/moment/locale/fi.js",
	"./fi.js": "./node_modules/moment/locale/fi.js",
	"./fil": "./node_modules/moment/locale/fil.js",
	"./fil.js": "./node_modules/moment/locale/fil.js",
	"./fo": "./node_modules/moment/locale/fo.js",
	"./fo.js": "./node_modules/moment/locale/fo.js",
	"./fr": "./node_modules/moment/locale/fr.js",
	"./fr-ca": "./node_modules/moment/locale/fr-ca.js",
	"./fr-ca.js": "./node_modules/moment/locale/fr-ca.js",
	"./fr-ch": "./node_modules/moment/locale/fr-ch.js",
	"./fr-ch.js": "./node_modules/moment/locale/fr-ch.js",
	"./fr.js": "./node_modules/moment/locale/fr.js",
	"./fy": "./node_modules/moment/locale/fy.js",
	"./fy.js": "./node_modules/moment/locale/fy.js",
	"./ga": "./node_modules/moment/locale/ga.js",
	"./ga.js": "./node_modules/moment/locale/ga.js",
	"./gd": "./node_modules/moment/locale/gd.js",
	"./gd.js": "./node_modules/moment/locale/gd.js",
	"./gl": "./node_modules/moment/locale/gl.js",
	"./gl.js": "./node_modules/moment/locale/gl.js",
	"./gom-deva": "./node_modules/moment/locale/gom-deva.js",
	"./gom-deva.js": "./node_modules/moment/locale/gom-deva.js",
	"./gom-latn": "./node_modules/moment/locale/gom-latn.js",
	"./gom-latn.js": "./node_modules/moment/locale/gom-latn.js",
	"./gu": "./node_modules/moment/locale/gu.js",
	"./gu.js": "./node_modules/moment/locale/gu.js",
	"./he": "./node_modules/moment/locale/he.js",
	"./he.js": "./node_modules/moment/locale/he.js",
	"./hi": "./node_modules/moment/locale/hi.js",
	"./hi.js": "./node_modules/moment/locale/hi.js",
	"./hr": "./node_modules/moment/locale/hr.js",
	"./hr.js": "./node_modules/moment/locale/hr.js",
	"./hu": "./node_modules/moment/locale/hu.js",
	"./hu.js": "./node_modules/moment/locale/hu.js",
	"./hy-am": "./node_modules/moment/locale/hy-am.js",
	"./hy-am.js": "./node_modules/moment/locale/hy-am.js",
	"./id": "./node_modules/moment/locale/id.js",
	"./id.js": "./node_modules/moment/locale/id.js",
	"./is": "./node_modules/moment/locale/is.js",
	"./is.js": "./node_modules/moment/locale/is.js",
	"./it": "./node_modules/moment/locale/it.js",
	"./it-ch": "./node_modules/moment/locale/it-ch.js",
	"./it-ch.js": "./node_modules/moment/locale/it-ch.js",
	"./it.js": "./node_modules/moment/locale/it.js",
	"./ja": "./node_modules/moment/locale/ja.js",
	"./ja.js": "./node_modules/moment/locale/ja.js",
	"./jv": "./node_modules/moment/locale/jv.js",
	"./jv.js": "./node_modules/moment/locale/jv.js",
	"./ka": "./node_modules/moment/locale/ka.js",
	"./ka.js": "./node_modules/moment/locale/ka.js",
	"./kk": "./node_modules/moment/locale/kk.js",
	"./kk.js": "./node_modules/moment/locale/kk.js",
	"./km": "./node_modules/moment/locale/km.js",
	"./km.js": "./node_modules/moment/locale/km.js",
	"./kn": "./node_modules/moment/locale/kn.js",
	"./kn.js": "./node_modules/moment/locale/kn.js",
	"./ko": "./node_modules/moment/locale/ko.js",
	"./ko.js": "./node_modules/moment/locale/ko.js",
	"./ku": "./node_modules/moment/locale/ku.js",
	"./ku.js": "./node_modules/moment/locale/ku.js",
	"./ky": "./node_modules/moment/locale/ky.js",
	"./ky.js": "./node_modules/moment/locale/ky.js",
	"./lb": "./node_modules/moment/locale/lb.js",
	"./lb.js": "./node_modules/moment/locale/lb.js",
	"./lo": "./node_modules/moment/locale/lo.js",
	"./lo.js": "./node_modules/moment/locale/lo.js",
	"./lt": "./node_modules/moment/locale/lt.js",
	"./lt.js": "./node_modules/moment/locale/lt.js",
	"./lv": "./node_modules/moment/locale/lv.js",
	"./lv.js": "./node_modules/moment/locale/lv.js",
	"./me": "./node_modules/moment/locale/me.js",
	"./me.js": "./node_modules/moment/locale/me.js",
	"./mi": "./node_modules/moment/locale/mi.js",
	"./mi.js": "./node_modules/moment/locale/mi.js",
	"./mk": "./node_modules/moment/locale/mk.js",
	"./mk.js": "./node_modules/moment/locale/mk.js",
	"./ml": "./node_modules/moment/locale/ml.js",
	"./ml.js": "./node_modules/moment/locale/ml.js",
	"./mn": "./node_modules/moment/locale/mn.js",
	"./mn.js": "./node_modules/moment/locale/mn.js",
	"./mr": "./node_modules/moment/locale/mr.js",
	"./mr.js": "./node_modules/moment/locale/mr.js",
	"./ms": "./node_modules/moment/locale/ms.js",
	"./ms-my": "./node_modules/moment/locale/ms-my.js",
	"./ms-my.js": "./node_modules/moment/locale/ms-my.js",
	"./ms.js": "./node_modules/moment/locale/ms.js",
	"./mt": "./node_modules/moment/locale/mt.js",
	"./mt.js": "./node_modules/moment/locale/mt.js",
	"./my": "./node_modules/moment/locale/my.js",
	"./my.js": "./node_modules/moment/locale/my.js",
	"./nb": "./node_modules/moment/locale/nb.js",
	"./nb.js": "./node_modules/moment/locale/nb.js",
	"./ne": "./node_modules/moment/locale/ne.js",
	"./ne.js": "./node_modules/moment/locale/ne.js",
	"./nl": "./node_modules/moment/locale/nl.js",
	"./nl-be": "./node_modules/moment/locale/nl-be.js",
	"./nl-be.js": "./node_modules/moment/locale/nl-be.js",
	"./nl.js": "./node_modules/moment/locale/nl.js",
	"./nn": "./node_modules/moment/locale/nn.js",
	"./nn.js": "./node_modules/moment/locale/nn.js",
	"./oc-lnc": "./node_modules/moment/locale/oc-lnc.js",
	"./oc-lnc.js": "./node_modules/moment/locale/oc-lnc.js",
	"./pa-in": "./node_modules/moment/locale/pa-in.js",
	"./pa-in.js": "./node_modules/moment/locale/pa-in.js",
	"./pl": "./node_modules/moment/locale/pl.js",
	"./pl.js": "./node_modules/moment/locale/pl.js",
	"./pt": "./node_modules/moment/locale/pt.js",
	"./pt-br": "./node_modules/moment/locale/pt-br.js",
	"./pt-br.js": "./node_modules/moment/locale/pt-br.js",
	"./pt.js": "./node_modules/moment/locale/pt.js",
	"./ro": "./node_modules/moment/locale/ro.js",
	"./ro.js": "./node_modules/moment/locale/ro.js",
	"./ru": "./node_modules/moment/locale/ru.js",
	"./ru.js": "./node_modules/moment/locale/ru.js",
	"./sd": "./node_modules/moment/locale/sd.js",
	"./sd.js": "./node_modules/moment/locale/sd.js",
	"./se": "./node_modules/moment/locale/se.js",
	"./se.js": "./node_modules/moment/locale/se.js",
	"./si": "./node_modules/moment/locale/si.js",
	"./si.js": "./node_modules/moment/locale/si.js",
	"./sk": "./node_modules/moment/locale/sk.js",
	"./sk.js": "./node_modules/moment/locale/sk.js",
	"./sl": "./node_modules/moment/locale/sl.js",
	"./sl.js": "./node_modules/moment/locale/sl.js",
	"./sq": "./node_modules/moment/locale/sq.js",
	"./sq.js": "./node_modules/moment/locale/sq.js",
	"./sr": "./node_modules/moment/locale/sr.js",
	"./sr-cyrl": "./node_modules/moment/locale/sr-cyrl.js",
	"./sr-cyrl.js": "./node_modules/moment/locale/sr-cyrl.js",
	"./sr.js": "./node_modules/moment/locale/sr.js",
	"./ss": "./node_modules/moment/locale/ss.js",
	"./ss.js": "./node_modules/moment/locale/ss.js",
	"./sv": "./node_modules/moment/locale/sv.js",
	"./sv.js": "./node_modules/moment/locale/sv.js",
	"./sw": "./node_modules/moment/locale/sw.js",
	"./sw.js": "./node_modules/moment/locale/sw.js",
	"./ta": "./node_modules/moment/locale/ta.js",
	"./ta.js": "./node_modules/moment/locale/ta.js",
	"./te": "./node_modules/moment/locale/te.js",
	"./te.js": "./node_modules/moment/locale/te.js",
	"./tet": "./node_modules/moment/locale/tet.js",
	"./tet.js": "./node_modules/moment/locale/tet.js",
	"./tg": "./node_modules/moment/locale/tg.js",
	"./tg.js": "./node_modules/moment/locale/tg.js",
	"./th": "./node_modules/moment/locale/th.js",
	"./th.js": "./node_modules/moment/locale/th.js",
	"./tk": "./node_modules/moment/locale/tk.js",
	"./tk.js": "./node_modules/moment/locale/tk.js",
	"./tl-ph": "./node_modules/moment/locale/tl-ph.js",
	"./tl-ph.js": "./node_modules/moment/locale/tl-ph.js",
	"./tlh": "./node_modules/moment/locale/tlh.js",
	"./tlh.js": "./node_modules/moment/locale/tlh.js",
	"./tr": "./node_modules/moment/locale/tr.js",
	"./tr.js": "./node_modules/moment/locale/tr.js",
	"./tzl": "./node_modules/moment/locale/tzl.js",
	"./tzl.js": "./node_modules/moment/locale/tzl.js",
	"./tzm": "./node_modules/moment/locale/tzm.js",
	"./tzm-latn": "./node_modules/moment/locale/tzm-latn.js",
	"./tzm-latn.js": "./node_modules/moment/locale/tzm-latn.js",
	"./tzm.js": "./node_modules/moment/locale/tzm.js",
	"./ug-cn": "./node_modules/moment/locale/ug-cn.js",
	"./ug-cn.js": "./node_modules/moment/locale/ug-cn.js",
	"./uk": "./node_modules/moment/locale/uk.js",
	"./uk.js": "./node_modules/moment/locale/uk.js",
	"./ur": "./node_modules/moment/locale/ur.js",
	"./ur.js": "./node_modules/moment/locale/ur.js",
	"./uz": "./node_modules/moment/locale/uz.js",
	"./uz-latn": "./node_modules/moment/locale/uz-latn.js",
	"./uz-latn.js": "./node_modules/moment/locale/uz-latn.js",
	"./uz.js": "./node_modules/moment/locale/uz.js",
	"./vi": "./node_modules/moment/locale/vi.js",
	"./vi.js": "./node_modules/moment/locale/vi.js",
	"./x-pseudo": "./node_modules/moment/locale/x-pseudo.js",
	"./x-pseudo.js": "./node_modules/moment/locale/x-pseudo.js",
	"./yo": "./node_modules/moment/locale/yo.js",
	"./yo.js": "./node_modules/moment/locale/yo.js",
	"./zh-cn": "./node_modules/moment/locale/zh-cn.js",
	"./zh-cn.js": "./node_modules/moment/locale/zh-cn.js",
	"./zh-hk": "./node_modules/moment/locale/zh-hk.js",
	"./zh-hk.js": "./node_modules/moment/locale/zh-hk.js",
	"./zh-mo": "./node_modules/moment/locale/zh-mo.js",
	"./zh-mo.js": "./node_modules/moment/locale/zh-mo.js",
	"./zh-tw": "./node_modules/moment/locale/zh-tw.js",
	"./zh-tw.js": "./node_modules/moment/locale/zh-tw.js"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./node_modules/moment/locale sync recursive ^\\.\\/.*$";

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/AddDeviceComponent.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/AddDeviceComponent.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AddDeviceComponent_vue_vue_type_template_id_425fef11___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AddDeviceComponent.vue?vue&type=template&id=425fef11& */ "./resources/js/components/AddDeviceComponent.vue?vue&type=template&id=425fef11&");
/* harmony import */ var _AddDeviceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AddDeviceComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/AddDeviceComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AddDeviceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AddDeviceComponent_vue_vue_type_template_id_425fef11___WEBPACK_IMPORTED_MODULE_0__.render,
  _AddDeviceComponent_vue_vue_type_template_id_425fef11___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/AddDeviceComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/AdduserComponent.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/AdduserComponent.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AdduserComponent_vue_vue_type_template_id_1676a748___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AdduserComponent.vue?vue&type=template&id=1676a748& */ "./resources/js/components/AdduserComponent.vue?vue&type=template&id=1676a748&");
/* harmony import */ var _AdduserComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AdduserComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/AdduserComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AdduserComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AdduserComponent_vue_vue_type_template_id_1676a748___WEBPACK_IMPORTED_MODULE_0__.render,
  _AdduserComponent_vue_vue_type_template_id_1676a748___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/AdduserComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/DevicesComponent.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/DevicesComponent.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _DevicesComponent_vue_vue_type_template_id_4c5ffb0b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DevicesComponent.vue?vue&type=template&id=4c5ffb0b& */ "./resources/js/components/DevicesComponent.vue?vue&type=template&id=4c5ffb0b&");
/* harmony import */ var _DevicesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DevicesComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/DevicesComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _DevicesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _DevicesComponent_vue_vue_type_template_id_4c5ffb0b___WEBPACK_IMPORTED_MODULE_0__.render,
  _DevicesComponent_vue_vue_type_template_id_4c5ffb0b___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/DevicesComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/GroupComponent.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/GroupComponent.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _GroupComponent_vue_vue_type_template_id_6edbc169___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./GroupComponent.vue?vue&type=template&id=6edbc169& */ "./resources/js/components/GroupComponent.vue?vue&type=template&id=6edbc169&");
/* harmony import */ var _GroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./GroupComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/GroupComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _GroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _GroupComponent_vue_vue_type_template_id_6edbc169___WEBPACK_IMPORTED_MODULE_0__.render,
  _GroupComponent_vue_vue_type_template_id_6edbc169___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/GroupComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/InboxComponent.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/InboxComponent.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _InboxComponent_vue_vue_type_template_id_34b998c2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InboxComponent.vue?vue&type=template&id=34b998c2& */ "./resources/js/components/InboxComponent.vue?vue&type=template&id=34b998c2&");
/* harmony import */ var _InboxComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InboxComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/InboxComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _InboxComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _InboxComponent_vue_vue_type_template_id_34b998c2___WEBPACK_IMPORTED_MODULE_0__.render,
  _InboxComponent_vue_vue_type_template_id_34b998c2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/InboxComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/InvoiceComponent.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/InvoiceComponent.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _InvoiceComponent_vue_vue_type_template_id_2d1526bb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InvoiceComponent.vue?vue&type=template&id=2d1526bb& */ "./resources/js/components/InvoiceComponent.vue?vue&type=template&id=2d1526bb&");
/* harmony import */ var _InvoiceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InvoiceComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/InvoiceComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _InvoiceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _InvoiceComponent_vue_vue_type_template_id_2d1526bb___WEBPACK_IMPORTED_MODULE_0__.render,
  _InvoiceComponent_vue_vue_type_template_id_2d1526bb___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/InvoiceComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/PairingDeviceComponent.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/PairingDeviceComponent.vue ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PairingDeviceComponent_vue_vue_type_template_id_bdbeffec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PairingDeviceComponent.vue?vue&type=template&id=bdbeffec& */ "./resources/js/components/PairingDeviceComponent.vue?vue&type=template&id=bdbeffec&");
/* harmony import */ var _PairingDeviceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PairingDeviceComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/PairingDeviceComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PairingDeviceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PairingDeviceComponent_vue_vue_type_template_id_bdbeffec___WEBPACK_IMPORTED_MODULE_0__.render,
  _PairingDeviceComponent_vue_vue_type_template_id_bdbeffec___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PairingDeviceComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/PairingDeviceNewComponent.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/PairingDeviceNewComponent.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PairingDeviceNewComponent_vue_vue_type_template_id_0f594780___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PairingDeviceNewComponent.vue?vue&type=template&id=0f594780& */ "./resources/js/components/PairingDeviceNewComponent.vue?vue&type=template&id=0f594780&");
/* harmony import */ var _PairingDeviceNewComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PairingDeviceNewComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/PairingDeviceNewComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _PairingDeviceNewComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PairingDeviceNewComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PairingDeviceNewComponent_vue_vue_type_template_id_0f594780___WEBPACK_IMPORTED_MODULE_0__.render,
  _PairingDeviceNewComponent_vue_vue_type_template_id_0f594780___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PairingDeviceNewComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ProfileComponent.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/ProfileComponent.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ProfileComponent_vue_vue_type_template_id_a8276c82___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProfileComponent.vue?vue&type=template&id=a8276c82& */ "./resources/js/components/ProfileComponent.vue?vue&type=template&id=a8276c82&");
/* harmony import */ var _ProfileComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProfileComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ProfileComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProfileComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProfileComponent_vue_vue_type_template_id_a8276c82___WEBPACK_IMPORTED_MODULE_0__.render,
  _ProfileComponent_vue_vue_type_template_id_a8276c82___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ProfileComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/SendMessageComponent.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/SendMessageComponent.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SendMessageComponent_vue_vue_type_template_id_57456a49___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SendMessageComponent.vue?vue&type=template&id=57456a49& */ "./resources/js/components/SendMessageComponent.vue?vue&type=template&id=57456a49&");
/* harmony import */ var _SendMessageComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SendMessageComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/SendMessageComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SendMessageComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SendMessageComponent_vue_vue_type_template_id_57456a49___WEBPACK_IMPORTED_MODULE_0__.render,
  _SendMessageComponent_vue_vue_type_template_id_57456a49___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SendMessageComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/UsersComponent.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/UsersComponent.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _UsersComponent_vue_vue_type_template_id_47d47080___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./UsersComponent.vue?vue&type=template&id=47d47080& */ "./resources/js/components/UsersComponent.vue?vue&type=template&id=47d47080&");
/* harmony import */ var _UsersComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./UsersComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/UsersComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _UsersComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _UsersComponent_vue_vue_type_template_id_47d47080___WEBPACK_IMPORTED_MODULE_0__.render,
  _UsersComponent_vue_vue_type_template_id_47d47080___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/UsersComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/AddDeviceComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/AddDeviceComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddDeviceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddDeviceComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AddDeviceComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddDeviceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/AdduserComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/AdduserComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AdduserComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AdduserComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AdduserComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AdduserComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/DevicesComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/DevicesComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DevicesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DevicesComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DevicesComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DevicesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/GroupComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/GroupComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./GroupComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/GroupComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/InboxComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/InboxComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InboxComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InboxComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InboxComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InboxComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/InvoiceComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/InvoiceComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InvoiceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InvoiceComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InvoiceComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InvoiceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PairingDeviceComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/PairingDeviceComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PairingDeviceComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PairingDeviceNewComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/PairingDeviceNewComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PairingDeviceNewComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ProfileComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/ProfileComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProfileComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProfileComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SendMessageComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/SendMessageComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SendMessageComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SendMessageComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/SendMessageComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SendMessageComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/UsersComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/UsersComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./UsersComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UsersComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/AddDeviceComponent.vue?vue&type=template&id=425fef11&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/AddDeviceComponent.vue?vue&type=template&id=425fef11& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddDeviceComponent_vue_vue_type_template_id_425fef11___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddDeviceComponent_vue_vue_type_template_id_425fef11___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddDeviceComponent_vue_vue_type_template_id_425fef11___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddDeviceComponent.vue?vue&type=template&id=425fef11& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AddDeviceComponent.vue?vue&type=template&id=425fef11&");


/***/ }),

/***/ "./resources/js/components/AdduserComponent.vue?vue&type=template&id=1676a748&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/AdduserComponent.vue?vue&type=template&id=1676a748& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AdduserComponent_vue_vue_type_template_id_1676a748___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AdduserComponent_vue_vue_type_template_id_1676a748___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AdduserComponent_vue_vue_type_template_id_1676a748___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AdduserComponent.vue?vue&type=template&id=1676a748& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AdduserComponent.vue?vue&type=template&id=1676a748&");


/***/ }),

/***/ "./resources/js/components/DevicesComponent.vue?vue&type=template&id=4c5ffb0b&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/DevicesComponent.vue?vue&type=template&id=4c5ffb0b& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DevicesComponent_vue_vue_type_template_id_4c5ffb0b___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DevicesComponent_vue_vue_type_template_id_4c5ffb0b___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DevicesComponent_vue_vue_type_template_id_4c5ffb0b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DevicesComponent.vue?vue&type=template&id=4c5ffb0b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DevicesComponent.vue?vue&type=template&id=4c5ffb0b&");


/***/ }),

/***/ "./resources/js/components/GroupComponent.vue?vue&type=template&id=6edbc169&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/GroupComponent.vue?vue&type=template&id=6edbc169& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GroupComponent_vue_vue_type_template_id_6edbc169___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GroupComponent_vue_vue_type_template_id_6edbc169___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GroupComponent_vue_vue_type_template_id_6edbc169___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./GroupComponent.vue?vue&type=template&id=6edbc169& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/GroupComponent.vue?vue&type=template&id=6edbc169&");


/***/ }),

/***/ "./resources/js/components/InboxComponent.vue?vue&type=template&id=34b998c2&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/InboxComponent.vue?vue&type=template&id=34b998c2& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InboxComponent_vue_vue_type_template_id_34b998c2___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InboxComponent_vue_vue_type_template_id_34b998c2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InboxComponent_vue_vue_type_template_id_34b998c2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InboxComponent.vue?vue&type=template&id=34b998c2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InboxComponent.vue?vue&type=template&id=34b998c2&");


/***/ }),

/***/ "./resources/js/components/InvoiceComponent.vue?vue&type=template&id=2d1526bb&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/InvoiceComponent.vue?vue&type=template&id=2d1526bb& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InvoiceComponent_vue_vue_type_template_id_2d1526bb___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InvoiceComponent_vue_vue_type_template_id_2d1526bb___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InvoiceComponent_vue_vue_type_template_id_2d1526bb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InvoiceComponent.vue?vue&type=template&id=2d1526bb& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InvoiceComponent.vue?vue&type=template&id=2d1526bb&");


/***/ }),

/***/ "./resources/js/components/PairingDeviceComponent.vue?vue&type=template&id=bdbeffec&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/PairingDeviceComponent.vue?vue&type=template&id=bdbeffec& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceComponent_vue_vue_type_template_id_bdbeffec___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceComponent_vue_vue_type_template_id_bdbeffec___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceComponent_vue_vue_type_template_id_bdbeffec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PairingDeviceComponent.vue?vue&type=template&id=bdbeffec& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceComponent.vue?vue&type=template&id=bdbeffec&");


/***/ }),

/***/ "./resources/js/components/PairingDeviceNewComponent.vue?vue&type=template&id=0f594780&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/PairingDeviceNewComponent.vue?vue&type=template&id=0f594780& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_template_id_0f594780___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_template_id_0f594780___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PairingDeviceNewComponent_vue_vue_type_template_id_0f594780___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PairingDeviceNewComponent.vue?vue&type=template&id=0f594780& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=template&id=0f594780&");


/***/ }),

/***/ "./resources/js/components/ProfileComponent.vue?vue&type=template&id=a8276c82&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/ProfileComponent.vue?vue&type=template&id=a8276c82& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileComponent_vue_vue_type_template_id_a8276c82___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileComponent_vue_vue_type_template_id_a8276c82___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileComponent_vue_vue_type_template_id_a8276c82___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProfileComponent.vue?vue&type=template&id=a8276c82& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProfileComponent.vue?vue&type=template&id=a8276c82&");


/***/ }),

/***/ "./resources/js/components/SendMessageComponent.vue?vue&type=template&id=57456a49&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/SendMessageComponent.vue?vue&type=template&id=57456a49& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SendMessageComponent_vue_vue_type_template_id_57456a49___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SendMessageComponent_vue_vue_type_template_id_57456a49___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SendMessageComponent_vue_vue_type_template_id_57456a49___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SendMessageComponent.vue?vue&type=template&id=57456a49& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/SendMessageComponent.vue?vue&type=template&id=57456a49&");


/***/ }),

/***/ "./resources/js/components/UsersComponent.vue?vue&type=template&id=47d47080&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/UsersComponent.vue?vue&type=template&id=47d47080& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersComponent_vue_vue_type_template_id_47d47080___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersComponent_vue_vue_type_template_id_47d47080___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersComponent_vue_vue_type_template_id_47d47080___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./UsersComponent.vue?vue&type=template&id=47d47080& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UsersComponent.vue?vue&type=template&id=47d47080&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AddDeviceComponent.vue?vue&type=template&id=425fef11&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AddDeviceComponent.vue?vue&type=template&id=425fef11& ***!
  \******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row justify-content-md-center" }, [
    _c("div", { staticClass: "col-lg-6" }, [
      _vm.message
        ? _c("div", { staticClass: "alert alert-primary" }, [
            _vm._v("\n      " + _vm._s(_vm.message) + "\n    "),
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "card" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "card-body" }, [
          _vm.step == 1
            ? _c("div", [
                _vm._m(1),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row mb-4" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-form-label text-md-right col-12 col-md-3 col-lg-3",
                    },
                    [_vm._v("Server")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-12 col-md-7" }, [
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.server,
                            expression: "server",
                          },
                        ],
                        staticClass: "form-control",
                        class: { "is-invalid": _vm.errors.server },
                        on: {
                          change: function ($event) {
                            var $$selectedVal = Array.prototype.filter
                              .call($event.target.options, function (o) {
                                return o.selected
                              })
                              .map(function (o) {
                                var val = "_value" in o ? o._value : o.value
                                return val
                              })
                            _vm.server = $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          },
                        },
                      },
                      [
                        _c(
                          "option",
                          { attrs: { value: "null", disabled: "" } },
                          [_vm._v("Select Server")]
                        ),
                        _vm._v(" "),
                        _vm._l(_vm.serverList, function (item, key) {
                          return _c(
                            "option",
                            { key: key, domProps: { value: item.id } },
                            [
                              _vm._v(
                                "\n                  " +
                                  _vm._s(item.name) +
                                  "\n                "
                              ),
                            ]
                          )
                        }),
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _vm.errors.server
                      ? _c("div", { staticClass: "invalid-feedback" }, [
                          _c("p", [_vm._v(_vm._s(_vm.errors.server[0]))]),
                        ])
                      : _vm._e(),
                  ]),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row mb-4" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-form-label text-md-right col-12 col-md-3 col-lg-3",
                    },
                    [_vm._v("Phone")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-sm-12 col-md-7" },
                    [
                      _c("VuePhoneNumberInput", {
                        attrs: {
                          "fetch-country": true,
                          error: _vm.errors.phone,
                        },
                        on: { update: _vm.onPhoneNumberUpdated },
                        model: {
                          value: _vm.phoneString,
                          callback: function ($$v) {
                            _vm.phoneString = $$v
                          },
                          expression: "phoneString",
                        },
                      }),
                      _vm._v(" "),
                      _vm.errors.phone
                        ? _c(
                            "span",
                            { staticClass: "text-small text-danger" },
                            [_c("p", [_vm._v(_vm._s(_vm.errors.phone[0]))])]
                          )
                        : _vm._e(),
                    ],
                    1
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row mb-4" }, [
                  _vm._m(2),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-12 col-md-7" }, [
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.version,
                            expression: "version",
                          },
                        ],
                        staticClass: "form-control",
                        class: { "is-invalid": _vm.errors.version },
                        on: {
                          change: function ($event) {
                            var $$selectedVal = Array.prototype.filter
                              .call($event.target.options, function (o) {
                                return o.selected
                              })
                              .map(function (o) {
                                var val = "_value" in o ? o._value : o.value
                                return val
                              })
                            _vm.version = $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          },
                        },
                      },
                      [
                        _c("option", { attrs: { value: "multidevice" } }, [
                          _vm._v("Multi Device"),
                        ]),
                        _vm._v(" "),
                        _c("option", { attrs: { value: "default" } }, [
                          _vm._v("Legacy"),
                        ]),
                      ]
                    ),
                    _vm._v(" "),
                    _vm.errors.version
                      ? _c("span", { staticClass: "text-small text-danger" }, [
                          _c("p", [_vm._v(_vm._s(_vm.errors.version[0]))]),
                        ])
                      : _vm._e(),
                  ]),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row mb-4" }, [
                  _c("label", {
                    staticClass:
                      "col-form-label text-md-right col-12 col-md-3 col-lg-3",
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-12 col-md-7" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary btn-lg",
                        attrs: { disabled: _vm.loading },
                        on: { click: _vm.nextStep },
                      },
                      [
                        _vm.loading
                          ? _c("span", [_vm._v("Adding")])
                          : _c("span", [_vm._v("Next")]),
                      ]
                    ),
                  ]),
                ]),
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.step == 2
            ? _c(
                "div",
                { staticClass: "d-flex flex-column align-items-center" },
                [
                  _c("img", {
                    staticClass: "img-fluid mb-5",
                    attrs: { width: "100", src: "/images/password-entry.png" },
                  }),
                  _vm._v(" "),
                  _c("h6", [_vm._v("We need to Verify your Device")]),
                  _vm._v(" "),
                  _c("p", { staticClass: "text-center" }, [
                    _vm._v(
                      "\n            We have sent 4 digits One Time Password to Your WhatsApp Number,\n            please check your phone and enter One Time Password here.\n          "
                    ),
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.otp.pin,
                        expression: "otp.pin",
                      },
                    ],
                    staticClass: "form-control",
                    attrs: { placeholder: "Enter 4 digits OTP" },
                    domProps: { value: _vm.otp.pin },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.otp, "pin", $event.target.value)
                      },
                    },
                  }),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary btn-block mt-2",
                      attrs: { disabled: _vm.loading },
                      on: { click: _vm.submitOtp },
                    },
                    [_vm._v("\n            Verify\n          ")]
                  ),
                  _vm._v(" "),
                  _c("p", [
                    _vm._v(
                      "\n            Don't received any OTP?\n            "
                    ),
                    _vm.otp.nextRequestIn <= 0
                      ? _c(
                          "a",
                          { attrs: { href: "#" }, on: { click: _vm.sendOtp } },
                          [_vm._v("Resend OTP")]
                        )
                      : _c("a", { attrs: { href: "#" } }, [
                          _vm._v(
                            "Wait for " +
                              _vm._s(_vm.otp.nextRequestIn) +
                              " Seconds "
                          ),
                        ]),
                  ]),
                ]
              )
            : _vm._e(),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("h4", [_vm._v("Add a New Device")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "alert alert-warning", attrs: { role: "alert" } },
      [
        _c("h4", { staticClass: "alert-heading" }, [
          _vm._v("🔥🔥 We Support for Multi Device Now ! "),
        ]),
        _vm._v(" "),
        _c("p", [
          _vm._v(
            "\n              Aww yeah, WhatsApp has been released new API Version called Multidevice, with multidevice you will able to sending message while your Device is Offline, if you still using Old WhatsApp version please select Legacy\n            "
          ),
        ]),
        _vm._v(" "),
        _c("hr"),
        _vm._v(" "),
        _c("p", { staticClass: "mb-0" }, [
          _vm._v(
            "\n              Select multidevice version on Device Version to use multidevice feature \n            "
          ),
        ]),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-form-label text-md-right col-12 col-md-3 col-lg-3" },
      [
        _vm._v("Device Version\n              "),
        _c("i", {
          staticClass: "fas fa-question-circle",
          attrs: {
            "data-toggle": "tooltip",
            "data-placement": "top",
            title:
              "WhatsApp has been released new API Version called Multidevice, with multidevice you will able to sending message while your Device is Offline, if you still using Old WhatsApp version please select Legacy",
          },
        }),
      ]
    )
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AdduserComponent.vue?vue&type=template&id=1676a748&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/AdduserComponent.vue?vue&type=template&id=1676a748& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-12" }, [
      _vm.message
        ? _c("div", { staticClass: "alert alert-primary" }, [
            _vm._v("\n            " + _vm._s(_vm.message) + "\n        "),
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "card" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "card-body" }, [
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Name")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.name,
                    expression: "name",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.name },
                attrs: { type: "text", placeholder: "Full name of the user." },
                domProps: { value: _vm.name },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.name = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.name
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [_vm._v(_vm._s(_vm.errors.name[0]))]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Email")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.email,
                    expression: "email",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.email },
                attrs: {
                  type: "text",
                  placeholder: "Email address (should be unique).",
                },
                domProps: { value: _vm.email },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.email = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.email
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [_vm._v(_vm._s(_vm.errors.email[0]))]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Role")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.role,
                      expression: "role",
                    },
                  ],
                  staticClass: "form-control",
                  class: { "is-invalid": _vm.errors.role },
                  on: {
                    change: function ($event) {
                      var $$selectedVal = Array.prototype.filter
                        .call($event.target.options, function (o) {
                          return o.selected
                        })
                        .map(function (o) {
                          var val = "_value" in o ? o._value : o.value
                          return val
                        })
                      _vm.role = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    },
                  },
                },
                _vm._l(_vm.roles, function (role) {
                  return _c("option", { domProps: { value: role.id } }, [
                    _vm._v(_vm._s(role.name)),
                  ])
                }),
                0
              ),
              _vm._v(" "),
              _vm.errors.role
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [_vm._v(_vm._s(_vm.errors.role[0]))]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Password")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.password,
                    expression: "password",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.password },
                attrs: {
                  type: "password",
                  autocomplete: "new-password",
                  placeholder: "Set an account password.",
                },
                domProps: { value: _vm.password },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.password = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.password
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [_vm._v(_vm._s(_vm.errors.password[0]))]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Confirm Password")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.password_confirmation,
                    expression: "password_confirmation",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.password_confirmation },
                attrs: {
                  type: "password",
                  placeholder: "Confirm account password.",
                  autocomplete: "new-password",
                },
                domProps: { value: _vm.password_confirmation },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.password_confirmation = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.password_confirmation
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [
                      _vm._v(_vm._s(_vm.errors.password_confirmation[0])),
                    ]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c("label", {
              staticClass:
                "col-form-label text-md-right col-12 col-md-3 col-lg-3",
            }),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { disabled: _vm.loading },
                  on: { click: _vm.addUser },
                },
                [
                  _vm.loading
                    ? _c("span", [_vm._v("Adding")])
                    : _c("span", [_vm._v("Add")]),
                ]
              ),
            ]),
          ]),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("h4", [_vm._v("Add a New User")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DevicesComponent.vue?vue&type=template&id=4c5ffb0b&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DevicesComponent.vue?vue&type=template&id=4c5ffb0b& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.$parent.userCan("manage-devices")
    ? _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-12" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-header" }, [
              _c("h4", [
                _vm._v("Devices "),
                _vm.total
                  ? _c("span", [_vm._v("(" + _vm._s(_vm.total) + ")")])
                  : _vm._e(),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "card-header-action" }, [
                _c("div", { staticClass: "input-group" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.query,
                        expression: "query",
                      },
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", placeholder: "Search" },
                    domProps: { value: _vm.query },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.query = $event.target.value
                      },
                    },
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group-btn" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary",
                        on: { click: _vm.search },
                      },
                      [_c("i", { staticClass: "fas fa-search" })]
                    ),
                  ]),
                ]),
                _vm._v(" "),
                _vm.$parent.userCan("create-devices")
                  ? _c(
                      "a",
                      {
                        staticClass: "btn btn-primary",
                        attrs: {
                          href: _vm.$parent.MakeUrl("secure/subscriptions"),
                        },
                      },
                      [_vm._v("Add "), _c("i", { staticClass: "fas fa-plus" })]
                    )
                  : _vm._e(),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card-body p-0" }, [
              !_vm.loading
                ? _c("div", { staticClass: "table-responsive table-invoice" }, [
                    _vm.devices.length
                      ? _c("table", { staticClass: "table table-striped" }, [
                          _c(
                            "tbody",
                            [
                              _c("tr", [
                                _c("th", { attrs: { width: "5%" } }),
                                _vm._v(" "),
                                _vm.$parent.userCan("view-all-devices")
                                  ? _c("th", [_vm._v("User")])
                                  : _vm._e(),
                                _vm._v(" "),
                                _c("th", [_vm._v("Server Location")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Package")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Phone")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Status")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Reg. Date")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Expiry. Date")]),
                                _vm._v(" "),
                                _c("th"),
                              ]),
                              _vm._v(" "),
                              _vm._l(_vm.devices, function (item, index) {
                                return _c("tr", { key: index }, [
                                  _c(
                                    "td",
                                    { staticClass: "text-center no-padding" },
                                    [
                                      item.image_url
                                        ? _c("img", {
                                            staticClass: "rounded-circle",
                                            attrs: {
                                              src: item.image_url,
                                              width: "50",
                                            },
                                          })
                                        : _c("img", {
                                            staticClass: "rounded-circle",
                                            attrs: {
                                              src: _vm.$parent.MakeUrl(
                                                "assets/img/logo-icon.png"
                                              ),
                                              width: "50",
                                            },
                                          }),
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _vm.$parent.userCan("view-all-devices")
                                    ? _c("td", [
                                        _c(
                                          "a",
                                          {
                                            attrs: {
                                              href: _vm.$parent.MakeUrl(
                                                "secure/users/" +
                                                  item.user.id +
                                                  "/edit"
                                              ),
                                            },
                                          },
                                          [
                                            _vm._v(
                                              _vm._s(item.user.name) +
                                                " <" +
                                                _vm._s(item.user.email) +
                                                ">"
                                            ),
                                          ]
                                        ),
                                      ])
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(item.server.name))]),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(item.package.name))]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(item.phone) +
                                        "\n                                    "
                                    ),
                                    _c("p", { staticClass: "text-secondary" }, [
                                      _vm._v(_vm._s(item.device_name_mobile)),
                                    ]),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    item.status === "ACTIVE"
                                      ? _c(
                                          "span",
                                          {
                                            staticClass:
                                              "badge text-capitalize",
                                            class: _vm.pairedClass(item),
                                          },
                                          [_vm._v(_vm._s(item.paired_status))]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    item.status != "ACTIVE"
                                      ? _c(
                                          "span",
                                          {
                                            staticClass:
                                              "badge text-capitalize",
                                            class: _vm.pairedClass(item),
                                          },
                                          [_vm._v(_vm._s(item.status))]
                                        )
                                      : _vm._e(),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm._f("formatDate")(item.created_at)
                                        ) +
                                        "\n                                "
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm._f("formatDate")(
                                            item.subscriptions.expired_at
                                          )
                                        ) +
                                        "\n                                "
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", { staticClass: "text-right" }, [
                                    item.paired_status === "PAIRED" &&
                                    item.status === "ACTIVE"
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn btn-success",
                                            on: {
                                              click: function ($event) {
                                                return _vm.sendMessage(item.id)
                                              },
                                            },
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-paper-plane",
                                            }),
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    item.status === "ACTIVE"
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn btn-primary",
                                            attrs: {
                                              "data-toggle": "tooltip",
                                              "data-placement": "top",
                                              title: "Tooltip on top",
                                            },
                                            on: {
                                              click: function ($event) {
                                                return _vm.reconnect(item.id)
                                              },
                                            },
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-sync",
                                            }),
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$parent.userCan("edit-devices") &&
                                    item.status === "ACTIVE"
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn btn-warning",
                                            on: {
                                              click: function ($event) {
                                                return _vm.configDevice(item.id)
                                              },
                                            },
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-cog",
                                            }),
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _c(
                                      "button",
                                      {
                                        staticClass: "btn btn-danger",
                                        attrs: {
                                          "data-toggle": "tooltip",
                                          "data-placement": "top",
                                          title: "Force Logout",
                                        },
                                        on: {
                                          click: function ($event) {
                                            return _vm.stopDevice(item)
                                          },
                                        },
                                      },
                                      [_c("i", { staticClass: "fa fa-stop" })]
                                    ),
                                  ]),
                                ])
                              }),
                            ],
                            2
                          ),
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.devices.length
                      ? _c(
                          "div",
                          { staticClass: "text-center p-3 text-muted" },
                          [
                            _c("h5", [_vm._v("No Results")]),
                            _vm._v(" "),
                            _c("p", [
                              _vm._v(
                                "Looks like you have not added any devices yet!"
                              ),
                            ]),
                          ]
                        )
                      : _vm._e(),
                  ])
                : _c("div", { staticClass: "text-center p-4 text-muted" }, [
                    _c("h5", [_vm._v("Loading")]),
                    _vm._v(" "),
                    _c("p", [_vm._v("Please wait, data is being loaded...")]),
                  ]),
            ]),
          ]),
          _vm._v(" "),
          _vm.devices.length && _vm.total > _vm.devices.length
            ? _c("div", { staticClass: "text-center" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary",
                    attrs: { disabled: _vm.loading },
                    on: { click: _vm.loadDevices },
                  },
                  [
                    _vm.loading
                      ? _c("span", [
                          _vm._v("Loading "),
                          _c("i", { staticClass: "fas fa-spinner fa-spin" }),
                        ])
                      : _c("span", [_vm._v("Load More")]),
                  ]
                ),
              ])
            : _vm._e(),
        ]),
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/GroupComponent.vue?vue&type=template&id=6edbc169&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/GroupComponent.vue?vue&type=template&id=6edbc169& ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.$parent.userCan("manage-inbox")
    ? _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-12" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-header" }, [
              _c("h4", [_vm._v("Groups")]),
              _vm._v(" "),
              _c("div", { staticClass: "card-header-form" }, [
                _c("form", [
                  _c("div", { staticClass: "row align-items-center" }, [
                    _c("div", { staticClass: "col-md-7 col-sm-12" }, [
                      _c(
                        "select",
                        {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.device,
                              expression: "device",
                            },
                          ],
                          staticClass: "form-control form-control-sm",
                          attrs: { name: "device", id: "device" },
                          on: {
                            change: [
                              function ($event) {
                                var $$selectedVal = Array.prototype.filter
                                  .call($event.target.options, function (o) {
                                    return o.selected
                                  })
                                  .map(function (o) {
                                    var val = "_value" in o ? o._value : o.value
                                    return val
                                  })
                                _vm.device = $event.target.multiple
                                  ? $$selectedVal
                                  : $$selectedVal[0]
                              },
                              _vm.onChangeDevice,
                            ],
                          },
                        },
                        _vm._l(_vm.devices, function (device) {
                          return _c(
                            "option",
                            {
                              key: device.id,
                              attrs: { selected: "" },
                              domProps: { value: device.id },
                            },
                            [
                              _vm._v(
                                "\n                    " +
                                  _vm._s(device.phone) +
                                  "\n                  "
                              ),
                            ]
                          )
                        }),
                        0
                      ),
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-5 col-sm-12 text-center" },
                      [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-info btn-sm w-100",
                            on: {
                              click: function ($event) {
                                $event.preventDefault()
                                return _vm.pullData.apply(null, arguments)
                              },
                            },
                          },
                          [
                            _vm._v(
                              "\n                  Pull Data\n                "
                            ),
                          ]
                        ),
                      ]
                    ),
                  ]),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card-body p-0" }, [
              !_vm.loading
                ? _c("div", { staticClass: "table-responsive table-invoice" }, [
                    _vm.items.length
                      ? _c("table", { staticClass: "table table-striped" }, [
                          _c(
                            "tbody",
                            [
                              _vm._m(0),
                              _vm._v(" "),
                              _vm._l(_vm.items, function (item, index) {
                                return _c("tr", [
                                  _c("td", [_vm._v(_vm._s(item.id))]),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(item.title))]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(_vm._s(item.muted ? "Yes" : "No")),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(_vm._s(item.spam ? "Yes" : "No")),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      _vm._s(
                                        _vm._f("formatDate")(
                                          item.group_created_at
                                        )
                                      )
                                    ),
                                  ]),
                                ])
                              }),
                            ],
                            2
                          ),
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.items.length
                      ? _c(
                          "div",
                          { staticClass: "text-center p-3 text-muted" },
                          [
                            _c("h5", [_vm._v("No Results")]),
                            _vm._v(" "),
                            _vm.canPullData
                              ? _c("div", [
                                  _c("p", [
                                    _vm._v(
                                      "\n                  Looks like you have not have any group yet!, click button\n                  below to get group list from your number\n                "
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "button",
                                    {
                                      staticClass: "btn btn-info btn-sm",
                                      on: { click: _vm.pullData },
                                    },
                                    [
                                      _vm._v(
                                        "\n                  Pull Data\n                "
                                      ),
                                    ]
                                  ),
                                ])
                              : _c("div", [
                                  _c("p", [
                                    _vm._v(
                                      "\n                Sorry, this feature only available on Startup Package, please\n                upgrade your package\n              "
                                    ),
                                  ]),
                                ]),
                          ]
                        )
                      : _vm._e(),
                  ])
                : _c("div", { staticClass: "text-center p-4 text-muted" }, [
                    _c("h5", [_vm._v("Loading")]),
                    _vm._v(" "),
                    _c("p", [_vm._v("Please wait, data is being loaded...")]),
                  ]),
            ]),
          ]),
          _vm._v(" "),
          _vm.loadingmore
            ? _c("div", { staticClass: "text-center" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary",
                    attrs: { disabled: _vm.loading },
                    on: { click: _vm.fetchData },
                  },
                  [
                    _vm.loading
                      ? _c("span", [
                          _vm._v("Loading "),
                          _c("i", { staticClass: "fas fa-spinner fa-spin" }),
                        ])
                      : _c("span", [_vm._v("Load More")]),
                  ]
                ),
              ])
            : _vm._e(),
        ]),
      ])
    : _vm._e()
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", [_vm._v("ID")]),
      _vm._v(" "),
      _c("th", [_vm._v("Title")]),
      _vm._v(" "),
      _c("th", [_vm._v("Muted")]),
      _vm._v(" "),
      _c("th", [_vm._v("Spam")]),
      _vm._v(" "),
      _c("th", [_vm._v("Created At")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InboxComponent.vue?vue&type=template&id=34b998c2&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InboxComponent.vue?vue&type=template&id=34b998c2& ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.$parent.userCan("manage-inbox")
    ? _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-12" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-header" }, [
              _c("h4", [
                _vm._v("Inbox "),
                _vm.total
                  ? _c("span", [_vm._v("(" + _vm._s(_vm.total) + ")")])
                  : _vm._e(),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card-body p-0" }, [
              !_vm.loading
                ? _c("div", { staticClass: "table-responsive table-invoice" }, [
                    _vm.inbox.length
                      ? _c("table", { staticClass: "table table-striped" }, [
                          _c(
                            "tbody",
                            [
                              _vm._m(0),
                              _vm._v(" "),
                              _vm._l(_vm.inbox, function (item, index) {
                                return _c("tr", [
                                  _c("td", [
                                    _vm._v(
                                      _vm._s(
                                        _vm._f("formatDate")(item.created_at)
                                      )
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(item.device.phone))]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(_vm._s(parseInt(item.from_number))),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(_vm._s(parseInt(item.to_number))),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      _vm._s(
                                        item.msg_type == "ingoing"
                                          ? "Inbox"
                                          : "Outbox"
                                      )
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      class: {
                                        "text-danger": item.status == "ERROR",
                                      },
                                    },
                                    [
                                      _vm._v(
                                        _vm._s(
                                          item.msg_type == "ingoing"
                                            ? "Delivered"
                                            : item.status
                                        ) + " "
                                      ),
                                      item.failed_reason
                                        ? _c(
                                            "span",
                                            {
                                              staticClass:
                                                "text-small text-danger",
                                            },
                                            [
                                              _vm._v(
                                                "(" +
                                                  _vm._s(item.failed_reason) +
                                                  ")"
                                              ),
                                            ]
                                          )
                                        : _vm._e(),
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(item.body))]),
                                ])
                              }),
                            ],
                            2
                          ),
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.inbox.length
                      ? _c(
                          "div",
                          { staticClass: "text-center p-3 text-muted" },
                          [
                            _c("h5", [_vm._v("No Results")]),
                            _vm._v(" "),
                            _c("p", [
                              _vm._v(
                                "Looks like you have not have any inbox yet!"
                              ),
                            ]),
                          ]
                        )
                      : _vm._e(),
                  ])
                : _c("div", { staticClass: "text-center p-4 text-muted" }, [
                    _c("h5", [_vm._v("Loading")]),
                    _vm._v(" "),
                    _c("p", [_vm._v("Please wait, data is being loaded...")]),
                  ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "text-center" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-primary",
                attrs: { disabled: _vm.loading },
                on: { click: _vm.loadInbox },
              },
              [
                _vm.loading
                  ? _c("span", [
                      _vm._v("Loading "),
                      _c("i", { staticClass: "fas fa-spinner fa-spin" }),
                    ])
                  : _c("span", [_vm._v("Load More")]),
              ]
            ),
          ]),
        ]),
      ])
    : _vm._e()
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", [_vm._v("Date")]),
      _vm._v(" "),
      _c("th", [_vm._v("Device")]),
      _vm._v(" "),
      _c("th", [_vm._v("From")]),
      _vm._v(" "),
      _c("th", [_vm._v("To")]),
      _vm._v(" "),
      _c("th", [_vm._v("Type")]),
      _vm._v(" "),
      _c("th", [_vm._v("Delivery Status")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "30%" } }, [_vm._v("Message")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InvoiceComponent.vue?vue&type=template&id=2d1526bb&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/InvoiceComponent.vue?vue&type=template&id=2d1526bb& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.$parent.userCan("manage-invoices")
    ? _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-12" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-header" }, [
              _c("h4", [
                _vm._v("Invoices "),
                _vm.total
                  ? _c("span", [_vm._v("(" + _vm._s(_vm.total) + ")")])
                  : _vm._e(),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "card-header-form" }, [
                _c("div", { staticClass: "input-group" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.query,
                        expression: "query",
                      },
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", placeholder: "Search" },
                    domProps: { value: _vm.query },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.query = $event.target.value
                      },
                    },
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group-btn" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary",
                        on: { click: _vm.search },
                      },
                      [_c("i", { staticClass: "fas fa-search" })]
                    ),
                  ]),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card-body p-0" }, [
              !_vm.loading
                ? _c("div", { staticClass: "table-responsive table-invoice" }, [
                    _vm.invoices.length
                      ? _c("table", { staticClass: "table table-striped" }, [
                          _c(
                            "tbody",
                            [
                              _c("tr", {}, [
                                _c("th", [_vm._v("Invoice Number")]),
                                _vm._v(" "),
                                _vm.$parent.userCan("view-all-invoices")
                                  ? _c("th", [_vm._v("User")])
                                  : _vm._e(),
                                _vm._v(" "),
                                _c("th", [_vm._v("Date")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Due Date")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Product")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Total")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Status")]),
                                _vm._v(" "),
                                _c("th", [_vm._v("Action")]),
                              ]),
                              _vm._v(" "),
                              _vm._l(_vm.invoices, function (item, index) {
                                return _c("tr", { staticClass: "pb-3" }, [
                                  _c("td", [_vm._v(_vm._s(item.code))]),
                                  _vm._v(" "),
                                  _vm.$parent.userCan("view-all-invoices")
                                    ? _c("td", [_vm._v(_vm._s(item.user.name))])
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      _vm._s(
                                        _vm._f("formatDate")(item.created_at)
                                      )
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      _vm._s(
                                        _vm._f("formatDate")(item.due_date)
                                      )
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(_vm._s(item.items[0].item_name)),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(
                                      _vm._s(_vm._f("toCurrency")(item.total))
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _c(
                                      "span",
                                      {
                                        staticClass: "badge text-capitalize",
                                        class: _vm.pairedClass(item),
                                      },
                                      [_vm._v(_vm._s(item.status))]
                                    ),
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    { staticClass: "text-right d-block mb-3" },
                                    [
                                      _c(
                                        "a",
                                        {
                                          staticClass: "btn btn-info",
                                          attrs: {
                                            href: _vm.$parent.MakeUrl(
                                              "secure/invoices/" + item.id
                                            ),
                                          },
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fas fa-file-invoice",
                                          }),
                                          _vm._v(
                                            "\n                                        View invoice\n\n                                    "
                                          ),
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _vm.$parent.userCan(
                                        "view-all-invoices"
                                      ) && item.status === "PENDING"
                                        ? _c(
                                            "button",
                                            {
                                              staticClass: "btn btn-success",
                                              on: {
                                                click: function ($event) {
                                                  return _vm.approve(item)
                                                },
                                              },
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fas fa-check",
                                              }),
                                            ]
                                          )
                                        : _vm._e(),
                                    ]
                                  ),
                                ])
                              }),
                            ],
                            2
                          ),
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.invoices.length
                      ? _c(
                          "div",
                          { staticClass: "text-center p-3 text-muted" },
                          [
                            _c("h5", [_vm._v("No Results")]),
                            _vm._v(" "),
                            _c("p", [
                              _vm._v(
                                "Looks like you have not added any invoices yet!"
                              ),
                            ]),
                          ]
                        )
                      : _vm._e(),
                  ])
                : _c("div", { staticClass: "text-center p-4 text-muted" }, [
                    _c("h5", [_vm._v("Loading")]),
                    _vm._v(" "),
                    _c("p", [_vm._v("Please wait, data is being loaded...")]),
                  ]),
            ]),
          ]),
          _vm._v(" "),
          _vm.invoices.length
            ? _c("div", { staticClass: "text-center" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary",
                    attrs: { disabled: _vm.loading },
                    on: { click: _vm.loadInvoices },
                  },
                  [
                    _vm.loading
                      ? _c("span", [
                          _vm._v("Loading "),
                          _c("i", { staticClass: "fas fa-spinner fa-spin" }),
                        ])
                      : _c("span", [_vm._v("Next Page")]),
                  ]
                ),
              ])
            : _vm._e(),
        ]),
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceComponent.vue?vue&type=template&id=bdbeffec&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceComponent.vue?vue&type=template&id=bdbeffec& ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-12" }, [
      _vm.message
        ? _c("div", { staticClass: "alert alert-primary" }, [
            _vm._v("\n            " + _vm._s(_vm.message) + "\n        "),
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "card" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "card-body text-center" }, [
          _vm.loading
            ? _c(
                "div",
                { staticClass: "spinner-border", attrs: { role: "status" } },
                [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
              )
            : _vm._e(),
          _vm._v(" "),
          !_vm.loading
            ? _c("div", { staticClass: "row justify-content-center" }, [
                _c(
                  "div",
                  { staticClass: "col-xl-4" },
                  [
                    _c("VueQrcode", {
                      attrs: { value: _vm.qrCode, options: { width: 300 } },
                    }),
                  ],
                  1
                ),
              ])
            : _vm._e(),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("h4", [_vm._v("Pairing new device")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=template&id=0f594780&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/PairingDeviceNewComponent.vue?vue&type=template&id=0f594780& ***!
  \*************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "body-inner", staticStyle: { position: "relative" } },
    [
      _c("div", { staticClass: "header-green" }),
      _vm._v(" "),
      _c("div", { staticClass: "card card-pairing" }, [
        _c("div", { staticClass: "card-body" }, [
          _c("div", { staticClass: "row" }, [
            _vm._m(0),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-6 text-center" }, [
              _c("img", { staticClass: "img-fluid", attrs: { src: _vm.qr } }),
              _vm._v(" "),
              _c("p", { staticClass: "text-small" }, [
                _vm._v(
                  "This page will refresh on " +
                    _vm._s(_vm.timeout) +
                    " seconds"
                ),
              ]),
            ]),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c("div", {}),
    ]
  )
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6" }, [
      _c("h5", { staticClass: "mb-5" }, [_vm._v("To use Whatspie you needs:")]),
      _vm._v(" "),
      _c("p", [_vm._v("1. Open WhatsApp on Your Phone")]),
      _vm._v(" "),
      _c("p", [_vm._v("2. Tap menu or Setting and select WhatsApp Web")]),
      _vm._v(" "),
      _c("p", [
        _vm._v("2. Point your phone to this screen to capture the code"),
      ]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProfileComponent.vue?vue&type=template&id=a8276c82&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProfileComponent.vue?vue&type=template&id=a8276c82& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-12" }, [
      _vm.message
        ? _c("div", { staticClass: "alert alert-primary" }, [
            _vm._v("\n            " + _vm._s(_vm.message) + "\n        "),
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "card" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "card-body" }, [
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Name")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.name,
                    expression: "name",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.name },
                attrs: { type: "text" },
                domProps: { value: _vm.name },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.name = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.name
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [_vm._v(_vm._s(_vm.errors.name[0]))]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Email")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.email,
                    expression: "email",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.email },
                attrs: { type: "text", readonly: "" },
                domProps: { value: _vm.email },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.email = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.email
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [_vm._v(_vm._s(_vm.errors.email[0]))]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _vm.$parent.userCan("edit-users") && !_vm.getUserdata("isme")
            ? _c("div", { staticClass: "form-group row mb-4" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-form-label text-md-right col-12 col-md-3 col-lg-3",
                  },
                  [_vm._v("Role")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-12 col-md-7" }, [
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.role,
                          expression: "role",
                        },
                      ],
                      staticClass: "form-control",
                      class: { "is-invalid": _vm.errors.role },
                      on: {
                        change: function ($event) {
                          var $$selectedVal = Array.prototype.filter
                            .call($event.target.options, function (o) {
                              return o.selected
                            })
                            .map(function (o) {
                              var val = "_value" in o ? o._value : o.value
                              return val
                            })
                          _vm.role = $event.target.multiple
                            ? $$selectedVal
                            : $$selectedVal[0]
                        },
                      },
                    },
                    _vm._l(_vm.roles, function (role) {
                      return _c("option", { domProps: { value: role.id } }, [
                        _vm._v(_vm._s(role.name)),
                      ])
                    }),
                    0
                  ),
                  _vm._v(" "),
                  _vm.errors.role
                    ? _c("div", { staticClass: "invalid-feedback" }, [
                        _c("p", [_vm._v(_vm._s(_vm.errors.role[0]))]),
                      ])
                    : _vm._e(),
                ]),
              ])
            : _vm._e(),
          _vm._v(" "),
          !_vm.$parent.userCan("edit-users")
            ? _c("div", { staticClass: "form-group row mb-4" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-form-label text-md-right col-12 col-md-3 col-lg-3",
                  },
                  [_vm._v("Current Password")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-12 col-md-7" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.current_password,
                        expression: "current_password",
                      },
                    ],
                    staticClass: "form-control",
                    class: { "is-invalid": _vm.errors.current_password },
                    attrs: {
                      type: "password",
                      autocomplete: "new-password",
                      placeholder: "Current password",
                    },
                    domProps: { value: _vm.current_password },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.current_password = $event.target.value
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm.errors.current_password
                    ? _c("div", { staticClass: "invalid-feedback" }, [
                        _c("p", [
                          _vm._v(_vm._s(_vm.errors.current_password[0])),
                        ]),
                      ])
                    : _vm._e(),
                ]),
              ])
            : _vm._e(),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Password")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.password,
                    expression: "password",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.password },
                attrs: {
                  type: "password",
                  autocomplete: "new-password",
                  placeholder:
                    "New password (Only if you want to change the password)",
                },
                domProps: { value: _vm.password },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.password = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.password
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [_vm._v(_vm._s(_vm.errors.password[0]))]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Confirm Password")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.password_confirmation,
                    expression: "password_confirmation",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.password_confirmation },
                attrs: { type: "password", autocomplete: "new-password" },
                domProps: { value: _vm.password_confirmation },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.password_confirmation = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.password_confirmation
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [
                      _vm._v(_vm._s(_vm.errors.password_confirmation[0])),
                    ]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("API Key")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("code", [_vm._v(_vm._s(_vm.token))]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c("label", {
              staticClass:
                "col-form-label text-md-right col-12 col-md-3 col-lg-3",
            }),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { disabled: _vm.loading },
                  on: { click: _vm.updateUser },
                },
                [
                  _vm.loading
                    ? _c("span", [_vm._v("Updating")])
                    : _c("span", [_vm._v("Update")]),
                ]
              ),
            ]),
          ]),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("h4", [_vm._v("Update Profile")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/SendMessageComponent.vue?vue&type=template&id=57456a49&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/SendMessageComponent.vue?vue&type=template&id=57456a49& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-12" }, [
      _c("div", { staticClass: "card" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "card-body" }, [
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Receiver")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.receiver,
                    expression: "receiver",
                  },
                ],
                staticClass: "form-control",
                class: { "is-invalid": _vm.errors.receiver },
                attrs: {
                  type: "number",
                  placeholder: "Receiver phone number eg (6285603051722)",
                },
                domProps: { value: _vm.receiver },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.receiver = $event.target.value
                  },
                },
              }),
              _vm._v(" "),
              _vm.errors.receiver
                ? _c("div", { staticClass: "invalid-feedback" }, [
                    _c("p", [_vm._v(_vm._s(_vm.errors.receiver[0]))]),
                  ])
                : _vm._e(),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-form-label text-md-right col-12 col-md-3 col-lg-3",
              },
              [_vm._v("Message")]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c("textarea", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.message,
                    expression: "message",
                  },
                ],
                staticClass: "form-control",
                domProps: { value: _vm.message },
                on: {
                  input: function ($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.message = $event.target.value
                  },
                },
              }),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-group row mb-4" }, [
            _c("label", {
              staticClass:
                "col-form-label text-md-right col-12 col-md-3 col-lg-3",
            }),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-12 col-md-7" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { disabled: _vm.loading },
                  on: { click: _vm.sendMessage },
                },
                [
                  _vm.loading
                    ? _c("span", [_vm._v("Adding")])
                    : _c("span", [_vm._v("Send Message")]),
                ]
              ),
            ]),
          ]),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("h4", [_vm._v("Send Message")]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UsersComponent.vue?vue&type=template&id=47d47080&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UsersComponent.vue?vue&type=template&id=47d47080& ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.$parent.userCan("manage-users")
    ? _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-12" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-header" }, [
              _c("h4", [
                _vm._v("Users "),
                _vm.total
                  ? _c("span", [_vm._v("(" + _vm._s(_vm.total) + ")")])
                  : _vm._e(),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "card-header-action" }, [
                _c("div", { staticClass: "input-group" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.query,
                        expression: "query",
                      },
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", placeholder: "Search" },
                    domProps: { value: _vm.query },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.query = $event.target.value
                      },
                    },
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group-btn" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary",
                        on: { click: _vm.search },
                      },
                      [_c("i", { staticClass: "fas fa-search" })]
                    ),
                  ]),
                ]),
                _vm._v(" "),
                _vm.$parent.userCan("create-users")
                  ? _c(
                      "a",
                      {
                        staticClass: "btn btn-primary",
                        attrs: {
                          href: _vm.$parent.MakeUrl("secure/users/create"),
                        },
                      },
                      [_vm._v("Add "), _c("i", { staticClass: "fas fa-plus" })]
                    )
                  : _vm._e(),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card-body p-0" }, [
              !_vm.loading
                ? _c("div", { staticClass: "table-responsive table-invoice" }, [
                    _vm.users.length
                      ? _c("table", { staticClass: "table table-striped" }, [
                          _c(
                            "tbody",
                            [
                              _vm._m(0),
                              _vm._v(" "),
                              _vm._l(_vm.users, function (user, index) {
                                return _c("tr", { key: index }, [
                                  _c("td", [_vm._v(_vm._s(user.name))]),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(user.phone_number))]),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(user.email))]),
                                  _vm._v(" "),
                                  _c("td", [_vm._v(_vm._s(user.created_at))]),
                                  _vm._v(" "),
                                  _c("td", { staticClass: "text-right" }, [
                                    _vm.$parent.userCan("delete-users") &&
                                    !user.isme
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn btn-danger",
                                            on: {
                                              click: function ($event) {
                                                return _vm.deleteUser(
                                                  user.id,
                                                  index
                                                )
                                              },
                                            },
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-trash",
                                            }),
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$parent.userCan("edit-users") &&
                                    !user.isme
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn btn-warning",
                                            on: {
                                              click: function ($event) {
                                                return _vm.loginAs(
                                                  user.id,
                                                  index
                                                )
                                              },
                                            },
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-user",
                                            }),
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$parent.userCan("edit-users")
                                      ? _c(
                                          "a",
                                          {
                                            staticClass: "btn btn-primary",
                                            attrs: { href: user.profilelink },
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-edit",
                                            }),
                                          ]
                                        )
                                      : _vm._e(),
                                  ]),
                                ])
                              }),
                            ],
                            2
                          ),
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.users.length
                      ? _c(
                          "div",
                          { staticClass: "text-center p-3 text-muted" },
                          [
                            _c("h5", [_vm._v("No Results")]),
                            _vm._v(" "),
                            _c("p", [
                              _vm._v(
                                "Looks like you have not added any users yet!"
                              ),
                            ]),
                          ]
                        )
                      : _vm._e(),
                  ])
                : _c("div", { staticClass: "text-center p-4 text-muted" }, [
                    _c("h5", [_vm._v("Loading")]),
                    _vm._v(" "),
                    _c("p", [_vm._v("Please wait, data is being loaded...")]),
                  ]),
            ]),
          ]),
          _vm._v(" "),
          _vm.users.length && _vm.total > _vm.users.length
            ? _c("div", { staticClass: "text-center" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary",
                    attrs: { disabled: _vm.loading },
                    on: { click: _vm.loadUsers },
                  },
                  [
                    _vm.loading
                      ? _c("span", [
                          _vm._v("Loading "),
                          _c("i", { staticClass: "fas fa-spinner fa-spin" }),
                        ])
                      : _c("span", [_vm._v("Load More")]),
                  ]
                ),
              ])
            : _vm._e(),
        ]),
      ])
    : _vm._e()
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", [_vm._v("Name")]),
      _vm._v(" "),
      _c("th", [_vm._v("Phone Number")]),
      _vm._v(" "),
      _c("th", [_vm._v("Email")]),
      _vm._v(" "),
      _c("th", [_vm._v("Reg. Date")]),
      _vm._v(" "),
      _c("th"),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "?ac64":
/*!********************!*\
  !*** ws (ignored) ***!
  \********************/
/***/ (() => {

/* (ignored) */

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["css/app","/js/vendor"], () => (__webpack_exec__("./resources/js/app.js"), __webpack_exec__("./resources/sass/app.scss")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);