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

  var channel = pusher.subscribe('donnees-channel');

  channel.bind('nouvelle-donnee', function (data) {
    // Lorsque vous recevez l'événement, afficher l'alerte Bootstrap
    console.log('event donnee: ', data);

    updateListDonneeModule(data);
  });

  function updateListDonneeModule(data) {
    // Créer une nouvelle ligne de tableau
    var newRow = ` 
        <tr id="donnee-module-${data.module.id}">
            <th scope="row">${$('#donnee-modules-table-body tr').length + 1}</th>
            <td>${data.module.nom}</td>
            <td>${data.valeur}</td>
            <td>${formatDate(data.date_dernier_signal)}</td>
            <td class="donnee-module-status">
                <span class="badge rounded-pill bg-label-${data.en_panne == true ? 'danger' : 'success'}">
                    ${data.en_panne == true ? 'En panne' : 'Actif'}
                </span>
            </td>
        </tr>
    `;

    // Insérer la nouvelle ligne au début de la table
    $('#donnee-modules-table-body').prepend(newRow);
  }
})();
