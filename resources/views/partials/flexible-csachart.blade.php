@php
  $title = get_sub_field('title');
  $description = get_sub_field('description');
@endphp

<section class="row csachart justify-content-center">
  <div class="col-sm-10 col-md-8">
    @if( get_row_layout() == 'flexible-csachart' )
      <h2>{{ $title }}</h2>
      <p>{!! $description !!}</p>
  @else 
    <h2>What to expect in your CSA!</h2>
    <p>Below is a list of most of the veggies that went out in 2023's CSA. Although this year won't neccessarily be the same (due to weather, etc.), it should give you a pretty good idea of variety and quantity.</p>
    <p>The chart shows veggies included in our Bigger bounty size. The main difference between our Bigger and Smaller sizes is that carrots and potatoes are typically delivered every week in Bigger bounties while they alternate weeks in Smaller bounties.</p>
  @endif
  </div>
  <table class="col-sm-11 col-md-10">
    <thead>
      <tr>
        <th>Week</th>
        <th>WK 1</th>
        <th>2</th>            
        <th>3</th>            
        <th>4</th>            
        <th>5</th>            
        <th>6</th>            
        <th>7</th>            
        <th>8</th>            
        <th>9</th>            
        <th>10</th>            
        <th>11</th>            
        <th>12</th>            
        <th>13</th>            
        <th>14</th>            
        {{-- <th>15</th>                         --}}
      </tr>
    </thead>        
    <tbody>
      <tr>
        <td><h5>Spinach</h5></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Swiss Chard</h5></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Beets</h5></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Dill</h5></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Kohlrabi</h5></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Zucchini</h5></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Kale</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Cucumber</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Fennel</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Cabbage</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Broccoli</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Cauliflower</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Beans</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Corn</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Leek</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        {{-- <td><i class="fas fa-check-circle"></i></td> --}}
      </tr>
      <tr>
        <td><h5>Squash</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        {{-- <td><i class="fas fa-check-circle"></i></td> --}}
      </tr>
      <tr>
        <td><h5>Brussels Sprouts</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        {{-- <td></td> --}}
      </tr>
      <tr>
        <td><h5>Onion</h5></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        {{-- <td><i class="fas fa-check-circle"></i></td> --}}
      </tr>
      <tr>
        <td><h5>Carrots</h5></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        {{-- <td><i class="fas fa-check-circle"></i></td> --}}
      </tr>
      <tr>
        <td><h5>Potatoes</h5></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        <td><i class="fas fa-check-circle"></i></td>
        {{-- <td><i class="fas fa-check-circle"></i></td> --}}
      </tr>
    </tbody>
  </table>
</section>