/**
 * Main
 */

'use strict';

import { default as Pusher } from 'pusher-js';

(function () {
  var ctx = document.getElementById('donneesChart')?.getContext('2d');
  var chartData = {
    labels: [],
    datasets: [
      {
        label: 'Valeur des Modules',
        data: [],
        borderColor: 'blue',
        backgroundColor: 'rgba(0, 0, 255, 0.2)',
        borderWidth: 1
      }
    ]
  };

  var donneesChart = new Chart(ctx, {
    type: 'line',
    data: chartData,
    options: {
      responsive: true,
      scales: {
        x: {
          title: { display: true, text: 'Heure' },
          display: false
        },
        y: { title: { display: true, text: 'Valeur Mesurée' } }
      }
    }
  });

  // Connexion à Pusher
  // console.log('pusher ', PUSHER_APP_KEY, PUSHER_APP_CLUSTER);

  var pusher = new Pusher(PUSHER_APP_KEY, {
    cluster: PUSHER_APP_CLUSTER,
    encrypted: true
  });

  var channel = pusher.subscribe('donnees-channel');

  channel.bind('nouvelle-donnee', function (data) {
    //console.log('data ', data);

    updateShowModule(data);
  });

  function updateShowModule(data) {
    // Récupérer l'ID du module affiché
    var moduleContainer = document.getElementById('module-container');
    var moduleAfficheId = moduleContainer ? moduleContainer.getAttribute('data-module-id') : null;
    console.log('\nid: ', moduleAfficheId, data, 'next\n');
    // Vérifier si c'est bien le module affiché
    if (moduleAfficheId != data.module.id) {
      return; // Ne rien faire si ce n'est pas le bon module
    }

    const moduleIdEl = `#module-${data.module.id}`;
    $(moduleIdEl + '-valeur').text(data.valeur + ' ' + data.unite);
    $(moduleIdEl + '-duree').text(data.duree);
    $(moduleIdEl + '-total_donnees').text(data.total_donnees);
    $(moduleIdEl + '-date_dernier_signal').text(formatLastSignal(data.date_dernier_signal));
    $(moduleIdEl + '-etat')
      .text(data.en_panne == true ? 'En panne' : 'Actif')
      .removeClass('bg-label-danger bg-label-success')
      .addClass(data.en_panne == true ? 'bg-label-danger' : 'bg-label-success');

    console.log('Mise à jour du chart pour le module ID:', data.module.id);

    // Update Chart
    if (chartData.labels.length > 20) {
      chartData.labels.shift();
      chartData.datasets[0].data.shift();
    }

    var signalDate = new Date(data.date_dernier_signal);

    chartData.labels.push(formatLastSignal(data.date_dernier_signal));
    chartData.datasets[0].data.push(data.valeur);
    donneesChart.update();
  }

  function formatLastSignal(dateString) {
    let signalDate = new Date(dateString);
    let now = new Date();

    let diffTime = now - signalDate;
    let diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)); // Différence en jours

    let hours = signalDate.getHours().toString().padStart(2, '0');
    let minutes = signalDate.getMinutes().toString().padStart(2, '0');
    let seconds = signalDate.getSeconds().toString().padStart(2, '0');

    if (diffDays === 0) {
      return `Aujourd'hui, à ${hours}h${minutes}:${seconds}`;
    } else if (diffDays === 1) {
      return `Hier, à ${hours}h${minutes}:${seconds}`;
    } else {
      return signalDate.toLocaleDateString() + ` à ${hours}h${minutes}:${seconds}`;
    }
  }
})();
