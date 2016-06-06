icaavModule.controller('OrigenVentaController', ['$scope', '$http', '$translate', function($scope, $http, $translate) {

  $scope.httpForm = new icaav.services.HTTPForm($http);
  $scope.toastr   = new icaav.helpers.ToastTranslate($translate);
  $scope.basePath = icaav.helpers.getBasePath();
  $scope.origenesVenta = [];
  $scope.idDeleteOrigenVenta = null;
  $scope.origenVenta = {};
  $scope.isCreating = null;

  $scope.prepareDeleteOrigenVenta = function(idOrigenVenta) {
    $scope.idDeleteOrigenVenta = idOrigenVenta;
    $('#modalDeleteOrigenVenta').modal('show');
  };

  $scope.createOrigenVenta = function() {
    $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/add-origen-venta', $scope.origenVenta)
    .success(function(data) {
      if(data['@pr_affect_rows'] == 1) {
        $scope.getOrigenesVenta();
        $('#modalOrigenVenta').modal('hide');
        $scope.toastr.success('Origen de venta creado correctamente!!');
      } else {
        console.log('No se pudo eliminar porque el registro no existe!!');
      }
    });
  };

  $scope.updateOrigenVenta = function() {
    $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/edit-origen-venta', $scope.origenVenta)
    .success(function(data) {
      if(data['@pr_affect_rows'] == 1) {
        $scope.getOrigenesVenta();
        $('#modalOrigenVenta').modal('hide');
        $scope.toastr.success('Origen de venta actualizado correctamente!!');
      } else {
        console.log('No se pudo eliminar porque el registro no existe!!');
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
    $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/get-origen-venta')
    .success(function(data) {
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
        $scope.toastr.success('Origen de venta eliminado correctamente!!');
      } else {
        console.log('No se pudo eliminar porque el registro no existe!!');
      }
    });
  };

}]);