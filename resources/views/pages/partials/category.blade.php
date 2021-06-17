@if($post->hasCategory())
    <h6>
        <a href="{{ route('category.show', $post->category->slug) }}"> {{ $post->category->title }}</a>
    </h6>
@endif
