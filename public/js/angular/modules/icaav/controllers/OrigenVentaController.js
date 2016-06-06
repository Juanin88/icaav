icaavModule.controller('OrigenVentaController', ['$scope', '$http', function($scope, $http) {

  $scope.httpForm = new icaav.services.HTTPForm($http);
  //$scope.location = new icaav.services.Location($location);
  //$scope.toastr   = new icaav.helpers.ToastTranslate($translate);
  $scope.basePath = icaav.helpers.getBasePath();

  $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/get-origen-venta')
  .success(function(data) {
    console.log(data);
  });

  $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/add-origen-venta', {
    pr_orig_ven: 'test01'
  })
  .success(function(data) {
    console.log(data);
  });

  $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/delete-origen-venta',{
    pr_id_orig: '5'
  })
  .success(function (data){
    console.log(data);
  });

  $scope.httpForm.post($scope.basePath + '/icaav/origen-venta/update-origen-venta',{
    pr_id_orig: , pr_orig_ven  
  })

}]);