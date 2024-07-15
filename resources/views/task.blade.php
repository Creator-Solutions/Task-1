<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- External JavaScript File -->
    <script src="{{ asset('js/task.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col">

    <!-- Header Component -->
    <x-header />

    <div class="w-9/12 m-auto">
        <button onclick="TaskHandler.onShowPopUp()"
            class="w-48 h-[45px] bg-[#0B1215] text-white mt-12 rounded-lg float-right">New Task</button>
    </div>

    <!-- Table that displays all the tasks -->
    <table id="task-table" class="w-9/12 m-auto mt-2 shadow-md rounded-md">
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
                        <button onclick="TaskHandler.onEdit({{ $task->id }})" class="edit-button">
                            <img src="/images/edit.svg" class="w-auto hover:cursor-pointer" />
                        </button>
                        <button onclick="TaskHandler.onDelete({{ $task->id }})" class="delete-button">
                            <img src="/images/delete.svg" class="w-auto hover:cursor-pointer" />
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

    <!-- Overlay for Form PopUp -->
    <div id="overlay" class="w-full hidden h-screen top-0 absolute bg-white opacity-40 z-30">
    </div>

    <!-- New Task Form PopUp-->
    <div id="popup"
        class="w-1/3 h-96 m-auto hidden bg-white overlfow-y-scroll z-50 opacity-100 shadow-xl rounded-md absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <div class="w-full h-10 flex">
            <p class="self-center pl-4">New Task</p>
        </div>
        <div class="w-9/12 h-auto m-auto mt-2">
            <form id="taskForm" class="flex flex-col">
                <div class="w-full h-auto flex flex-col">
                    <label for="tasktitle">Task Title</label>
                    <input type="text" id="tasktitle"
                        class="h-[35px] border-[1px] border-[#c0c0c0] rounded-md pl-2 focus:outline-none" />
                </div>
                <div class="w-full h-auto flex flex-col mt-3">
                    <label for="tastdescription">Task Description</label>
                    <textarea id="taskdescription" rows="10" cols="50"
                        class="h-[100px] border-[1px] border-[#c0c0c0] rounded-md pl-2 focus:outline-none"></textarea>
                </div>
                <div class="w-full h-auto flex flex-row mt-3">
                    <input id="taskcompleted" type="checkbox" value="Task Completed"
                        class="h-[25px] border-[1px] border-[#c0c0c0] rounded-md pl-2 focus:outline-none" />
                    <label for="taskcompleted" class="ml-4">Task Completed</label>
                </div>
                <input type="button" value="Create Task" onclick="TaskHandler.onCreateTask(event)"
                    class="w-9/12 h-[35px] m-auto mt-4 border-[1px] border-black rounded-md hover:cursor-pointer" />
            </form>
        </div>
    </div>

    <script>
        // Pass the base URL and CSRF token to the external JS file
        const baseURL = '{{ url('/') }}';
        const csrfToken = '{{ csrf_token() }}';
    </script>
</body>

</html>
