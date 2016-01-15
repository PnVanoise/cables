var app = angular.module('colorServices');

/*
 * Service pour la gestion des couleurs et styles par défault des couches géométriques
 */
app.service('defaultColorService', function () {

    // Styles des zones sensibles
    this.zsStyle = function(){
        zsStyle = {
            weight: 3,
            opacity: 1,
            fillOpacity: 0.3
        }
    return zsStyle;
    }

    //  zones sensibles : niveau  sensibilité 1
    this.zs1 = function(){
        zs1 = {
            color: "#FF9300",
            fillColor: "#FF9300"
        }
    return zs1;
    }

    //  zones sensibles : niveau  sensibilité 2
    this.zs2 = function(){
        zs2 = {
            color: "#FF5900",
            fillColor: "#FF5900"
        }
    return zs2;
    }

    //  zones sensibles : niveau  sensibilité 3
    this.zs3 = function(){
        zs3 = {
            color: "#FF0000",
            fillColor: "#FF0000"
        }
    return zs3;
    }

    //Style pour les polygones ; nidifications
    this.polyStyle = function(){
        polyStyle = {
            weight: 2,
            opacity: 0,
            fillOpacity: 0.5
        }
    return polyStyle;
    }

    // style pour les lignes
    this.lineStyle = function(){
        lineStyle = {
            opacity: 0.8
        }
    return lineStyle;
    }

    // Tronçons à risque : élevé
    this.tronRisqueEleve = function(){
        tronRisqueEleve = angular.extend({
            color:'#DE0101',
            weight: 7
        }
        //, lineStyle()
        )
    return tronRisqueEleve;
    }

    // Tronçons à risque : secondaire
    this.tronRisqueSecondaire = function(){
        tronRisqueSecondaire = angular.extend({
            color:'#ECA500',
            weight: 7
        }//, lineStyle()
        )
    return tronRisqueSecondaire;
    }

    // Tronçons à risque : pas de risque
    this.tronNonRisque = function(){
        tronNonRisque = angular.extend({
            color:'#2B4EDC',
            weight: 7
        }
        //, lineStyle()
        )
    return tronNonRisque;
    }

    //Style pour les mortalités par pércussion
    this.iconPerc = function(){
        iconPerc = L.AwesomeMarkers.icon({
            icon: 'glyphicon-certificate',
            markerColor: 'cadetblue',
            iconColor: '#FFF'
        });
    return iconPerc;
    }

    //Style pour les mortalités par électrocution
    this.iconElec = function(){
        iconElec = L.AwesomeMarkers.icon({
            prefix: 'fa',
            icon: 'bolt',
            markerColor: 'cadetblue',
            iconColor: '#DECF06'
        });
    return iconElec;
    }

    //Style pour les poteaux à risque élevé
    this.poRisqueEleve = function(){
        poRisqueEleve = L.icon({
            className : 'poRisqueEleve',
            iconUrl: 'css/lib/images/marker-poteau.png',
        });
    return poRisqueEleve;
    }

    //Style pour les poteaux à risque secondaire
    this.poRisqueSecondaire = function(){
        poRisqueSecondaire = L.icon({
            className : 'poRisqueSecondaire',
            iconUrl: 'css/lib/images/marker-poteau.png',
        });
    return poRisqueSecondaire;
    }

    //Style pour les poteaux à non risque
    this.poNonRisque = function(){
        poNonRisque = L.icon({
            className : 'poNonRisque',
            iconUrl: 'css/lib/images/marker-poteau.png',
        });
    return poNonRisque;
    }

    //Style pour les équipements poteaux
    this.eqPoteau = function(){
        eqPoteau = L.icon({
            className : 'eqPoteau',
            iconUrl: 'css/lib/images/marker-poteau.png',
        });
    return eqPoteau;
    }

    //Style pour les équipements tronçons
    this.eqTroncon = function(){
        eqTroncon = {
            color:'#5CB85C',
            width:1,
            opacity:0.8
        };
    return eqTroncon;
    }

    // Appareils de coupure ERDF
    this.erdfac = function(){
        erdfac = L.icon({
            className : 'apcoupERDF',
            iconUrl: 'css/lib/images/marker_poteau_erdf.png'
        });
    return erdfac;
    }

    // Connexions aériennes ERDF
    this.erdfca = function(){
        erdfca = L.icon({
            className : 'caERDF',
            iconUrl: 'css/lib/images/marker_poteau_erdf.png'
        });
    return erdfca;
    }

    // Parafoudre ERDF
    this.erdfp = function(){
        erdfp = L.icon({
            className : 'parafERDF',
            iconUrl: 'css/lib/images/marker_poteau_erdf.png'
        });
    return erdfp;
    }

    // Postes électriques ERDF
    this.erdfpe = function(){
        erdfpe = L.icon({
            className : 'postelecERDF',
            iconUrl: 'css/lib/images/marker_poteau_erdf.png'
        });
    return erdfpe;
    }

    // Remontées aérosouterraines ERDF
    this.erdfra = function(){
        erdfra = L.icon({
            className : 'raesoutERDF',
            iconUrl: 'css/lib/images/marker_poteau_erdf.png'
        });
    return erdfra;
    }

    //  Tronçons aériens ERDF
    this.erdfta = function(){
        erdfta = {
            color: "#000000",
            fillColor: "#000000",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.3
        }
    return erdfta;
    }

    // Remontées mécaniques OGM
    this.ogmrm = function(){
        ogmrm = {
            color: "#58FAF4",
            fillColor: "#58FAF4",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.6
        }
    return ogmrm;
    }

    // Domaines skiables OGM
    this.ogmds = function(){
        ogmds = {
            color: "#58FAF4",
            fillColor: "#58FAF4",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.1
        }
    return ogmds;
    }

    // Tronçons dangereux OGM
    this.ogmtd = function(){
        ogmtd = {
            color: "#FF0000",
            fillColor: "#FF0000",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.3
        }
    return ogmtd;
    }

    // Tronçons visualisés OGM
    this.ogmtv = function(){
        ogmtv = {
            color: "#000000",
            fillColor: "#000000",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.3
        }
    return ogmtv;
    }

    // Tronçons visualisés dangereux OGM
    this.ogmtvd = function(){
        ogmtvd = {
            color: "#FF0000",
            fillColor: "#FF0000",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.3
        }
    return ogmtvd;
    }

    // Lignes RTE
    this.rtel = function(){
        rtel = {
            color: "#000000",
            fillColor: "#000000",
            weight: 3,
            opacity: 1,
            fillOpacity: 0.3
        }
    return rtel;
    }

    // Postes RTE
    this.rtep = function(){
        rtep = L.icon({
            className : 'posteRTE',
            iconUrl: 'css/lib/images/marker_poteau_erdf.png'
        });
    return rtep;
    }

    // Poteaux RTE
    this.rtepot = function(){
        rtepot = L.icon({
            className : 'poteauRTE',
            iconUrl: 'css/lib/images/marker_poteau_erdf.png'
        });
    return rtepot;
    }

    // Communes
    this.com = function(){
        com = {
            color: "#848484",
            fillColor: "#848484",
            weight: 3,
            opacity: 0.8,
            fillOpacity: 0.1
        }
    return com;
    }

    // Observations : classes en fonction du nombre d'obs
    // ** 0- 20 **
    this.obsClasse1 = function(){
        obsClasse1 = L.icon({
            className : 'obsClasse1',
            iconUrl: 'css/lib/images/marker-poteau.png'
        });
    return obsClasse1;
    }
    // ** 20- 40 **
    this.obsClasse2 = function(){
        obsClasse2 = L.icon({
            className : 'obsClasse2',
            iconUrl: 'css/lib/images/marker-poteau.png'
        });
    return obsClasse2;
    }
    // ** + 40 **
    this.obsClasse3 = function(){
        obsClasse3 = L.icon({
            className : 'obsClasse3',
            iconUrl: 'css/lib/images/marker-poteau.png'
        });
    return obsClasse3;
    }
});

