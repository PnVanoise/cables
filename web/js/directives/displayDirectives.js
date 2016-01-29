var app = angular.module('DisplayDirectives');

/*
 * messages utilisateurs
 */
app.service('userMessages', function($modal){
    this.infoMessage = '';
    this.errorMessage = '';
    this.successMessage = '';

    // wrapper pour alert
    this.alert = function(txt){
        return alert(txt);
    };

    // wrapper pour confirm
    this.confirm = function(txt){
        return confirm(txt);
    };
});


/**
 * Directive pour l'affichage des messages utilisateur en popover
 */
app.directive('usermsg', function(userMessages, $timeout){
    return {
        restrict: 'A',
        templateUrl: 'js/templates/modalMsg.htm',
        controller: function($scope){
            $scope.hideMsg=true;
            $scope.$watch(
                function(){return userMessages.infoMessage},
                function(newval){
                    if(newval){
                        $scope.msgStyle = 'alert-info';
                        $scope.showMsg(newval);
                    }
                }
            );

            $scope.$watch(
                function(){return userMessages.errorMessage},
                function(newval){
                    if(newval){
                        $scope.msgStyle = 'alert-danger';
                        $scope.showMsg(newval);
                    }
                }
            );

            $scope.$watch(
                function(){return userMessages.successMessage},
                function(newval){
                    if(newval){
                        $scope.msgStyle = 'alert-success';
                        $scope.showMsg(newval);
                    }
                }
            );

            $scope.showMsg = function(msg){
                $scope.userMessage = msg;
                $scope.hideMsg=false;
                $timeout(function(){
                    userMessages.infoMessage = null;
                    $scope.hideMsg=true;
                    userMessages.infoMessage = '';
                    userMessages.errorMessage = '';
                    userMessages.successMessage = '';
                }, 5500);
            };
        }
    };
});


/**
 * fonction qui renvoie le label associé à un identifiant
 * paramètres :
 *  xhrurl ->url du  service web
 *  inputid -> identifiant de l'élément
 */
app.directive('xhrdisplay', function(){
    return {
        restrict: 'A',
        scope: {
            inputid: '=',
            xhrurl: '=',
        },
        template: '{{value}}',
        controller: function($scope, dataServ){
            $scope.setResult = function(resp){
                $scope.value = resp.label;
            };
            $scope.$watch(function(){return $scope.inputid}, function(newval, oldval){
                if(newval){
                    dataServ.get($scope.xhrurl + '/' + newval, $scope.setResult);
                }
            });
        }
    };
});


