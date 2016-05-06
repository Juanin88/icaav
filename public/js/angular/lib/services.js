/**
* List generics services that use any angular controller
* This scripts require
* - angular
* - implement with angular variables
*
* @author Alan Olivares
*/
'use strict'
var icaav = (function () {

	var basePath = 'Base path is not defined use: icaav.helpers.setBasePath';
	var icaav = {
		services: {},
		helpers: {},
		angular_filters: {},
	};

	icaav.services.HTTPForm = function($http) {

		function _callHTTP(data) {
			return $http({
	            url: data.url,
	            method: data.method,
	            data: icaav.helpers.getFormData(data.data),
	            headers: {
	                'Content-Type'  : undefined,
	            }
	        })
		}

		this.get 	= function(uploadURI, data) {
			return _callHTTP({
				url: uploadURI,
				data: data,
				method: 'GET',
			});
		};

		this.post 	= function(uploadURI, data) {
			return _callHTTP({
				url: uploadURI,
				data: data,
				method: 'POST',
			});
		};

		this.put 	= function(uploadURI, data) {
			return _callHTTP({
				url: uploadURI,
				data: data,
				method: 'PUT',
			});
		};

		this.delete = function(uploadURI, data) {
			return _callHTTP({
				url: uploadURI,
				data: data,
				method: 'DELETE',
			});
		};

	};

	icaav.services.Location = function($location) {

		this.path = function(url) {
			$location.path(icaav.helpers.getBasePath() + url);
		};

	};

	icaav.helpers.getFormData = function(jsonData) {
		var formData = new FormData();
		for(var i in jsonData) {
			formData.append(i, jsonData[i]);
		}

		return formData;
	};

	icaav.helpers.ToastTranslate = function($translate) {

		toastr.options = {
			"closeButton": true,
		}

		this.success = function(CODE) {
			$translate(CODE).then(toastr.success);
		};
		this.info = function() {
			$translate(CODE).then(toastr.info);
		};
		this.warning = function() {
			$translate(CODE).then(toastr.warning);
		};
		this.error = function() {
			$translate(CODE).then(toastr.error);
		};

	};

	icaav.helpers.getArrayCopy = function(array) {
		return array ? array.slice() : [];
	};

	icaav.helpers.setBasePath = function(path) {
		return basePath = path;
	};

	icaav.helpers.getBasePath = function() {
		return basePath;
	};

	icaav.angular_filters.paginate = function() {
		return function(inputs, start, end) {
			return inputs ? inputs.slice(start, end) : [];
		};
	};

	icaav.angular_filters.sortBy = function() {
		return function(inputs, by) {
			return inputs ? inputs.sort(function(a, b) {
				
			}) : [];
		};
	};

	return icaav;

})();

