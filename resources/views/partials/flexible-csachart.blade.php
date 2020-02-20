@php
  $title = get_sub_field('title');
  $description = get_sub_field('description');
@endphp

<section class="row csachart justify-content-center">
  @if( get_row_layout() == 'flexible-csachart' )
    <div class="col-sm-10 col-md-7">
      <h2>{{ $title }}</h2>
      <p>{!! $description !!}</p>
    </div>
  @endif
  <table class="col-sm-11 col-md-10">
    <thead>
      <tr>
        <th>Week</th>
        <th>1</th>
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
        <th>15</th>                        
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
      </tr>
      <tr>
        <td><h5>Zucchinni</h5></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td></td>
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
        <td><i class="fas fa-check-circle"></i></td>
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
        <td><i class="fas fa-check-circle"></i></td>
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
        <td></td>
      </tr>
      <tr>
        <td><h5>Parsnips</h5></td>
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
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td><i class="fas fa-check-circle"></i></td>
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
        <td><i class="fas fa-check-circle"></i></td>
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
        <td><i class="fas fa-check-circle"></i></td>
      </tr>
    </tbody>
  </table>
</section>