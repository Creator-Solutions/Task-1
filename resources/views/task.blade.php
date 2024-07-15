<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <x-header />

    <table id="task-table" class="w-9/12 m-auto mt-12 shadow-md rounded-md">
        <tr class="h-14 bg-[#0B1215] text-white">
            <th class="w-24">ID</th>
            <th class="w-24">Task Title</th>
            <th class="w-48">Task Description</th>
            <th class="w-24">Task Completed</th>
            <th class="w-24">Actions</th>
        </tr>
        @foreach ($tasks as $task)
        <tr class="h-12" id="task_{{ $task->id }}">
            <td class="w-24 text-center">{{ $task->id }}</td>
            <td class="w-24 text-center">{{ $task->task_title }}</td>
            <td class="w-48 text-center">{{ $task->task_description }}</td>
            <td class="w-24 text-center">{{ $task->task_completed }}</td>
            <td class="w-48 text-center">
                <div class="w-full h-height flex flex-row justify-evenly">
                    <button onclick="onEdit({{ $task->id }})" class="edit-button">
                        <img src="/images/edit.svg" class="w-auto hover:cursor-pointer" />
                    </button>
                    <button onclick="onDelete({{ $task->id }})" class="delete-button">
                        <img src="/images/delete.svg" class="w-auto hover:cursor-pointer" />
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </table>

    <script>
        function onEdit(taskId) {
            alert('Edit task ID: ' + taskId);
            // Implement edit functionality, e.g., redirect to edit route
            // window.location.href = `/tasks/${taskId}/edit`;
        }

        function onDelete(taskId) {
            alert('Delete task ID: ' + taskId);
            // Implement delete functionality, e.g., send AJAX request
        }
    </script>
</body>

</html>
