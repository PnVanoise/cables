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


app.controller('CategoryCtrl', function($scope, $loading, $q, categories, category, mapService, configServ, userServ, storeFlag) {
    $scope.categories = categories;
    $scope.category = category;
    $scope.title = category.title;
    $scope.data = [];

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
            mapService.showLayer(category.id);
            dfd.resolve('loading data');
        });

    $scope.$watchCollection(
        // ce qui est écouté = getLayer renvoie les objets dans un featureGroup, donc le nombre
        function() {
            return mapService.tabThemaData[category.id].getLayers();
        },
        // ce qiu est déclenché quand ce qui est écouté change
        // newVal = mapService.tabThemaData.[category.id].getLayers() nouvellement modifié
        function(newVal) {
            var data = [];
            // newVal equals to mapService.tabThemaData.zonessensibles.getLayers()
            newVal.forEach(function(layer){
                data.push(layer.feature.properties);
            });
            $scope.data = data;
        }
    );
});



// Gestion des onglets dans la bloc tableau de données attributaires
app.controller('TabsManagerCtrl', function($rootScope, $scope, $location, storeFlag, mapService, $q) {

    $scope.displayLayer = function(pTabClickedValue) {

        // NF1 : voir layerToggle dans mapServices.js
        // var idCheckTab = pTabClickedValue+"_tab";

        if (storeFlag.getFlagLayer(pTabClickedValue) == "noLoaded"){
            // alert("dans noloaded");
            storeFlag.setFlagLayer(pTabClickedValue, "cacheChecked");
            // NF1
            // document.getElementById(idCheckTab).checked = true;
        }
        else if (storeFlag.getFlagLayer(pTabClickedValue) === "cacheUnchecked"){
            // alert("dans noloaded");
            mapService.setTabThemaData(pTabClickedValue);
            storeFlag.setFlagLayer(pTabClickedValue, "cacheChecked");
            // NF1
            // document.getElementById(idCheckTab).checked = true;
        }
    };
});