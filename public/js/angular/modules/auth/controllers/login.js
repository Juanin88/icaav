auth = angular.module('auth', []);
auth.controller('login', ['$scope', '$http', function($scope, $http) {

    $scope.httpForm = new icaav.services.HTTPForm($http);
    $scope.authUrl = '/auth/authentication';
    $scope.user = {};

    $scope.authentication = function() {
        $scope.httpForm.post(icaav.helpers.getBasePath() + $scope.authUrl, $scope.user)
        .success(function(response) {
            if(response.success) {
                window.location.href = icaav.helpers.getBasePath() + "/admin";
            } else {
                console.log('No redirect user');
            }
        });
    };

}]);
