var app = angular.module('photosTronconsErdfCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/photostronconserdf', {
            controller: 'photosTronconsErdfEditCtrl',
            templateUrl: 'js/templates/photosTronconErdf/edit.htm'
        })
        .when('/:appName/edit/tronconserdf/photostronconserdf/:id_inventaire_troncon_erdf', {
            controller: 'photosTronconsErdfEditCtrl',
            templateUrl: 'js/templates/photosTronconErdf/edit.htm'
        })        
        .when('/:appName/edit/photostronconserdf/:id', {
            controller: 'photosTronconsErdfEditCtrl',
            templateUrl: 'js/templates/photosTronconErdf/edit.htm'
        })
        .when('/:appName/photostronconserdf/:id', {
            controller: 'photosTronconsErdfDetailCtrl',
            templateUrl: 'js/templates/photosTronconErdf/detail.htm'
        });
});


/*
 * controleur pour l'affichage basique des détails 
 */
app.controller('photosTronconsErdfDetailCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/photostronconserdf/detail';
    $scope.dataUrl = $scope._appName + '/photostronconserdf/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/photostronconserdf/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        $scope.title = 'Photo n°' + data.id + '  du tronçon ERDF ' + data.inventaire_troncon_erdf;
        $scope.cheminPhoto = data.cheminPhoto; 
    });

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/photostronconserdf/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/photostronconserdf';
        $scope.data = {}
    } 
    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = "la photo du tronçon" + data.idInventaireTronconErdf + ' a été supprimée.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/photostronconserdf/');
    });

});

/*
 * controleur pour l'édition 
 */
app.controller('photosTronconsErdfEditCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/photostronconserdf/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/photostronconserdf/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/photostronconserdf/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/photostronconserdf';
        $scope.data = {idInventaireTronconErdf: $routeParams.id_inventaire_troncon_erdf};
    }

   $scope.$on('form:init', function(ev, data){
        if(data.id){
        $scope.title = "Modifications de la photo" + data.id;
        
        }
        else{
            $scope.title = "Ajout d'une nouvelle photo";
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        if(data.id){
            $location.url($scope._appName + '/tronconserdf/' + data.id);
        }
        else{
            $location.url($scope._appName + '/tronconserdf/' + data.idInventaireTronconErdf);
        }
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = "la photo du tronçon" + data.idInventaireTronconErdf + ' a été créée avec succès.'
        $location.url($scope._appName + '/photostronconserdf/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.successMessage = "la photo du tronçon" + data.idInventaireTronconErdf + ' a été mise à jour avec succès.'
        $location.url($scope._appName + '/photostronconserdf/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.successMessage = "la photo du tronçon" + data.idInventaireTronconErdf + ' a été supprimée.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/tronconserdf/' + data.idInventaireTronconErdf);
    });
});

