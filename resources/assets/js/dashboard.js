/**
 * Main
 */

'use strict';

import { default as Pusher } from 'pusher-js';

(function () {
  // Sélection des éléments HTML où afficher les valeurs
  var totalModulesEl = document.getElementById('total-modules');
  var modulesEnPanneEl = document.getElementById('modules-en-panne');
  var totalDonneesEl = document.getElementById('total-donnees');
  var disponibiliteEl = document.getElementById('disponibilite-systeme');

  var modulesData = {}; // Stocke les infos des modules pour calculs

  // Fonction pour récupérer les modules depuis la base de données
  function fetchModulesFromDB() {
    fetch(fetchAllModuleUrl) // Assure-toi que cette route Laravel retourne les données des modules
      .then(response => response.json())
      .then(data => {
        // console.log(data, 'modules');
        data.forEach(module => {
          modulesData[module.id] = {
            valeur: module.valeur || 0,
            duree: module.duree || '0s',
            total_donnees: module.total_donnees || 0,
            en_panne: module.en_panne
          };
        });

        // Mettre à jour le dashboard après récupération des données
        updateDashboard();
      })
      .catch(error => console.error('Erreur lors de la récupération des modules:', error));
  }

  function fetchModuleFromDB(module_id) {
    let url = fetchOneModuleUrl.replace('__ID__', module_id);
    fetch(url)
      .then(response => response.json())
      .then(module => {
        // console.log(module, 'module');
        modulesData[module.id] = {
          valeur: module.valeur || 0,
          duree: module.duree || '0s',
          total_donnees: module.total_donnees || 0,
          en_panne: module.en_panne
        };

        // Mettre à jour le dashboard après récupération des données
        updateDashboard();
      })
      .catch(error => console.error('Erreur lors de la récupération des modules:', error));
  }

  // Mise à jour des stats du dashboard
  function updateDashboard() {
    var totalModules = Object.keys(modulesData).length;
    var modulesEnPanne = Object.values(modulesData).filter(m => m.en_panne).length;
    var totalDonnees = Object.values(modulesData).reduce((sum, m) => sum + (m.total_donnees || 0), 0);
    var disponibilite = totalModules > 0 ? (((totalModules - modulesEnPanne) / totalModules) * 100).toFixed(2) : 0;

    // Affichage des valeurs dans le dashboard
    totalModulesEl && (totalModulesEl.textContent = totalModules);
    modulesEnPanneEl && (modulesEnPanneEl.textContent = modulesEnPanne);
    totalDonneesEl && (totalDonneesEl.textContent = totalDonnees);
    disponibiliteEl && (disponibiliteEl.textContent = disponibilite + ' %');

    // Met à jour la liste de modules
    updateListModule();
  }

  function listenDonneeChannel() {
    var channel = pusher.subscribe('donnees-channel');

    channel.bind('nouvelle-donnee', function (data) {
      // console.log('data ', data);
      // Mise à jour des données du module
      //console.log('in nouvelle donnees;', data.module.id);
      modulesData[data.module.id] = {
        valeur: data.valeur,
        duree: data.duree,
        total_donnees: data.total_donnees,
        en_panne: data.en_panne
      };

      updateDashboard();
    });
  }

  function listenEtatChannel() {
    var channel = pusher.subscribe('etat-module-channel');

    channel.bind('nouvel-etat', function (data) {
      console.log('event notif: ', data.module.id);

      // Mise à jour des données du module
      fetchModuleFromDB(data.module.id);

      updateListModule();
    });
  }

  function updateListModule() {
    let tableBody = document.getElementById('modules-table-body');

    if (!tableBody) {
      console.log('not found: ', tableBody);
      return;
    }

    function loadModules() {
      fetch(fetchAllModuleUrl)
        .then(response => response.json())
        .then(data => {
          let tableBody = document.getElementById('modules-table-body');
          tableBody.innerHTML = ''; // Vider la table avant de recharger
          data.forEach((module, index) => {
            var showModuleUrl = APP_ROUTES.showModule.replace('__MODULE__', module.id);
            var editModuleUrl = APP_ROUTES.editModule.replace('__MODULE__', module);
            let statusClass = module.en_panne ? 'danger' : 'success';
            let statusText = module.en_panne ? 'En panne' : 'Actif';

            let moduleRow = `
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${module.nom}</td>
                            <td>${module.valeur.valeur} ${module.unite}</td>
                            <td>${formatDate(new Date(module.valeur.created_at))}</td>

                            
                            <td>
                                <span class="badge rounded-pill bg-label-${statusClass} me-1">${statusText}</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="${showModuleUrl}">
                                            <i class="bx bx-show me-1 text-primary"></i> Afficher
                                        </a> 
                                       
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;

            tableBody.innerHTML += moduleRow;
          });

          // Ajouter l'événement de suppression après le chargement des données
          document.querySelectorAll('.delete-module').forEach(button => {
            button.addEventListener('click', function (e) {
              e.preventDefault();
              let module = this.getAttribute('data-module');
              if (confirm('Voulez-vous vraiment supprimer ce module ?')) {
                deleteModule(JSON.parse(module));
              }
            });
          });
        })
        .catch(error => console.error('Erreur lors du chargement des modules :', error));
    }

    function deleteModule(id) {
      fetch(`${APP_ROUTES.deleteModule}+"/"+${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json'
        }
      })
        .then(response => {
          if (response.ok) {
            loadModules(); // Recharger la liste après suppression
          } else {
            alert('Erreur lors de la suppression.');
          }
        })
        .catch(error => console.error('Erreur :', error));
    }

    loadModules(); // Charger les modules au chargement de la page
  }

  document.addEventListener('DOMContentLoaded', function () {
    updateListModule();
  });

  var pusher = new Pusher(PUSHER_APP_KEY, {
    cluster: PUSHER_APP_CLUSTER,
    encrypted: true
  });

  listenDonneeChannel();
  listenEtatChannel();
  fetchModulesFromDB();
})();
