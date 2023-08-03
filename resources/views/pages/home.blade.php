@extends('master')

@section('content')

    <a class="linkHref" href="{{ route('create-task') }}">
        + Create new task
    </a>

    <select id="projectFilter">
        <option value="">All Projects</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>

    <ul id="columns">

        @foreach($tasks as $task)

            <li class="column items" data-task_id="{{$task->id}}" data-project_id="{{$task->project_id}}" draggable="true">
                <header>{{ $task->name }}<span>#{{$task->priority}}</span></header>
                <a href="{{ route('update-task' , $task->id) }}">Edit</a>
                <a href="#" class="deleteTask" data-task_id="{{ $task->id }}">Delete</a>
            </li>

        @endforeach

    </ul>

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to delete this task?</p>
            <button id="confirmDelete">Yes</button>
            <button id="cancelDelete">No</button>
        </div>
    </div>

@endsection


@section('script')

    <script>
        $(document).ready(function () {

            $('#projectFilter').on('change', function () {
                const selectedProjectId = $(this).val();

                if (selectedProjectId) {
                    $('#columns li').hide();
                    $(`#columns li[data-project_id="${selectedProjectId}"]`).show();
                } else {
                    $('#columns li').show();
                }
            });


            let taskIdToDelete;
            const confirmModal = $('#confirmModal');

            $('.deleteTask').on('click', function (e) {
                e.preventDefault();

                taskIdToDelete = $(this).data('task_id');

                confirmModal.show();
            });

            $('#confirmDelete').on('click', function () {
                confirmModal.hide();

                $.ajax({
                    type: 'DELETE',
                    url: '/api/task/' + taskIdToDelete,
                    success: function (response) {
                        console.log('Task deleted successfully!');
                        console.log(response);

                        $('#columns li[data-task_id="' + taskIdToDelete + '"]').remove();
                    },
                    error: function (error) {

                        console.error('Error while deleting the task:', error);
                    }
                });
            });

            $('#cancelDelete').on('click', function () {
                confirmModal.hide();
            });
        });
    </script>

@endsection
