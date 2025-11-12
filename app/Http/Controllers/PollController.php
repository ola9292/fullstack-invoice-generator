<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Voter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PollController extends Controller
{
    public function index()
    {
        $current_user_id = auth()->user()->id;
        $polls = Poll::with('options')->where('user_id', $current_user_id)->get();

        return Inertia::render('Poll/Index', [
            'polls' => $polls,
        ]);
    }

    public function create()
    {
        return Inertia::render('Poll/Create');
    }

    public function store(Request $request)
    {
        // dd(auth()->user()->id);
        // dd($request->all());
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string|max:255',
        ]);

        // Create the poll
        $poll = Poll::create([
            'user_id' => auth()->user()->id,
            'question' => $validated['question'],
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        // Create the poll options
        foreach ($validated['options'] as $option) {
            $poll->options()->create([
                'text' => $option['text'],
            ]);
        }

        return redirect()->route('home')->with('message', 'Poll created successfully!');

    }

    public function show(Request $request, $slug)
    {

        $poll = Poll::with('options')->where('slug', $slug)->first();

        if ($poll->expires_at < Carbon::now()) {
            return redirect()->route('home')->with('message', 'Poll expired!');
        }

        return Inertia::render('Poll/Show', [
            'poll' => $poll,
        ]);
    }

    public function storeVote(Request $request)
    {

        $option_id = $request->input('option_id');
        $poll_id = $request->input('poll_id');
        $current_user_id = auth()->user()->id;

        $voter = Voter::where('user_id', $current_user_id)
            ->where('poll_id', $poll_id)
            ->first();

        // if ($voter) {
        //     return to_route('home')->with('message', 'You have already voted in this poll.');
        // }

        Voter::create([
            'user_id' => auth()->user()->id,
            'option_id' => $option_id,
            'poll_id' => $poll_id,
        ]);

        // $poll = Poll::with('options')->findOrFail($poll_id);

        $poll = Poll::with(['options' => function ($query) {
            $query->withCount('voters');
        }])->findOrFail($poll_id);

        return to_route('poll.result', $poll_id)->with('message', 'You have successfully voted.');

        // return Inertia::render('Poll/Result', [
        //     'poll' => $poll,
        // ])->with('message', 'You have successfully voted.');
    }

    public function showResult(Request $request, $id)
    {

        // $poll = Poll::with(['options' => function ($query) {
        //     $query->withCount('voters');
        // }])->findOrFail($id);
        $poll = Poll::with('options.voters')->findOrFail($id);

        return Inertia::render('Poll/Result', [
            'poll' => $poll,
        ])->with('message', 'You have successfully voted.');
    }
}
