@php
  $csa_type = get_field('csa_type');
@endphp

@if ($csa_type === 'regular')
  <div class="side-nav col-3">
    <h4>Locations</h4>
    <button data-toggle="collapse" class="btn btn-link show" data-target="#collapsePublic" role="button" aria-expanded="true" aria-controls="collapsePublic">Public Pickups</button>
  </div>
  <div class="location-cards col-9" id="locations">
    <div id="collapsePublic" class="collapse show" data-parent="#locations">
      <h5>Public Pickup Locations</h5>
      <ul>
      @php
        if( have_rows('location_details', 'options') ):
        $count = 0;	
        // loop through data
        while ( have_rows('location_details', 'options') ) : the_row();
          if( get_sub_field('pickup_type') == 'public' ):
            
            $name = get_sub_field('name'); 
            $description = get_sub_field('description');
            
            // trigger for modal
            echo '<li><a href="#" data-toggle="modal" data-target="#pickupModal-'.$count.'">'.$name.'</a></li>';
        
            // modal
            echo '<div class="modal fade" id="pickupModal-'.$count.'" tabindex="-1" role="dialog" aria-hidden="true">';
          @endphp

          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>{{$name}}</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  @php the_sub_field('description'); @endphp
                </div>										
              </div>
            </div>
          </div>
        @php endif;
          // increase count
          $count++;
        endwhile;
        else :
          // no rows found
        endif;
        @endphp
      </ul>
    </div>
    <div id="collapseSchool" class="collapse collapseSchool" data-parent="#locations">
        <h5>School Fundraiser Pickup Locations</h5>
        <ul>
        @php
        if( have_rows('location_details', 'options') ):
        $count = 0;	
        // loop through data
        while ( have_rows('location_details', 'options') ) : the_row();
          if( get_sub_field('pickup_type') == 'school' ):
            
            $name = get_sub_field('name'); 
            $description = get_sub_field('description'); 
            
            // trigger for modal
            echo '<li><a href="#" data-toggle="modal" data-target="#pickupModal-'.$count.'">'.$name.'</a></li>';
        
            // modal
            echo '<div class="modal fade" id="pickupModal-'.$count.'" tabindex="-1" role="dialog" aria-hidden="true">';
          @endphp

          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>{{$name}}</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  @php the_sub_field('description'); @endphp
                </div>										
              </div>
            </div>
          </div>
        @php endif;
          // increase count
          $count++;
        endwhile;
        else :
          // no rows found
        endif;
        @endphp
      </ul>
    </div>
    <div id="collapseEmployee" class="collapse collapseEmployee" data-parent="#locations">
        <h5>Employee-only Pickup Locations</h5>
        <ul>
        @php
        if( have_rows('location_details', 'options') ):
        $count = 0;	
        // loop through data
        while ( have_rows('location_details', 'options') ) : the_row();
          if( get_sub_field('pickup_type') == 'employee' ):
            
            $name = get_sub_field('name'); 
            $description = get_sub_field('description'); 
            
            // trigger for modal
            echo '<li><a href="#" data-toggle="modal" data-target="#pickupModal-'.$count.'">'.$name.'</a></li>';
        
            // modal
            echo '<div class="modal fade" id="pickupModal-'.$count.'" tabindex="-1" role="dialog" aria-hidden="true">';
          @endphp

          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>{{$name}}</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  @php the_sub_field('description'); @endphp
                <a href="">Sign up for Full Season at {{ $name }}</a>
                </div>										
              </div>
            </div>
          </div>
        @php endif;
          // increase count
          $count++;
        endwhile;
        else :
          // no rows found
        endif;
        @endphp
      </ul>
    </div>				
  </div>
@else
{{-- Check for late season participation when looping through locations. Only display locations that are checked to true. --}}
<div class="side-nav col-3">
  <h4>Locations</h4>
</div>
<div class="location-cards col-9" id="locations">
  <div id="collapsePublic" class="collapse show" data-parent="#locations">
    <h5>Pickup Locations</h5>
    <ul>
    @php
      if( have_rows('location_details', 'options')):
      $count = 0;	
      // loop through data
      while ( have_rows('location_details', 'options') ) : the_row();
        
        $late_season = get_sub_field('late_season');
        
        if( $late_season ):
          
          $name = get_sub_field('name'); 
          $description = get_sub_field('description');
          
          // trigger for modal
          echo '<li><a href="#" data-toggle="modal" data-target="#pickupModal-'.$count.'">'.$name.'</a></li>';
      
          // modal
          echo '<div class="modal fade" id="pickupModal-'.$count.'" tabindex="-1" role="dialog" aria-hidden="true">';
        @endphp

        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3>{{$name}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                @php the_sub_field('description'); @endphp
              </div>										
            </div>
          </div>
        </div>
      @php endif;
        // increase count
        $count++;
      endwhile;
      else :
        // no rows found
      endif;
      @endphp
    </ul>
  </div>				
</div>
@endif