admin.controller('CorporativoController', ['$scope', '$http', '$localStorage', '$location', '$timeout', 'NgTableParams', 'ngTableSimpleMediumList', function($scope, $http, $localStorage, $location, $timeout, NgTableParams, ngTableSimpleMediumList) {


  this.defaultConfigTableParams = new NgTableParams({}, { dataset: simpleList});
    this.customConfigParams = createUsingFullOptions();

    function createUsingFullOptions() {
      var initialParams = {
        count: 5 // initial page size
      };
      var initialSettings = {
        // page size buttons (right set of buttons in demo)
        counts: [],
        // determines the pager buttons (left set of buttons in demo)
        paginationMaxBlocks: 13,
        paginationMinBlocks: 2,
        dataset: simpleList
      };
      return new NgTableParams(initialParams, initialSettings);
    }


    

  $scope.httpForm = new icaav.services.HTTPForm($http);
  $scope.location = new icaav.services.Location($location);
  $scope.corporativoEdit = {};
  $scope.vars = $localStorage.$default({
    corporativoAdd: {
      id_corporativo:  '',
      nombre_corporativo: '',
      limite_credito: '',
      estatus_corporativo: false,
    }
  });

  $scope.setDataEditCorportativo = function(corporativo) {
    $scope.corporativoEdit = new Object(corporativo);
    $scope.corporativoEdit.estatus_corporativo = $scope.corporativoEdit.estatus_corporativo == 1;
  };

  $scope.routeAdd = function() {
    $scope.location.path('/admin/corporativo/add');
  };

  $scope.routeView = function() {
    $scope.location.path('/admin/corporativo');
  };

  $scope.getCorporativos = function() {
    $scope.httpForm.post(icaav.helpers.getBasePath() +'/admin/corporativo/get-corporativos', {
      start_pag: 0,
      end_pag: 100
    }).success(function(data) {
      if(data['@pr_affect_rows']) {
        $scope.corporativos = data.results;
      }
    });
  };

  $scope.deleteCorporativo = function(id) {
    if(confirm("¿Esta seguro de eliminar el corporativo?")) {
      $scope.httpForm.post(icaav.helpers.getBasePath() + '/admin/corporativo/delete-ajax', {
        id_corporativo: id
      }).success(function(data) {
        console.log(data);
        if(data['@pr_message'] == 'SUCCESS' && data['@pr_affect_rows']) {
          $scope.getCorporativos();
        } else {
          alert('No se pudo eliminar el corporativo');
        }
      });
    }
  };

$scope.createCorporativo = function() {
  $scope.httpForm.post(icaav.helpers.getBasePath() + '/admin/corporativo/add-ajax', $scope.vars.corporativoAdd)
  .success(function(data) {
    if(data['@pr_message'] == 'SUCCESS' && data['@pr_affect_rows']) {
      $timeout(function() {
        delete $scope.vars.corporativoAdd;
      }, 0);
      $scope.location.path('/admin/corporativo');
    } else {
      alert('No se pudo crear el corporativo');
    }
  });
};

$scope.updateCorporativo = function() {
  $scope.httpForm.post(icaav.helpers.getBasePath() + '/admin/corporativo/edit-ajax', $scope.corporativoEdit)
  .success(function(data) {
    if(data['@pr_message'] == 'SUCCESS' && data['@pr_affect_rows']) {
      $scope.getCorporativos();
      $scope.corporativoEdit = {};
    } else {
      alert('No se pudo editar el corporativo');
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
}]);
