@extends ("theme::layouts/app")
@section ("title", "Games")

@section ("main")

    @php
        $games = get_games();
    @endphp

    <div class="games-page">
        <div class="container py-4">
    
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Explore Games</h2>
                    <p class="text-secondary mb-0">Discover and play your favorite games</p>
                </div>
    
                <div class="btn-group">
                    <button class="btn btn-primary" id="grid_view">
                        <i class="bi bi-grid-3x3-gap"></i> Grid
                    </button>
    
                    <button class="btn btn-outline-secondary" id="list_view">
                        <i class="bi bi-list-ul"></i> List
                    </button>
                </div>
            </div>
    
            {{-- Games --}}
            <div class="row g-4" id="games_container">
    
                @foreach($games as $game)
                    <div class="col-sm-6 col-lg-4 game_item"
                        data-name="{{ strtolower($game->title) }}"
                        data-category="{{ strtolower($game->category->name ?? '') }}"
                        data-rating="{{ $game->rating ?? 0 }}"
                        data-popularity="{{ $game->players ?? 0 }}"
                        data-date="{{ $game->created_at->timestamp }}">
    
                        <div class="game-card">
    
                            <img
                                src="{{ $game->thumbnail }}"
                                alt="{{ $game->title }}"
                                class="game-image"
                            >
    
                            <div class="game-content">
    
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary">
                                        {{ $game->category->name ?? 'Uncategorized' }}
                                    </span>
    
                                    <span class="text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        {{ $game->rating ?? '0.0' }}
                                    </span>
                                </div>
    
                                <h5 class="game-title">
                                    {{ $game->title }}
                                </h5>
    
                                <p class="game-description">
                                    {{ $game->description }}
                                </p>
    
                                <div class="d-flex justify-content-between align-items-center mt-3">
    
                                    <small class="text-secondary">
                                        <i class="bi bi-people"></i>
                                        {{ number_format($game->players ?? 0) }} Players
                                    </small>
    
                                    <a href="{{ route('games.play', ['slug' => $game->slug]) }}"
                                        class="btn btn-success btn-sm px-4">
                                        <i class="bi bi-play-fill"></i>
                                        Play Now
                                    </a>
    
                                </div>
    
                            </div>
                        </div>
    
                    </div>
    
                @endforeach
    
            </div>
    
            <div id="no_games" class="text-center py-5 d-none">
                <i class="bi bi-controller display-3 text-secondary"></i>
                <h5 class="mt-3">No games found</h5>
                <p class="text-secondary">Try changing your search or filters.</p>
            </div>
    
        </div>
    </div>
    
    <script>
        
document.addEventListener("DOMContentLoaded", function () {

    const games_container = document.getElementById("games_container");
    const search_games = document.getElementById("search_games");
    const filter_category = document.getElementById("filter_category");
    const sort_games = document.getElementById("sort_games");
    const grid_view = document.getElementById("grid_view");
    const list_view = document.getElementById("list_view");
    const no_games = document.getElementById("no_games");

    let current_view = "grid";

    function change_view(view) {

        current_view = view;

        if (view === "grid") {
            games_container.classList.remove("game-list-view");

            grid_view.classList.replace("btn-outline-secondary", "btn-primary");
            list_view.classList.replace("btn-primary", "btn-outline-secondary");

        } else {
            games_container.classList.add("game-list-view");

            list_view.classList.replace("btn-outline-secondary", "btn-primary");
            grid_view.classList.replace("btn-primary", "btn-outline-secondary");
        }
    }

    function filter_games() {

        const search = search_games.value.toLowerCase().trim();
        const category = filter_category.value.toLowerCase();

        const game_items = Array.from(
            document.querySelectorAll(".game_item")
        );

        game_items.forEach(function (item) {

            const name = item.dataset.name;
            const item_category = item.dataset.category;

            const matches_search = name.includes(search);
            const matches_category = !category || item_category === category;

            item.classList.toggle(
                "d-none",
                !(matches_search && matches_category)
            );

        });

        const visible_games = game_items.filter(function (item) {
            return !item.classList.contains("d-none");
        });

        no_games.classList.toggle("d-none", visible_games.length > 0);

    }

    function sort_games_list() {

        const sort_by = sort_games.value;

        const game_items = Array.from(
            document.querySelectorAll(".game_item")
        );

        game_items.sort(function (a, b) {

            switch (sort_by) {

                case "rating":
                    return Number(b.dataset.rating) - Number(a.dataset.rating);

                case "latest":
                    return Number(b.dataset.date) - Number(a.dataset.date);

                case "name":
                    return a.dataset.name.localeCompare(b.dataset.name);

                default:
                    return Number(b.dataset.popularity) - Number(a.dataset.popularity);
            }

        });

        game_items.forEach(function (item) {
            games_container.appendChild(item);
        });

        filter_games();
    }

    grid_view.addEventListener("click", function () {
        change_view("grid");
    });

    list_view.addEventListener("click", function () {
        change_view("list");
    });

    search_games.addEventListener("input", filter_games);

    filter_category.addEventListener("change", filter_games);

    sort_games.addEventListener("change", sort_games_list);

    change_view(current_view);

});
    </script>
    
    <style>
        
.games-page {
    min-height: 100vh;
    background: #10131c;
    color: #fff;
}

.game-card {
    background: #1b2030;
    border: 1px solid #30384b;
    border-radius: 12px;
    overflow: hidden;
    height: 100%;
    transition: transform .2s ease, border-color .2s ease;
}

.game-card:hover {
    transform: translateY(-4px);
    border-color: #5269a5;
}

.game-image {
    width: 100%;
    height: 190px;
    object-fit: cover;
}

.game-content {
    padding: 16px;
}

.game-title {
    font-weight: 700;
    color: #fff;
}

.game-description {
    color: #a5adbd;
    font-size: 14px;
    min-height: 42px;
}

.game-list-view .game_item {
    width: 100%;
}

.game-list-view .game-card {
    display: flex;
    flex-direction: row;
    padding: 12px;
    gap: 15px;
}

.game-list-view .game-image {
    width: 220px;
    min-width: 220px;
    height: 155px;
    border-radius: 8px;
}

.game-list-view .game-content {
    flex: 1;
}

@media(max-width: 576px) {
    .game-list-view .game-card {
        flex-direction: column;
    }

    .game-list-view .game-image {
        width: 100%;
        height: 190px;
    }
}
    </style>

@endsection