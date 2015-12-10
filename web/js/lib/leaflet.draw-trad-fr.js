
L.drawLocal = {
	draw: {
		toolbar: {
			actions: {
				//title: 'Cancel drawing',
				//text: 'Cancel'
				title: 'Annuler dessin',
				text: 'Annuler'
			},
			undo: {
				//title: 'Delete last point drawn',
				//text: 'Delete last point'
				title: 'Supprimer le dernier point dessiné',
				text: 'Supprimer le dernier point'
			},
			buttons: {
				//polyline: 'Draw a polyline',
				//polygon: 'Draw a polygon',
				//rectangle: 'Draw a rectangle',
				//circle: 'Draw a circle',
				//marker: 'Draw a marker'
				polyline: 'Dessiner une polyline',
				polygon: 'Dessiner un polygone',
				rectangle: 'Dessiner un rectangle',
				circle: 'Dessiner un cercle',
				marker: 'Dessiner un point'
			}
		},
		handlers: {
			circle: {
				tooltip: {
					//start: 'Click and drag to draw circle.'
					start: 'Cliquez et glissez pour dessiner un cercle.'
				},
				//radius: 'Radius'
				radius: 'Rayon'
			},
			marker: {
				tooltip: {
					//start: 'Click map to place marker.'
					start: 'Cliquez la carte pour placer le point.'
				}
			},
			polygon: {
				tooltip: {
					//start: 'Click to start drawing shape.',
					//cont: 'Click to continue drawing shape.',
					//end: 'Click first point to close this shape.'
					start: 'Cliquez pour commencer le polygone.',
					cont: 'Cliquez pour continuer le polygone.',
					end: 'Cliquez le premier point pour terminer le polygone.'
				}
			},
			polyline: {
				//error: '<strong>Error:</strong> shape edges cannot cross!',
				error: '<strong>Erreur :</strong> les aretes d\'un polygone ne doivent pas se croiser !',
				tooltip: {
					//start: 'Click to start drawing line.',
					//cont: 'Click to continue drawing line.',
					//end: 'Click last point to finish line.'
					start: 'Cliquez pour commencer une ligne.',
					cont: 'Cliquez pour continuer la ligne.',
					end: 'Cliquez le dernier point pour terminer la ligne.'
				}
			},
			rectangle: {
				tooltip: {
					//start: 'Click and drag to draw rectangle.'
					start: 'Cliquez et glissez pour dessiner un rectangle.'
				}
			},
			simpleshape: {
				tooltip: {
					//end: 'Release mouse to finish drawing.'
					end: 'Relachez le bouton pour terminer le dessin.'
				}
			}
		}
	},
	edit: {
		toolbar: {
			actions: {
				save: {
					//title: 'Save changes.',
					//text: 'Save'
					title: 'Enregistrer les changements.',
					text: 'Enregistrer'
				},
				cancel: {
					//title: 'Cancel editing, discards all changes.',
					//text: 'Cancel'
					title: 'Arrêter l\'édition, annuler tous les changements.',
					text: 'Annuler'
				}
			},
			buttons: {
				//edit: 'Edit layers.',
				//editDisabled: 'No layers to edit.',
				//remove: 'Delete layers.',
				//removeDisabled: 'No layers to delete.'
				edit: 'Modifier les couches.',
				editDisabled: 'Aucune couche à modifier.',
				remove: 'Supprimer les couches.',
				removeDisabled: 'Aucune couche à supprimer.'
			}
		},
		handlers: {
			edit: {
				tooltip: {
					//text: 'Drag handles, or marker to edit feature.',
					//subtext: 'Click cancel to undo changes.'
					text: 'Glissez les poignées ou le point pour modifier l\'élément.',
					subtext: 'Cliquez Annuler pour revenir en arrière.'
				}
			},
			remove: {
				tooltip: {
					//text: 'Click on a feature to remove'
					text: 'Cliquez sur un élément pour le supprimer'
				}
			}
		}
	}
};



