icaavModule.controller('UnidadNegocioController', ['$scope', '$http', '$translate', '$translatePartialLoader', 'NgTableParams', '$filter', function($scope, $http, $translate, $translatePartialLoader, NgTableParams, $filter) {

	$scope.httpForm = new icaav.services.HTTPForm($http);
	$scope.toastr   = new icaav.helpers.Toastr.ToastTranslate($translate);
	$scope.basePath = new icaav.helpers.getBasePath();
	$scope.unidadNegocio =[];
	$scope.idDeleteUnidadNegocio = null;
	$scope.unidadNegocio = {};
	$scope.isCreating  = null;
	$scope.tableUnidadNegocio = null;
	$scope.page = 1;
	$scope.countPerPAge = 5;
	$scope.searchingUnidadNegocio = false;
	$scope.cols = {
		nombre_unidad_negocio: { name:'CORPORATE.NAME_OF_UNIDAD_NEGOCIO', show: true },
	};

	$translatePartialLoader.addPart	('unidad_negocio');
	$translate.refresh();

	$scope.prepareDeleteUnidadNegocio = function(idUnidadNegocio) {
		$scope.idDeleteUnidadNegocio = idUnidadNegocio;
		$('#modalDeleteUnidadNegocio').modal('show');
	};

	$scope.createUnidadNegocio = function() {
		$scope.httpForm.post($scope.basePath + '/icaav/unidad-venta/add-unidad-negocio', $scope.unidadNegocio)
		.success(function(data){
			if(data['@pr_affect_rows'] == 1) {
				$scope.getUnidadNegocio();
				$('#modalUnidadNegocio').modal ('hide');
				$scope.toastr.success('Unidad de Venta creado correctamente.');
			} else {
				console.log('No se puede eliminar la Unidad de Negocio ya que no existe.');
			}
		});
	};

	$scope.updateUnidadNegocio = function(){
		$scope.httpForm.post($scope.basePath + '/icaav/unidad-negocio/edit-unidad-negocio' , $scope.unidadNegocio)
		.success(function(data){
			if (data['@pr_affect_rows'] == 1) {
				$scope.getUnidadNegocio() ;
				$('#modalUnidadNegocio').modal('hide');
				$scope.toastr.success('Unidad de Negocio actualizado Correctamente');
			} else {
				console.log('No se puede eliminar la Unidad de Negocio no existe')
			}
		});
	};

	$scope.optionSubmitUnidadNegocio = function() {
		if($scope.isCreating) {
			$scope.createUnidadNegocio();
		} else {
			$scope.updateUnidadNegocio();
		}
	};

	$scope.prepareCreationUnidadNegocio = function() {
		$scope.isCreating = true;
		$('#modalUnidadNegocio'),modal('show');
	};

	$scope.prepareUpdatingUnidadNegocio = function(unidadNegocio) {
		$scope.unidadNegocio = new Object(unidadNegocio);
		$scope.isCreating = false;
		$('#modalUnidadNegocio').modal('show');
	};

	$scope.getUnidadNegocio = function() {
		  	$scope.searchingUnidadNegocio = true;
		  	$scope.httpForm.post($scope.basePath + '/icaav/origen-venta/get-unidad-negocio', {
		  		pr_ini_pag: 0,
		  		pr_fin_pag: 2
		  	})
		  	.success(function(data){
		  		$scope.searchingUnidadNegocio= false;
		  		$scope.tableUnidadNegocio = new NgTableParams({
		            page: $scope.page,
		            count: $scope.countPerPage
		          }, {
		            filterSwitch: true,
		            counts: [5, 10, 50 ,100],
		            paginationMaxBlocks: 4,
		            paginationMinBlocks: 1,
		            getData: function(params) {
		              filteredData    = params.filter()  ? $filter('filter')($scope.unidadNegocio, params.filter()) : $scope.unidadNegocio;
		              orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
		              $scope.filteredUnidadNegocio = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
		              params.total(orderedData.length);
		              $scope.page = params.page();
		              $scope.countPerPage = params.count();
		              return $scope.filteredUnidadNegocio;
		            }
		        });
		  		$scope.unidadNegocio = data.results;
		  	});
		  };

  $scope.deleteUnidadNegocio = function() {
    $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/delete-unidad-negocio',{
      pr_id_orig: $scope.idDeleteUnidadNegocio
    })
    .success(function (data){
      if(data['@pr_affect_rows'] == 1) {
        $scope.getUnidadNegocio();
        $('#modalDeleteUnidadNegocio').modal('hide');
        $scope.toastr.success('!Unidad de Negocioeliminado correctamente!!');
      } else {
        console.log('!No se elimino porque el registro no existe!!');
      }
    });
  };

}]);



