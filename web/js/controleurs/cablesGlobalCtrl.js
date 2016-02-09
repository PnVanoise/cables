var app = angular.module('cablesGlobalCtrl');


/*
 * configuration des routes
 */
app.config(function($routeProvider){

    var categories = [
        {
            id: 'zonessensibles',
            title: 'Zones sensibles'
        }, {
            id: 'mortalites',
            title: 'Cas de mortalités'
        }, {
            id: 'poteauxerdf',
            title: 'Poteaux ERDF'
        }, {
            id: 'tronconserdf',
            title: 'Tronçons ERDF'
        }, {
            id: 'eqpoteauxerdf',
            title: 'Equipements poteaux ERDF'
        }, {
            id: 'eqtronconserdf',
            title: 'Equipements tronçons ERDF'
        }
    ];

    // selon la catégorie métier dans l'URL le template category reçoit les titre ad hoc
    categories.forEach(function(category) {
        $routeProvider
            .when('/cables/' + category.id, {
                controller: 'CategoryCtrl',
                templateUrl: 'js/templates/cables/category.htm',
                resolve: {
                    categories: function() {
                        return categories;
                    },
                    category: function() {
                        return category;
                    }
                }
            });
    });
});


app.controller('CategoryCtrl', function($rootScope, $scope, $loading, $q, categories, category, mapService, configServ, userServ, storeFlag, selectedItemService, selectedPage) {
    $scope.categories = categories;
    $scope.category = category;
    $scope.title = category.title;
    $scope.data = [];
    $scope.selectedpage;

    // Spinner
    $loading.start('spinner-1');
    var dfd = $q.defer();
    var promise = dfd.promise;
    promise.then(function(result) {
        $loading.finish('spinner-1');
    });

    configServ.getUrl('cables/config/' + category.id + '/list',
        function(schema) {
            $scope.schema = schema;
            // adding createAcces and EditAcces
            if (schema.createUrl){
                $scope.createAccess = userServ.checkLevel(3);
                $scope.editAccess = userServ.checkLevel(3);
            }
            // chargement des données sur la carte et sur dans le tableau des données métier ad hoc
            // Actions sur légende quand on clique sur l'onglet Mortalités
            if (!mapService.tabThemaData[category.id].loaded) {
                if (category.id === "mortalites") {
                    configServ.put('legendLayer:mortalites:main:visibility', "visible");
                    configServ.put('legendLayer:mortalites:mortalitesPercussions:visibility', "visible");
                    configServ.put('legendLayer:mortalites:mortalitesElectrocutions:visibility', "visible");

                    mapService.pictoLayer.mortalites.mainLayer = "css/img/couche_visible.png";
                    mapService.pictoLayer.mortalites.subLayer.mortalitesPercussions = "css/img/couche_visible.png";
                    mapService.pictoLayer.mortalites.subLayer.mortalitesElectrocutions = "css/img/couche_visible.png";
                }
            }

            // Zones sensibles : interaction entre carte, légende et onglet
            if (category.id === "zonessensibles") {
                configServ.get('legendLayer:zonessensibles:main:visibility', function(visibility){
                    if(visibility === 'visible'){
                        mapService.showLayer(null, category.id);
                    }
                });
            }
            else {
                mapService.tabThemaData[category.id].loaded = false;
                mapService.showLayer(null, category.id, 'force');
            }
            
            dfd.resolve('loading data');
        });

    $scope.$watchCollection(
        // ce qui est écouté = getLayer renvoie les objets dans un featureGroup, donc le nombre
        function() {
            return mapService.tabThemaData[category.id].getLayers();
        },
        // ce qui est déclenché quand ce qui est écouté change
        // newVal = mapService.tabThemaData.[category.id].getLayers() nouvellement modifié
        function(newVal, oldVal) {
            var data = [];
            // newVal equals to mapService.tabThemaData.zonessensibles.getLayers()
            newVal.forEach(function(layer){
                if (selectedItemService[0] !== undefined) {
                    var selectedItem = selectedItemService[0].feature.properties;
                    if (selectedItem.id === layer.feature.properties.id) {
                        layer.feature.properties.$selected = true;
                        data.push(layer.feature.properties);
                    }
                    else {
                        data.push(layer.feature.properties);
                    }
                }
                else {
                    data.push(layer.feature.properties);
                }
            });
            $scope.data.length = 0;
            $scope.data = data;

            // Envoi du numéro de la page de l'objet sélectionné
            if (selectedPage[0] !== undefined) {
                $rootScope.$broadcast('selectedPage', selectedPage[0]);
            }
        }
    );
});