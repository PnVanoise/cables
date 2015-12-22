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
        mapService.showLayer('tronconserdf').then(function() {
            mapService.selectItem($routeParams.id, 'tronconserdf');
        });
        $scope.title = 'Tronçon ' + data.id;
    });

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/tronconserdf/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/tronconserdf';
        $scope.data = {}
    } 
    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'le tronçon' + data.id + ' a été supprimé.'
        dataServ.forceReload = true;
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
        // mapService.initializeCarte('js/resources/defaultMap.json').then(function(){
        //     mapService.loadData($scope._appName + '/tronconserdf', "tronconserdf").then(
        //         function(){
        //             document.getElementById("tronconserdf").checked = true;
        //             mapService.displayGeomData("tronconserdf");
        //             storeFlag.setFlagLayer("tronconserdf", "cacheChecked");
        //         });
            if(data.espece){
            $scope.title = 'Modification du tronçon' + data.id;
            }
            else{
                $scope.title = 'Nouveau tronçon';
            }
        // });
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/tronconserdf/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'le site de tronconserdf' + data.remarques + ' a été créé avec succès.'
        $location.url($scope._appName + '/tronconserdf/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){

        userMessages.successMessage = 'le site de tronconserdf' + data.remarques + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/tronconserdf/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'le site de tronconserdf ' + data.remarques + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/tronconserdf/');
    });
});

