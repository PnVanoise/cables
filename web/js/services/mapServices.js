app = angular.module('mapServices');

/*
 * * #1 - configuration des types couches de bases == voir js/resource
 */
app.factory('LeafletServices', ['$http', function($http) {
    return {

        // changement du nom de "layer" en "couche"
        couche : {},

        loadData : function(layerdata) {
            this.couche = {};
            this.couche.id = layerdata.id; // nom de la couche
            this.couche.name = layerdata.name; // nom de la couche
            this.couche.active = layerdata.active; // true ou false pour activer le fond par default

            if (layerdata.type == 'tileLayer' || layerdata.type == 'ign') {
                if ( layerdata.type == 'ign') {
                    url = 'https://gpp3-wxs.ign.fr/' + layerdata.key + '/geoportail/wmts?LAYER='+layerdata.layer+'&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}';
                }
                else {
                    url = layerdata.url;
                }
                this.couche.map = new L.TileLayer(url,layerdata.options);
            }
            else if (layerdata.type == 'wms') {
                this.couche.map = L.tileLayer.wms(layerdata.url,layerdata.options);
            }
            return this.couche;
        }
    };
}]);

/*
 * * #2 - Service cartographique
 */
app.service('mapService', function($rootScope, $routeParams, $loading, $q, $timeout, $location, configServ, dataServ, LeafletServices, defaultColorService, changeColorService, storeFlag, selectedItemService, selectedCategoryService) {

    /*
     * Private variables or functions
     */

    var map;

    var geom;

    var geoms = [];

    var empriseInit;

    var zoomInit;

    var tileLayers = []; // couche pour les fonds de référence

    var currentSel = [];

    var currentBaseLayer = null;

    var editLayer;

    var self;

    /*
     * Récupération de l'url de données avec getUrl de configServ
     * Url fourni dans les contôles des base (exemple : cablesControllers.js)
     */
    var loadMapConfig = function() {
        configServ.getUrl('js/resources/defaultMap.json', function(res) {
            resource = res[0];
            //Chargement des fonds de référence : layers ==> baselayers définis defaultMap.json
            configServ.get('map:currentLayer', function(_curlayer){
                currentBaseLayer = _curlayer;
            });

            // Ajout des couches sur la carte
            if (resource.serveur === '139') {
                var i = 0;
                resource.layers.baselayers_139.forEach(function(_layer, name){
                    // Récupération des différentes propriétés pour l'affichage dans la carte et dans la légende
                    var layerData = LeafletServices.loadData(_layer);
                    var layerDataId = layerData.id;
                    var layerDataName = layerData.name;
                    var layerDataMap = layerData.map;
                    var layerDataActive = layerData.active;
                    tileLayers[i] = {id: layerDataId, name: layerDataName, active: layerDataActive, map: layerDataMap};

                    if(currentBaseLayer){
                        if(layerData.name == currentBaseLayer){
                            layerData.map.addTo(map);
                        }
                    } else {
                        if(layerData.active){
                            layerData.map.addTo(map);
                            currentBaseLayer = layerData.map;
                        }
                    }
                    i++;
                });
            }
            else if (resource.serveur === '141') {
                var i = 0;
                resource.layers.baselayers_141.forEach(function(_layer, name){
                    // Récupération des différentes propriétés pour l'affichage dans la carte et dans la légende
                    var layerData = LeafletServices.loadData(_layer);
                    var layerDataId = layerData.id;
                    var layerDataName = layerData.name;
                    var layerDataMap = layerData.map;
                    var layerDataActive = layerData.active;
                    tileLayers[i] = {id: layerDataId, name: layerDataName, active: layerDataActive, map: layerDataMap};

                    if(currentBaseLayer){
                        if(layerData.name == currentBaseLayer){
                            layerData.map.addTo(map);
                        }
                    } else {
                        if(layerData.active){
                            layerData.map.addTo(map);
                            currentBaseLayer = layerData.map;
                        }
                    }
                    i++;
                });
            };

            // Vue par défaut de la carte
            if (resource.appli === '73') {
                empriseInit = [resource.center73.lat, resource.center73.lng];
                zoomInit = resource.center73.zoom;
            };

            if (resource.appli === '74') {
                console.log('dans if')
                empriseInit = [resource.center74.lat, resource.center74.lng];
                zoomInit = resource.center74.zoom;
            };

            if (resource.appli === '38') {
                console.log('dans if')
                empriseInit = [resource.center38.lat, resource.center38.lng];
                zoomInit = resource.center38.zoom;
            };

             // Vue au premier chargement de l'appli
            map.setView(empriseInit, zoomInit);

        });
    };

    /*
     * Ajout des controls (zoom, scale, etc.) à la carte.
     */
    var addControls = function() {

        // CONTROL ECHELLE
        L.control.scale().addTo(map);

        // CONTROL EMPRISE INITIALE
        L.easyButton({
            position:"bottomleft",
            states: [{
                icon: 'glyphicon glyphicon-home',
                title: 'Emprise initiale',
                onClick: function(control) {
                    map.setView(empriseInit, zoomInit);
                }
            }]
        }).addTo(map);

        // CONTROL PLEIN ECRAN
        L.control.fullscreen({
            position: 'bottomleft',
            title: 'Afficher en plein écran !'
        }).addTo(map);

        // CONTROL ZOOM
        L.control.zoom({
            maxZoom: 18,
            position: 'bottomleft'
        }).addTo(map);

        // CONTROL LEGENDE
        layerControl = L.control.layers(tileLayers, null, { collapsed: false}).addTo(map);;
        // Suppression du conteneur de la légande Leaflet par défaut pour le recréer par la suite
        layerControl._container.remove();
        // Ajout d'un panneau de type sidebar pour contenir la légende
        var sidebar = L.control.sidebar('legendblock', {
            closeButton: true,
            position: 'left'
        });
        map.addControl(sidebar);
    };

    /*
     * Changement de couleur lorsqu'un élément est sélectionné sur la carte et la liste
     * Parameters :
     * - item : un élément (géométrique et attributaire) d'un ensemble de données métier
     * - _status : booléen pour changement de couleur et d'icônes sur sélection de l'objet
     */
    var changeColorItem = function(item, _status) {
        // Récupération des couleurs et icons initiales
        var iconElec             = defaultColorService.iconElec();               // 1- mortalités par électrocution
        var iconPerc             = defaultColorService.iconPerc();               // 2- mortalités par percussion
        var zs1                  = defaultColorService.zs1();                    // 3- zones sensibles : niveau  sensibilité 1
        var zs2                  = defaultColorService.zs2();                    // 4- zones sensibles : niveau  sensibilité 2
        var zs3                  = defaultColorService.zs3();                    // 5- zones sensibles : niveau  sensibilité 3
        var poRisqueEleve        = defaultColorService.poteauxErdfRisqueEleve();          // 6- poteaux à risques élevés
        var poRisqueSecondaire   = defaultColorService.poteauxErdfRisqueSecondaire();     // 7- poteaux à risques secondaires
        var poNonRisque          = defaultColorService.poteauxErdfPeuPasRisque();            // 8- poteaux à non risques
        var eqPoteau             = defaultColorService.eqPoteau();               // 9- équipements poteaux
        var eqTroncon            = defaultColorService.eqTroncon();              // 10- équipements tronçons
        var tronRisqueEleve      = defaultColorService.tronRisqueEleve();        // 11- tronçons risques élevés
        var tronRisqueSecondaire = defaultColorService.tronRisqueSecondaire();   // 12 - tronçons risques secondaires
        var tronNonRisque        = defaultColorService.tronNonRisque();          // 13 - tronçons non risques
        var zOffset              = 0;
        var iconelecpink;
                                                    // position de l'élément avant click
        if (_status) {
            // Changement de couleurs et icons au click
            iconElec             = changeColorService.iconElec();
            // iconelecpink = iconElec;
            iconPerc             = changeColorService.iconPerc();
            zs1                  = changeColorService.zs1();
            zs2                  = changeColorService.zs2();
            zs3                  = changeColorService.zs3();
            poRisqueEleve        = changeColorService.poRisqueEleve();
            poRisqueSecondaire   = changeColorService.poRisqueSecondaire();
            poNonRisque          = changeColorService.poNonRisque();
            eqPoteau             = changeColorService.eqPoteau();
            eqTroncon            = changeColorService.eqTroncon();
            tronRisqueEleve      = changeColorService.tronRisqueEleve();
            tronRisqueSecondaire = changeColorService.tronRisqueSecondaire();
            tronNonRisque        = changeColorService.tronNonRisque();
            zOffset              = 1000;
        }

        try {
            if(item.feature.properties.cause_mortalite === 'électrocution') {
                item.setIcon(iconElec);
            }
            else if(item.feature.properties.cause_mortalite === 'percussion') {
                item.setIcon(iconPerc);
            }
            else if(item.feature.properties.risquePoteau === 'Risque élevé') {
                item.setIcon(poRisqueEleve);
            }
            else if(item.feature.properties.risquePoteau === 'Risque secondaire') {
                item.setIcon(poRisqueSecondaire);
            }
            else if(item.feature.properties.risquePoteau === 'Peu ou pas de risque') {
                item.setIcon(poNonRisque);
            }
            if(item.feature.properties.cat === 'eqpoteauxerdf') {
                item.setIcon(eqPoteau);
            }
            if(item.feature.properties.cat === 'eqtronconserdf'){
                item.setStyle(eqTroncon);
            }
            if(item.feature.properties.cat === 'zonessensibles'){
                switch (item.feature.properties.niveau_sensibilite) {
                    case 1:
                        item.setStyle(zs1);
                    break;
                    case 2:
                        item.setStyle(zs2);
                    break;
                    case 3:
                        item.setStyle(zs3);
                    break;
                }

            }
            switch(item.feature.properties.risqueTroncon){
                case 'Risque élevé':
                    item.setStyle(tronRisqueEleve);
                break;
                case 'Risque secondaire':
                    item.setStyle(tronRisqueSecondaire);
                break;
                case 'Peu ou pas de risque':
                    item.setStyle(tronNonRisque);
                break;
            }

            item.setZIndexOffset(zOffset);
        }
        catch(e){
        }
    };

    /*
     * Chargement des données métiers
     * Parameters:
     * - category : la catégorie métier
     * - force : si on veut forcer le rechargement de la couche métier
     */
    var loadCategoryData = function(subLayer, category, force) {
        $loading.start('map-loading');
        var deferred = $q.defer();
        if (this.tabThemaData[category].loaded) { // loaded est une propriété booléenne du feature
            // s'assurer que la fonction a retourné la promise avant que la promise soit résolue = $timeout
            $timeout(function() {
                deferred.resolve();
            }, 0);
        } else {
            this.tabThemaData[category].loaded = true;
            if (force !== undefined) {
                // suppression de toutes les layers dans un featureGroup donné
                this.clear(category);
            }
            dataServ.get("cables/" + category,
                angular.bind(this, function(resp) {
                    resp.forEach(angular.bind(this, function(item) {
                        // addGeom est une fn publique. Si privée supprimé le angular.bind
                        this.addGeom(item, subLayer, category);
                    }));
                    deferred.resolve();
                }),
                function() {
                    // en cas d'erreur remettre le loaded à false
                },
                force
            );

        }
        return deferred.promise;
    };

    return {
        /*
         * Public properties or methods
         */

        /*
         * Tableau des couches métier
         */
        tabThemaData : {
            "zonessensibles" : L.featureGroup(),
            "mortalites" : L.featureGroup(),
            "tronconserdf": L.featureGroup(),
            "poteauxerdf": L.featureGroup(),
            "eqtronconserdf": L.featureGroup(),
            "eqpoteauxerdf": L.featureGroup(),
            "nidifications": L.featureGroup(),
            "obsClasse2": L.featureGroup(),
            "obsClasse3": L.featureGroup(),
            "observations": L.featureGroup(),
            "erdfappareilcoupure": L.featureGroup(),
            "erdfconnexionaerienne": L.featureGroup(),
            "erdfparafoudre": L.featureGroup(),
            "erdfposteelectrique": L.featureGroup(),
            "erdfremonteeaerosout": L.featureGroup(),
            "erdftronconaerien": L.featureGroup(),
            "ogmcablesremonteesmecaniques": L.featureGroup(),
            "ogmdomainesskiables": L.featureGroup(),
            "ogmtronconsdangereux": L.featureGroup(),
            "ogmtronconsvisualises": L.featureGroup(),
            "ogmtronconsvisualisesdangereux": L.featureGroup(),
            "rtelignes": L.featureGroup(),
            "rtepostes": L.featureGroup(),
            "rtepoteaux": L.featureGroup(),
            "communes": L.featureGroup(),
            "airelife": L.featureGroup()
        },

        /*
         * Tableau de gestion de la visibilité des couches et sous-couches dans légende
         */
        pictoLayer : {
                "communes": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "erdfappareilcoupure": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "erdfconnexionaerienne": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "erdfparafoudre": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "erdfposteelectrique": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "erdfremonteeaerosout": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "erdftronconaerien": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "ogmcablesremonteesmecaniques": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "ogmdomainesskiables": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "ogmtronconsdangereux": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "ogmtronconsvisualises": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "ogmtronconsvisualisesdangereux": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "rtelignes": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "rtepostes": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "rtepoteaux": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "zonessensibles": {
                    "mainLayer": "css/img/icones_couches_legende/couche_visible.png"
                },
                "mortalites": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png",
                    "subLayer": {
                        "mortalitesPercussions": "css/img/icones_couches_legende/couche_non_visible.png",
                        "mortalitesElectrocutions": "css/img/icones_couches_legende/couche_non_visible.png"
                    }
                },
                "tronconserdf": {
                    "mainLayer": "css/img/icones_couches_legende/couche_visible.png",
                    "subLayer": {
                        "tronconsErdfRisqueEleve": "css/img/icones_couches_legende/couche_visible.png",
                        "tronconsErdfRisqueSecondaire": "css/img/icones_couches_legende/couche_visible.png",
                        "tronconsErdfPeuPasRisque": "css/img/icones_couches_legende/couche_visible.png"
                    }
                },
                "poteauxerdf": {
                    "mainLayer": "css/img/icones_couches_legende/couche_visible.png",
                    "subLayer": {
                        "poteauxErdfRisqueEleve": "css/img/icones_couches_legende/couche_visible.png",
                        "poteauxErdfRisqueSecondaire": "css/img/icones_couches_legende/couche_visible.png",
                        "poteauxErdfPeuPasRisque": "css/img/icones_couches_legende/couche_visible.png"
                    }
                },
                "eqtronconserdf": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "eqpoteauxerdf": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png"
                },
                "nidifications": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png",
                    "subLayer": {
                        "nidificationsGypaete": "css/img/icones_couches_legende/couche_non_visible.png",
                        "nidificationsAigle": "css/img/icones_couches_legende/couche_non_visible.png",
                        "nidificationsGrandDuc": "css/img/icones_couches_legende/couche_non_visible.png",
                        "nidificationsFaucon": "css/img/icones_couches_legende/couche_non_visible.png",
                        "nidificationsCircaete": "css/img/icones_couches_legende/couche_non_visible.png",
                        "nidificationsBusardStMartin": "css/img/icones_couches_legende/couche_non_visible.png",
                        "nidificationsBusardCendre": "css/img/icones_couches_legende/couche_non_visible.png",
                        "nidificationsBusardRoseaux": "css/img/icones_couches_legende/couche_non_visible.png",
                        "nidificationsCigogneBlanche": "css/img/icones_couches_legende/couche_non_visible.png"
                    }
                },
                "observations": {
                    "mainLayer": "css/img/icones_couches_legende/couche_non_visible.png",
                    "subLayer": {
                        "observationsNombre020": "css/img/icones_couches_legende/couche_non_visible.png",
                        "observationsNombre2040": "css/img/icones_couches_legende/couche_non_visible.png",
                        "observationsSup40": "css/img/icones_couches_legende/couche_non_visible.png"
                    }
                },
                "airelife": {
                    "mainLayer": "css/img/icones_couches_legende/couche_visible.png"
                }
            },

        /*
         * Initialisation et affichage de la carte avec tout ce qu'elle contient
         * Parameters :
         * - elementId : nom de la div contenant la carte
         */
        initMap: function(elementId) {
            map = L.map(elementId, {
              zoomControl: false,
            });

            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);
            var drawControl = new L.Control.Draw({
              edit: {
                featureGroup: drawnItems,
              },
            });
            map.addControl(drawControl);

            });

            loadMapConfig();

            var aireLifeFeature = {
                "type": "Feature",
                "geometry": {
                    "type":"Polygon",
                    "coordinates":[[
                        [6.6393,46.4052],[6.7172,46.4077],[6.7576,46.4024],[6.7614,46.4],[6.7901,46.3929],[6.8053,46.3938],[6.8032,46.3911],[6.8063,46.3798],[6.801,46.3749],
                        [6.792,46.367],[6.7824,46.3664],[6.7714,46.3599],[6.7723,46.35],[6.7748,46.3471],[6.787,46.3323],[6.7965,46.3306],[6.8013,46.3208],[6.8228,46.3125],
                        [6.8317,46.3002],[6.8461,46.2907],[6.851,46.29],[6.8555,46.2917],[6.8639,46.2796],[6.8548,46.2562],[6.8405,46.2469],[6.8342,46.2374],[6.8223,46.231],
                        [6.8213,46.2241],[6.8037,46.2029],[6.8053,46.1996],[6.8071,46.1962],[6.8109,46.18],[6.8075,46.1776],[6.7937,46.164],[6.7918,46.1574],[6.7906,46.1541],
                        [6.7974,46.138],[6.8125,46.1318],[6.8154,46.1291],[6.8349,46.132],[6.8528,46.1265],[6.8973,46.1228],[6.8933,46.1055],[6.8852,46.0966],[6.8907,46.0834],
                        [6.8883,46.0731],[6.8807,46.0684],[6.8728,46.0518],[6.8881,46.0437],[6.9097,46.0518],[6.9222,46.0626],[6.9363,46.0641],[6.9381,46.054],[6.9513,46.0494],
                        [6.9608,46.0334],[6.963,46.0303],[6.9813,46.0184],[6.9871,46.0047],[7.0094,45.9969],[7.0205,45.981],[7.0128,45.9726],[7.0127,45.9659],[7.0361,45.9528],
                        [7.0415,45.9248],[7.0211,45.9146],[7.0087,45.9032],[7.0046,45.8859],[7.0031,45.8825],[6.9966,45.8728],[6.9928,45.8704],[6.9547,45.8602],[6.9377,45.847],
                        [6.9033,45.8426],[6.8794,45.8478],[6.8737,45.8422],[6.8701,45.8281],[6.8659,45.8261],[6.8615,45.8323],[6.8574,45.8343],[6.854,45.8369],[6.8403,45.8398],
                        [6.8217,45.8368],[6.8048,45.8165],[6.8072,45.8136],[6.8121,45.8077],[6.8118,45.7972],[6.804,45.7884],[6.8027,45.7782],[6.8074,45.7472],[6.816,45.7387],
                        [6.8095,45.7257],[6.8277,45.7049],[6.8404,45.6998],[6.8457,45.6938],[6.8462,45.6904],[6.8722,45.6801],[6.9015,45.6789],[6.9056,45.6768],[6.9065,45.6699],
                        [6.9023,45.6635],[6.9151,45.6607],[6.9163,45.6546],[6.915,45.6515],[6.9334,45.6464],[6.9669,45.6536],[6.9769,45.646],[6.9993,45.638],[6.9975,45.6312],
                        [6.9854,45.62],[6.979,45.5884],[6.9951,45.5711],[6.9907,45.5612],[6.9952,45.5438],[6.9921,45.5333],[7.0049,45.5183],[7.0009,45.5081],[7.0001,45.5046],
                        [7.0218,45.4967],[7.0512,45.496],[7.0549,45.4937],[7.0545,45.4872],[7.0464,45.4789],[7.0497,45.4725],[7.0785,45.4731],[7.1019,45.4683],[7.1011,45.4548],
                        [7.115,45.4408],[7.1137,45.434],[7.1504,45.4228],[7.1647,45.4129],[7.1826,45.4066],[7.1843,45.4032],[7.1777,45.3899],[7.1666,45.3829],[7.1606,45.3732],
                        [7.16,45.3594],[7.1358,45.3476],[7.1328,45.3304],[7.1243,45.3271],[7.1145,45.3287],[7.1108,45.3263],[7.1118,45.316],[7.1179,45.3103],[7.1221,45.2966],
                        [7.1354,45.2816],[7.1311,45.2717],[7.1352,45.2543],[7.1263,45.2459],[7.1115,45.2444],[7.0837,45.2245],[7.076,45.2119],[7.0665,45.2111],[7.0545,45.2224],
                        [7.0513,45.2251],[7.0416,45.2244],[7.0257,45.2164],[7.0014,45.2175],[6.9902,45.2108],[6.971,45.2076],[6.9635,45.2036],[6.9648,45.1967],[6.9542,45.1896],
                        [6.9514,45.1796],[6.943,45.176],[6.9452,45.1728],[6.8931,45.1655],[6.8862,45.1562],[6.8955,45.14],[6.8546,45.1284],[6.797,45.1527],[6.792,45.1531],
                        [6.7697,45.1591],[6.7474,45.1406],[6.7389,45.1373],[6.7114,45.1445],[6.7067,45.1434],[6.6788,45.1376],[6.6714,45.1246],[6.6501,45.1158],[6.6354,45.115],
                        [6.6301,45.1091],[6.6271,45.1026],[6.6368,45.093],[6.625,45.0973],[6.6247,45.0974],[6.6162,45.1004],[6.6077,45.104],[6.6038,45.1058],[6.5992,45.1076],
                        [6.5908,45.1111],[6.5839,45.1143],[6.5823,45.115],[6.5738,45.1183],[6.5653,45.1215],[6.5608,45.1228],[6.5568,45.1238],[6.5483,45.1253],[6.5398,45.1259],
                        [6.5313,45.1256],[6.5228,45.1243],[6.5162,45.1228],[6.5143,45.1222],[6.5058,45.1193],[6.4973,45.1162],[6.4922,45.1143],[6.4889,45.1127],[6.4804,45.1088],
                        [6.4729,45.1058],[6.4719,45.1052],[6.4634,45.1013],[6.4549,45.0983],[6.4513,45.0973],[6.4464,45.0956],[6.4379,45.0934],[6.4294,45.092],[6.4209,45.0919],
                        [6.4124,45.0932],[6.4039,45.0955],[6.3995,45.0973],[6.3954,45.0987],[6.3869,45.1036],[6.384,45.1058],[6.3785,45.1093],[6.3726,45.1143],[6.37,45.1162],
                        [6.3628,45.1228],[6.3615,45.1239],[6.3542,45.1313],[6.353,45.1324],[6.3463,45.1397],[6.3445,45.1417],[6.3388,45.1482],[6.336,45.1515],[6.3318,45.1567],
                        [6.3275,45.1626],[6.3255,45.1652],[6.3195,45.1737],[6.319,45.1745],[6.3138,45.1822],[6.3105,45.188],[6.3088,45.1907],[6.3038,45.1992],[6.302,45.2031],
                        [6.2993,45.2077],[6.2949,45.2162],[6.2935,45.2197],[6.2908,45.2247],[6.2866,45.2332],[6.285,45.2382],[6.2829,45.2416],[6.279,45.2501],[6.2766,45.2578],
                        [6.2747,45.2586],[6.2681,45.2666],[6.2663,45.2586],[6.2613,45.2501],[6.2596,45.2486],[6.2553,45.2416],[6.2511,45.2364],[6.2489,45.2332],[6.2426,45.2257],
                        [6.2418,45.2247],[6.2341,45.2169],[6.2333,45.2162],[6.2256,45.2097],[6.2227,45.2077],[6.2171,45.2041],[6.2086,45.1992],[6.2086,45.1992],[6.2001,45.1959],
                        [6.1916,45.1934],[6.1831,45.192],[6.1747,45.1919],[6.1662,45.1928],[6.1577,45.195],[6.1492,45.1981],[6.1471,45.1992],[6.1407,45.2024],[6.1329,45.2077],
                        [6.1322,45.2082],[6.1237,45.2157],[6.1233,45.2162],[6.116,45.2247],[6.1152,45.2257],[6.1104,45.2332],[6.1067,45.2402],[6.106,45.2416],[6.1025,45.2501],
                        [6.1002,45.2586],[6.0986,45.2671],[6.0982,45.2724],[6.0982,45.2724],[6.098,45.2756],[6.0982,45.2812],[6.0983,45.2841],[6.0994,45.2926],[6.1015,45.3011],
                        [6.1048,45.3096],[6.1067,45.3135],[6.109,45.3181],[6.1145,45.3266],[6.1152,45.3275],[6.122,45.3351],[6.1237,45.3367],[6.1314,45.3435],[6.1322,45.3442],
                        [6.1407,45.3495],[6.1463,45.352],[6.1492,45.3534],[6.1577,45.3564],[6.1662,45.3582],[6.1747,45.3591],[6.1831,45.3587],[6.1916,45.357],[6.2001,45.354],
                        [6.2046,45.352],[6.2086,45.3503],[6.2171,45.3446],[6.2184,45.3435],[6.2256,45.3372],[6.2278,45.3351],[6.2341,45.3283],[6.2357,45.3266],[6.2425,45.3181],
                        [6.2426,45.3179],[6.2482,45.3096],[6.2511,45.3042],[6.2532,45.3011],[6.2581,45.2926],[6.2596,45.2887],[6.2627,45.2841],[6.2667,45.2756],[6.2681,45.2677],
                        [6.2766,45.2721],[6.2772,45.2756],[6.2809,45.2841],[6.285,45.2902],[6.2858,45.2926],[6.2902,45.3011],[6.2935,45.3066],[6.2947,45.3096],[6.2993,45.3181],
                        [6.302,45.3222],[6.3041,45.3266],[6.3092,45.3351],[6.3105,45.3371],[6.314,45.3435],[6.319,45.3513],[6.3195,45.352],[6.3251,45.3605],[6.3275,45.3639],
                        [6.3308,45.369],[6.336,45.3759],[6.3372,45.3775],[6.344,45.386],[6.3445,45.3866],[6.3512,45.3945],[6.353,45.3967],[6.3588,45.403],[6.3615,45.406],
                        [6.3669,45.4115],[6.37,45.4146],[6.3757,45.42],[6.3785,45.4227],[6.3853,45.4285],[6.3869,45.43],[6.3954,45.4369],[6.3955,45.437],[6.4039,45.443],
                        [6.4083,45.4454],[6.4124,45.4479],[6.4209,45.4526],[6.425,45.4539],[6.4294,45.4557],[6.4379,45.4584],[6.4464,45.4603],[6.4549,45.4613],[6.4634,45.4617],
                        [6.4719,45.4616],[6.4804,45.461],[6.4889,45.4604],[6.4973,45.4598],[6.5058,45.4595],[6.5143,45.4603],[6.5228,45.4623],[6.5232,45.4624],[6.5313,45.466],
                        [6.5387,45.4709],[6.5398,45.4717],[6.5481,45.4794],[6.5483,45.4796],[6.5553,45.4879],[6.5568,45.4897],[6.561,45.4964],[6.5653,45.5031],[6.5662,45.5049],
                        [6.5706,45.5134],[6.5738,45.52],[6.5745,45.5219],[6.5775,45.5304],[6.5805,45.5389],[6.5823,45.5455],[6.5827,45.5474],[6.5842,45.5558],[6.5849,45.5643],
                        [6.5852,45.5728],[6.5848,45.5813],[6.5841,45.5898],[6.583,45.5983],[6.5823,45.6037],[6.5817,45.6068],[6.5803,45.6153],[6.5787,45.6238],[6.5773,45.6323],
                        [6.5761,45.6408],[6.5749,45.6493],[6.5738,45.6574],[6.5737,45.6577],[6.5724,45.6662],[6.5707,45.6747],[6.5686,45.6832],[6.5661,45.6917],[6.5653,45.6939],
                        [6.5612,45.7002],[6.5568,45.7042],[6.5483,45.7073],[6.5398,45.7072],[6.5313,45.7055],[6.5228,45.7032],[6.5143,45.701],[6.5114,45.7002],[6.5058,45.6984],
                        [6.4973,45.6958],[6.4889,45.6938],[6.4804,45.6921],[6.4774,45.6917],[6.4719,45.6907],[6.4634,45.6894],[6.4549,45.6885],[6.4464,45.688],[6.4379,45.688],
                        [6.4294,45.6881],[6.4209,45.6886],[6.4124,45.6895],[6.4039,45.6904],[6.3954,45.6913],[6.3916,45.6917],[6.3869,45.6921],[6.3785,45.6928],[6.37,45.6932],
                        [6.3615,45.6931],[6.353,45.6922],[6.3502,45.6917],[6.3445,45.6904],[6.336,45.6862],[6.3313,45.6832],[6.3275,45.68],[6.3224,45.6747],[6.319,45.6705],
                        [6.3161,45.6662],[6.3107,45.6577],[6.3105,45.6575],[6.3051,45.6493],[6.302,45.6449],[6.2992,45.6408],[6.2935,45.6334],[6.2925,45.6323],[6.285,45.6248],
                        [6.2839,45.6238],[6.2766,45.6183],[6.2717,45.6153],[6.2681,45.6131],[6.2596,45.6092],[6.2523,45.6068],[6.2511,45.6064],[6.2426,45.6047],[6.2341,45.6036],
                        [6.2256,45.6034],[6.2171,45.6037],[6.2086,45.6048],[6.2001,45.6064],[6.199,45.6068],[6.1916,45.609],[6.1831,45.6123],[6.1769,45.6153],[6.1747,45.6163],
                        [6.1662,45.6218],[6.1635,45.6238],[6.1577,45.6285],[6.1538,45.6323],[6.1492,45.6378],[6.1469,45.6408],[6.1416,45.6493],[6.1407,45.6516],[6.1382,45.6577],
                        [6.1357,45.6662],[6.1345,45.6747],[6.134,45.6832],[6.1345,45.6917],[6.1356,45.7002],[6.1378,45.7087],[6.1405,45.7172],[6.1407,45.7177],[6.1439,45.7257],
                        [6.1483,45.7342],[6.1492,45.7359],[6.1527,45.7427],[6.1574,45.7512],[6.1577,45.7516],[6.1623,45.7596],[6.1662,45.7675],[6.1664,45.7681],[6.1702,45.7766],
                        [6.1733,45.7851],[6.1747,45.7898],[6.1756,45.7936],[6.1774,45.8021],[6.179,45.8106],[6.1809,45.8191],[6.1825,45.8276],[6.1831,45.831],[6.184,45.8361],
                        [6.1859,45.8446],[6.1879,45.8531],[6.1906,45.8615],[6.1916,45.8649],[6.193,45.87],[6.1957,45.8785],[6.1991,45.887],[6.2001,45.8898],[6.202,45.8955],
                        [6.2049,45.904],[6.208,45.9125],[6.2086,45.9145],[6.2105,45.921],[6.2126,45.9295],[6.2147,45.938],[6.2164,45.9465],[6.2171,45.9505],[6.2177,45.955],
                        [6.219,45.9635],[6.2201,45.9719],[6.2213,45.9804],[6.2231,45.9889],[6.2249,45.9974],[6.2256,46.0003],[6.2268,46.0059],[6.2293,46.0144],[6.2326,46.0229],
                        [6.2341,46.0261],[6.2363,46.0314],[6.2408,46.0399],[6.2426,46.0426],[6.2461,46.0484],[6.2511,46.0551],[6.2525,46.0569],[6.2596,46.0649],[6.26,46.0654],
                        [6.2681,46.0737],[6.2682,46.0738],[6.2766,46.0818],[6.2771,46.0823],[6.285,46.0894],[6.2866,46.0908],[6.2935,46.097],[6.296,46.0993],[6.302,46.1047],
                        [6.3052,46.1078],[6.3105,46.1127],[6.3143,46.1163],[6.319,46.1207],[6.3233,46.1248],[6.3275,46.1287],[6.3323,46.1333],[6.336,46.1368],[6.3417,46.1418],
                        [6.3445,46.1444],[6.3513,46.1503],[6.353,46.1518],[6.3614,46.1588],[6.3615,46.1588],[6.37,46.1655],[6.3725,46.1673],[6.3785,46.1716],[6.3854,46.1757],
                        [6.3869,46.1768],[6.3954,46.182],[6.3999,46.1842],[6.4039,46.1866],[6.4124,46.1908],[6.4171,46.1927],[6.4209,46.1946],[6.4294,46.1985],[6.437,46.2012],
                        [6.4379,46.2016],[6.4464,46.2054],[6.4549,46.2085],[6.4583,46.2097],[6.4634,46.212],[6.4719,46.2158],[6.4775,46.2182],[6.4804,46.2197],[6.4889,46.2241],
                        [6.4939,46.2267],[6.4973,46.2287],[6.5058,46.2338],[6.5083,46.2352],[6.5143,46.239],[6.5224,46.2437],[6.5228,46.2439],[6.5313,46.2487],[6.5387,46.2522],
                        [6.5398,46.2528],[6.5483,46.2571],[6.5568,46.2606],[6.5569,46.2607],[6.5653,46.2639],[6.5738,46.2668],[6.5816,46.2692],[6.5823,46.2694],[6.5908,46.2718],
                        [6.5992,46.2745],[6.6077,46.2775],[6.6082,46.2776],[6.6162,46.2819],[6.6215,46.2861],[6.6247,46.2902],[6.627,46.2946],[6.6294,46.3031],[6.6302,46.3116],
                        [6.6302,46.3201],[6.6297,46.3286],[6.6292,46.3371],[6.6288,46.3456],[6.6287,46.3541],[6.6291,46.3626],[6.6297,46.3711],[6.6313,46.3795],[6.6331,46.388],
                        [6.6332,46.3885],[6.6357,46.3965],[6.6392,46.405],[6.6393,46.4052]
                    ]]
                }
            };
            var aireLifeJson = L.GeoJSON.geometryToLayer(aireLifeFeature);
            this.tabThemaData["airelife"].addLayer(aireLifeJson);
            this.tabThemaData["airelife"].addLayer(aireLifeJson);
            map.addLayer(this.tabThemaData["airelife"]);

            // Ajout des controls sur la carte
            addControls();

            // Si aucun changement dans sélection, zoom et surbrillance sur sélection courante
            $rootScope.$watchCollection(function() {
                return selectedItemService;
            }, angular.bind(this, function(newVal, oldVal) {
                // don't take first call into account
                if (newVal == oldVal) {
                    return;
                }
                if (newVal) {
                    this.zoomAndHighlightItem(selectedItemService);
                }
            }));

            return map;
        },

        /*
         * Récupération des couches visibles après filtre depuis tableau de données
         */
        getVisibleItems: function() {
            var bounds = map.getBounds();
            var visibleItems = [];
            geoms.forEach(function(item){
                try{
                    var _coords = item.getLatLng();
                }
                catch(e){
                    var _coords = item.getLatLngs();
                }
                try{
                    if(bounds.intersects(_coords)){
                        visibleItems.push(item.feature.properties.id);
                    }
                }
                catch(e){
                    if(bounds.contains(_coords)){
                        visibleItems.push(item.feature.properties.id);
                    }
                }
            });

            return visibleItems;
        },

        /*
         * Mise en service des couches de référence raster
         */
        getTileLayers: function() {
            return tileLayers;
        },

        /*
         * Mise en service des couches métiers
         */
        getLayer:  function(layer) {
            return this.tabThemaData[layer];
        },

        /*
         * Mise en service des contrôles de la carte
         */
        getLayerControl: function() {
            return layerControl;
        },

        /*
         * Mise en service de la carte
         */
        getMap: function() {
            return map;
        },

        /*
         * Mise en service du tableau de couches Leaflet GeoJSON
         * *** A SUPPRIMER *** => voir issue #110
         */
        getGeoms: function() {
            return geoms;
        },

        /*
         * Ajout (affichage) des couches métiers sur la carte
         * Parameters :
         * - layer : Couche métier
         */
        showLayer: function(subLayer, category, force) {
            var deferred = $q.defer();
            var promise = loadCategoryData.call(this, subLayer, category, force);
            promise.then(
                angular.bind(this, function() {
                    var categoryAdded = this.tabThemaData[category];
                    map.addLayer(categoryAdded);
                    if (category === 'zonessensibles') {
                        categoryAdded.bringToBack();
                    }
                    // if (subLayer === 'poteauxerdf' || 'tronconserdf' || 'nidifications' || 'observations') {
                    //     this.changeVisibilityLayer(category, subLayer);
                    // }
                    // map.addLayer(this.tabThemaData[category]);
                    deferred.resolve();
                    $loading.finish('map-loading');
                })
            );
            return deferred.promise;
        },

        /*
         * Suppression (désaffichage) des couches métiers sur la carte
         * Parameters :
         * - layer : Couche métier
         */
        hideLayer: function(layer) {
            map.removeLayer(this.tabThemaData[layer]);
        },

        /*
         * Vérification de l'affichage des couches métiers sur la carte
         * Parameters :
         * - layer : Couche métier
         */
        layerIsVisible: function(layer) {
            return map.hasLayer(this.tabThemaData[layer]);
        },

        /*
         * Permet de zoomer sur un objets quel que soit son type (point, ligne et polygone)
         * Parameters :
         * - item : un élément (géométrique et attributaire) d'un ensemble de données métier
         */
        zoomToItem: function(item) {
            try {
                // centre la carte sur l'objet point sélectionné
                map.setView(item.getLatLng(), Math.max(map.getZoom(), 13));
            }
            catch(e) {
                // centre la carte sur l'objet ligneou polygone sélectionné
                map.fitBounds(item.getBounds());
            }
        },

        /*
         * Permet de zoomer sur des objets quel que soit leurs types
         * Parameters :
         * - collection : une collection de features
         */
        zoomToCollection: function(collection) {
            var fg = new L.FeatureGroup(collection);
            map.fitBounds(fg.getBounds());
        },

        /*
         * Actions faites (zoom et couleur de sélection) sur la sélection d'un
         * élément sur la carte ou dans un tableau
         * Parameters :
         * - collection : la collection de géométrie à mettre en évidence
         *                dans la carte
         */
        zoomAndHighlightItem: function(collection) {
            // Si on est en édition le zoom et recentrage
            // sur un objet dans la carte n'est pas actif
            if ($location.path().split('/')[2]=='edit') { return; }

            // sélection courante = pas de changement de couleur
            currentSel.forEach(function(item) {
                changeColorItem(item, false);
            }.bind(this));
            currentSel = collection.slice();
            this.zoomToCollection(collection);
            collection.forEach(function(item) {
              // changement de couleur sur item sélectionné
              changeColorItem(item, true);
            }.bind(this));
        },

        manageColor: function(item, category, subLayer, style, color, noVisibleStyle, defaultStyle, changeStyle) {
            var layerVisibility;
            configServ.get('legendLayer:'+category+':'+subLayer+':visibility', function(visibility){
            // configServ.get('legendLayer:tronconserdf:tronconsErdfRisqueEleve:visibility', function(visibility){
                layerVisibility = visibility;
            });

            // 0 - Couche non visible dans la carte = couche décochée dans légende
            if(layerVisibility === 'novisible'){
                // console.log('addgeom 0')
                if (style === 'marker') {
                    item.setIcon(noVisibleStyle);
                }
                else if (style === 'line') {
                    item.setStyle(noVisibleStyle);
                }
                else if (style === 'poly') {
                    item.setStyle(noVisibleStyle);
                }
            }
            else {
                // console.log('addgeom else novisible')
                // 1 - page avec tableau = URL avec catégorie SANS id objet
                if ($routeParams.id === undefined) {
                    // console.log('addgeom 1');
                    // 2 - pas d'objet sélection = selectedItemService[0] vide
                    // => tous les objets avec couleur par défaut
                    if (selectedItemService[0] === undefined) {
                        // console.log('addgeom 2');
                        if (style === 'marker') {
                            item.setIcon(defaultStyle);
                        }
                        else if (style === 'line') {
                            item.setStyle(defaultStyle);
                        }
                        else if (style === 'poly') {
                            item.setStyle(angular.extend({color: color}, defaultStyle));
                        }
                    }
                    // 2' - objet sélectionné = selectedItemService[0] rempli
                    else {
                        // console.log('addgeom 2\'');
                        // 3 - objet dans tabThemaData = objet dans selectedItemService[0]
                        // => l'objet avec couleur de sélection
                        if (category === selectedCategoryService[0]) {
                            // console.log('mapservice managecolor 3')
                            if (item.feature.properties.id === selectedItemService[0].feature.properties.id) {
                                // console.log('addgeom 3');
                                selectedItemService.length = 0;
                                // selectedCategoryService.length = 0;
                                selectedItemService.push(item);
                                // console.log('mapservice push 1');
                                // selectedCategoryService.push(category);
                                if (style === 'marker') {
                                item.setIcon(changeStyle);
                                }
                                else if (style === 'line') {
                                    item.setStyle(changeStyle);
                                }
                                else if (style === 'poly') {
                                    item.setStyle(angular.extend({color: color}, changeStyle));
                                }
                            }
                            // 3' - tous les autres objets avec couleur par défaut
                            else {
                                // console.log('addgeom 3\'');
                                if (style === 'marker') {
                                    item.setIcon(defaultStyle);
                                }
                                else if (style === 'line') {
                                    item.setStyle(defaultStyle);
                                }
                                else if (style === 'poly') {
                                    item.setStyle(angular.extend({color: color}, defaultStyle));
                                }
                            }
                        }
                        else {
                            if (style === 'marker') {
                                item.setIcon(defaultStyle);
                            }
                            else if (style === 'line') {
                                item.setStyle(defaultStyle);
                            }
                            else if (style === 'poly') {
                                item.setStyle(angular.extend({color: color}, defaultStyle));
                            }
                        }
                    }
                }
                // 1' - page Détail ou Edition = URL avec catégorie AVEC id objet             
                else {
                    // console.log('addgeom 1\'');
                    // 4 - objet dans tabThemaData = objet avec id dans URL
                    // => l'objet avec couleur de sélection
                    if (item.feature.properties.id === parseInt($routeParams.id)) {
                        // console.log('addgeom 4');
                        selectedItemService.length = 0;
                        selectedCategoryService.length = 0;
                        selectedItemService.push(item);
                        selectedCategoryService.push(category);
                        // console.log('mapservice push 2');
                        if (style === 'marker') {
                            item.setIcon(changeStyle);
                        }
                        else if (style === 'line') {
                            item.setStyle(changeStyle);
                        }
                        else if (style === 'poly') {
                            item.setStyle(angular.extend({color: color}, changeStyle));
                        }
                    }
                    // 4' - tous les autres objets avec couleur par défaut
                    else {
                        // console.log('addgeom 4\'');
                        if (style === 'marker') {
                            item.setIcon(defaultStyle);
                        }
                        else if (style === 'line') {
                            item.setStyle(defaultStyle);
                        }
                        else if (style === 'poly') {
                            item.setStyle(angular.extend({color: color}, defaultStyle));
                        }
                    }
                }

            }
        },

        /*
         * Création des couches Leaflet (featureGroup) depuis le json renvoyé par Symfony pour une catégorie métier
         * Parameters :
         * - jsonData : Json utilisé pour créer la couche métier Leaflet
         * - categoryData : nom de la catégorie métier utilisée qui va être créée
         */
        addGeom: function(jsonData, filter, categoryData) {
            var geom = L.GeoJSON.geometryToLayer(jsonData); // la couche GeoJSON
            geom.feature = jsonData;
            var cat = jsonData.properties.cat; // récupération de la catégorie

            // Au click: Zoom et affiche le label de la couche s'il y'en a
            geom.on('click', function(e){
                $rootScope.$apply(function() {
                    if (!e.originalEvent.ctrlKey) {
                        selectedItemService.length = 0;
                        selectedCategoryService.length = 0;
                    }
                    if (selectedCategoryService.length > 0
                      && selectedCategoryService.indexOf(cat) === -1) {
                      return;
                    }
                    selectedItemService.push(geom);
                    selectedCategoryService.push(cat);
                });
            });
            if (jsonData.properties.geomLabel) {
                geom.bindPopup(jsonData.properties.geomLabel);
            }
            try {
                geom.setZIndexOffset(0);
            } catch(e) {}

            /*
             * Distribution des couleurs aux différentes couches
             */

// COUCHES DE REFERENCE = ERDF, RTE, OGM, COMMUNES
             switch (jsonData.properties.cat) {
                case'erdfappareilcoupure':
                    geom.setIcon(defaultColorService.erdfac())
                    break;
                case'erdfconnexionaerienne':
                    geom.setIcon(defaultColorService.erdfca())
                    break;
                case'erdfposteelectrique':
                    geom.setIcon(defaultColorService.erdfpe())
                    break;
                case'erdfremonteeaerosout':
                    geom.setIcon(defaultColorService.erdfra())
                    break;
                 case'erdfparafoudre':
                    geom.setIcon(defaultColorService.erdfp())
                    break;
                case'erdftronconaerien':
                    geom.setStyle(defaultColorService.erdfta())
                    break;
                case'ogmcablesremonteesmecaniques':
                    geom.setStyle(defaultColorService.ogmrm())
                    break;
                case'ogmtronconsdangereux':
                    geom.setStyle(defaultColorService.ogmtd())
                    break;
                case'ogmtronconsvisualises':
                    geom.setStyle(defaultColorService.ogmtv())
                    break;
                case'ogmtronconsvisualisesdangereux':
                    geom.setStyle(defaultColorService.ogmtvd())
                    break;
                case'rtelignes':
                    geom.setStyle(defaultColorService.rtel())
                    break;
                case'rtepostes':
                    geom.setIcon(defaultColorService.rtep())
                    break;
                case'rtepoteaux':
                    geom.setIcon(defaultColorService.rtepot())
                    break;
                case'communes':
                    geom.setStyle(defaultColorService.com())
                    break;
             }

// COUCHES METIER
// ZONES SENSIBLES : Couleurs en fonctions du niveau de sensibilité
            if(jsonData.properties.cat === 'zonessensibles'){
                switch (jsonData.properties.niveau_sensibilite) {
                    case 1:
                        geom.setStyle(angular.extend(defaultColorService.zs1(), defaultColorService.zsStyle()))
                    break;
                    case 2:
                        geom.setStyle(angular.extend(defaultColorService.zs2(), defaultColorService.zsStyle()))
                    break;
                    case 3:
                        geom.setStyle(angular.extend(defaultColorService.zs3(), defaultColorService.zsStyle()))
                    break;
                }
                geom.bindLabel(jsonData.properties.nom_zone_sensible, { noHide: true });
            }

// MORTALITES
            if(jsonData.properties.cat === 'mortalites') {
                // MORTALITES ELECTROCUTION
                if(jsonData.properties.cause_mortalite === 'électrocution'){
                    this.manageColor(
                        geom, 
                        'mortalites', 
                        'mortalitesElectrocutions',
                        'marker', 
                        null,
                        defaultColorService.poNoVisible(), 
                        defaultColorService.iconElec(),
                        changeColorService.iconElec()
                    );
                }

                // MORTALITES PERCUSSION
                else if(jsonData.properties.cause_mortalite === 'percussion'){
                    this.manageColor(
                        geom,
                        'mortalites', 
                        'mortalitesPercussions', 
                        'marker',
                        null,
                        defaultColorService.poNoVisible(), 
                        defaultColorService.iconPerc(), 
                        changeColorService.iconPerc()
                    );
                };
            };

// TRONCONS A RISQUE
            if(jsonData.properties.cat === 'tronconserdf') {
                if (jsonData.properties.risqueTroncon === 'Risque élevé') {
                    this.manageColor(
                        geom, 
                        'tronconserdf', 
                        'tronconsErdfRisqueEleve',
                        'line', 
                        null,
                        defaultColorService.tronNoVisible(), 
                        defaultColorService.tronRisqueEleve(),
                        changeColorService.tronRisqueEleve()
                    );
                }
                
                if (jsonData.properties.risqueTroncon === 'Risque secondaire') {
                    this.manageColor(
                        geom, 
                        'tronconserdf', 
                        'tronconsErdfRisqueSecondaire',
                        'line', 
                        null,
                        defaultColorService.tronNoVisible(), 
                        defaultColorService.tronRisqueSecondaire(),
                        changeColorService.tronRisqueSecondaire()
                    );
                }

                if (jsonData.properties.risqueTroncon === 'Peu ou pas de risque') {
                    this.manageColor(
                        geom, 
                        'tronconserdf', 
                        'tronconsErdfPeuPasRisque',
                        'line', 
                        null,
                        defaultColorService.tronNoVisible(), 
                        defaultColorService.tronNonRisque(),
                        changeColorService.tronNonRisque()
                    );
                }
            };

// POTEAUX A RISQUE : Couleur en fonction du niveau de risque
            if(jsonData.properties.cat === 'poteauxerdf'){
                if (jsonData.properties.risquePoteau === 'Risque élevé') {
                    this.manageColor(
                        geom, 
                        'poteauxerdf', 
                        'poteauxErdfRisqueEleve',
                        'marker', 
                        null,
                        defaultColorService.poNoVisible(), 
                        defaultColorService.poteauxErdfRisqueEleve(),
                        changeColorService.poRisqueEleve()
                    );
                }
                
                if (jsonData.properties.risquePoteau === 'Risque secondaire') {
                    this.manageColor(
                        geom, 
                        'poteauxerdf', 
                        'poteauxErdfRisqueSecondaire',
                        'marker', 
                        null,
                        defaultColorService.poNoVisible(), 
                        defaultColorService.poteauxErdfRisqueSecondaire(),
                        changeColorService.poRisqueSecondaire()
                    );
                }

                if (jsonData.properties.risquePoteau === 'Peu ou pas de risque') {
                    this.manageColor(
                        geom, 
                        'poteauxerdf', 
                        'poteauxErdfPeuPasRisque',
                        'marker', 
                        null,
                        defaultColorService.poNoVisible(), 
                        defaultColorService.poteauxErdfPeuPasRisque(),
                        changeColorService.poNonRisque()
                    );
                }
            };

// EQUIPEMENTS TRONCONS
            if(jsonData.properties.cat === 'eqtronconserdf'){
                this.manageColor(
                    geom, 
                    'eqtronconserdf', 
                    'main',
                    'line', 
                    null,
                    defaultColorService.tronNoVisible(), 
                    defaultColorService.eqTroncon(),
                    changeColorService.eqTroncon()
                );
            }

// // EQUIPEMENTS POTEAUX
            if(jsonData.properties.cat === 'eqpoteauxerdf'){
                this.manageColor(
                    geom, 
                    'eqpoteauxerdf', 
                    'main',
                    'marker', 
                    null,
                    defaultColorService.poNoVisible(), 
                    defaultColorService.eqPoteau(),
                    changeColorService.eqPoteau()
                );
            }

// SITES DE NIDIFICATION : Couleur en fonction de l'espece
            if(jsonData.properties.cat === 'nidifications'){
               if (jsonData.properties.nom_espece === 'Aigle royal') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsAigle',
                        'poly', 
                        '#2E64FE',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }

                if (jsonData.properties.nom_espece === 'Grand Duc d\'Europe') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsGrandDuc',
                        'poly', 
                        '#8904B1',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }

                if (jsonData.properties.nom_espece === 'Faucon pélerin') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsFaucon',
                        'poly', 
                        '#088A08',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }

                if (jsonData.properties.nom_espece === 'Gypaète barbu') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsGypaete',
                        'poly', 
                        '#08088A',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }

                if (jsonData.properties.nom_espece === 'Circaète Jean-le-Blanc') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsCircaete',
                        'poly', 
                        '#FFFF00',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }

                if (jsonData.properties.nom_espece === 'Busard Saint-Martin') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsBusardStMartin',
                        'poly', 
                        '#FF4000',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }

                if (jsonData.properties.nom_espece === 'Busard cendré') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsBusardCendre',
                        'poly', 
                        '#8A2908',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }

                if (jsonData.properties.nom_espece === 'Busard des roseaux') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsBusardRoseaux',
                        'poly', 
                        '#3B170B',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }

                if (jsonData.properties.nom_espece === 'Cigogne blanche') { 
                   this.manageColor(
                        geom, 
                        'nidifications', 
                        'nidificationsCigogneBlanche',
                        'poly', 
                        '#FE2EC8',
                        defaultColorService.noPolyStyle(), 
                        defaultColorService.polyStyle(),
                        changeColorService.polyStyle()
                    );
                }
            }

