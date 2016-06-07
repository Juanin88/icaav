icaavModule.controller('OrigenVentaController', ['$scope', '$http', '$translate', '$translatePartialLoader', 'NgTableParams', '$filter', function($scope, $http, $translate, $translatePartialLoader, NgTableParams, $filter) {

	$scope.httpForm = new icaav.services.HTTPForm($http);
	$scope.toastr 	= new icaav.helpers.ToastTranslate($translate);
	$scope.basePath = icaav.helpers.getBasePath();
	$scope.origenesVenta = [];
	$scope.idDeleteOrigenVenta = null;
	$scope.origenVenta = {};
	$scope.isCreating = null;
	$scope.tableOrigenVenta = null;
	$scope.page = 1;
  	$scope.countPerPage = 5;
  	$scope.searchingOrigenesVenta = false;
  	$scope.cols = {
      nombre_origen_venta:  { name: 'CORPORATE.NAME_OF_CORPORATIVE', show: true },
    };

	$translatePartialLoader.addPart('origen-venta');
  	$translate.refresh();

	$scope.prepareDeleteOrigenVenta = function(idOrigenVenta) {
		$scope.idDeleteOrigenVenta = idOrigenVenta;
		$('#modalDeleteOrigenVenta').modal('show');
	};

	$scope.createOrigenVenta = function() {
		$scope.httpForm.post($scope.basePath +'/icaav/origen-venta/add-origen-venta', $scope.origenVenta)
		.success(function(data){
			if (data['@pr_affect_rows'] == 1) {
				$scope.getOrigenesVenta();
				$('#modalOrigenVenta').modal ('hide');
				$scope.toastr.success('Origen de venta cread correctamente.');
			} else{
					console.log('No se puede eliminar el registro ya que no existe.');
				}
			});	
		};

		$scope.updateOrigenVenta = function() {
			$scope.httpForm.post($scope.basePath + '/icaav/origen-venta/edit-origen-venta' , $scope.origenVenta)
			.success(function(data){
				if (data['@pr_affect_rows'] == 1) {
					$scope.getOrigenesVenta() ;
					$('#modalOrigenVenta').modal('hide');
					$scope.toastr.success('Origen de venta actualizado correctamente');
				} else {
					console.log('No se pudo elimiar el refistro no existe');
				}
				});
			};
		
		$scope.optionSubmitOrigenVenta = function() {
			if($scope.isCreating) {
				$scope.createOrigenVenta();
			} else {
				$scope.updateOrigenVenta();
			}
		  };

		   $scope.prepareCreationOrigenVenta = function() {
    	   $scope.isCreating = true;
    	   $('#modalOrigenVenta').modal('show');
		  };

		  $scope.prepareUpdatingOrigenVenta = function(origenVenta) {
		  	$scope.origenVenta = new Object(origenVenta);
		  	$scope.isCreating = false;
		  	$('#modalOrigenVenta').modal('show');
		  };

		  $scope.getOrigenesVenta = function() {
		  	$scope.searchingOrigenesVenta = true;
		  	$scope.httpForm.post($scope.basePath + '/icaav/origen-venta/get-origen-venta', {
		  		pr_ini_pag: 0,
		  		pr_fin_pag: 2
		  	})
		  	.success(function(data){
		  		$scope.searchingOrigenesVenta = false;
		  		$scope.tableOrigenVenta = new NgTableParams({
		            page: $scope.page,
		            count: $scope.countPerPage
		          }, {
		            filterSwitch: true,
		            counts: [5, 10, 50 ,100],
		            paginationMaxBlocks: 4,
		            paginationMinBlocks: 1,
		            getData: function(params) {
		              filteredData    = params.filter()  ? $filter('filter')($scope.origenesVenta, params.filter()) : $scope.origenesVenta;
		              orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
		              $scope.filteredOrigenesVenta = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
		              params.total(orderedData.length);
		              $scope.page = params.page();
		              $scope.countPerPage = params.count();
		              return $scope.filteredOrigenesVenta;
		            }
		        });
		  		$scope.origenesVenta = data.results;
		  	});
		  };

  $scope.deleteOrigenVenta = function() {
    $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/delete-origen-venta',{
      pr_id_orig: $scope.idDeleteOrigenVenta
    })
    .success(function (data){
      if(data['@pr_affect_rows'] == 1) {
        $scope.getOrigenesVenta();
        $('#modalDeleteOrigenVenta').modal('hide');
        $scope.toastr.success('!!!!!!!!!Origen de venta eliminado correctamente!!');
      } else {
        console.log('!!!!!!!No se pudo eliminar porque el registro no existe!!');
      }
    });
  };

}]);