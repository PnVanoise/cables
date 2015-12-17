var app = angular.module('cablesServices');

/**
 * Service de gestion des communications avec le serveur
 */
app.service('dataServ', function($http, $filter, userMessages){
    //cache de données pour ne pas recharger systématiquement les données du serveur
    var cache = {};
    // console.log("dans dataserv cache : "+JSON.stringify(cache));

    //flag ordonnant la recharge des données plutôt que l'utilisation du cache
    this.forceReload = false;

    /*
     * contacte le serveur en GET et met en cache les données renvoyées
     * Si les données sont déja en cache, retourne le données directement, à moins
     * que le flag forceReload ou le paramtre "force" soient true, auquel cas le serveur
     * est recontacté et les données renvoyées écrasent le cache.
     * retourne les données via la callback success
     *
     * params:
     *  url: l'url à contacter
     *  success: la callback à utiliser pour traiter les données
     *  error: une callback appelée en cas d'erreur gérable
     *  force: flag permettant de forcer le rechargement des données plutot que l'utilisation
     *         du cache
     */
    this.getCache = function(url){
      // console.log(JSON.stringify(json));
        return cache[url];
    };

    this.getAllCache = function(){
      // console.log(JSON.stringify(json));
        return cache;
    };

    this.get = function(url, success, error, force){
        // ne recharger les données du serveur que si le cache est vide ou
        // si l'option force est true
        if(!error){
            error = function(err){console.log(err)};
        }
        if(cache[url] == undefined || force || this.forceReload){
            $http.get(url)
                .then(function(data){
                    this.forceReload = false;
                    cache[url] = data.data;
                    success(cache[url]);
                },
                function(err){
                    switch(err.status){
                        case 500:
                            userMessages.errorMessage = "Erreur serveur ! Si cette erreur se reproduit, contactez un administrateur.";
                            break;
                        case 404:
                            userMessages.errorMessage = "Erreur : Donnée inexistante";
                            break;
                        case 403:
                            userMessages.errorMessage = "Vous n'êtes pas autorisé à effectuer cette action";
                            break;
                        case 400:
                            userMessages.errorMessage = "Données inutilisables";
                            break;
                        default: userMessages.errorMessage = "Erreur !";
                    };
                    error(err);
                }
            );
        }
        else{
            success(cache[url]);
        }
    };

    /*
     * contacte le serveur en POST et renvoie le résultat via la callback success
     * aucune donnée n'est mise en cache
     * params:
     *  url: l'url à contacter
     *  data: les données POST
     *  success: la callback de traitement de la réponse du serveur
     *  error: la callback de traitement en cas d'erreur gérable
     */
    this.post = function(url, data, success, error){
        $http.post(url, data).success(success).error(error || function(err){console.log(err);});
    };

    /*
     * contacte le serveur en PUT et renvoie le résultat via la callback success
     * params:
     *  cf. this.post
     */
    this.put = function(url, data, success, error){
        $http.put(url, data).success(success).error(error || function(err){console.log(err);});
    };

    /*
     * contacte le serveur en DELETE
     * params:
     *  url: l'url à contacter
     *  success: la callback de traitement de la réponse du serveur
     *  error: la callback de traitement en cas d'erreur gérable
     */
    this.delete = function(url, success, error){
        $http.delete(url).success(success).error(error || function(err){console.log(err);});
    };

});


/**
 * Service de récupération et stockage des configurations
 * Utiliser pour stocker les variables globales ou les éléments de configuation de l'application
 */
app.service('configServ', function(dataServ){
    var cache = {};

    /*
     * charge des informations depuis une url si elles ne sont pas déja en cache
     * et les retourne via une callback. Si les variables sont déjà en cache, les
     * retourne directement.
     * params:
     *  serv: l'url du serveur
     *  success: la callback de traitement
     */
    this.getUrl = function(serv, success){
        // alert("dans configserv");
        if(cache[serv]){
            // console.log(cache[serv]);
            // console.log("configserv : dans cache");
            // alert("dans configserv cache");
            // console.log("configserv dans cache : "+JSON.stringify(cache[serv]));
            success(cache[serv]);
        }
        else{
            dataServ.get(serv, function(resp){
                cache[serv] = resp;
                // console.log(cache[serv]);
                // alert("dans configserv symf");
                // console.log("configserv dans dataserv : "+JSON.stringify(cache[serv]));
                success(cache[serv]);
            });
        }
    };

    /*
     * retourne une variable globale via la callback success
     * params:
     *  key : le nom de la variable
     *  success : la callback de traitement
     */
    this.get = function(key, success){
        success(cache[key]);
    };


    /*
     * crée ou met à jour une variable globale
     * params:
     *  key : le nom de la variable
     *  data : le contenu
     */
    this.put = function(key, data){
        cache[key] = data;
    };
});


/*
 * service utilisateur
 */
