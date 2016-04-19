angular.module('core', ['ngRoute', 'ngStorage'])
.controller('main', ['$scope', '$rootScope', 'tabs', '$location', '$localStorage', function($scope, $rootScope, tabs, $location, $localStorage) {
  var basePath = icaav.helpers.getBasePath();
  $scope.menu = [{
    url: basePath + '/admin',
    name: 'Dashboard',
    classIcon: 'fa fa-dashboard',
  }, {
    name: 'Catálogos',
    classIcon: 'fa fa-files-o',
    li: [{
        name: 'Corporativos',
        url: basePath + '/admin/corporativo',
        classIcon: 'fa fa-suitcase'
      }, {
        name: 'Unidades de negocio',
        url: basePath + '/admin/unidad-negocio',
        classIcon: 'fa fa-user-secret'
    }]
  }];
  $scope.tabs = [];
  $scope.selectedTab = {};

  $scope.$on('changeTabs', function() {
    $scope.tabs = tabs.getTabs();
    $scope.cleanActives(tabs.getActiveTab().name);
  });

  $rootScope.$on( "$routeChangeStart", function(event, next, current) {
    tabs.updatePathSelectedTab($location.path());
  });

  $scope.setDefaultTab = function() {

  };

  $scope.activeMenu = function() {
    for(i in $scope.tabs) {
      if($scope.tabs[i].isActive) {
      for(j in $scope.menu) {
        $scope.menu[j].isActive = false;
        if($scope.tabs[i].name === $scope.menu[j].name) {
          $scope.menu[j].isActive = true;
          $scope.selectedTab = $scope.menu[j];
        }
      }
      }
    }
  };

  $scope.cleanActives = function(nameTabSelect) {
    for(i in $scope.menu) {
      if($scope.menu[i].li) {
        for(j in $scope.menu[i].li) {
          $scope.menu[i].li[j].isActive = nameTabSelect == $scope.menu[i].li[j].name;
        }
      } else {
        $scope.menu[i].isActive = nameTabSelect == $scope.menu[i].name;
      }
    }
  }

  $scope.setTab = function(tab) {
    if(tab.url) {
      $location.path(tab.url);
      tabs.set(tab);
    }
  };

  $scope.removeTab = function(name) {
    tabs.remove(name);
  };

}])
.factory('tabs', function($rootScope) {
  var tabs = [];
  var i    = 0;
  function changeTabs() {
    $rootScope.$broadcast('changeTabs');
  }
  function getTab(name) {
    tab = null;
    for(i in tabs) {
      tabs[i].isActive = false;
      if(tabs[i].name === name) {
        tab = tabs[i];
      }
    }

    return tab;
  }
  return {
    activeTab: null,
    set: function(tab) {
      this.activeTab = getTab(tab.name);
      if(!this.activeTab) {
        this.activeTab = {
          name: tab.name,
          url : tab.url,
          isActive: true,
          classIcon: tab.classIcon
        };
        tabs.push(this.activeTab);
      } else {
        this.activeTab.isActive = true;
      }
      changeTabs();
    }, remove: function(name) {
      for(i = 0; i < tabs.length; i++) {
        if(tabs[i].name === name) {
          tabs.splice(i, 1);
        }
      }
      changeTabs();
    }, getTabs: function() {
      return tabs;
    }, getActiveTab: function() {
      return this.activeTab;
    }, updatePathSelectedTab: function(newPath) {
      if(this.activeTab) {
        for(i = 0; i < tabs.length; i++) {
          if(tabs[i].url === newPath && tabs[i].name != this.activeTab.name) {
            this.activeTab.isActive = false;
            this.activeTab = tabs[i];
            this.activeTab.isActive = true;
          }
        }
        this.activeTab.url = newPath;
      }
    }
  };
});