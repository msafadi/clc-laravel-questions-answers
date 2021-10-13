<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;

class QuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*leftJoin('users', 'questions.user_id', '=', 'users.id')
        ->select([
            'questions.*',
            'users.name as user_name',
        ])
        ->*/
        $search = request('search');
        $tag_id = request('tag_id');

        $questions = Question::with('user', 'tags')
            //->has('answers')
            ->withCount('answers')
            ->latest()
            //->orderBy('created_at', 'DESC')
            ->when($search, function ($query, $search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->when($tag_id, function ($query, $tag_id) {
                // $query->whereRaw('questions.id IN (
                //     SELECT question_id FROM question_tag WHERE tag_id = ?
                // )', [$tag_id]);

                $query->whereHas('tags', function ($query) use ($tag_id) {
                    $query->where('id', '=', $tag_id);
                });
            })
            ->paginate(3); // 15 per page
        return view('questions.index', [
            'questions' => $questions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('questions.create', [
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tags' => ['required', 'array']
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'status' => 'open',
        ]);

        DB::beginTransaction();
        try {
            $question = Question::create($request->all());

            $question->tags()->attach($request->input('tags'));

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('questions.index')
            ->with('success', 'Question added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);

        // $answers = Answer::where('question_id', $question->id)
        //     ->with('user')
        //     ->latest()
        //     ->get();

        $answers = $question->answers()->with('user')->latest()->get();

        return view('questions.show', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $tags = Tag::all();

        $question_tags = $question->tags()->pluck('id')->toArray();

        return view('questions.edit', [
            'question' => $question,
            'tags' => $tags,
            'question_tags' => $question_tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('update', $question);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['in:open,closed'],
            'tags' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $question->update($request->all());

            $question->tags()->sync($request->input('tags'));
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('questions.index')
            ->with('success', 'Question updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('delete', $question);

        Question::destroy($id);
        return redirect()->route('questions.index')
            ->with('success', 'Question deleted!');
    }
}
