angular.module('bootstrap.tabset', [])
.directive('accueil', function () {
  return {
    restrict: 'E',
    replace: true,
    transclude: true,
    controller: function($scope, $rootScope) {
      $scope.templateUrl = '';
      var tabs = $rootScope.tabs = [];
      var controller = this;

      this.selectTab = function (montab) {
        angular.forEach(tabs, function (montab) {
          montab.selected = false;
          // console.log('selectTab', montab)
        });
        montab.selected = true;
      };

      this.setTabTemplate = function (templateUrl) {
        $scope.templateUrl = templateUrl;
      }

      this.addTab = function (montab) {
        if(montab.active === 'true') {
          montab.selected = true
        }
        tabs.push(montab);
      };
    },
    template:
      '<div class="row-fluid">' +
        '<div class="row-fluid">' +
          '<div class="nav nav-tabs" ng-transclude></div>' +
        '</div>' +
        '<div class="row-fluid">' +
          '<ng-include src="templateUrl"></ng-include>' +
        '</div>' +
      '</div>'
  };
})
.directive('montab', function () {
  return {
    restrict: 'E',
    replace: true,
    require: '^accueil',
    scope: {
      title: '@',
      templateUrl: '@',
      cat:'@',
      active:'@'
    },
    link: function(scope, element, attrs, accueilController) {
      accueilController.addTab(scope);      

      scope.select = function () {
        accueilController.selectTab(scope);
      }

      scope.$watch('selected', function () {
        if (scope.selected) {
          accueilController.setTabTemplate(scope.templateUrl);
        }
      });
    },
    template:
      '<li ng-class="{active: selected}">' +
        '<a href="" ng-click="select()">{{ title }}</a>' +
      '</li>'
  };
});
