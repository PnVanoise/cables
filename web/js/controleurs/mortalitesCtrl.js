var app = angular.module('mortalitesCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/mortalites', {
            controller: 'mortalitesEditCtrl',
            templateUrl: 'js/templates/mortalites/edit.htm'
        })
        .when('/:appName/edit/mortalites/:id', {
            controller: 'mortalitesEditCtrl',
            templateUrl: 'js/templates/mortalites/edit.htm'
        })
        .when('/:appName/mortalites/:id', {
            controller: 'mortalitesDetailCtrl',
            templateUrl: 'js/templates/mortalites/detail.htm'
        });
});


/*
 * controleur pour l'affichage basique des détails d'un cas
 */
app.controller('mortalitesDetailCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/mortalites/detail';
    $scope.dataUrl = $scope._appName + '/mortalites/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/mortalites/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        $scope.title = data.espece;
    });

    // Chargement des données sur chargement page de détail
    mapService.tabThemaData['mortalites'].loaded = false;
    // console.log('showlayer mortalitectrl');
    mapService.showLayer(null, 'mortalites', 'force');

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/mortalites/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/mortalites';
        $scope.data = {}
    }    

    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'le ' + data.espece + ' a été supprimé.'
        // dataServ.forceReload = true;
        $location.url($scope._appName + '/mortalites/');
    });
});

/*
 * controleur pour l'édition et suppression d'un cas
 */
app.controller('mortalitesEditCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){
    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/mortalites/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/mortalites/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/mortalites/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/mortalites';
        $scope.data = {
            // date: '2016/23/03'
        };
    }

    $scope.$on('form:init', function(ev, data){
        if(data.espece){
            $scope.title = 'Modification du cas de mortalité de ' + data.espece;
        }
        else{
            $scope.title = 'Nouveau cas de mortalité';
        };
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/mortalites/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'Le cas de mortalité ' + data.espece + ' a été créé avec succès.'
        $location.url($scope._appName + '/mortalites/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.successMessage = 'Le cas de mortalité ' + data.espece + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/mortalites/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.successMessage = 'Le cas de mortalité ' + data.espece + ' a été supprimé.'
        $location.url($scope._appName + '/mortalites/');
    });
});

