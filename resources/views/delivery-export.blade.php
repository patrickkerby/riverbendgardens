{{--
  Template Name: Delivery Export
--}}

{{-- @extends('layouts.lists') --}}



@php
  $post_id = get_the_ID();
  // do_action( 'acf/save_post', $post_id );
  
  $is_storetodoor = true;

  //function for creating unique arrays from a key/value set
  function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

// Users query
$user_ids = (array) get_users([
      'role'       => 'customer',
      'number'     => -1,
      'fields'     => 'ID',
  ]);

// Get order data!
  $query = new WC_Order_Query( array(  
      'limit' => -1,
      // 'orderby' => 'name',
      // 'order' => 'asc',
      'status' => array('wc-processing'),
  ) );
  $results = $query->get_orders();
  
//Create filtered list of orders based on the date selected on list page.
  $filtered_orders = array();
  $filtered_orders_print = array();

  foreach ( $results as $daily_results ) {    
    $order_id = $daily_results->get_id();
  }

// $unique_array = unique_multidim_array($filtered_orders,'_timeslot');

@endphp

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <table id="lists{{ $loop->iteration }}" class="display">
        <thead> 
          <tr>
            <th>Name</th>
            <th colspan="5">Location ( Unit number / Street Address / City / Province / Postal Code )</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>what3words (Optional)</th>
            <th>Deeleeo Details</th>
            <td class="d-print-none">Order Details to Print</td>
          </tr>
        </thead>
        <tbody>  
          <tr>
            <td>Customer name / Order ID</td>
            <td>Unit/apt # (Optional)</td>
            <td>Street Address</td>
            <td>City</td>
            <td>Province (ie: Alberta, not AB)</td>
            <td>Postal code</td>
            <td>valid email address if no phone provided this becomes mandatory</td>
            <td>10 digit number of the recipient or shipper - if no email provided this becomes mandatory</td>
            <td>///optional.data.here</td>
            <td>Pick up/Drop off instruction (is it a home/apt/office?) and Unit/Buzzer numbers. Info about the package) Other phone numbers, etc. </td>
          </tr>
          @foreach ($filtered_orders as $details)
            @php 
              $phone = $details->get_billing_phone();
              $email = $details->get_billing_email();
              $order_id = $details->get_id();
              $first_name = $details->get_shipping_first_name();
              $last_name = $details->get_shipping_last_name();
              $address1 = $details->get_shipping_address_1();
              $address2 = $details->get_shipping_address_2();
              $unitno_shipping = $details->get_meta( 'shipping_unitno', true );
              $unitno_billing = $details->get_meta( 'billing_unitno', true );
              $city = $details->get_shipping_city();
              $state = $details->get_shipping_state();
              $postcode = $details->get_shipping_postcode();
              $status = $details->get_status();
              $customer_note = $details->get_customer_note();
              $order_number = $details->get_id();  
            @endphp

              <tr>
                <td class="name"><strong>{{ $last_name }}, {{ $first_name }}</strong></td>
                <td>
                  @if($unitno_shipping)
                  {{ $unitno_shipping }}
                  @else
                  {{ $unitno_billing }}
                  @endif
                </td>
                <td class="">
                  {{ $address1 }} {{ $address2 }}
                </td>
                <td>{{ $city }}</td>
                <td>{{ $state }}</td>
                {{-- <td>Canada</td> --}}
                <td>{{ $postcode }}</td>
                <td class="email">{{ $email }}</td>
                <td class="phone">{{ $phone }}</td>
                <td></td>
                <td class="notes">{{ $customer_note }}</td>                
              </tr>   
     
          @endforeach
        </tbody>
      </table>
      
      <br><br>
    
    </div>
  </div>
@endsection