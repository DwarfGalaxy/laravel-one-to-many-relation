<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Service\BlogService;
use Illuminate\Http\Request;
class BlogController extends Controller
{
    private $blogService;
    public function __construct() {
        $this->blogService = new BlogService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $blogs=$this->blogService->fetchBlogs();
            return view('admin.blogs.index',compact('blogs'));
        }catch(\Throwable $th){
            return back()-with('error',$th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        try{
            $this->blogService->addService($request->validated());
            return redirect()->route('blogs.index')->with('success','Blog added successfully');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        try{
            $blog=$this->blogService->singleBlog($blog);
            return view('admin.blogs.view',compact('blog'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        try{
            $blog=$this->blogService->singleBlog($blog);
            return view('admin.blogs.edit',compact('blog'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
       try{
         $this->blogService->updateService($request->validated(),$blog);
         return redirect()->route('blogs.index')->with('Success','Blog updated successfully');
       }catch(\Throwable $th){
        return back()->with('error',$th->getMessage());
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try{
            $this->blogService->delete($blog);
            return back()->with('success',"Blog deleted successfully");
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}