app.service('userServ', function(dataServ, $rootScope, localStorageService){
    var _user = null;
    var _tmp_password = '';

    this.getUser = function(){
        if(!_user){
            var tmp_user = localStorageService.get('user');
            if(tmp_user){
                this.login(tmp_user.identifiant, tmp_user.pass);
                _user = tmp_user;
            }
        }
        return _user
    };

    this.setUser = function(){
        localStorageService.set('user', _user);
    };

    this.checkLevel = angular.bind(this, function(level){
        try{
            return _user.maxdroit >= level;
        }
        catch(e){
            return false;
        }
    });

    this.isOwner = angular.bind(this,function(ownerId){
        if(_user==null){
            return false;
        }
        return _user.id_role == ownerId;
    });

    this.login = function(login, password, app){
        _tmp_password = password;
        dataServ.post('users/login', {login: login, pass: password},
            this.connected,
            this.error
            );
    };

    this.logout = function(){
        dataServ.get('users/logout',
                this.disconnected,
                function(){},
                true);
    };

    this.connected = angular.bind(this, function(resp){
        _user = resp;
        _user.pass = _tmp_password;
        this.setUser()
        $rootScope.$broadcast('user:login', _user);
    });

    this.disconnected = function(resp){
        _user = null;
        localStorageService.remove('user');
        $rootScope.$broadcast('user:logout');
    }

    this.error = function(resp){
        $rootScope.$broadcast('user:error');
    };


});


/*
 * Service qui récupere l'url depuis Symf
 */
app.service('loadDataSymf', function(dataServ, mapService, storeFlag){
    var vSymfPath = null;
    var geoms = null;
    var tmp = [];
    var data = [];
    var flagInitMap = true;

    this.getThemaData = function(pThemaData){
        vSymfPath = "cables/"+pThemaData;
            dataServ.get(vSymfPath,
                function(resp){
                    resp.forEach(function(item){
                        mapService.addGeom(item, pThemaData);
                    });
                }
            );
        // document.getElementById(pThemaData).checked = true;
        // storeFlag.setFlagLayer(pThemaData, "cacheChecked");
    };
});

/**
 * Déclaration du tableau pour la gestion de l'affichage des couches dans la légende
 */
app.service('storeFlag', function(){
    var tabFlagLayer = {
        "zonessensibles": "firstLoad",
        "mortalites": "noLoaded",
        "tronconserdf": "firstLoad",
        "eqtronconserdf": "noLoaded",
        "eqpoteauxerdf": "noLoaded",
        "nidifications": "noLoaded",
        "observations": "noLoaded",
        "poteauxerdf": "noLoaded",
        "erdfappareilcoupure": "noLoaded",
        "erdfconnexionaerienne": "noLoaded",
        "erdfparafoudre": "noLoaded",
        "erdfposteelectrique": "noLoaded",
        "erdfremonteeaerosout": "noLoaded",
        "erdftronconaerien": "noLoaded",
        "ogmcablesremonteesmecaniques": "noLoaded",
        "ogmdomainesskiables": "noLoaded",
        "ogmtronconsdangereux": "noLoaded",
        "ogmtronconsvisualises": "noLoaded",
        "ogmtronconsvisualisesdangereux": "noLoaded",
        "rtelignes": "noLoaded",
        "rtepostes": "noLoaded",
        "rtepoteaux": "noLoaded",
        "communes": "noLoaded"
    };

    this.getFlagLayer = function(pFlagLayer){
        return tabFlagLayer[pFlagLayer];
    }

    this.setFlagLayer = function(pFlagLayer, pValFlag){
        tabFlagLayer[pFlagLayer] = pValFlag;
    }

    this.getTabFlagLayer = function(){
        return tabFlagLayer;
    }

});

/**
 * Méthode qui enregistre la valeur du premier élément du breadcrumb qui correspond à la catégorie métier dans laquelle on se trouve
 */
app.service('storeBreadcrumb', function(){
    var catBreadcrumb = null;

    this.getCatBreadcrumb = function(){
        return catBreadcrumb;
    };

    this.setCatBreadcrumb = function(pCatBreadcrumb){
        catBreadcrumb = pCatBreadcrumb;
    };

});


/**
 * filtre basique - transforme une date yyyy-mm-dd en dd/mm/yyyy pour l'affichage
 * Utilisé comme un formateur de date
 */
app.filter('datefr', function(){
    return function(input){
        try{
            return input.replace(/^(\d+)-(\d+)-(\d+).*$/i, "$3/$2/$1");
        }
        catch(e){
            return input;
        }
    }
});


/**
 * Affichage du label d'une liste déroulante à partir de son identifiant
 */
app.filter('tselect', function($filter){
    return function(input, param){
        if(!param){
            return 'Non renseigné';
        }
        var res = $filter('filter')(input, {id: param}, function(act, exp){return act==exp;});
        try{
            return res[0].libelle;
        }
        catch(e){
            return 'Erreur : Valeur incompatible'; //Erreur censée ne jamais arriver.
        }
    }
});

