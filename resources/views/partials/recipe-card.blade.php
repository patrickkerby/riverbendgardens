
     <div class="recipe-card">        
        <a href="{{ get_the_permalink() }}">
            <h3>{{ $recipes_loop->post->post_title }}</h3>
            <ul class="pills-list">
                @foreach (get_field('veggies_used', $recipes_loop->post->ID) as $item)
                    <li class="pills">{{ $item->post_title }}</li>
                @endforeach
            </ul>
        </a>
    </div>