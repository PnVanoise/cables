var app = angular.module('tronconsErdfCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/tronconserdf', {
            controller: 'tronconsErdfEditCtrl',
            templateUrl: 'js/templates/tronconsErdf/edit.htm'
        })
        .when('/:appName/edit/tronconserdf/:id', {
            controller: 'tronconsErdfEditCtrl',
            templateUrl: 'js/templates/tronconsErdf/edit.htm'
        })
        .when('/:appName/tronconserdf/:id', {
            controller: 'tronconsErdfDetailCtrl',
            templateUrl: 'js/templates/tronconsErdf/detail.htm'
        });
});


/*
 * controleur pour l'affichage basique des détails 
 */
app.controller('tronconsErdfDetailCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){
    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/tronconserdf/detail';
    $scope.dataUrl = $scope._appName + '/tronconserdf/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/tronconserdf/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        // mapService.selectItem(parseInt($routeParams.id), 'tronconserdf');
        $scope.title = 'Tronçon Enedis ' + data.id;
    });

    // Chargement des données sur chargement page de détail
    mapService.tabThemaData['tronconserdf'].loaded = false;
    mapService.showLayer(null, 'tronconserdf', 'force');

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/tronconserdf/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/tronconserdf';
        $scope.data = {}
    } 
    $scope.$on('form:delete', function(ev, data){
        userMessages.successMessage = 'Le tronçon Enedis' + data.id + ' a été supprimé.'
        // dataServ.forceReload = true;
        $location.url($scope._appName + '/tronconserdf/');
    });

});

/*
 * controleur pour l'édition 
 */
app.controller('tronconsErdfEditCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/tronconserdf/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/tronconserdf/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/tronconserdf/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/tronconserdf';
        $scope.data = {}
    }

    $scope.$on('form:init', function(ev, data){
        if(data.espece){
        $scope.title = 'Modification du tronçon Enedis' + data.id;
        }
        else{
            $scope.title = 'Nouveau tronçon Enedis';
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/tronconserdf/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'Le tronçon Enedis ' + data.remarques + ' a été créé avec succès.'
        $location.url($scope._appName + '/tronconserdf/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.successMessage = 'Le tronçon Enedis ' + data.remarques + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/tronconserdf/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.successMessage = 'Le tronçon Enedis ' + data.remarques + ' a été supprimé.'
        $location.url($scope._appName + '/tronconserdf/');
    });
});

