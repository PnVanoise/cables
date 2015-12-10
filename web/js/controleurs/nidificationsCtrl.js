var app = angular.module('nidificationsCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/nidifications', {
            controller: 'nidificationsEditCtrl',
            templateUrl: 'js/templates/nidifications/edit.htm'
        })
        .when('/:appName/edit/nidifications/:id', {
            controller: 'nidificationsEditCtrl',
            templateUrl: 'js/templates/nidifications/edit.htm'
        })
        .when('/:appName/nidifications/:id', {
            controller: 'nidificationsDetailCtrl',
            templateUrl: 'js/templates/nidifications/detail.htm'
        });
});


/*
 * controleur pour l'affichage basique des détails 
 */
app.controller('nidificationsDetailCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/nidifications/detail';
    $scope.dataUrl = $scope._appName + '/nidifications/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/nidifications/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        mapService.initializeCarte('js/resources/defaultMap.json').then(function(){
            mapService.loadData($scope._appName + '/nidifications', "nidifications").then(
                function(){
                    mapService.selectItem($routeParams.id, 'nidifications');
                    document.getElementById("nidifications").checked = true;
                    mapService.displayGeomData("nidifications");
                    storeFlag.setFlagLayer("nidifications", "cacheChecked");
                });
            $scope.title = data.nom_espece;
        });
    });

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/nidifications/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/nidifications';
        $scope.data = {}
    } 
    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'le  ' + data.nom_espece + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/nidifications/');
    });

});

/*
 * controleur pour l'édition 
 */
app.controller('nidificationsEditCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/nidifications/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/nidifications/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/nidifications/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/nidifications';
        $scope.data = {}
    }

    $scope.$on('form:init', function(ev, data){
        mapService.initializeCarte('js/resources/defaultMap.json').then(function(){
            mapService.loadData($scope._appName + '/nidifications', "nidifications").then(
                function(){
                    document.getElementById("nidifications").checked = true;
                    mapService.displayGeomData("nidifications");
                    storeFlag.setFlagLayer("nidifications", "cacheChecked");
                });
            if(data.espece){
            $scope.title = "Modification du site de nidifications de " + data.espece;
            }
            else{
                $scope.title = "Nouveau site";
            }
        });
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/nidifications/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'le site de nidifications' + data.nom_espece + ' a été créé avec succès.'
        $location.url($scope._appName + '/nidifications/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){

        userMessages.successMessage = 'le site de nidifications' + data.nom_espece + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/nidifications/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'le site de nidifications ' + data.nom_espece + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/nidifications/');
    });
});