app.directive('detailDisplay', function(){
    return{
        restrict: 'A',
        scope: {
            saveUrl: '=saveurl',
            schemaUrl: '=schemaurl',
            dataUrl: '=dataurl',
            updateUrl: '=updateurl',
            dataId: '=dataid',
            data: '='
        },
        transclude: true,
        templateUrl: 'js/templates/display/baseDetail.htm',
        controller: function($scope, $rootScope, configServ, dataServ, userServ, userMessages, $loading, $q,  $modal, $location, $timeout, mapService){
            $scope.subEditing = false;
            /*
             * Spinner
             * */
            $loading.start('spinner-detail');
            var dfd = $q.defer();
            var promise = dfd.promise;
            promise.then(function(result) {
                $loading.finish('spinner-detail');
            });

            $scope.openConfirm = function(txt){
                var modInstance = $modal.open({
                    templateUrl: 'js/templates/modalConfirmation.htm',
                    resolve: {txt: function(){return txt}},
                    controller: function($modalInstance, $scope, txt){
                        $scope.txt = txt;
                        $scope.ok = function(){
                            $modalInstance.close();
                        };
                        $scope.cancel = function(){
                            $modalInstance.dismiss('cancel');
                        }
                    }
                });
                return modInstance.result;
            }

            $scope.setSchema = function(resp){
                $scope.schema = angular.copy(resp);
                $scope.editAccess = userServ.checkLevel($scope.schema.editAccess);
                $scope.subEditAccess = userServ.checkLevel($scope.schema.subEditAccess);
                    //récupération des données
                    dataServ.get($scope.dataUrl, $scope.setData, function(){dfd.resolve('loading data')});
            };

            $scope.setData = function(resp){
                $scope.data = angular.copy(resp);
                if(!$scope.editAccess && $scope.schema.editAccessOverride){
                    $scope.editAccess = userServ.isOwner($scope.data[$scope.schema.editAccessOverride]);
                }

                //ajout du button supprimer dans detail
                $scope.deleteAccess = userServ.checkLevel($scope.schema.deleteAccess);
                if(!$scope.deleteAccess && $scope.schema.deleteAccessOverride){
                    $scope.deleteAccess = userServ.isOwner($scope.data[$scope.schema.deleteAccessOverride]);
                }
                // envoi des données vers le controleur
                $rootScope.$broadcast('display:init', $scope.data);

                // si le schema a un/des sous-schema
                //récupération du sous-schema classique
                if($scope.schema.subSchemaUrl){
                    configServ.getUrl($scope.schema.subSchemaUrl, $scope.setSubSchema);
                }
                //récupération du sous-schema des photos
                if($scope.schema.subSchemaPhotosUrl){
                    configServ.getUrl($scope.schema.subSchemaPhotosUrl, $scope.setSubSchemaPhotos);
                }
                //récupération du sous-schema poteaux erdf
                if($scope.schema.subSchemaPoteauxUrl){
                    configServ.getUrl($scope.schema.subSchemaPoteauxUrl, $scope.setSubSchemaPoteaux);
                }
                //récupération du sous-schema troncons erdf
                if($scope.schema.subSchemaTronconsUrl){
                    configServ.getUrl($scope.schema.subSchemaTronconsUrl, $scope.setSubSchemaTroncons);
                }
                else {
                  dfd.resolve('loading data');
                }
            }

            $scope.setSubSchema = function(resp){
                $scope.subSchema = angular.copy(resp);
                // récupération des données liées au sous-schéma
                dataServ.get($scope.schema.subDataUrl + $scope.dataId, $scope.setSubData);
            }
            $scope.setSubData = function(resp){
                $scope.subData = angular.copy(resp);
                dfd.resolve('loading data');
            }
            $scope.setSubSchemaPhotos = function(resp){
                $scope.subSchemaPhotos = angular.copy(resp);
                // récupération des données liées au sous-schéma photos
                dataServ.get($scope.schema.subDataPhotosUrl + $scope.dataId, $scope.setSubDataPhotos);
            }
            $scope.setSubDataPhotos = function(resp){
                $scope.subDataPhotos = angular.copy(resp);
                dfd.resolve('loading data');
            }
            $scope.setSubSchemaPoteaux = function(resp){
                $scope.subSchemaPoteaux = angular.copy(resp);
                // récupération des données liées au sous-schéma photos
                dataServ.get($scope.schema.subDataPoteauxUrl + $scope.dataId, $scope.setSubDataPoteaux);
            }
            $scope.setSubDataPoteaux = function(resp){
                $scope.subDataPoteaux = angular.copy(resp);
                dfd.resolve('loading data');
            }
            $scope.setSubSchemaTroncons = function(resp){
                $scope.subSchemaTroncons = angular.copy(resp);
                // récupération des données liées au sous-schéma photos
                dataServ.get($scope.schema.subDataTronconsUrl + $scope.dataId, $scope.setSubDataTroncons);
            }
            $scope.setSubDataTroncons = function(resp){
                $scope.subDataTroncons = angular.copy(resp);
                dfd.resolve('loading data');
            }
            //
            $scope.$on('subEdit:dataAdded', function(evt, data){
                $scope.subEditing = false;
                dataServ.forceReload = true;
                dataServ.get($scope.schema.subDataUrl + $scope.dataId, $scope.setSubData);
                dataServ.get($scope.schema.subDataPhotosUrl + $scope.dataId, $scope.setSubDataPhotos);
                dataServ.get($scope.schema.subDataPoteauxUrl + $scope.dataId, $scope.setSubDataPoteaux);
                dataServ.get($scope.schema.subDataTronconsUrl + $scope.dataId, $scope.setSubDataTroncons);
            });

            $scope.switchEditing = function(){
                $scope.subEditing = !$scope.subEditing;
            }

            $scope.remove = function(){
                $scope.openConfirm(["Êtes vous certain de vouloir supprimer cet élément ?"]).then(function(){
                    $loading.start('spinner-send');
                    var dfd = $q.defer();
                    var promise = dfd.promise;
                    promise.then(function(result) {
                        $loading.finish('spinner-send');
                    });
                    dataServ.delete($scope.saveUrl, $scope.removed(dfd));
                });
            };

            $scope.removed = function(dfd){
                return function(resp){
                    dirty = false;
                    dfd.resolve('removed');
                    var category = $scope.dataUrl.split('/')[1];
                    mapService.tabThemaData[category].loaded = false;
                    mapService.showLayer(null, category, 'force');
                    if (category === 'poteauxerdf' || 'tronconserdf')
                    {
                        mapService.tabThemaData['zonessensibles'].loaded = false;
                        mapService.showLayer(null, 'zonessensibles', 'force');
                    };
                    $rootScope.$broadcast('form:delete', $scope.data);
                };
            };

            // récupération du schéma
            configServ.getUrl($scope.schemaUrl, $scope.setSchema);
        }
    }
});


