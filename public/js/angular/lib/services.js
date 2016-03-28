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

	icaav.helpers.getFormData = function(jsonData) {
		var formData = new FormData();
		for(var i in jsonData) {
			formData.append(i, jsonData[i]);
		}

		return formData;
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

	return icaav;

})();
