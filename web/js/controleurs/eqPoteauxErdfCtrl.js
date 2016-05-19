var app = angular.module('eqPoteauxErdfCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/edit/eqpoteauxerdf/:id', {
            controller: 'eqPoteauxErdfEditCtrl',
            templateUrl: 'js/templates/eqPoteauxErdf/edit.htm'
        })
        .when('/:appName/edit/poteauxerdf/eqpoteauxerdf/:id_inventaire_poteau_erdf', {
            controller: 'eqPoteauxErdfEditCtrl',
            templateUrl: 'js/templates/eqPoteauxErdf/edit.htm'
        })
        .when('/:appName/eqpoteauxerdf/:id', {
            controller: 'eqPoteauxErdfDetailCtrl',
            templateUrl: 'js/templates/eqPoteauxErdf/detail.htm'
        });
});

/*
 * controleur pour l'affichage basique des détails 
 */
app.controller('eqPoteauxErdfDetailCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages, storeFlag){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/eqpoteauxerdf/detail';
    $scope.dataUrl = $scope._appName + '/eqpoteauxerdf/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/eqpoteauxerdf/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        $scope.title = 'Equipement de poteau de type ' + data.type_equipement_poteau;
    });

    // Ajout la possibilité de supprimer un élément en mode détail
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/eqpoteauxerdf/' + $routeParams.id;
    }
    else{
        $scope.saveUrl = $scope._appName + '/eqpoteauxerdf';
        $scope.data = {}
    } 
    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = "L'équipement de poteau de type" + data.type_equipement_poteau + "a été supprimé."
        dataServ.forceReload = true;
        $location.url($scope._appName + '/eqpoteauxerdf/');
    });

});

/*
 * controleur pour l'édition 
 */
app.controller('eqPoteauxErdfEditCtrl', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ,userServ, userMessages, storeFlag){
    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/eqpoteauxerdf/form';
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/eqpoteauxerdf/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/eqpoteauxerdf/' + $routeParams.id;
        $scope.data = {};
    }
    else{
        $scope.saveUrl = $scope._appName + '/eqpoteauxerdf';
        $scope.data = {
            loginSaisie: userServ.getUser().nom_complet, 
            idInventairePoteauErdf: $routeParams.id_inventaire_poteau_erdf
        };
    }

    $scope.$on('form:init', function(ev, data){
        if(data.type_equipement_poteau){
        $scope.title = "Modification de l'équipement de poteau de type" + data.type_equipement_poteau;
        }
        else{
            $scope.title = "Nouvel équipement de poteau";
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        if(data.id){
            $location.url($scope._appName + '/eqpoteauxerdf/' + data.id);
        }
        else{
            $location.url($scope._appName + '/eqpoteauxerdf/' + data.idInventairePoteauErdf);
        }
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = "L'équipement de poteau de type " + data.type_equipement_troncon + ' a été créé avec succès.'
        $location.url($scope._appName + '/eqpoteauxerdf/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.successMessage = "L'équipement de poteau de type " + data.type_equipement_troncon + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/eqpoteauxerdf/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.successMessage = "L'équipement de poteau de type " + data.type_equipement_troncon + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/poteauxerdf/' + data.idInventaireTronconErdf);
    });
});
