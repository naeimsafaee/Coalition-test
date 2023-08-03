@extends('master')


@section('content')

    <h2>Update Task {{ $task->name }}</h2>
    <form id="taskForm">
        <label for="project_id">Project ID:</label>
        <select id="project_id" name="project_id" required>
            <option value="">Select a project ID</option>
            @foreach($projects as $project)
                <option value="{{$project->id}}" @if($task->project_id === $project->id) selected @endif>{{$project->name}}</option>
            @endforeach
        </select>
        <br><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') ?? $task->name }}" required><br><br>

        <label for="priority">Priority:</label>
        <input type="number" id="priority" name="priority" value="{{old('priority') ?? $task->priority}}" required><br><br>

        <input type="submit" value="Update Task">
    </form>

    <div id="responseMessage"></div>



@endsection

@section('script')

    <script>

        $('#taskForm').submit(function (e) {
            e.preventDefault();

            const formData = {
                project_id: $('#project_id').val(),
                name: $('#name').val(),
                priority: $('#priority').val()
            };

            $.ajax({
                type: "PUT",
                url: "{{ route('task.update' , $task->id) }}",
                data: formData,
                success: function (data) {
                    $('#responseMessage').text('Task updated successfully!').css('color', 'green');

                    setTimeout(()=> {
                        window.location = "{{ route('home') }}"
                    } , 1000)

                },
                error: function (xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).message;
                    $('#responseMessage').text('Error: ' + errorMessage).css('color', 'red');
                }
            });
        });
    </script>

@endsection
