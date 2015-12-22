var app = angular.module('zonesSensiblesCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/zonessensibles', {
            controller: 'zsEditController',
            templateUrl: 'js/templates/zonesSensibles/edit.htm'
        })
        .when('/:appName/edit/zonessensibles/:id', {
            controller: 'zsEditController',
            templateUrl: 'js/templates/zonesSensibles/edit.htm'
        })
        .when('/:appName/zonessensibles/:id', {
            controller: 'zsDetailController',
            templateUrl: 'js/templates/zonesSensibles/detail.htm'
        });
});


/*
 * controleur pour l'affichage basique des détails
 */
app.controller('zsDetailController', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/zonessensibles/detail';
    $scope.dataUrl = $scope._appName + '/zonessensibles/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/zonessensibles/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        mapService.showLayer('zonessensibles').then(function() {
            mapService.selectItem($routeParams.id, 'zonessensibles');
        });
        $scope.title = data.nom_zone_sensible;
    });

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/zonessensibles/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/zonessensibles';
        $scope.data = {}
    }
    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'la zone sensible  ' + data.nom_zone_sensible + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/zonessensibles/');
    });

});

/*
 * controleur pour l'édition
 */
app.controller('zsEditController', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/zonessensibles/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/zonessensibles/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/zonessensibles/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/zonessensibles';
        $scope.data = {}
    }

    $scope.$on('form:init', function(ev, data){
        mapService.initializeCarte('js/resources/defaultMap.json').then(function(){
            mapService.loadData($scope._appName + '/zonessensibles', "zonessensibles").then(
                function(){
                    document.getElementById("zonessensibles").checked = true;
                    mapService.displayGeomData("zonessensibles");
                    storeFlag.setFlagLayer("zonessensibles", "cacheChecked");
                });
            if(data.espece){
            $scope.title = 'Modification de la zone sensible ' + data.nom_zone_sensible;
            }
            else{
                $scope.title = 'Nouveau site';
            }
        });
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/zonessensibles/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'la zone sensible' + data.nom_zone_sensible + ' a été créé avec succès.'
        $location.url($scope._appName + '/zonessensibles/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){

        userMessages.successMessage = 'la zone sensible' + data.nom_zone_sensible + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/zonessensibles/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'la zone sensible ' + data.nom_zone_sensible + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/zonessensibles/');
    });
});

