var core = angular.module('core', ['ngRoute', 'ngStorage', 'pascalprecht.translate']);
core.controller('main', ['$scope', '$rootScope', 'tabs', '$location', '$localStorage', '$translate', "$translatePartialLoader", "$timeout", function($scope, $rootScope, tabs, $location, $localStorage, $translate, $translatePartialLoader, $timeout) {
  var basePath = icaav.helpers.getBasePath();
  $scope.menu = [{
    url: basePath + '/icaav',
    name: 'Dashboard',
    classIcon: 'fa fa-dashboard',
  }, {
    name: 'Catálogos',
    classIcon: 'fa fa-files-o',
    li: [{
        name: 'Corporativos',
        url: basePath + '/icaav/corporativo',
        classIcon: 'fa fa-suitcase'
      }, {
        name: 'Origen venta',
        url: basePath + '/icaav/origen-venta',
        classIcon: 'fa fa-suitcase'
      }, {
        name: 'Unidad de negocio',
        url: basePath + '/icaav/unidad-negocio',
        classIcon: 'fa fa-suitcase'
      }]
  }];
  $scope.tabs = [];
  $scope.selectedTab = {};

  $translatePartialLoader.addPart('system');
  $translatePartialLoader.addPart('tables');
  $translate.refresh();

  $scope.$on('changeTabs', function() {
    $scope.tabs = tabs.getTabs();
    $scope.cleanActives(tabs.getActiveTab().name);
  });

  $rootScope.$on( "$routeChangeStart", function(event, next, current) {
    tabs.updatePathSelectedTab($location.path());
  });

  $scope.changeLanguaje = function(lang) {
    $translate.use(lang);
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
    if(!tab.li && tab.name) {
      if(tab.url && $location.path() != tab.url) {
        $timeout(function() {
          $location.path(tab.url);
        }, 0)
      } else {
        tab.url = $location.path();
        console.log(tab.url);
      }
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
}).config(function ($translateProvider) {

  $translateProvider.useLoader('$translatePartialLoader', {  
    urlTemplate: icaav.helpers.getBasePath() + '/js/angular/lib/langs/{part}/{lang}.json'
  });

  $translateProvider.preferredLanguage('es');

});;
