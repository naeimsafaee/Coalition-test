@extends('master')


@section('content')

    <h2>Create Task</h2>
    <form id="taskForm">
        <label for="project_id">Project ID:</label>
        <select id="project_id" name="project_id" required>
            <option value="">Select a project ID</option>
            @foreach($projects as $project)
                <option value="{{$project->id}}">{{$project->name}}</option>
            @endforeach
        </select>
        <br><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="priority">Priority:</label>
        <input type="number" id="priority" name="priority" required><br><br>

        <input type="submit" value="Create Task">
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
                type: "POST",
                url: "{{ route('task.store') }}",
                data: formData,
                success: function (data) {
                    $('#responseMessage').text('Task created successfully!').css('color', 'green');

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
