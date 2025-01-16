@extends('layouts.app')
@section('content')
<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Tasks List</h2>
        </div>
        <div class="col-md-6">

        </div>
        <br>
        <div class="col-md-12">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Task Name</th>
                        <th width="10%" class="text-center">
                            Task Status
                        </th>
                        <th width="20%" class="text-center">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                    <tr>
                        <th>{{ $task->id }}</th>
                        <td>{{ $task->title }}</td>
                        <td>
                            {{ $task->status }}
                        </td>
                        <td>
                            <div class="action_btn">
                                <div class="action_btn">
                                    <a href="{{ route('task.edit', $task->id)}}" class="btn btn-warning">Edit</a>
                                </div>
                                <div class="action_btn col-3">
                                    <a href="{{ route('task.show', $task->id)}}" class="btn btn-primary">View</a>
                            </div>

                                    </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            No data found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection