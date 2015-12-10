var app = angular.module('observationsCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/observations', {
            controller: 'observationsEditCtrl',
            templateUrl: 'js/templates/observations/edit.htm'
        })
        .when('/:appName/edit/observations/:id', {
            controller: 'observationsEditCtrl',
            templateUrl: 'js/templates/observations/edit.htm'
        })
        .when('/:appName/observations/:id', {
            controller: 'observationsDetailCtrl',
            templateUrl: 'js/templates/observations/detail.htm'
        });
});


/*
 * controleur pour l'affichage basique des détails 
 */
app.controller('observationsDetailCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/observations/detail';
    $scope.dataUrl = $scope._appName + '/observations/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/observations/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        mapService.initializeCarte('js/resources/defaultMap.json').then(function(){
            mapService.loadData($scope._appName + '/observations', "observations").then(
                function(){
                    mapService.selectItem($routeParams.id, 'observations');
                    document.getElementById("observations").checked = true;
                    mapService.displayGeomData("observations");
                    storeFlag.setFlagLayer("observations", "cacheChecked");
                });
            $scope.title = data.espece;
        });
    });

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/observations/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/observations';
        $scope.data = {}
    } 
    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = "Observation sur  ' + data.espece + ' a été supprimé."
        dataServ.forceReload = true;
        $location.url($scope._appName + '/observations/');
    });

});

/*
 * controleur pour l'édition 
 */
app.controller('observationsEditCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/observations/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/observations/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/observations/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/observations';
        $scope.data = {}
    }

    $scope.$on('form:init', function(ev, data){
        mapService.initializeCarte('js/resources/defaultMap.json').then(function(){
            mapService.loadData($scope._appName + '/observations', "observations").then(
                function(){
                    document.getElementById("observations").checked = true;
                    mapService.displayGeomData("observations");
                    storeFlag.setFlagLayer("observations", "cacheChecked");
                });
            if(data.espece){
            $scope.title = "Modification de l'observations sur " + data.espece;
            }
            else{
                $scope.title = "Nouvelle observation";
            }
        });
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/observations/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'Observations sur' + data.espece + ' a été créé avec succès.'
        $location.url($scope._appName + '/observations/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){

        userMessages.successMessage = 'Observations sur' + data.espece + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/observations/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'Observations sur' + data.espece + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/observations/');
    });
});

