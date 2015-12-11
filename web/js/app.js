var app = angular.module('appCables', [ 'cablesGlobalCtrl', 'mortalitesCtrl', 'zonesSensiblesCtrl', 'tronconsErdfCtrl', 'eqTronconsErdfCtrl', 'eqPoteauxErdfCtrl','nidificationsCtrl','observationsCtrl','poteauxErdfCtrl', 'cablesServices', 'FormDirectives', 'DisplayDirectives', 'ui.bootstrap', 'bootstrap.tabset', 'darthwade.loading', 'mapServices', 'LocalStorageModule']); //'ngTableResizableColumns'

// module de gestion de la page d'accueil
angular.module('cablesGlobalCtrl', ['cablesServices', 'mapServices', 'ngRoute', 'ngTable']);

// module de gestion des cas de mortalité
angular.module('mortalitesCtrl', ['cablesServices', 'mapServices', 'ngRoute', 'ngTable']);

// module de gestion des zones sensibles
angular.module('zonesSensiblesCtrl', ['cablesServices', 'mapServices', 'ngRoute', 'ngTable']);

// module de gestion des inventaires tronçons erdf
angular.module('tronconsErdfCtrl', ['cablesServices', 'mapServices','ngRoute', 'ngTable']);

// module de gestion des équipements tronçons erdf
angular.module('eqTronconsErdfCtrl', ['cablesServices', 'mapServices','ngRoute', 'ngTable']);

// module de gestion des équipements poteaux erdf
angular.module('eqPoteauxErdfCtrl', ['cablesServices', 'mapServices','ngRoute', 'ngTable']);

// module de gestion des sites de nidifications erdf
angular.module('nidificationsCtrl', ['cablesServices', 'mapServices','ngRoute', 'ngTable']);

// module de gestion des observations erdf
angular.module('observationsCtrl', ['cablesServices', 'mapServices','ngRoute', 'ngTable']);

// module de gestion des inventaires poteaux erdf
angular.module('poteauxErdfCtrl', ['cablesServices', 'mapServices','ngRoute', 'ngTable']);

// services de l'application
angular.module('cablesServices', ['mapServices']);

// directives formulaires
angular.module('FormDirectives', ['angularFileUpload', 'mapServices']);

// directives affichage
angular.module('DisplayDirectives', ['mapServices']);

// directives map
angular.module('mapServices', ['cablesServices']);


/*
 * Configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/', {
            controller: 'baseController',
            templateUrl: 'js/templates/index.htm'
        })
        .when('/login', {
            controller: 'loginController',
            templateUrl: 'js/templates/login.htm',      
        })
        .when('/logout', {
            controller: 'logoutController',
            templateUrl: 'js/templates/login.htm',   
        })
});

app.run(function($rootScope, $templateCache) {
   $rootScope.$on('$viewContentLoaded', function() {
      // $templateCache.removeAll();
   });
});


app.config(function (localStorageServiceProvider) {
    localStorageServiceProvider.setPrefix('cables');
})
/*
 * Controleur de base
 */
app.controller('baseController', function($scope, $location, dataServ, configServ, mapService, userMessages, userServ){
    $scope._appName = null; // pour une gestion factorisée des applications = pas utile pour le moment
    $scope.app = {name: "cables"};
    $scope.success = function(resp){
        $scope.user = userServ.getUser();
        if(!$scope.user){
            $location.url('login');
        }
        // retourne /cables si on tape juste pnv
        if($location.path() == '/'){
            $location.url('/cables');
        }
        $scope.data = resp;

        // FIXME DEBUG
        configServ.put('debug', true);
        
        userMessages.infoMessage = "bienvenue !";

        $scope.$on('user:login', function(ev, user){
            $scope.user = user;
        });    

        $scope.$on('user:logout', function(ev){
            $scope.app = {name: "Cables"};
            $scope.user = null;
        });

    };

    // gestion des menus dans le bandeau
    $scope.isActive = function (viewLocation) { 
        return viewLocation === $location.path();
    };
   // collapsed tableau de données 
    $scope.toggle = function() {
       $scope.affiche = !$scope.affiche;
    } ;

    $scope.check = function(val){
        return userServ.checkLevel(val); 
    }; 
  
    configServ.getUrl('config/apps', $scope.success);
});

/*
 * controleur login
 */
app.controller('loginController', function($scope, $location, $rootScope, userServ, userMessages, configServ){
    if(userServ.getUser()){
        $scope.data = {
            login: userServ.getUser().identifiant,
            pass: userServ.getUser().pass, 
        };
    }
    else{
        $scope.data = {login: null, pass: null};
    }

    $scope.$on('user:login', function(ev, user){
        userMessages.infoMessage = user.nom_complet.replace(/(\w+) (\w+)/, 'Bienvenue $2 $1 !');
        $location.url('/cables'); 
    });

    $scope.$on('user:error', function(ev){
        userMessages.errorMessage = "Erreur d'identification. Respirez un coup et recommencez."
    });

    $scope.send = function(){
        userServ.login($scope.data.login, $scope.data.pass);
    };
});


/*
 * controleur logout
 */
app.controller('logoutController', function($scope, $location, userServ, userMessages, configServ){
    $scope.$on('user:logout', function(ev){
        userMessages.infoMessage = "Déconnecté !";
        $location.url('login');
    });

    userServ.logout();
});



