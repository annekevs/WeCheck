/**
 * Main
 */

'use strict';

import Pusher from 'pusher-js';

(function () {
  // Connexion à Pusher
  // console.log('pusher ', PUSHER_APP_KEY, PUSHER_APP_CLUSTER);

  var pusher = new Pusher(PUSHER_APP_KEY, {
    cluster: PUSHER_APP_CLUSTER,
    encrypted: true
  });

  var channel = pusher.subscribe('etat-module-channel');

  channel.bind('nouvel-etat', function (data) {
    // Lorsque vous recevez l'événement, afficher l'alerte Bootstrap
    //console.log('event notif: ', data);

    launchNotification(data);
    updateListEtatModule(data);
  });

  function launchNotification(data) {
    // Créer un élément d'alerte Bootstrap
    const alertElement = document.createElement('div');
    alertElement.classList.add('alert', 'alert-dismissible', 'fade', 'show');

    if (data.etat === 'panne') {
      alertElement.classList.add('alert-danger'); // Alerte en rouge pour panne
    } else {
      alertElement.classList.add('alert-success'); // Alerte verte pour autre état
    }

    alertElement.setAttribute('role', 'alert');
    alertElement.innerHTML = `
            ${data.message} 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

    // Ajouter l'alerte au conteneur 'notifications'
    const notificationsContainer = document.getElementById('notifications');
    notificationsContainer.appendChild(alertElement);

    // Supprimer l'alerte après un délai
    setTimeout(() => {
      alertElement.classList.remove('show');
      alertElement.classList.add('fade');
      setTimeout(() => alertElement.remove(), 1500); // Supprimer l'alerte après une courte animation
    }, 6000); // L'alerte disparaît après 6 secondes
  }

  function updateListEtatModule(data) {
    // Créer une nouvelle ligne de tableau
    var newRow = `
        <tr id="etat-module-${data.module.id}">
            <th scope="row">${$('#etat-modules-table-body tr').length + 1}</th>
            <td>${data.module.nom}</td>
            <td>${data.module.duree}</td>
            <td>${formatDate(data.module.date_reprise)}</td>
            <td class="etat-module-status">
                <span class="badge rounded-pill bg-label-${data.etat === 'panne' ? 'danger' : 'success'}">
                    ${data.etat === 'panne' ? 'En panne' : 'Actif'}
                </span>
            </td>
        </tr>
    `;

    // Insérer la nouvelle ligne au début de la table
    $('#etat-modules-table-body').prepend(newRow);
  }
})();