// OBSERVATIONS : Classes en fonction du nb d'individus
            if(jsonData.properties.cat === 'observations'){
                if (jsonData.properties.nombre < 20) { 
                   this.manageColor(
                        geom, 
                        'observations', 
                        'observationsNombre020',
                        'marker', 
                        null,
                        defaultColorService.poNoVisible(), 
                        defaultColorService.obsClasse1(),
                        changeColorService.obsClasse1()
                    );
                }

                if (jsonData.properties.nombre >= 20 && jsonData.properties.nombre < 40) { 
                   this.manageColor(
                        geom, 
                        'observations', 
                        'observationsNombre2040',
                        'marker', 
                        null,
                        defaultColorService.poNoVisible(), 
                        defaultColorService.obsClasse2(),
                        changeColorService.obsClasse2()
                    );
                }

                if (jsonData.properties.nombre >= 40) { 
                   this.manageColor(
                        geom, 
                        'observations', 
                        'observationsSup40',
                        'marker', 
                        null,
                        defaultColorService.poNoVisible(), 
                        defaultColorService.obsClasse3(),
                        changeColorService.obsClasse3()
                    );
                }
            };

            // Ajout des couches dans le tableau des couches geoms
            // A SUPPRIMER A TERME => voir issue #110
            geoms.push(geom);

            // Ajout des couches GeoJSON dans les couches métiers
            this.tabThemaData[categoryData].addLayer(geom);

            return geom;
        },

        /*
         * Suppression de tous les objets dans un featureGroup donné
         * Parameters :
         * - category : nom de la catégorie métier utilisée pour la suppression des objets associés
         */
        clear: function(category) {
            this.tabThemaData[category].clearLayers();
        },

        /*
         * Suppression de la couche temporaire d'édition des objets des différentes catégories métier
         * Parameters :
         */
        clearEditLayer: function() {
            if(editLayer)
            {
                map.removeLayer(editLayer);
            }
        },

        /*
         * Récupération de la catégorie de la couche temporaire d'édition en cours
         * Parameters :
         * - EditLayerCat : nom de la catégorie métier en cours d'édition
         */
        setEditLayer: function(EditLayerCat) {
            editLayer = EditLayerCat;
        },

        /*
         * Chargement des couches sur la carte depuis tableau de données (clique sur onglet)
         * FIXME
         * Parameters :
         * - pTabClickedValue : valeur de l'nglet sur lequel on a cliqué (=catégorie donnée métier)
         */
        setTabThemaData: function(pTabClickedValue){
            map.addLayer(tabThemaData[pTabClickedValue]);
            document.getElementById(pTabClickedValue).checked = true;
        },

        /*
         * Gestion des couches de référence raster
         * FIXME
         * Parameters :
         * - baseLayer : valeur de l'nglet sur lequel on a cliqué (=catégorie donnée métier)
         */
        setBaseLayer: function(baseLayer) {
            if (currentBaseLayer) {
                map.removeLayer(currentBaseLayer);
            }
            currentBaseLayer = baseLayer;
            baseLayer.addTo(map);
        }
    };
});

 /*
  * * #3 - Directive pour la gestion de la carte Leaflet et des couches
  */
