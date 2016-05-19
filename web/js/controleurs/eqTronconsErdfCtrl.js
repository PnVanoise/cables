var app = angular.module('eqTronconsErdfCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/eqtronconserdf', {
            controller: 'eqTronconsErdfEditCtrl',
            templateUrl: 'js/templates/eqTronconsErdf/edit.htm'
        })
        .when('/:appName/edit/tronconserdf/eqtronconserdf/:id_inventaire_troncon_erdf', {
            controller: 'eqTronconsErdfEditCtrl',
            templateUrl: 'js/templates/eqTronconsErdf/edit.htm'
        })        
        .when('/:appName/edit/eqtronconserdf/:id', {
            controller: 'eqTronconsErdfEditCtrl',
            templateUrl: 'js/templates/eqTronconsErdf/edit.htm'
        })
        .when('/:appName/eqtronconserdf/:id', {
            controller: 'eqTronconsErdfDetailCtrl',
            templateUrl: 'js/templates/eqTronconsErdf/detail.htm'
        });
});


/*
 * controleur pour l'affichage basique des détails 
 */
app.controller('eqTronconsErdfDetailCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/eqtronconserdf/detail';
    $scope.dataUrl = $scope._appName + '/eqtronconserdf/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/eqtronconserdf/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        $scope.title = 'Equipement tronçon de type ' + data.type_equipement_troncon;
    });

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/eqtronconserdf/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/eqtronconserdf';
        $scope.data = {}
    } 
    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = "L'équipement de tronçon de type" + data.type_equipement_troncon + "a été supprimé."
        dataServ.forceReload = true;
        $location.url($scope._appName + '/eqtronconserdf/');
    });

});

/*
 * controleur pour l'édition 
 */
app.controller('eqTronconsErdfEditCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/eqtronconserdf/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/eqtronconserdf/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/eqtronconserdf/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/eqtronconserdf';
        $scope.data = {idInventaireTronconErdf: $routeParams.id_inventaire_troncon_erdf};
    }

    $scope.$on('form:init', function(ev, data){
        if(data.type_equipement_troncon){
        $scope.title = 'Modification de l\'équipement de tronçon ' + data.type_equipement_troncon;
        }
        else{
            $scope.title = 'Nouvel équipement de tronçon';
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/eqtronconserdf/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'L\'équipement de tronçon ' + data.type_equipement_troncon + ' a été créé avec succès.'
        $location.url($scope._appName + '/eqtronconserdf/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.successMessage = 'L\'équipement de tronçon ' + data.type_equipement_troncon + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/eqtronconserdf/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.successMessage = 'L\'équipement de tronçon ' + data.type_equipement_troncon + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/eqtronconserdf/');
    });
});

