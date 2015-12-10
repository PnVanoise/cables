var app = angular.module('poteauxErdfCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/poteauxerdf', {
            controller: 'poteauxErdfEditCtrl',
            templateUrl: 'js/templates/poteauxErdf/edit.htm'
        })
        .when('/:appName/edit/poteauxerdf/:id', {
            controller: 'poteauxErdfEditCtrl',
            templateUrl: 'js/templates/poteauxErdf/edit.htm'
        })
        .when('/:appName/poteauxerdf/:id', {
            controller: 'poteauxErdfDetailCtrl',
            templateUrl: 'js/templates/poteauxErdf/detail.htm'
        });
});


/*
 * controleur pour l'affichage basique des détails 
 */
app.controller('poteauxErdfDetailCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/poteauxerdf/detail';
    $scope.dataUrl = $scope._appName + '/poteauxerdf/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/poteauxerdf/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        mapService.initializeCarte('js/resources/defaultMap.json').then(function(){
            mapService.loadData($scope._appName + '/poteauxerdf', "poteauxerdf").then(
                function(){
                    mapService.selectItem($routeParams.id, 'poteauxerdf');
                    document.getElementById("poteauxerdf").checked = true;
                    mapService.displayGeomData("poteauxerdf");
                    storeFlag.setFlagLayer("poteauxerdf", "cacheChecked");
                });
            $scope.title = 'Poteau ' + data.id;
        });
    });


    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/poteauxerdf/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/poteauxerdf';
        $scope.data = {}
    } 
    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'le poteau  ' + data.id + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/poteauxerdf/');
    });

});

/*
 * controleur pour l'édition 
 */
app.controller('poteauxErdfEditCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/poteauxerdf/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/poteauxerdf/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/poteauxerdf/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/poteauxerdf';
        $scope.data = {}
    }

    $scope.$on('form:init', function(ev, data){
        // mapService.initializeCarte('js/resources/defaultMap.json').then(function(){
        //     mapService.loadData($scope._appName + '/poteauxerdf', "poteauxerdf").then(
        //         function(){
        //             document.getElementById("poteauxerdf").checked = true;
        //             mapService.displayGeomData("poteauxerdf");
        //             storeFlag.setFlagLayer("poteauxerdf", "cacheChecked");
        //         });
            if(data.espece){
            $scope.title = "Modification du poteau " + data.id;
            }
            else{
                $scope.title = "Nouveau poteau";
            }
        // });
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/poteauxerdf/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'le poteau' + data.id + ' a été créé avec succès.'
        $location.url($scope._appName + '/poteauxerdf/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){

        userMessages.successMessage = 'le poteau' + data.remarques + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/poteauxerdf/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'le poteau ' + data.remarques + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/poteauxerdf/');
    });
});