/*
 * Changement des couleurs et styles des couches géométriques  quand on clique dessus
 */
app.service('changeColorService', function () {

    // Styles des zones sensibles
    this.zsStyle = function(){
        zsStyle = {
            weight: 3,
            opacity: 1,
            fillOpacity: 0.3
        }
    return zsStyle;
    }

    //  zones sensibles : niveau  sensibilité 1
    this.zs1 = function(){
        zs1 = {
            weight: 2,
            color: "#F400DC",
            opacity: 0.5,
            fillColor: "#F400DC",
            fillOpacity: 0.5
        }
    return zs1;
    }

    //  zones sensibles : niveau  sensibilité 2
    this.zs2 = function(){
        zs2 = {
           weight: 2,
            color: "#F400DC",
            opacity: 0.5,
            fillColor: "#F400DC",
            fillOpacity: 0.5
        }
    return zs2;
    }

    //  zones sensibles : niveau  sensibilité 3
    this.zs3 = function(){
        zs3 = {
            weight: 2,
            color: "#F400DC",
            opacity: 0.5,
            fillColor: "#F400DC",
            fillOpacity: 0.5
        }
    return zs3;
    }

    //Style pour les polygones ; nidifications
    this.polyStyle = function(){
        polyStyle = {
            weight: 2,
            opacity: 0,
            fillOpacity: 0.5
        }
    return polyStyle;
    }

    // style pour les lignes
    this.lineStyle = function(){
        lineStyle = {
            opacity: 0.8
        }
    return lineStyle;
    }

    // Tronçons à risque : élevé
    this.tronRisqueEleve = function(){
        tronRisqueEleve = angular.extend({
            color:'#F400DC',
            weight: 7
        })
    return tronRisqueEleve;
    }

    // Tronçons à risque : secondaire
    this.tronRisqueSecondaire = function(){
        tronRisqueSecondaire = angular.extend({
            color:'#F400DC',
            weight: 7
        })
    return tronRisqueSecondaire;
    }

    // Tronçons à risque : pas de risque
    this.tronNonRisque = function(){
        tronNonRisque = angular.extend({
            color:'#F400DC',
            weight: 7
        })
    return tronNonRisque;
    }

    //Style pour les mortalités par pércussion
    this.iconPerc = function(){
        iconPerc = L.AwesomeMarkers.icon({
            icon: 'glyphicon-certificate',
            markerColor: 'pink',
            iconColor: '#FFF'
        });
    return iconPerc;
    }

    //Style pour les mortalités par électrocution
    this.iconElec = function(){
        iconElec = L.AwesomeMarkers.icon({
            prefix: 'fa',
            icon: 'bolt',
            markerColor: 'pink',
            iconColor: '#FFF'
        });
    return iconElec;
    }

    //Style pour les poteaux à risque élevé
    this.poRisqueEleve = function(){
        poRisqueEleve = L.icon({
            className : 'poRisqueClick',
            iconUrl: 'css/lib/images/marker-poteau.png',
        });
    return poRisqueEleve;
    }

    //Style pour les poteaux à risque secondaire
    this.poRisqueSecondaire = function(){
        poRisqueSecondaire = L.icon({
            className : 'poRisqueClick',
            iconUrl: 'css/lib/images/marker-poteau.png',
        });
    return poRisqueSecondaire;
    }

    //Style pour les poteaux à non risque
    this.poNonRisque = function(){
        poNonRisque = L.icon({
            className : 'poRisqueClick',
            iconUrl: 'css/lib/images/marker-poteau.png',
        });
    return poNonRisque;
    }

    //Style pour les équipements poteaux
    this.eqPoteau = function(){
        eqPoteau = L.icon({
            className : 'eqPoteauClick',
            iconUrl: 'css/lib/images/marker-poteau.png',
        });
    return eqPoteau;
    }

    //Style pour les équipements tronçons
    this.eqTroncon = function(){
        eqTroncon = {
            color:'#F400DC',
            width:1,
            opacity:0.8
        };
    return eqTroncon;
    }
});