app.directive('fieldDisplay', function(){
    return {
        restrict: 'A',
        scope: {
            field: '=',
            data: '=',
            dataid: '='
        },
        templateUrl: 'js/templates/display/field.htm',
        controller: function(){}
    };
});



app.directive('breadcrumbs', function(){
    return {
        restrict: 'A',
        scope: {},
        templateUrl: 'js/templates/display/breadcrumbs.htm',
        controller: function($scope, configServ, $location){
            $scope.bc = [];
            $scope._edit = false;
            $scope._create = false;
            var _url = null;
            var params = $location.path().slice(1).split('/');
            if(params.indexOf('edit') >= 0){
                params.splice(params.indexOf('edit'), 1);
                $scope._edit = true;
                if(!parseInt(params[params.length-1])){
                    $scope._create = true;
                }
            }
            if(params.length == 4){
                if(!parseInt(params[3])){
                    url = params[0] + '/config/breadcrumb?view=' + params[1]
                }
                else{
                    if($scope._edit){
                        url = params[0] + '/config/breadcrumb?view=' + params[2] + '&id=' + params[3];
                    }
                    else{
                        url = params[0] + '/config/breadcrumb?view=' + params[1] + '&id=' + params[3];
                    }
                }
            }
            else if(params.length == 3){
                if(!parseInt(params[2])){
                    url = params[0] + '/config/breadcrumb?view=' + params[1]
                }
                else{
                    url = params[0] + '/config/breadcrumb?view=' + params[1]+ '&id=' + params[2];
                }
            }
            else if(params.length == 2){
                url = params[0] + '/config/breadcrumb?view=' + params[1];
            }
            configServ.getUrl(url, function(resp){
                $scope.bc = resp;
            });
        },
    };
});


