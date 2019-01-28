<footer class="content-info">
  <div class="container">
    @php dynamic_sidebar('sidebar-footer') @endphp
  </div>
</footer>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoicGF0cmlja2tlcmJ5IiwiYSI6ImpxWDBaVFkifQ.t3gbX7-Sfy3Z9Nh14aLFow';
  const map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/patrickkerby/cjexbfjfi358d2rpeom12bmuo',
  });
</script>