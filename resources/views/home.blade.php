@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    {{-- <div class="container">
                        <h1>Tasks</h1>
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->due_date }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>--}}

            </div>
        </div>
    </div>
</div>
</div>
@endsection