app.directive('tablewrapper', function(){
    return {
        restrict: 'A',
        scope: {
            refName: '@refname',
            schema: '=',
            data: '=',
        },
        transclude: true,
        templateUrl: 'js/templates/display/tableWrapper.htm',
        controller: function($scope, $rootScope, $filter, configServ, userServ, ngTableParams, $modal, mapService, selectedItemService){
            $scope.currentItem = null;
            $scope._checkall = false;
            filterIds = [];
            extFilter = false;
            var orderedData;

            $scope.filterZero = function(x){
                if(x.id == 0){
                    x.id = '';
                }
                return x;
            };

            // Modal pour l'aperçu de la photo
            $(document).ready(function () {
                $('#modalPhoto').on('show.bs.modal', function (event) { // Récupération de l'ID du modal (#modalPhoto)
                    var chemin = null;
                    var image = $(event.relatedTarget) // récuperation de l'évenement sur la photo
                    var id = image.data('test') // Extraction des données : ID de la photo
                    var cheminPhoto = image.data('chemin') //                    : chemin de la photo

                    var title = 'Aperçu de la photo #' + id // Titre du modal avec l'ID
                    var modal = $(this)
                    modal.find('.modal-title').text(title)

                    var img = $('<img />', {            // Création de la photo d'aperçu
                        id: id,
                        src: cheminPhoto,
                        width: 595,
                        height: 500,
                    });
                    $('#photo').html(img);             // Initialisation de la photo dans la div #photo du #modalPhoto
                })
            });


            var filterFuncs = {
                starting: function(key, filterTxt){
                    if(filterTxt == ''){
                        return function(x){return true};
                    }
                    return function(filtered){
                        if(!filtered[key]){
                            if(filterTxt == '-'){
                                return true;
                            }
                            return false;
                        }
                        return filtered[key].toLowerCase().indexOf(filterTxt.toLowerCase())===0;
                    }
                },
                integer: function(key, filterTxt){
                    filterTxt = filterTxt.trim();
                    if(filterTxt == ''){
                        return function(x){return true};
                    }
                    return function(filtered){
                        //Abscence de filtre quand uniquement = > ou <
                        if (filterTxt.length <2 ) return true;

                        var nbr = parseFloat(filterTxt.slice(1, filterTxt.length));
                        if (isNaN(nbr)) return false;

                        if (filterTxt.indexOf('>') === 0){
                            return filtered[key] > nbr;
                        }
                        else if(filterTxt.indexOf('<') === 0){
                            return filtered[key] < nbr;
                        }
                        else if(filterTxt.indexOf('=') === 0){
                            return filtered[key] == nbr;
                        }
                        else return false;
                    };
                },
            };
            var filtering = {};

            $scope.__init__ = function(){
                $scope.editAccess = userServ.checkLevel($scope.schema.editAccess);
                $scope.schema.fields.forEach(function(field){
                    if(field.filterFunc && filterFuncs[field.filterFunc]){
                        filtering[field.name] = filterFuncs[field.filterFunc];
                    }
                });
            };


            if(!$scope.schema){
                $scope.$watch('schema', function(newval){
                    if(newval){
                        $scope.__init__();
                    }
                });
            }
            else{
                $scope.__init__();
            }

            /*
             *  initialisation des parametres du tableau
             */
            $scope.tableParams = new ngTableParams({
                page: 1,
                count: 10,
                filter: {},
                sorting: {id: 'asc'}
            },
            {
                counts: [10, 25, 50, 100, 1000],
                total: $scope.data ? $scope.data.length : 0, // length of data
                getData: function ($defer, params) {
                    /*
                    // use build-in angular filter
                    var filteredData = params.filter() ?
                            $filter('filter')($scope.data, params.filter()) :
                            $scope.data;
                    */
                    if(extFilter){
                        var filteredData = $scope.data.filter(function(item){return filterIds.indexOf(item.id) !== -1});
                    }
                    else{
                        var filteredData = $scope.data;
                    }
                    if(!filteredData.length){
                        return;
                    }
                    reqFilter = params.filter();
                    if(reqFilter){
                        for(filterKey in reqFilter){
                            if(filtering[filterKey]){
                                //filteredData = $filter('filter')(filteredData, filterDef, );
                                filteredData = filteredData.filter(filtering[filterKey](filterKey, reqFilter[filterKey]))
                            }
                            else{
                                var filterDef = {}
                                filterDef[filterKey] = reqFilter[filterKey];
                                filteredData = $filter('filter')(filteredData, filterDef);
                            }
                        }
                    }
                    $scope._checkall = false;
                    //$scope.clearChecked();
                    orderedData = params.sorting() ?
                            $filter('orderBy')(filteredData, params.orderBy()) :
                            $scope.data;
                    configServ.put($scope.refName + ':ngTable:Filter', params.filter());
                    configServ.put($scope.refName + ':ngTable:Sorting', params.sorting());
                    configServ.put($scope.refName + ':ngTable:Page', params.page());
                    $rootScope.$broadcast($scope.refName + ':ngTable:Filtered', orderedData);


                    params.total(orderedData.length); // set total for recalc pagination
                    $scope.currentSel = {total: $scope.data.length, current: orderedData.length};

                    var curPg = params.page() || 1;
                    $defer.resolve(orderedData.slice((curPg - 1) * params.count(), curPg * params.count()));
                }
            });
            
            // récupération des filtres utilisés sur le tableau
            configServ.get($scope.refName + ':ngTable:Filter', function(filter){
                $scope.tableParams.filter(filter);
            });

            // récupération du tri utilisé sur le tableau
            configServ.get($scope.refName + ':ngTable:Sorting', function(sorting){
                $scope.tableParams.sorting(sorting);
            });

            // récupération du tri utilisé sur le tableau
            configServ.get($scope.refName + ':ngTable:Page', function(page){
                $scope.tableParams.page(page);
            });

            /*
             * Fonctions
             */
            $scope.selectItem = function(item, broadcast, cat){
                if($scope.currentItem){ // currentItem déclaré dans controller
                    $scope.currentItem.$selected = false;
                }
                if(broadcast == undefined){
                    broadcast = true;
                }
                item.$selected = true;
                $scope.currentItem = item;
                configServ.put($scope.refName + ':itemId:selected', item.id);
                if(broadcast){
                    selectedItemService.length = 0;
                    angular.forEach(mapService.tabThemaData[cat].getLayers(),
                        function(geom) {
                            if (geom.feature.properties.id == item.id) {
                                selectedItemService.push(geom);
                            }
                        }
                    );
                }
            };

            // detect any change in selection, then zoom on item and highlight
            // it
            $rootScope.$watchCollection(function() {
                return selectedItemService;
            }, function(newVal, oldVal) {
                // don't take first call into account
                if (newVal == oldVal) {
                    return;
                }
                var selectedItem = selectedItemService[0].feature.properties;
                var category = $scope.refName.split('/')[1];
                angular.forEach($scope.data, function(item) {
                    if (item.id == selectedItem.id &&
                        selectedItem.cat == category) {
                        item.$selected = true;
                    } else {
                        item.$selected = false;
                    }
                });
                if (selectedItem && selectedItem.cat == category) {
                    var idx = null;
                    for (var key in orderedData){
                        if (orderedData[key].id === selectedItem.id){
                            idx = orderedData.indexOf(orderedData[key]);
                        }
                    }
                    var pgnum = Math.ceil((idx + 1) / $scope.tableParams.count());
                    $scope.tableParams.page(pgnum);
                }
            });

            //$scope.$watch('data', function(newval){
                
                //if(newval){
                    //$scope.data.forEach(function(item){
                        //if(item.$selected){
                            //console.log('dans if data');
                            //$scope.currentItem = item;
                            //window.itemsel = item;
                            //$rootScope.$broadcast($scope.refName + ':ngTable:ItemSelected', item);
                        //}
                    //});
                    //$scope.tableParams.reload();
                //}
            //});

            /*
             * Listeners
             */
            $scope.$on($scope.refName + ':select', function(evt, item){
                $scope.selectItem(item, false, item.cat);
            });

        },
    };
});

