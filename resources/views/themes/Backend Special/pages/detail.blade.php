@extends ("theme::layouts/app")
@section ("title", $page->title)
@section ("meta_keywords", $page->keywords)
@section ("meta_description", $page->excerpt)
@section ("type", "article")
@section ("main")
    <div class="container content">
        {!! $page->content !!}
    </div>
@endsection