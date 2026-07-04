@extends ("theme::layouts/app")
@section ("title", $post->title)
@section ("meta_keywords", implode(",", $post->tags))
@section ("meta_description", $post->excerpt)
@section ("type", "article")

@section ("main")

    <div class="post-container">
        <h1 class="post-title">{{ $post->title }}</h1>
        <div class="post-meta">By {{ $post->user_name }} • {{ $post->created_at_formatted }}</div>
        <div class="post-cover">
          <img src="{{ $post->file_path }}" alt="{{ $post->title }}"
            onerror="this.remove();" />
        </div>
        <div class="post-content">
          {!! $post->content !!}
        </div>

        <div class="post-navigation">
          <a href="{{ $previous_post->url ?? '' }}" class="nav-card prev-post {{ $previous_post == null ? 'hide' : '' }}">
            <div class="nav-label">← Previous Post</div>
            <div class="nav-title">{{ $previous_post->title ?? "" }}</div>
          </a>

          <a href="{{ $next_post->url ?? '' }}" class="nav-card next-post {{ $next_post == null ? 'hide' : '' }}">
            <div class="nav-label">Next Post →</div>
            <div class="nav-title">{{ $next_post->title ?? "" }}</div>
          </a>
        </div>
    </div>

    <style>
        .post-navigation {
          display: flex;
          justify-content: space-between;
          margin-top: 3rem;
          gap: 1rem;
          flex-wrap: wrap;
        }

        .nav-card {
          /*flex: 1 1 45%;*/
          background: #ffffff;
          padding: 1.5rem;
          border-radius: 12px;
          box-shadow: 0 10px 25px rgba(0,0,0,0.05);
          text-decoration: none;
          color: #333;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .nav-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 16px 30px rgba(0,0,0,0.1);
        }

        .nav-label {
          font-size: 0.85rem;
          color: #007bff;
          margin-bottom: 0.25rem;
          transition: color 0.3s ease;
        }

        .nav-card:hover .nav-label {
          color: #0056b3;
        }

        .nav-title {
          font-size: 1.1rem;
          font-weight: 600;
          color: #222;
          transition: color 0.3s ease;
        }

        .nav-card:hover .nav-title {
          color: #000;
        }
        @keyframes fadeInBody {
          from { opacity: 0; }
          to { opacity: 1; }
        }

        .post-container {
          background: #fff;
          max-width: 800px;
          margin: auto;
          padding: 2rem;
          border-radius: 16px;
          box-shadow: 0 20px 40px rgba(0,0,0,0.1);
          transform: translateY(20px);
          animation: slideInUp 0.6s ease-out forwards;
        }

        @keyframes slideInUp {
          from { opacity: 0; transform: translateY(40px); }
          to { opacity: 1; transform: translateY(0); }
        }

        .post-title {
          font-size: 2.5rem;
          margin-bottom: 0.5rem;
          color: #111;
          transition: color 0.3s ease;
        }

        .post-title:hover {
          color: #007bff;
        }

        .post-meta {
          color: #777;
          font-size: 0.95rem;
          margin-bottom: 1.5rem;
          transition: transform 0.3s;
        }

        .post-meta:hover {
          transform: translateX(5px);
        }

        .post-cover img {
          width: 100%;
          border-radius: 12px;
          margin-bottom: 1.5rem;
          transition: transform 0.4s ease;
        }

        .post-cover img:hover {
          transform: scale(1.03);
        }

        .post-content p {
          margin-bottom: 1rem;
          font-size: 1.1rem;
          transition: color 0.3s;
        }

        .post-content p:hover {
          color: #444;
        }
    </style>

@endsection