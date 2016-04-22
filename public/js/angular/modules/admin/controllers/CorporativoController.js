admin.controller('CorporativoController', ['$scope', '$http', '$localStorage', '$location', '$timeout', 'NgTableParams', 'CorporativoService', '$filter', function($scope, $http, $localStorage, $location, $timeout, NgTableParams, CorporativoService, $filter) {

  $scope.httpForm = new icaav.services.HTTPForm($http);
  $scope.location = new icaav.services.Location($location);
  $scope.page = 1;
  $scope.countPerPage = 5;
  $scope.corporativoEdit = {};
  /*
  $scope.vars = $localStorage.$default({
    corporativoAdd: {
      id_corporativo:  '',
      nombre_corporativo: '',
      limite_credito: '',
      estatus_corporativo: false,
    }
  });
  */
  $scope.tableCorporativos = null;
  $scope.cols = {
      nombre_corporativo: {name: 'Nombre corporativo', show: true},
      limite_credito: {name: 'Limite de credito', show: true},
      estatus_corporativo: {name: 'Estatus del corporativo', show: true},
    };
  $scope.disabledCols = false;
  $scope.corporativos = [];
  $scope.filteredCorporativos = [];
  $scope.searchingCorporativos = false;
  $scope.corporativo = {};
  $scope.optionsCorporativo = {
    create: true
  };
  $scope.deleteIdCorporativo = null;

  $scope.setDataEditCorportativo = function(corporativo) {
    $scope.corporativoEdit = new Object(corporativo);
    $scope.corporativoEdit.estatus_corporativo = $scope.corporativoEdit.estatus_corporativo == 1;
  };

  $scope.verify = function() {
    count = 0
    angular.forEach(Object.keys($scope.cols), function(value, key) {
      count += $scope.cols[value].show ? 1 : 0;
    });
    $scope.disabledCols = count == 1;
  };

  $scope.initFilterColumns = function() {
    $(document).ready(function(){
        $('#filterColumnsCorporativos').popover(); 
    });
  };

  $scope.routeAdd = function() {
    $scope.location.path('/admin/corporativo/add');
  };

  $scope.routeView = function() {
    $scope.location.path('/admin/corporativo');
  };

  $scope.getCorporativos = function() {
      $scope.searchingCorporativos = true;
      CorporativoService.getAll({
        start_pag: 0,
        end_pag: 100
      }).success(function(data) {
      if(data['@pr_affect_rows']) {
        $scope.searchingCorporativos = false;
        $scope.corporativos = data.results;
        $scope.tableCorporativos = new NgTableParams({
            page: $scope.page,
            count: $scope.countPerPage
          }, {
            filterSwitch: true,
            counts: [5, 10, 50 ,100],
            paginationMaxBlocks: 4,
            paginationMinBlocks: 1,
            getData: function(params) {
              filteredData    = params.filter()  ? $filter('filter')($scope.corporativos, params.filter()) : $scope.corporativos;
              orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
              $scope.filteredCorporativos = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
              params.total(orderedData.length);
              $scope.page = params.page();
              $scope.countPerPage = params.count();
              return $scope.filteredCorporativos;
            }
        });
      }
    });
  };

  $scope.prepareUpdate = function(corporativo) {
    $scope.corporativo = Object.create(corporativo);
    $scope.corporativo.limite_credito = parseFloat(corporativo.limite_credito);
    $scope.corporativo.estatus_corporativo = corporativo.estatus_corporativo == 1;
    $scope.optionsCorporativo.create = false;
    $('#modalCorporativo').modal();
  };

  $scope.optionSubmitCorporativo = function() {
    if($scope.optionsCorporativo.create) {
      $scope.createCorporativo();
    } else {
      $scope.updateCorporativo();
    }
  }

  $scope.prepareDelete = function(id) {
    $("#modalDeleteCorporativo").modal('show');
    $scope.deleteIdCorporativo = id;
  };

  $scope.deleteCorporativo = function(id) {
    CorporativoService.delete({
      id_corporativo: id
    }).success(function(data) {
      if(data['@pr_message'] == 'SUCCESS' && data['@pr_affect_rows']) {
        $scope.getCorporativos();
        $("#modalDeleteCorporativo").modal('hide');
        toastr.success("Corporativo eliminado correctamente");
      } else {
        toastr.error("No se pudo eliminar el corporativo");
      }
    });
  };

$scope.createCorporativo = function() {
  CorporativoService.create($scope.corporativo)
  .success(function(data) {
    if(data['@pr_message'] == 'SUCCESS' && data['@pr_affect_rows']) {
      $timeout(function() {
        $scope.corporativo = {};
      }, 0);
      toastr.success("Corporativo creado correctamente");
      $("#modalCorporativo").modal('hide');
      $scope.getCorporativos();
    } else {
      toastr.error("No se pudo crear el corporativo");
    }
  });
};

$scope.updateCorporativo = function() {
  CorporativoService.update($scope.corporativo)
  .success(function(data) {
    if(data['@pr_message'] == 'SUCCESS' && data['@pr_affect_rows']) {
      toastr.success("Corporativo actualizado correctamente");
      $("#modalCorporativo").modal('hide');
      $scope.getCorporativos();
      $scope.corporativo = {};
    } else {
      toastr.error("No se pudo actualizar el corporativo");
    }
  });
};
}])
.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
  var basePath = icaav.helpers.getBasePath();
  $routeProvider
  .when(basePath + '/admin', {templateUrl : basePath + '/admin?terminal=true'})
  .when(basePath + '/admin/corporativo', {templateUrl : basePath + '/admin/corporativo?terminal=true'})
  .when(basePath + '/admin/corporativo/add', {templateUrl : basePath + '/admin/corporativo/add?terminal=true'})
  .when(basePath + '/admin/unidad-negocio', {templateUrl : basePath + '/admin/unidad-negocio?terminal=true'})
  .otherwise({
    templateUrl: window.location.href + '?terminal=true'
  });
  $locationProvider.html5Mode(true);
}])
.factory('CorporativoService', ['$http', function($http) {
  httpForm = new icaav.services.HTTPForm($http);
  basePath = icaav.helpers.getBasePath();
  return {
    getAll: function(data) {
      return httpForm.post(basePath + '/admin/corporativo/get-corporativos', data);
    }, create: function(data) {
      return httpForm.post(basePath + '/admin/corporativo/add-ajax', data);
    }, update: function(data) {
      return httpForm.post(basePath + '/admin/corporativo/edit-ajax', data);
    }, delete: function(data) {
      return httpForm.post(basePath + '/admin/corporativo/delete-ajax', data);
    }
  }
}]);
