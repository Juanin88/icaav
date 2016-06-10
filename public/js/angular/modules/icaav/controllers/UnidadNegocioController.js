icaavModule.controller('UnidadNegocioController', ['$scope', '$http', '$translate', '$translatePartialLoader', 'NgTableParams', '$filter', function($scope, $http, $translate, $translatePartialLoader, NgTableParams, $filter) {

	$scope.httpForm = new icaav.services.HTTPForm($http);
	$scope.toastr 	= new icaav.helpers.ToastTranslate($translate);
	$scope.basePath = icaav.helpers.getBasePath();
	$scope.unidadesNegocio =[];
	$scope.idDeleteUnidadNegocio = null;
	$scope.unidadNegocio = {};
	$scope.isCreating  = null;
	$scope.tableUnidadNegocio = null;
	$scope.page = 1;
	$scope.countPerPage = 5;
	$scope.searchingUnidadesNegocio = false;
	$scope.cols = {
	  nombre_unidad_negocio: { name: 'CORPORATE.NAME_OF_CORPORATIVE', show: true },
	};

	$translatePartialLoader.addPart('unidad-negocio');
	$translate.refresh();

  	$scope.prepareDeleteUnidadNegocio = function(idUnidadNegocio) {
		$scope.idDeleteUnidadNegocio = idUnidadNegocio;
		$('#modalDeleteUnidadNegocio').modal('show');
	};

	$scope.createUnidadNegocio = function() {
		$scope.httpForm.post($scope.basePath + '/icaav/unidad-negocio/add-unidad-negocio', $scope.unidadNegocio)
		.success(function(data){
			if(data['@pr_affect_rows'] == 1) {
				$scope.unidadNegocio = {};
				$scope.getUnidadesNegocio();
				$('#modalUnidadNegocio').modal ('hide');
				$scope.toastr.success('La unidad de negocio fue creado correctamente.');
			} else {
				console.log('No se puede eliminar la unidad de Negocio ya que no existe.');
			}
		});
	};

	$scope.updateUnidadNegocio = function(){
		$scope.httpForm.post($scope.basePath + '/icaav/unidad-negocio/edit-unidad-negocio' , $scope.unidadNegocio)
		.success(function(data){
			if (data['@pr_affect_rows'] == 1) {
				$scope.getUnidadesNegocio() ;
				$('#modalUnidadNegocio').modal('hide');
				$scope.toastr.success('Unidad de negocio actualizado correctamente');
			} else {
				console.log('No se puede eliminar la unidad de negocio ya que no existe')
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
		$('#modalUnidadNegocio').modal('show');
	};

	$scope.prepareUpdatingUnidadNegocio = function(unidadNegocio) {
		$scope.unidadNegocio = new Object(unidadNegocio);
		$scope.isCreating = false;
    	$('#modalUnidadNegocio').modal('show');
	};

	$scope.getUnidadesNegocio = function() {
		  	$scope.searchingUnidadesNegocio = true;
		  	$scope.httpForm.post($scope.basePath + '/icaav/unidad-negocio/get-unidad-negocio', {
		  		pr_ini_pag: 0,
		  		pr_fin_pag: 100
		  	})
		  	.success(function(data){
		  		$scope.searchingUnidadesNegocio= false;
		  		$scope.tableUnidadNegocio = new NgTableParams({
		            page: $scope.page,
		            count: $scope.countPerPage
		          }, {
		            filterSwitch: true,
		            counts: [5, 10, 50 ,100],
		            paginationMaxBlocks: 4,
		            paginationMinBlocks: 1,
		            getData: function(params) {
		              filteredData    = params.filter()  ? $filter('filter')($scope.unidadesNegocio, params.filter()) : $scope.unidadesNegocio;
		              orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
		              $scope.filteredUnidadesNegocio = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
		              params.total(orderedData.length);
		              $scope.page = params.page();
		              $scope.countPerPage = params.count();
		              return $scope.filteredUnidadesNegocio;
		            }
		        });
		  		$scope.unidadesNegocio = data.results;
		  	});
		  };

  $scope.deleteUnidadNegocio = function() {
    $scope.httpForm.post($scope.basePath + '/icaav/unidad-negocio/delete-unidad-negocio',{
      pr_id_uni_neg: $scope.idDeleteUnidadNegocio
    })
    .success(function (data){
      if(data['@pr_affect_rows'] == 1) {
        $scope.getUnidadesNegocio();
        $('#modalDeleteUnidadNegocio').modal('hide');
        $scope.toastr.success('Unidad de negocio eliminado correctamente!!');
      } else {
        console.log('!No se elimino porque el registro no existe');
      }
    });
  };

}]);
