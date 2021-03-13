<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TagRepository;
class TagController extends Controller
{
    public function __construct(TagRepository $tagRepository)
    {
        $this->middleware('auth:admin');
        $this->tagRepository=$tagRepository;
    }

    public function getAllTags()
    {
        $tags=$this->tagRepository->getAllTags();
        return view('admin/tags/list')->with(['tags'=>$tags]);
    }

    public function getAddTagPage()
    {
        return view('admin/tags/create');
    }

    public function addTag(Request $request)
    {
        $result=$this->tagRepository->addTag($request);
        return $result;
    }

    public function getEditTagPage($id)
    {
        $tag=$this->tagRepository->getTagById($id);
        return view('admin/tags/edit')->with(['tag'=>$tag]);
    }

    public function updateTag(Request $request,$id)
    {
        $result=$this->tagRepository->updateTag($request,$id);
        return $result;
    }

    public function deleteTag(Request $request)
    {
        $result=$this->tagRepository->deleteTag($request);
        return $result;
    }
}
