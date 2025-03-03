import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_CLUSTER,
  forceTLS: true
});

// console.log('checking echo', window.Echo.connector);

// window.Echo.channel('etat-module-channel').listen('.ModuleNouvelEtat', event => {
//   console.log('in echo');
//   // Créer l'alerte Bootstrap
//   const alertMessage = event.message;

//   // Afficher l'alerte dans le DOM (ajoutez ce code dans une div spécifique de votre page)
//   const alert = document.createElement('div');
//   alert.classList.add('alert', 'alert-info');
//   alert.setAttribute('role', 'alert');
//   alert.textContent = alertMessage;

//   // Ajouter l'alerte à une section spécifique
//   const notificationsContainer = document.getElementById('notifications');
//   notificationsContainer.appendChild(alert);

//   // Vous pouvez aussi choisir de fermer l'alerte après un certain temps
//   setTimeout(() => {
//     alert.remove();
//   }, 5000); // L'alerte disparaît après 5 secondes
// });
