<?php

namespace App\Service;

use App\Models\Blog;
use App\Models\BlogInfo;
use Illuminate\Support\Facades\Storage;

// one to many relation
class BlogService
{
    // =========POST======
    public function addService($request)
    {
        // Initialize an empty array to store image names
        $imageNames = [];

        // Store multiple images in local storage folder
        if (isset($request['image'])) {
            foreach ($request['image'] as $key => $image) {
                $timestamp = now()->timestamp;
                $originalName = $image->getClientOriginalName();
                $imageName = $timestamp . '-' . $originalName;
                $image->storeAs('public/images/blogs', $imageName);

                // Store the image name in the array
                $imageNames[] = $imageName;
            }
        }

        // Create the Blog entry
        $blog = Blog::create([
            'title' => $request['title'],
            'slug' => $request['slug'],
            'description' => $request['description'],
        ]);

        // Create BlogInfo entries associated with the Blog
        foreach ($imageNames as $imageName) {
            BlogInfo::create([
                'image' => $imageName,
                'blog_id' => $blog->id,
            ]);
        }
    }

    // ========GET(Read all)================
    public function fetchBlogs()
    {
        //    $blogs=Blog::paginate(10);  //Paginate with 10 records per page
        //    $blogs=Blog::where('published',true)->get(); //where published=true
        //    $blogs=Blog::select('SELECT * FROM blogs'); //raw sql
        //    $blogs=Blog::all(); //fetch all the records
        $blogs = Blog::with('blog_info')->get();  //fetch all data with one to one relation
        //    $blogs=Blog::with('blog_info')->paginate(10);  // fetch data relationship with one to one
        return $blogs;
    }

    // =========DELETE==========
    public function delete($blog)
    {
        // delete image from local storage
        if (isset($blog->blog_info)) {
            foreach ($blog->blog_info as $key => $image) {
                Storage::delete('public/images/blogs/' . $image->image);
            }
        }
        // if cascade on delete not used:
        // $blog->blog_info->delete(); //delete child record
        // $blog->delete(); //delete parent record
        // if cascade on delete used:
        $blog->delete();
    }

    // ========FETCH(Single Blog)======
    public function singleBlog($blog)
    {
        // $blogs=Blog::where('slug',$blog->slug)->first();
        return $blog;
    }

    // =======UPDATE(PUT)==============
    public function updateService($request, $blog)
    {
        // Check if new images are uploaded
        if (isset($request['image'])) {
            // Delete old images from storage folder and database
            foreach ($blog->blog_info as $oldImage) {
                // Delete from local storage
                Storage::delete('public/images/blogs/' . $oldImage->image);
                // Delete from database
                $oldImage->delete();
            }
    
            // Store the new images
            foreach ($request['image'] as $key => $image) {
                $timestamp = now()->timestamp;
                $originalName = $image->getClientOriginalName();
                $imageName = $timestamp . '-' . $originalName;
                $image->storeAs('public/images/blogs', $imageName);
    
                // Update in child table
                $blog->blog_info()->create([
                    'image' => $imageName,
                ]);
            }
    
            // Update in parent table
            $blog->update([
                'title' => $request['title'],
                'slug' => $request['slug'],
                'description' => $request['description'],
            ]);
        } else {
            // If no new images, update only the parent table
            $blog->update([
                'title' => $request['title'],
                'slug' => $request['slug'],
                'description' => $request['description'],
            ]);
        }
    }
    
}