app.directive('leafletMap', function(){
    return {
        restrict: 'A',
        scope: {
            data: '=',
            name: '='
        },
        templateUrl: 'js/templates/display/map.htm',
        controller: function($scope, configServ, mapService, storeFlag) {
            var map = mapService.initMap('mapd');
            var tabThemaData = mapService.tabThemaData;

            $scope.tileLayers = mapService.getTileLayers();

            $scope.selectBaseLayer = function(layer) {
                mapService.setBaseLayer(layer);
            }

            // Nom de l'appli pour le éléments distincts entre chaque appli
            configServ.getUrl('js/resources/defaultMap.json', function(res) {
                resource = res[0];
                $scope.appliDep = resource.appli;
            });

            // collapsed bandeau
            $scope.toggleBandeau = function() {
               $scope.affichebandeau = !$scope.affichebandeau;
            };

            var pictoLayerVisible = "css/img/icones_couches_legende/couche_visible.png";
            var pictoLayerNoVisible = "css/img/icones_couches_legende/couche_non_visible.png";
            var category = $scope.category;
            var filter = $scope.filter;

            // Affectation des pictos de chaque couche à un objet du scope qui sera utilisé dans le template
            $scope.pictoLayer = mapService.pictoLayer;
            
            // gestion affichage des couches et des pictos associés
            $scope.getVisibility = function(category, subLayer){
                // Clic sur le picto oeil VISIBLE de la couche principale (métier) = Passage oeil NON VISIBLE
                if (subLayer === undefined && $scope.pictoLayer[category]["mainLayer"] === pictoLayerVisible) {
                    // Passage couche principale en NON VISIBLE
                    $scope.pictoLayer[category]["mainLayer"] = pictoLayerNoVisible;
                    configServ.put('legendLayer:'+category+':main:visibility', "novisible");
                    mapService.hideLayer(category);

                    // Passage toutes les sous-couches de la catégorie en NON VISIBLE
                    var subLayer = $scope.pictoLayer[category]["subLayer"];
                    for(item in subLayer) {
                        $scope.pictoLayer[category]["subLayer"][item] = pictoLayerNoVisible;
                        configServ.put('legendLayer:'+category+':'+item+':visibility', "novisible");
                    };
                }

                // Clic sur le picto oeil NON VISIBLE de la couche principale (métier) => Passage oeil VISIBLE
                else if (subLayer === undefined && $scope.pictoLayer[category]["mainLayer"] === pictoLayerNoVisible) {
                    // Passage couche principale en VISIBLE
                    if (category === "airelife") {
                        $scope.pictoLayer[category]["mainLayer"] = pictoLayerVisible;
                        configServ.put('legendLayer:'+category+':main:visibility', "visible");
                        mapService.tabThemaData[category].loaded = false;
                        map.addLayer(mapService.tabThemaData["airelife"]);
                    }
                    else {
                        $scope.pictoLayer[category]["mainLayer"] = pictoLayerVisible;
                        configServ.put('legendLayer:'+category+':main:visibility', "visible");
                        mapService.tabThemaData[category].loaded = false;
                        mapService.showLayer(null, category, 'force');
                    }

                    // Passage toutes les sous-couches de la catégorie en VISIBLE
                    var subLayer = $scope.pictoLayer[category]["subLayer"];
                    for(item in subLayer) {
                        $scope.pictoLayer[category]["subLayer"][item] = pictoLayerVisible;
                        configServ.put('legendLayer:'+category+':'+item+':visibility', "visible");
                    };
                }

                // Clic sur le picto oeil VISIBLE d'une sous-couche' = Passage oeil NON VISIBLE
                else if (subLayer !== undefined && $scope.pictoLayer[category]["subLayer"][subLayer] === pictoLayerVisible){
                    $scope.pictoLayer[category]["mainLayer"] = pictoLayerNoVisible;
                    configServ.put('legendLayer:'+category+':main:visibility', "novisible");
                    // mapService.hideLayer(category);
                    $scope.pictoLayer[category]["subLayer"][subLayer] = pictoLayerNoVisible;
                    configServ.put('legendLayer:'+category+':'+subLayer+':visibility', "novisible");
                    mapService.tabThemaData[category].loaded = false;
                    mapService.showLayer(subLayer, category, 'force');
                    // configServ.put('cables/'+category+':ngTable:Filter', '{risquePoteau: "Risque secondaire"}');
                }

                // Clic sur le picto oeil NON VISIBLE d'une sous-couche' = Passage oeil VISIBLE
                else if (subLayer !== undefined && $scope.pictoLayer[category]["subLayer"][subLayer] === pictoLayerNoVisible){
                    $scope.pictoLayer[category]["subLayer"][subLayer] = pictoLayerVisible;
                    configServ.put('legendLayer:'+category+':'+subLayer+':visibility', "visible");
                    var temp = 'legendLayer:'+category+':'+subLayer+':visibility';
                    mapService.tabThemaData[category].loaded = false;
                    mapService.showLayer(null, category, 'force');

                    var i = true;
                    var subLayer2 = $scope.pictoLayer[category]["subLayer"];
                    for (item in subLayer2) {
                        if ($scope.pictoLayer[category]["subLayer"][item] !== pictoLayerVisible) {
                            i = false;
                            break;
                        }
                    }
                    // S'il reste une sous-couche non visible la couche principale reste non visible sinon elle s'affiche
                    if (i === false){
                        $scope.pictoLayer[category]["mainLayer"] = pictoLayerNoVisible;
                        configServ.put('legendLayer:'+category+':main:visibility', "novisible");
                    }
                    else {
                        $scope.pictoLayer[category]["mainLayer"] = pictoLayerVisible;
                        configServ.put('legendLayer:'+category+':main:visibility', "visible");
                    }
                }
            }
        }
    };
});

 /*
 * * #5 - Directive qui gère les évenements entre la carte et le tableau de données métier
 */
