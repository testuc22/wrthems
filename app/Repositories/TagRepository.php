<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Tag;
use Str;
class TagRepository
{
	public function getAllTags()
	{
	    return Tag::all();
	}

	public function addTag($request)
	{
	    $this->validateData($request);
	    $tagData=$this->getValidatedData($request);
	    Tag::create($tagData);
	    return $this->getMessage($request,'Tag Created Successfully');
	}

	public function getTagById($id)
	{
	    return Tag::find($id);
	}

	public function validateData($request)
	{
	    $request->validate([
	    	'tag_title'=>'required',
	    ]);
	}

	public function getValidatedData($request)
	{
	    return [
	    	'tag_name'=>$request->tag_title,
	    ];
	}

	public function updateTag($request,$id)
	{
	    $this->validateData($request);
	    $tagData=$this->getValidatedData($request);
	    $this->getTagById($id)->update($tagData);
	    return $this->getMessage($request,'Tag Updated Successfully');
	}

	public function deleteTag($request)
	{
	    $this->getTagById($request->tag)->delete();
	    return response()->json(['message'=>'Tag Deleted Successfully'],200);
	}

	public function getMessage($request,$message)
    {
        $request->session()->flash('success',$message);
        return redirect()->route('list-tags');
    }
	
}