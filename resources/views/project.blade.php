@extends('layout.main')

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/project-page.css') }}" media="all">
@endsection

@section('content')
    <div id="page"></div>
@endsection

@section('scripts')
    <script lang="ts">
        const page = new planner5d.ProjectPage('page', '{{ url('api') }}');
        page.fetchProject({{ $projectId }});
    </script>
@endsection