/*
 * Future directive pour la gestion du modal photo
 */
app.directive('modalPhoto', function () {
    return {
      restrict: 'A',
      link: function(scope, element) {

        element.bind('click', function(e) {
            angular.element(e.currentTarget).siblings('.thumb-image').trigger('click');
            var img = angular.element(e.currentTarget.ddf)
            return angular.element(e.currentTarget);

        });
      }
    };
});

app.directive('filterform', function(){
    return {
        restrict: 'E',
        scope: {
            url: '@',
            schema: '=',
            callback: '=',
        },
        templateUrl: 'js/templates/form/filterForm.htm',
        controller: function($scope, dataServ){
            $scope.filterData = {};
            $scope.counts = {};
            $scope.filters = {};
            $scope.pageNum = 0;
            $scope.maxCount = 0;
            $scope.schema_initialized = false;

            $scope.setArray = function(field, setArray){
                if(setArray){
                    var val = $scope.filterData[field].value;
                    $scope.filterData[field].value = [val, null];
                }
                else{
                    if(Array.isArray($scope.filterData[field].value)){
                        var val = $scope.filterData[field].value[0];
                        $scope.filterData[field].value = val;
                   }
                }
            };

            $scope.nextPage = function(){
                $scope.pageNum += 1;
                $scope.send();
            };

            $scope.prevPage = function(){
                $scope.pageNum -= 1;
                $scope.send();
            };

            $scope.send = function(resetPage){
                if(resetPage){
                    $scope.pageNum = 0;
                }
                var _qs = [];
                $scope.schema.fields.forEach(function(item){
                    if($scope.filterData[item.name].value){
                        var _val = $scope.filterData[item.name].value;
                        var _filter = $scope.filterData[item.name].filter;
                        _qs.push({item: item.name, filter: _filter, value: _val});
                    }
                });
                if(_qs.length){
                    var _url = $scope.url + "?page="+$scope.pageNum+"&limit="+$scope.schema.limit+"&filters=" + angular.toJson(_qs);
                }
                else{
                    var _url = $scope.url + "?page="+$scope.pageNum+"&limit="+$scope.schema.limit;
                }
                dataServ.get(_url, function(resp){
                    //envoi des données filtrées à la vue
                    $scope.counts.total = resp.total;
                    $scope.counts.current = resp.filteredCount;
                    $scope.maxCount = Math.min(($scope.pageNum+1) * $scope.schema.limit, $scope.counts.current);
                    $scope.callback(resp.filtered);
                });
            };

            $scope.init_schema = function(){
                if(!$scope.schema_initialized){
                    $scope.schema.fields.forEach(function(item){
                        $scope.filterData[item.name] = {filter: '=', value: item.default};
                    });
                }
                $scope.schema_initialized = true;
                $scope.send();
            };

            if($scope.schema){
                $scope.init_schema();
            }
            else{
                $scope.$watch('schema', function(newval){
                    if(newval){
                        $scope.init_schema();
                    }
                });
            }
        }
    };
});
