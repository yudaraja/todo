<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        switch ($filter) {
            case 'active':
                $todos = Todo::where('is_completed', false)->get();
                break;
            case 'completed':
                $todos = Todo::where('is_completed', true)->get();
                break;
            default:
                $todos = Todo::all();
                break;
        }

        $leftItems = Todo::where('is_completed', false)->count();

        return view('todo.index', compact('todos', 'filter', 'leftItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'todo' => 'required|string|max:255',
        ]);

        Todo::create([
            'todo' => $request->todo,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Todo $todo)
    {
        $todo->is_completed = $request->has('is_completed');
        $todo->save();

        return redirect()->back();
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->back();
    }

    public function clearCompleted()
    {
        Todo::where('is_completed', true)->delete();

        return redirect()->back()->with('success', 'Completed todos cleared!');
    }
}
