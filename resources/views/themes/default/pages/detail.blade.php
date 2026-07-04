@extends ("theme::layouts/app")
@section ("title", $page->title)
@section ("meta_keywords", $page->keywords)
@section ("meta_description", $page->excerpt)
@section ("type", "article")

@section ("main")

    <div class="content">
        {!! $page->content !!}
    </div>

    <style>
        .content {
          background: white;
          padding: 30px;
          max-width: 800px;
          margin: auto;
          box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .content h1, .content h2, .content h3 {
          margin-top: 30px;
          color: #222;
        }
        .content p {
          margin: 15px 0;
        }
        .content img {
          max-width: 100%;
          height: auto;
          display: block;
          margin: 20px auto;
        }
        .content iframe {
          width: 100%;
          height: 400px;
          border: none;
          margin: 20px 0;
        }
        .content ul, .content ol {
          margin: 15px 0 15px 30px;
        }
        .content a {
          color: #007BFF;
          text-decoration: none;
        }
        .content a:hover {
          text-decoration: underline;
        }
        .content section {
          border: 1px solid #ddd;
          padding: 20px;
          margin: 30px 0;
          background: #f9f9f9;
        }
        .columns {
          display: flex;
          gap: 20px;
        }
        .columns > div {
          flex: 1;
          border: 1px dashed #ccc;
          padding: 10px;
          background: #fff;
        }
    </style>

@endsection