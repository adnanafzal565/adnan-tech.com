@extends ("theme::layouts/app")
@section ("title", $post->title)
@section ("meta_keywords", implode(",", $post->tags))
@section ("meta_description", $post->excerpt)
@section ("type", "article")

@section ("main")

    <!-- Post Detail Section -->
  <div class="container post-detail">
    <article class="post-card">
      <img src="{{ $post->file_path }}" alt="{{ $post->title }}"
        onerror="this.remove();" />

      <div class="post-content">
        <h2>{{ $post->title }}</h2>
        <p class="meta">Published on {{ $post->created_at_formatted }} · by {{ $post->user_name }}</p>

        <div>{!! $post->content !!}</div>

        <a href="{{ url('/') }}" class="back-link">← Back to all posts</a>
      </div>
    </article>
  </div>

  <style>

    /* Style for the <code> tag */
    code {

      font-family: 'Courier New', Courier, monospace; /* Monospace font for code */
      padding: 2px 6px; /* Padding to add spacing around the inline code */
      border-radius: 4px; /* Rounded corners for a softer look */
      font-size: 1em; /* Ensure font size is consistent with the surrounding text */
      word-wrap: break-word; /* Break long words if needed */
      display: inline-block; /* Make code appear inline */
      line-height: 1.4; /* Ensure there's enough line spacing for readability */
      white-space: nowrap; /* Prevent wrapping of code in a single line */
    }


      /* Post Detail Page */
    .post-detail {
      margin-top: 40px;
      margin-bottom: 40px;
    }
    .post-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      overflow: hidden;
      animation: fadeInUp 0.5s ease;
    }
    .post-card img {
      width: 100%;
      display: block;
    }
    .post-content {
      padding: 30px;
    }
    .post-content h2 {
      font-size: 2rem;
      margin-bottom: 10px;
    }
    .post-content .meta {
      color: #888;
      font-size: 0.9rem;
      margin-bottom: 20px;
    }
    .post-content p {
      margin-bottom: 18px;
      font-size: 1rem;
      color: #444;
    }
    .post-content blockquote {
      background: #f1f1f1;
      border-left: 5px solid #007bff;
      padding: 15px 20px;
      margin: 20px 0;
      font-style: italic;
      color: #333;
    }
    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #007bff;
      transition: color 0.3s ease;
    }
    .back-link:hover {
      color: #0056b3;
    }

    /* Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(25px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

@endsection
