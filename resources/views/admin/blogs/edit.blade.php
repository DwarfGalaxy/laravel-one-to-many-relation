@extends('admin.layouts.master')
@section('content')
<div class="container">
    <form action="{{route('blogs.update',$blog)}}"  method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" value="{{$blog->title}}">
          @if ($errors->has('title'))
              <span class="text-danger">{{$errors->first('title')}}</span>
          @endif
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug"  value="{{$blog->slug}}">
            @if ($errors->has('slug'))
              <span class="text-danger">{{$errors->first('slug')}}</span>
            @endif
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px">{{$blog->description}}</textarea>
            @if ($errors->has('description'))
              <span class="text-danger">{{$errors->first('description')}}</span>
            @endif
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" name="image[]" multiple>
            @if ($errors->has('image'))
                <span class="text-danger">{{$errors->first('image')}}</span>
            @endif
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>


@endsection