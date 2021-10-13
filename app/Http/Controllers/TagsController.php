<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\TagRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TagsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Gate::allows('tags.view')) {
            abort(403);
        }

        // SELECT * FROM tags
        $tags = Tag::paginate();

        //dd($tags);
        return view('tags.index', [
            'title' => 'Tags List',
            'tags' => $tags,
            'user' => Auth::user(),
        ]);
    }

    public function create()
    {
        if (Gate::denies('tags.create')) {
            abort(403);
        }

        return view('tags.create', [
            'tag' => new Tag(),
        ]);
    }

    public function store(TagRequest $request)
    {
        //$this->validateRequest($request);

        // 1
        // $tag = new Tag();
        // $tag->name = $request->input('name');
        // $tag->slug = Str::slug($request->name);
        // $tag->save();

        $request->merge([
            'slug' =>  Str::slug($request->name)
        ]);
        // 2
        //dd($request->all());
        $tag = Tag::create($request->all());

        // 3
        // $tag = new Tag($request->all());
        // $tag->save();

        // 4
        // $tag = new Tag();
        // $tag->forceFill($request->all())->save();

        // PRG
        return redirect('/tags')->with('success', 'Tag created!');
    }

    public function edit($id)
    {
        Gate::authorize('tags.edit');

        // SELECT * FROM tags WHERE id = $id
        // $tag = Tag::where('id', '=', $id)->firstOrFail();
        $tag = Tag::findOrFail($id);
        /*if ($tag == null) {
            abort(404);
        }*/

        return view('tags.edit', [
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, $id)
    {

        // $rules = [
        //     'name' => ['required', 'string', 'between:3,255', "unique:tags,name,$id"],
        // ];

        // $validator = Validator::make(
        //     $request->all(),
        //     $rules,
        // );

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }


        $data = $this->validateRequest($request, $id);
        dd($data, $request->all());

        $tag = Tag::findOrFail($id);
        // 1
        // $tag->name = $request->input('name');
        // $tag->slug = Str::slug($request->input('name'));
        // $tag->save();

        // 2
        $tag->update([
            'name' => $data['name'],
            'slug' => Str::slug($request->input('name')),
        ]);

        //session()->flash();
        Session::flash('success', 'Tag updated!');
        Session::flash('info', $tag->name);

        return redirect('/tags'); //->with('success', 'Tag updated!');
    }

    public function destroy($id)
    {
        // 1
        Tag::destroy($id);

        // 2
        //Tag::where('id', '=', $id)->delete();

        // 3
        // $tag = Tag::findOrFail($id);
        // $tag->delete();

        return redirect('/tags')->with('success', 'Tag deleted!');
    }

    protected function validateRequest(Request $request, $id = 0)
    {
        $rules = [
            'name' => ['required', 'string', 'between:3,255', "unique:tags,name,$id"],
        ];
        $messages = [
            'required' => 'The input field :attribute is mandatory',
        ];

        //$clean = $request->validate($rules, $messages);
        //$clean = $this->validate($request, $rules, $messages);

        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages,
            [
                'name' => 'Tag Name'
            ]
        );

        if ($validator->failed()) {
            return redirect()->back();
        }

        $clean = $validator->validate();
        return $clean;
    }
}