app.directive('maplist', function($rootScope, $timeout, mapService) {
    return {
        restrict: 'A',
        transclude: true,
        template: '<div><ng-transclude></ng-transclude></div>',
        link: function(scope, elem, attrs){
            // Récupération de l'identificateur d'événements de la liste
            var target = attrs['maplist'];

            // var cat = target.split("/")[1];

            var filterTpl = '<div class="mapFilter"><label> filtrer avec la carte <input type="checkbox" onchange="filterWithMap(this);"/></label></div>';
            scope.mapAsFilter = false;
            scope.toolBoxOpened = true;
            var visibleItems = [];
            /*
             * Initialisation des listeners d'évenements carte
             */
            var connect = function(){

                scope.$on('mapService:pan', function(ev){
                    scope.filter();
                });

                scope.filter = function(){
                    visibleItems = mapService.getVisibleItems();
                    $rootScope.$broadcast(target + ':filterIds', visibleItems, scope.mapAsFilter);
                }

                // Sélection dans la liste
                // scope.$on(target + ':ngTable:ItemSelected', function(ev, item, cat){
                //    console.log('=============================== scope.on');
                //     $timeout(function(){
                //         try{
                //             var geom = mapService.selectItem(item.id, cat);
                //             geom.openPopup();
                //         }
                //         catch(e){}
                //     }, 0);
                // });

                // Filtrage avec le tableau
                scope.$on(target + ':ngTable:Filtered', function(ev, data){
                    ids = [];
                    data.forEach(function(item){
                        ids.push(item.id);
                    });
                    if(mapService.filterData){
                        mapService.filterData(ids);
                    }
                });

            };

            var _createFilterCtrl = function(){
                var filterCtrl = L.control({position: 'bottomleft'});
                filterCtrl.onAdd = function(map){
                    this._filtCtrl = L.DomUtil.create('div', 'filterBtn');
                    this.update();
                    return this._filtCtrl;
                };
                filterCtrl.update = function(){
                    this._filtCtrl.innerHTML = filterTpl;
                };
                filterCtrl.addTo(mapService.getMap());
            }

            // Fitre avec la carte
            document.filterWithMap = function(elem){
                $rootScope.$apply(function(){
                    scope.mapAsFilter = elem.checked;
                    scope.filter();
                });
            };

            $timeout(function(){
                connect();
            }, 0);

        }
    };
});
