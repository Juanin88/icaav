icaavModule.controller('TipoProveedorController', ['$scope', '$http', '$translate', '$translatePartialLoader', 'NgTableParams', '$filter', function($scope, $http, $translate, $translatePartialLoader, NgTableParams, $filter) {

	$scope.httpForm = new icaav.services.HTTPForm($http);
	$scope.toastr 	= new icaav.helpers.ToastTranslate($translate);
	$scope.basePath = icaav.helpers.getBasePath();
	$scope.tiposProveedor = [];
	$scope.idDeleteTipoProveedor = null;
	$scope.tipoProveedor = {};
	$scope.isCreating = null;
	$scope.tableTipoProveedor = null;
	$scope.page = 1;
 	$scope.countPerPage = 5;
  	$scope.searchingTipoProveedor = false;
  	$scope.cols = {
      nombre_tipo_proveedor:  { name: 'CORPORATE.NAME_OF_CORPORATIVE', show: true },
    };

	$translatePartialLoader.addPart('tipo-proveedor');
  $translate.refresh();

	$scope.prepareDeleteTipoProveedor = function(idTipoProveedor) {
		$scope.idDeleteTipoProveedor = idTipoProveedor;
		$('#modalDeleteTipoProveedor').modal('show');
	};

	$scope.createTipoProveedor = function() {
		$scope.httpForm.post($scope.basePath +'/icaav/tipo-proveedor/add-tipo-proveedor', $scope.tipoProveedor)
		.success(function(data){
			if (data['@pr_affect_rows'] == 1) {
				$scope.tipoProveedor = {};
				$scope.getTiposProveedor();
				$('#modalTipoProveedor').modal ('hide');
				$scope.toastr.success('Tipo proveedor se creo correctamente.');
			} else{
					console.log('No se puede eliminar el registro ya que no existe.');
				}
			});
		};

		$scope.updateTipoProveedor = function() {
			$scope.httpForm.post($scope.basePath + '/icaav/tipo-proveedor/edit-tipo-proveedor' , $scope.tipoProveedor)
			.success(function(data){
				if (data['@pr_affect_rows'] == 1) {
					$scope.getTiposProveedor() ;
					$('#modalTipoProveedor').modal('hide');
					$scope.toastr.success('Tipo proveedor actualizado correctamente');
				} else {
					console.log('No se puede eliminar el registro no existe');
				}
			});
		};

		$scope.optionSubmitTipoProveedor = function() {
			if($scope.isCreating) {
				$scope.createTipoProveedor();
			} else {
				$scope.updateTipoProveedor();
			}
		  };

		   $scope.prepareCreationTipoProveedor = function() {
    	   $scope.isCreating = true;
    	   $('#modalTipoProveedor').modal('show');
		  };

		  $scope.prepareUpdatingTipoProveedor = function(tipoProveedor) {
		  	$scope.tipoProveedor = new Object(tipoProveedor);
		  	$scope.isCreating = false;
		  	$('#modalTipoProveedor').modal('show');
		  };

		  $scope.getTiposProveedor = function() {
		  	$scope.searchingTiposProveedor = true;
		  	$scope.httpForm.post($scope.basePath + '/icaav/tipo-proveedor/get-tipo-proveedor', {
		  		pr_ini_pag: 0,
		  		pr_fin_pag: 100
		  	})
		  	.success(function(data){
		  		$scope.searchingTiposProveedor = false;
		  		$scope.tableTipoProveedor = new NgTableParams({
		            page: $scope.page,
		            count: $scope.countPerPage
		          }, {
		            filterSwitch: true,
		            counts: [5, 10, 50 ,100],
		            paginationMaxBlocks: 4,
		            paginationMinBlocks: 1,
		            getData: function(params) {
		              filteredData    = params.filter()  ? $filter('filter')($scope.tiposProveedor, params.filter()) : $scope.tiposProveedor;
		              orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
		              $scope.filteredTiposProveedor = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
		              params.total(orderedData.length);
		              $scope.page = params.page();
		              $scope.countPerPage = params.count();
		              return $scope.filteredTiposProveedor;
		            }
		        });
		  		$scope.tiposProveedor = data.results;
		  	});
		  };

  $scope.deleteTipoProveedor = function() {
    $scope.httpForm.post($scope.basePath + '/icaav/tipo-proveedor/delete-tipo-proveedor',{
      pr_id_tipo_proveedor: $scope.idDeleteTipoProveedor
    })
    .success(function (data){
      if(data['@pr_affect_rows'] == 1) {
        $scope.getTiposProveedor();
        $('#modalDeleteTipoProveedor').modal('hide');
        $scope.toastr.success('Tipo proveedor eliminado exitosamente.');
      } else {
        console.log('No se elimino porque el registro no existe');
      }
    });
  };

}]);
