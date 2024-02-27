<p>{{$blog->id}}</p>
<p>{{$blog->title}}</p>
<p>{{$blog->slug}}</p>
<p>{{$blog->description}}</p>
<p>
    @foreach ($blog->blog_info as $image)
                    <img  src="{{ asset('storage/images/blogs/'.$image->image) }}" style="height: 30px" alt="{{$image->image}}">
                    @endforeach
</p>