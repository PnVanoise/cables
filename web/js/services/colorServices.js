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

    //Style pour les polygones ; nidifications non visible
    this.noPolyStyle = function(){
        polyStyle = {
            weight: 0,
            // opacity: 0,
            fillOpacity: 0
        }
    return polyStyle;
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

    // Tronçons à risque : non visible
    this.tronNoVisible = function(){
        tronNoVisible = angular.extend({
            // color:'#DE0101',
            weight: 0
        }
        //, lineStyle()
        )
    return tronNoVisible;
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
        iconPerc = L.icon({
            iconUrl: 'css/lib/images/cas_mortalites_percussion.png',
            iconSize: [16, 16],
            iconAnchor: [8, 8],
        });
    return iconPerc;
    }

    //Style pour les mortalités par électrocution
    this.iconElec = function(){
        iconElec = L.icon({
            iconUrl: 'css/lib/images/cas_mortalites_electrocution.png',
            iconSize: [16, 16],
            iconAnchor: [8, 8],
        });
    return iconElec;
    }

    //Style pour les poteaux non visible
    this.poNoVisible = function(){
        poNoVisible = L.icon({
            className : 'poNoVisible',
            iconUrl: 'css/lib/images/marker-poteau-novisible.png',
            iconSize: [17, 17],
            iconAnchor: [8, 8],
        });
    return poNoVisible;
    }

    //Style pour les poteaux à risque élevé
    this.poteauxErdfRisqueEleve = function(){
        poRisqueEleve = L.icon({
            iconUrl: 'css/lib/images/poteaux_risque_eleve.png',
            iconSize: [14, 14],
            iconAnchor: [7, 7],
        });
    return poRisqueEleve;
    }

    //Style pour les poteaux à risque secondaire
    this.poteauxErdfRisqueSecondaire = function(){
        poRisqueSecondaire = L.icon({
            iconUrl: 'css/lib/images/poteaux_risque_secondaire.png',
            iconSize: [14, 14],
            iconAnchor: [7, 7],
        });
    return poRisqueSecondaire;
    }

    //Style pour les poteaux à non risque
    this.poteauxErdfPeuPasRisque = function(){
        poNonRisque = L.icon({
            iconUrl: 'css/lib/images/poteaux_risque_peupas.png',
            iconSize: [14, 14],
            iconAnchor: [7, 7],
        });
    return poNonRisque;
    }

    //Style pour les équipements poteaux
    this.eqPoteau = function(){
        eqPoteau = L.icon({
            iconUrl: 'css/lib/images/equip_poteaux.png',
            iconSize: [10, 10],
            iconAnchor: [5, 5],
        });
    return eqPoteau;
    }

    //Style pour les équipements tronçons
    this.eqTroncon = function(){
        eqTroncon = {
            color:'#01df01',
            width:1,
            opacity:0.9
        };
    return eqTroncon;
    }

    // Appareils de coupure ERDF
    this.erdfac = function(){
        erdfac = L.icon({
            className : 'apcoupERDF',
            iconUrl: 'css/lib/images/marker_appareils_coupure_erdf.png'
        });
    return erdfac;
    }

    // Connexions aériennes ERDF
    this.erdfca = function(){
        erdfca = L.icon({
            className : 'caERDF',
            iconUrl: 'css/lib/images/marker_connexions_aeriennes_erdf.png'
        });
    return erdfca;
    }

    // Parafoudre ERDF
    this.erdfp = function(){
        erdfp = L.icon({
            className : 'parafERDF',
            iconUrl: 'css/lib/images/marker_parafoudres_erdf.png'
        });
    return erdfp;
    }

    // Postes électriques ERDF
    this.erdfpe = function(){
        erdfpe = L.icon({
            className : 'postelecERDF',
            iconUrl: 'css/lib/images/marker_postes_electriques_erdf.png'
        });
    return erdfpe;
    }

    // Remontées aérosouterraines ERDF
    this.erdfra = function(){
        erdfra = L.icon({
            className : 'raesoutERDF',
            iconUrl: 'css/lib/images/marker_remontees_aerosouterraines_erdf.png'
        });
    return erdfra;
    }

    //  Tronçons aériens ERDF
    this.erdfta = function(){
        erdfta = {
            color: "#61210B",
            fillColor: "#61210B",
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
            color: "#0B610B",
            fillColor: "#0B610B",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.3
        }
    return ogmtv;
    }

    // Tronçons visualisés dangereux OGM
    this.ogmtvd = function(){
        ogmtvd = {
            color: "#FF8000",
            fillColor: "#FF8000",
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
            iconUrl: 'css/lib/images/marker_postes_electriques_rte.png'
        });
    return rtep;
    }

    // Poteaux RTE
    this.rtepot = function(){
        rtepot = L.icon({
            className : 'poteauRTE',
            iconUrl: 'css/lib/images/marker_poteaux_electriques_rte.png'
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

    // Observations : non visible
    this.noObs = function(){
        noObs = L.icon({
            className : 'noObs',
            iconUrl: 'css/lib/images/marker-poteau-novisible.png'
        });
    return noObs;
    }

    // Observations : classes en fonction du nombre d'obs
    // ** 0- 20 **
    this.obsClasse1 = function(){
        obsClasse1 = L.icon({
            className : 'obsClasse1',
            iconUrl: 'css/lib/images/marker_observations_inf_20.png'
        });
    return obsClasse1;
    }
    // ** 20- 40 **
    this.obsClasse2 = function(){
        obsClasse2 = L.icon({
            className : 'obsClasse2',
            iconUrl: 'css/lib/images/marker_observations_sup_20_inf_40.png'
        });
    return obsClasse2;
    }
    // ** + 40 **
    this.obsClasse3 = function(){
        obsClasse3 = L.icon({
            className : 'obsClasse3',
            iconUrl: 'css/lib/images/marker_observations_sup_40.png'
        });
    return obsClasse3;
    }
});

/*
 * Changement des couleurs et styles des couches géométriques  quand on clique dessus
 */
app.service('changeColorService', function () {
// console.log('dans changeColorService');
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

    this.iconPerc = function(){
        iconPerc = L.icon({
            iconUrl: 'css/lib/images/cas_mortalites_percussion_selection.png',
            iconSize: [16, 16],
            iconAnchor: [8, 8],
        });
    return iconPerc;
    }

    this.iconElec = function(){
        iconElec = L.icon({
            iconUrl: 'css/lib/images/cas_mortalites_electrocution_selection.png',
            iconSize: [16, 16],
            iconAnchor: [8, 8],
        });
    return iconElec;
    }

    //Style pour les poteaux à risque élevé
    this.poRisqueEleve = function(){
        poRisqueEleve = L.icon({
            iconUrl: 'css/lib/images/poteaux_risque_selection.png',
            iconSize: [14, 14],
            iconAnchor: [7, 7],
        });
    return poRisqueEleve;
    }

    //Style pour les poteaux à risque secondaire
    this.poRisqueSecondaire = function(){
        poRisqueSecondaire = L.icon({
            iconUrl: 'css/lib/images/poteaux_risque_selection.png',
            iconSize: [14, 14],
            iconAnchor: [7, 7],
        });
    return poRisqueSecondaire;
    }

    //Style pour les poteaux à non risque
    this.poNonRisque = function(){
        poNonRisque = L.icon({
            iconUrl: 'css/lib/images/poteaux_risque_selection.png',
            iconSize: [14, 14],
            iconAnchor: [7, 7],
        });
    return poNonRisque;
    }

    //Style pour les équipements poteaux
    this.eqPoteau = function(){
        eqPoteau = L.icon({
            iconUrl: 'css/lib/images/equip_poteaux_selection.png',
            iconSize: [10, 10],
            iconAnchor: [5, 5],
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