import mapboxgl from 'mapbox-gl/dist/mapbox-gl.js';

export default {
  init() {
    // JavaScript to be fired on the home page
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
    
    $(document).ready(function(){
      
      mapboxgl.accessToken = 'pk.eyJ1IjoicGF0cmlja2tlcmJ5IiwiYSI6ImpxWDBaVFkifQ.t3gbX7-Sfy3Z9Nh14aLFow';
  
      var bounds = [
        [-114.694127, 53.101844], // Southwest coordinates
        [-112.524187, 53.753422],  // Northeast coordinates
      ];
     
      var map = new mapboxgl.Map({
        container: 'map',
        height: '680px',
        style: 'mapbox://styles/patrickkerby/cjexbfjfi358d2rpeom12bmuo',
        maxBounds: bounds,
      });
    
      map.scrollZoom.disable();
      map.addControl(new mapboxgl.NavigationControl());
    });
  },
};
