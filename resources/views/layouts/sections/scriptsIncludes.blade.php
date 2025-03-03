@php
use Illuminate\Support\Facades\Vite;
@endphp
<!-- laravel style -->
@vite(['resources/assets/vendor/js/helpers.js'])

<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
@vite(['resources/assets/js/config.js'])

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script>
    var fetchAllModuleUrl = "{{ route('api.modules.fetchAll') }}";
    var fetchOneModuleUrl = "{{ route('api.modules.fetchOne', ['id' => '__ID__']) }}";
    var PUSHER_APP_KEY = "{{ env('PUSHER_APP_KEY') }}"
    var PUSHER_APP_CLUSTER = "{{ env('PUSHER_APP_CLUSTER') }}"

    var APP_ROUTES = {
        showModule : "{{ route('modules.show',['module' => '__MODULE__']) }}",
        editModule : "{{ route('modules.edit',['module' => '__MODULE__']) }}",        
        deleteModule : "{{ route('modules.destroy',['module' => '__MODULE__']) }}",
    }
    var API_ROUTES_URL = {
        fetchAllEtatModule : "{{ route('api.etat-modules.fetchAll')}}",
        fetchAllDonneesModule : "{{ route('api.donnee-modules.fetchAll') }}",
        fetchAllModuleUrl : "{{ route('api.modules.fetchAll') }}",
        fetchOneModuleUrl : "{{ route('api.modules.fetchOne', ['id' => '__ID__']) }}"
    }
</script>

@vite(['resources/assets/js/notification.js'])

@vite(['resources/assets/js/dashboard.js'])

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function formatDate(_date) {
    const date = new Date(_date)
    const now = new Date();
    const diff = now - date;
    
    // Check if the date is today
    const isToday = diff < 24 * 60 * 60 * 1000 && date.getDate()===now.getDate(); // Check if the date is yesterday const
        isYesterday=diff>= 24 * 60 * 60 * 1000 &&
        diff < 48 * 60 * 60 * 1000 && date.getDate()===new Date(now - 24 * 60 * 60 * 1000).getDate(); const options={
            hour: '2-digit' , minute: '2-digit' , second: '2-digit' }; const timeStr=date.toLocaleTimeString('fr-FR',
            options); if (isToday) { return `Aujourd'hui à ${timeStr}`; } else if (isYesterday) { return `Hier à
            ${timeStr}`; } else { return `Le ${date.toLocaleDateString('fr-FR')} à ${timeStr}`; } }
</script>