@extends('layout.main')

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/project-list.css') }}" media="all">
@endsection

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <div id="list"></div>
    </div>
@endsection

@section('scripts')
    <script lang="ts">
        const list = new planner5d.ProjectList('list', '{{ url('api') }}');
        list.fetchList();
    </script>
@endsection
