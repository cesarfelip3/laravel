window.SlcFormErrors = function () {
    this.errors = {};

    this.hasErrors = function () {
        return ! _.isEmpty(this.errors);
    };

    this.has = function (field) {
        return _.indexOf(_.keys(this.errors), field) > -1;
    };

    this.all = function () {
        return this.errors;
    };

    this.flatten = function () {
        return _.flatten(_.toArray(this.errors));
    };

    this.get = function (field) {
        if (this.has(field)) {
            return this.errors[field][0];
        }
    };

    this.set = function (errors) {
        if (typeof errors === 'object') {
            this.errors = errors;
        } else {
            this.errors = {'form': ['Something went wrong. Please try again or contact customer support.']};
        }
    };

    this.forget = function (field) {
        if (typeof field === 'undefined') {
            this.errors = {};
        } else {
            Vue.delete(this.errors, field);
        }
    };
};
