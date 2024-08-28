<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.3/tailwind.min.css">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full sm:w-1/2 lg:w-1/3">
        <h1 class="text-4xl font-bold text-center mb-6">Todos</h1>

        <form action="{{ route('todos.store') }}" method="POST" class="mb-4">
            @csrf
            <input type="text" name="todo" placeholder="What needs to be done?" class="border rounded w-full p-2 mb-2"
                required>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Add Todo</button>
        </form>

        <div class="flex justify-between items-center mb-4">
            <div>
                <a href="{{ route('todos.index', ['filter' => 'all']) }}"
                    class="border border-blue-500 text-blue-500 px-4 py-2 rounded {{ $filter === 'all' ? 'font-bold bg-blue-100' : 'hover:bg-blue-50' }}">All</a>
                <a href="{{ route('todos.index', ['filter' => 'active']) }}"
                    class="border border-blue-500 text-blue-500 px-4 py-2 rounded {{ $filter === 'active' ? 'font-bold bg-blue-100' : 'hover:bg-blue-50' }}">Active</a>
                <a href="{{ route('todos.index', ['filter' => 'completed']) }}"
                    class="border border-blue-500 text-blue-500 px-4 py-2 rounded {{ $filter === 'completed' ? 'font-bold bg-blue-100' : 'hover:bg-blue-50' }}">Completed</a>
            </div>
            <div>
                <span>{{ $leftItems }} item{{ $leftItems != 1 ? 's' : '' }} left!</span>
            </div>
        </div>

        <ul class="divide-y divide-gray-200 mb-4">
            @foreach($todos as $todo)
            <li class="flex justify-between items-center py-2">
                <form action="{{ route('todos.update', $todo->id) }}" method="POST" class="flex items-center">
                    @csrf
                    @method('PATCH')
                    <input type="checkbox" name="is_completed" onchange="this.form.submit()" class="mr-2" {{
                        $todo->is_completed ? 'checked' : '' }}>
                    <span class="{{ $todo->is_completed ? 'line-through text-gray-400' : '' }}">{{ $todo->todo }}</span>
                </form>

                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                </form>
            </li>
            @endforeach
        </ul>

        <form action="{{ route('todos.clearCompleted') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700">Clear Completed</button>
        </form>
    </div>
</body>

</html>
