@extends ("theme::layouts/app")
@section ("title", "PP3D | Game")

@section ("main")

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4328287883552246"
         crossorigin="anonymous"></script>
    <ins class="adsbygoogle"
         style="display:block; text-align:center;"
         data-ad-layout="in-article"
         data-ad-format="fluid"
         data-ad-client="ca-pub-4328287883552246"
         data-ad-slot="6974790312"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

    <!-- ===== Precision Parking 3D : paste this where the game should appear ===== -->
    <div id="precision-parking-game">
    
      <!-- OPTIONAL AdSense (outside the game frame). Enable in JS config: pp3d_config.ads -->
      <div class="pp3d-ad pp3d-ad-top" id="pp3d-ad-top" hidden></div>
    
      <div class="pp3d-frame" id="pp3d-frame">
        <div class="pp3d-canvas-wrap" id="pp3d-canvas-wrap"></div>
    
        <div class="pp3d-loading" id="pp3d-loading">
          <div class="pp3d-spinner"></div>
          <span id="pp3d-loading-text">Loading Precision Parking 3D…</span>
        </div>
    
        <!-- HUD -->
        <div class="pp3d-hud" id="pp3d-hud">
          <div class="pp3d-hud-left">
            <div class="pp3d-chip pp3d-chip-level" id="pp3d-hud-level">Level 1</div>
            <div class="pp3d-chip-row">
              <div class="pp3d-chip pp3d-chip-col" id="pp3d-hud-col-wrap" title="Collisions">💥 <b id="pp3d-hud-collisions">0/0</b></div>
              <div class="pp3d-chip" title="Parking accuracy">🎯 <b id="pp3d-hud-accuracy">0%</b></div>
            </div>
          </div>
          <div class="pp3d-hud-center">
            <div class="pp3d-timer" id="pp3d-hud-timer">0:00</div>
          </div>
          <div class="pp3d-hud-right">
            <button type="button" class="pp3d-btn pp3d-iconbtn" data-pp3d-action="camera" title="Camera (C)" aria-label="Change camera">🎥</button>
            <button type="button" class="pp3d-btn pp3d-iconbtn" data-pp3d-action="fullscreen" title="Fullscreen" aria-label="Fullscreen">⛶</button>
            <button type="button" class="pp3d-btn pp3d-iconbtn" data-pp3d-action="pause" title="Pause (Esc)" aria-label="Pause">⏸</button>
          </div>
          <div class="pp3d-hud-bottom">
            <div class="pp3d-hold" id="pp3d-hold"><div class="pp3d-hold-fill" id="pp3d-hold-fill"></div></div>
            <div class="pp3d-speedo">
              <span class="pp3d-gear" id="pp3d-hud-gear">N</span>
              <span class="pp3d-speed"><b id="pp3d-hud-speed">0</b> km/h</span>
            </div>
          </div>
        </div>
    
        <div class="pp3d-banner" id="pp3d-banner"></div>
        <div class="pp3d-toast" id="pp3d-toast"></div>
    
        <!-- Touch controls -->
        <div class="pp3d-touch" id="pp3d-touch" hidden>
          <div class="pp3d-touch-left">
            <button type="button" class="pp3d-btn pp3d-touchbtn" data-pp3d-hold="left" aria-label="Steer left">◀</button>
            <button type="button" class="pp3d-btn pp3d-touchbtn" data-pp3d-hold="right" aria-label="Steer right">▶</button>
          </div>
          <div class="pp3d-touch-right">
            <div class="pp3d-touch-small">
              <button type="button" class="pp3d-btn pp3d-touchbtn pp3d-touchbtn-sm" data-pp3d-action="camera" aria-label="Camera">🎥</button>
              <button type="button" class="pp3d-btn pp3d-touchbtn pp3d-touchbtn-sm" data-pp3d-action="reset_car" aria-label="Reset car">⟲</button>
              <button type="button" class="pp3d-btn pp3d-touchbtn pp3d-touchbtn-sm pp3d-touchbtn-hb" data-pp3d-hold="handbrake" aria-label="Handbrake">P</button>
            </div>
            <div class="pp3d-touch-pedals">
              <button type="button" class="pp3d-btn pp3d-touchbtn pp3d-touchbtn-gas" data-pp3d-hold="accel" aria-label="Accelerate">▲</button>
              <button type="button" class="pp3d-btn pp3d-touchbtn pp3d-touchbtn-rev" data-pp3d-hold="reverse" aria-label="Reverse / brake">▼</button>
            </div>
          </div>
        </div>
    
        <!-- MAIN MENU -->
        <section class="pp3d-screen pp3d-screen-menu" data-pp3d-screen="menu">
          <div class="pp3d-card pp3d-menu-card">
            <div class="pp3d-logo">
              <span class="pp3d-logo-top">PRECISION</span>
              <span class="pp3d-logo-main">PARKING <i>3D</i></span>
            </div>
            <div class="pp3d-menu-stats">
              <span>🏆 Best total: <b id="pp3d-menu-best">0</b></span>
              <span>⭐ <b id="pp3d-menu-stars">0</b></span>
              <span id="pp3d-menu-player"></span>
            </div>
            <button type="button" class="pp3d-btn pp3d-btn-primary pp3d-btn-big" data-pp3d-action="play">▶ Play</button>
            <div class="pp3d-btn-grid">
              <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="open_levels">Levels</button>
              <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="open_vehicles">Vehicles</button>
              <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="daily">📅 Daily <small id="pp3d-menu-daily"></small></button>
              <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="open_settings">Settings</button>
            </div>
            <div class="pp3d-menu-toggles">
              <button type="button" class="pp3d-btn pp3d-chipbtn" data-pp3d-action="toggle_sound" id="pp3d-btn-sound">🔊 Sound</button>
              <button type="button" class="pp3d-btn pp3d-chipbtn" data-pp3d-action="toggle_music" id="pp3d-btn-music">🎵 Music</button>
            </div>
            <p class="pp3d-note">Progress is saved in this browser only.</p>
          </div>
        </section>
    
        <!-- LEVEL SELECT -->
        <section class="pp3d-screen" data-pp3d-screen="levels">
          <div class="pp3d-card pp3d-card-wide">
            <div class="pp3d-card-head">
              <h2 class="pp3d-h2">Select Level</h2>
              <button type="button" class="pp3d-btn pp3d-btn-secondary pp3d-btn-sm" data-pp3d-action="menu">← Back</button>
            </div>
            <div class="pp3d-level-grid" id="pp3d-level-grid"></div>
          </div>
        </section>
    
        <!-- VEHICLES -->
        <section class="pp3d-screen pp3d-screen-side" data-pp3d-screen="vehicles">
          <div class="pp3d-card pp3d-card-side">
            <div class="pp3d-card-head">
              <h2 class="pp3d-h2">Garage</h2>
              <button type="button" class="pp3d-btn pp3d-btn-secondary pp3d-btn-sm" data-pp3d-action="menu">← Back</button>
            </div>
            <div class="pp3d-veh-list" id="pp3d-veh-list"></div>
            <h3 class="pp3d-h3">Paint</h3>
            <div class="pp3d-swatches" id="pp3d-paint-swatches"></div>
            <h3 class="pp3d-h3">Rims</h3>
            <div class="pp3d-swatches" id="pp3d-rim-swatches"></div>
          </div>
        </section>
    
        <!-- SETTINGS -->
        <section class="pp3d-screen" data-pp3d-screen="settings">
          <div class="pp3d-card pp3d-card-wide">
            <div class="pp3d-card-head">
              <h2 class="pp3d-h2">Settings</h2>
              <button type="button" class="pp3d-btn pp3d-btn-secondary pp3d-btn-sm" data-pp3d-action="settings_back">← Back</button>
            </div>
            <div class="pp3d-form">
              <label class="pp3d-row"><span>Nickname</span><input type="text" class="pp3d-input" id="pp3d-set-nick" maxlength="16" autocomplete="off"></label>
              <div class="pp3d-row"><span>Sound effects</span><button type="button" class="pp3d-btn pp3d-chipbtn" data-pp3d-action="toggle_sound" id="pp3d-set-sound">On</button></div>
              <div class="pp3d-row"><span>Music</span><button type="button" class="pp3d-btn pp3d-chipbtn" data-pp3d-action="toggle_music" id="pp3d-set-music">On</button></div>
              <label class="pp3d-row"><span>Graphics quality</span>
                <select class="pp3d-input" id="pp3d-set-quality"><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option></select></label>
              <label class="pp3d-row"><span>Camera distance</span><input type="range" class="pp3d-range" id="pp3d-set-camdist" min="0.7" max="1.5" step="0.05"></label>
              <label class="pp3d-row"><span>Camera smoothing</span><input type="range" class="pp3d-range" id="pp3d-set-camsmooth" min="0.5" max="2" step="0.1"></label>
              <label class="pp3d-row"><span>Steering sensitivity</span><input type="range" class="pp3d-range" id="pp3d-set-steer" min="0.5" max="1.5" step="0.05"></label>
              <label class="pp3d-row"><span>Touch controls</span>
                <select class="pp3d-input" id="pp3d-set-touch"><option value="auto">Auto</option><option value="on">Always on</option><option value="off">Off</option></select></label>
              <div class="pp3d-row pp3d-row-wrap">
                <button type="button" class="pp3d-btn pp3d-btn-secondary pp3d-btn-sm" data-pp3d-action="export">Export progress</button>
                <button type="button" class="pp3d-btn pp3d-btn-secondary pp3d-btn-sm" data-pp3d-action="import">Import progress</button>
                <button type="button" class="pp3d-btn pp3d-btn-danger pp3d-btn-sm" data-pp3d-action="reset_data" id="pp3d-btn-reset">Reset progress</button>
              </div>
            </div>
          </div>
        </section>
    
        <!-- PAUSE -->
        <section class="pp3d-screen" data-pp3d-screen="pause">
          <div class="pp3d-card pp3d-card-narrow">
            <h2 class="pp3d-h2 pp3d-center">Paused</h2>
            <button type="button" class="pp3d-btn pp3d-btn-primary" data-pp3d-action="resume">Resume</button>
            <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="restart">Restart level</button>
            <div class="pp3d-menu-toggles">
              <button type="button" class="pp3d-btn pp3d-chipbtn" data-pp3d-action="toggle_sound" id="pp3d-pause-sound">🔊 Sound</button>
              <button type="button" class="pp3d-btn pp3d-chipbtn" data-pp3d-action="toggle_music" id="pp3d-pause-music">🎵 Music</button>
            </div>
            <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="menu">Main menu</button>
          </div>
        </section>
    
        <!-- LEVEL COMPLETE -->
        <section class="pp3d-screen" data-pp3d-screen="complete">
          <div class="pp3d-card pp3d-card-narrow">
            <h2 class="pp3d-h2 pp3d-center" id="pp3d-done-title">Level Completed!</h2>
            <div class="pp3d-stars" id="pp3d-done-stars"></div>
            <div class="pp3d-badge" id="pp3d-done-badge" hidden>New record!</div>
            <table class="pp3d-stats">
              <tr><td>Score</td><td><b id="pp3d-done-score">0</b></td><td class="pp3d-dim" id="pp3d-done-score-best"></td></tr>
              <tr><td>Time</td><td><b id="pp3d-done-time">0</b></td><td class="pp3d-dim" id="pp3d-done-time-best"></td></tr>
              <tr><td>Collisions</td><td><b id="pp3d-done-col">0</b></td><td></td></tr>
              <tr><td>Accuracy</td><td><b id="pp3d-done-acc">0%</b></td><td class="pp3d-dim" id="pp3d-done-acc-best"></td></tr>
            </table>
            <p class="pp3d-dim pp3d-center" id="pp3d-done-extra"></p>
            <button type="button" class="pp3d-btn pp3d-btn-primary" data-pp3d-action="next" id="pp3d-btn-next">Next level ▶</button>
            <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="restart">Replay</button>
            <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="menu">Main menu</button>
          </div>
        </section>
    
        <!-- FAILED -->
        <section class="pp3d-screen" data-pp3d-screen="failed">
          <div class="pp3d-card pp3d-card-narrow">
            <h2 class="pp3d-h2 pp3d-center" id="pp3d-fail-title">Level failed</h2>
            <p class="pp3d-center pp3d-dim" id="pp3d-fail-text"></p>
            <button type="button" class="pp3d-btn pp3d-btn-primary" data-pp3d-action="restart">Try again</button>
            <button type="button" class="pp3d-btn pp3d-btn-secondary" data-pp3d-action="menu">Main menu</button>
          </div>
        </section>
      </div>
    
      <!-- OPTIONAL AdSense (outside the game frame) -->
      <div class="pp3d-ad pp3d-ad-bottom" id="pp3d-ad-bottom" hidden></div>
    
      <input type="file" id="pp3d-import-file" accept="application/json,.json" hidden>
    </div>
    
    <script>
    /* ===== Precision Parking 3D — isolated game script (no build step, no backend) ===== */
(function () {
  "use strict";

  /* =====================================================================
   * CONFIG
   * ===================================================================== */
  const pp3d_config = {
    root_id: "precision-parking-game",
    three_url: "https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js",
    storage_key: "precision_parking_3d_v1",
    storage_version: 1,
    ads: {
      enabled: false,          // true = load AdSense display ads (outside the game frame)
      adsense_client: "",      // YOUR AdSense client id, e.g. "ca-pub-XXXXXXXXXXXXXXXX"
      slot_top: "",            // YOUR display ad slot id (top)
      slot_bottom: "",         // YOUR display ad slot id (bottom)
      h5_enabled: false,       // true ONLY if your account is approved for H5 Games Ads
      h5_test_mode: true       // adds data-adbreak-test="on" while testing
    }
  };

  const pp3d_scoring = {
    base_score: 1000,
    accuracy_weight: 6,
    time_bonus_per_sec: 8,
    collision_penalty: 150,
    min_score: 0,
    hold_time: 1.0,
    max_park_speed: 0.55,
    max_park_angle: 0.3,
    edge_tolerance: 0.08,
    collision_speed_threshold: 0.6,
    collision_cooldown: 0.7,
    stars: {
      three: { min_accuracy: 85, max_collisions: 0, max_time_frac: 0.6 },
      two: { min_accuracy: 65, max_collisions: 2, max_time_frac: 0.85 }
    },
    daily: { time_limit: 90, max_collisions: 5, points_multiplier: 1 }
  };

  const pp3d_vehicles = [
    { id: "hatch", name: "City Hatch", desc: "Agile and forgiving.", length: 3.7, width: 1.75, height: 1.45, wheelbase: 2.4,
      accel: 7.5, max_speed: 10, max_reverse: 4.2, brake: 15, steer_max: 0.66, steer_rate: 3.4,
      body_h: 0.55, cabin_h: 0.5, cabin_len: 0.55, cabin_z: -0.05, wheel_r: 0.3, unlock_levels: 0, def_paint: "#e63946" },
    { id: "sedan", name: "Sport Sedan", desc: "Fast, longer turning circle.", length: 4.5, width: 1.85, height: 1.4, wheelbase: 2.8,
      accel: 6.5, max_speed: 12.5, max_reverse: 4.6, brake: 14, steer_max: 0.54, steer_rate: 2.9,
      body_h: 0.5, cabin_h: 0.46, cabin_len: 0.48, cabin_z: -0.06, wheel_r: 0.32, unlock_levels: 4, def_paint: "#3a86ff" },
    { id: "van", name: "Delivery Van", desc: "Big, heavy, wide turns.", length: 5.2, width: 2.0, height: 2.2, wheelbase: 3.3,
      accel: 4.8, max_speed: 9.5, max_reverse: 3.8, brake: 12, steer_max: 0.5, steer_rate: 2.3,
      body_h: 0.8, cabin_h: 1.1, cabin_len: 0.8, cabin_z: -0.1, wheel_r: 0.38, unlock_levels: 8, def_paint: "#f4f4f4" }
  ];
  const pp3d_paints = ["#e63946", "#3a86ff", "#ffb703", "#2a9d8f", "#8338ec", "#f4f4f4", "#ff7a1a", "#222831"];
  const pp3d_rims = ["#d9dde3", "#ffcc33", "#2ee59d", "#ff4d6d"];

  /* =====================================================================
   * UTILS
   * ===================================================================== */
  const clamp = (v, a, b) => Math.max(a, Math.min(b, v));
  const wrap_angle = (a) => { while (a > Math.PI) a -= Math.PI * 2; while (a < -Math.PI) a += Math.PI * 2; return a; };
  const move_toward = (v, t, d) => (v < t ? Math.min(t, v + d) : Math.max(t, v - d));
  function local_to_world(tx, tz, rot, lx, lz) {
    const c = Math.cos(rot), s = Math.sin(rot);
    return { x: tx + lx * c + lz * s, z: tz - lx * s + lz * c };
  }
  function hash_string(s) {
    let h = 2166136261 >>> 0;
    for (let i = 0; i < s.length; i++) { h ^= s.charCodeAt(i); h = Math.imul(h, 16777619) >>> 0; }
    return h >>> 0;
  }
  function make_rng(seed) {
    let a = seed >>> 0;
    return function () {
      a = (a + 0x6D2B79F5) >>> 0;
      let t = a;
      t = Math.imul(t ^ (t >>> 15), t | 1);
      t ^= t + Math.imul(t ^ (t >>> 7), t | 61);
      return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
    };
  }
  function local_date_string(d) {
    d = d || new Date();
    const m = String(d.getMonth() + 1).padStart(2, "0"), day = String(d.getDate()).padStart(2, "0");
    return d.getFullYear() + "-" + m + "-" + day;
  }
  function date_diff_days(a, b) {
    const pa = a.split("-").map(Number), pb = b.split("-").map(Number);
    return Math.round((new Date(pb[0], pb[1] - 1, pb[2]) - new Date(pa[0], pa[1] - 1, pa[2])) / 86400000);
  }
  function format_time(sec) {
    sec = Math.max(0, sec);
    const m = Math.floor(sec / 60), s = Math.floor(sec % 60);
    return m + ":" + String(s).padStart(2, "0");
  }
  const get_vehicle = (id) => pp3d_vehicles.find((v) => v.id === id) || pp3d_vehicles[0];
  function pp3d_cockpit_layout(veh) {
    const floor = 0.18 + veh.body_h, cl = veh.length * veh.cabin_len, cz = veh.length * veh.cabin_z;
    const front = cz + cl / 2, eye_y = floor + veh.cabin_h * 0.75;
    const eye_z = Math.max(cz - cl / 2 + 0.3, front - 1.45);
    const wheel_z = eye_z + 0.62, wheel_y = eye_y - 0.22, dash_z0 = wheel_z + 0.1;
    const dash_d = Math.max(0.2, front - dash_z0), dash_h = Math.max(0.2, wheel_y - 0.12 - floor);
    return { x: veh.width * 0.2, eye_y, eye_z, wheel_y, wheel_z, floor, dash_h, dash_d, dash_z: dash_z0 + dash_d / 2, front };
  }
  const is_coarse_pointer = () => { try { return window.matchMedia("(pointer: coarse)").matches; } catch (e) { return false; } };

  /* =====================================================================
   * LEVEL DATA
   * ===================================================================== */
  const car_w = 1.85, car_l = 4.5;
  const ob_cone = (x, z) => ({ type: "cone", x, z, w: 0.55, l: 0.55, rot: 0, h: 0.7 });
  const ob_barrier = (x, z, w, rot) => ({ type: "barrier", x, z, w, l: 0.7, rot: rot || 0, h: 0.95, color: "#ff7a1a" });
  const ob_pillar = (x, z) => ({ type: "pillar", x, z, w: 1.1, l: 1.1, rot: 0, h: 3.4, color: "#a7afba" });
  const ob_wall = (x, z, w, l, rot) => ({ type: "wall", x, z, w, l, rot: rot || 0, h: 1.3, color: "#c9c2b4" });
  const ob_car = (x, z, rot, color) => ({ type: "car", x, z, w: car_w, l: car_l, rot: rot || 0, h: 1.5, color: color || "#3a86ff" });
  const bay_cars = (t, colors) => {
    const off = t.w / 2 + 0.15 + car_w / 2;
    return [-1, 1].map((sg, i) => { const p = local_to_world(t.x, t.z, t.rot, sg * off, 0); return ob_car(p.x, p.z, t.rot, colors[i % colors.length]); });
  };
  const para_cars = (t, colors) => {
    const off = t.l / 2 + 0.2 + car_l / 2;
    return [-1, 1].map((sg, i) => { const p = local_to_world(t.x, t.z, t.rot, 0, sg * off); return ob_car(p.x, p.z, t.rot, colors[i % colors.length]); });
  };
  const PI = Math.PI;

  const level_t3 = { x: 0, z: 14, rot: 0, w: 3.2, l: 6.4 };
  const level_t4 = { x: 18, z: 2, rot: PI / 2, w: 3.1, l: 6.4 };
  const level_t5 = { x: 8, z: 6, rot: PI, w: 3.2, l: 6.4 };
  const level_t6 = { x: -12, z: 10, rot: 0, w: 2.7, l: 6.0 };
  const level_t7 = { x: 14, z: 8, rot: PI / 2, w: 3.0, l: 6.2 };
  const level_t8 = { x: -12, z: 8, rot: PI, w: 2.9, l: 6.2 };
  const level_t9 = { x: 6, z: -8, rot: PI / 2, w: 2.6, l: 6.4 };
  const level_t10 = { x: -8, z: 14, rot: 0, w: 2.9, l: 6.4 };
  const level_t11 = { x: -14, z: -8, rot: PI / 2, w: 2.9, l: 6.4 };
  const level_t12 = { x: 6, z: 6, rot: PI / 4, w: 2.7, l: 6.0 };

  const pp3d_levels = [
    { id: 1, name: "First Wheels", hint: "Hold W / ↑ to drive, S / ↓ to brake. Stop inside the glowing bay.", vehicle: null, arena: 28,
      start: { x: 0, z: -20, rot: 0 }, target: { x: 0, z: 9, rot: 0, w: 4.2, l: 7 },
      obstacles: [ob_cone(-6, -4), ob_cone(6, -4), ob_cone(-6, 0), ob_cone(6, 0)],
      time_limit: 90, max_collisions: 10, difficulty: 1, strict_dir: false },
    { id: 2, name: "Gentle Turns", hint: "Steer around the barriers, then straighten up in the bay.", vehicle: null, arena: 28,
      start: { x: -16, z: -20, rot: 0 }, target: { x: 12, z: 8, rot: 0, w: 3.8, l: 6.8 },
      obstacles: [ob_barrier(-6, -8, 10, 0), ob_barrier(4, 0, 8, 0), ob_cone(10, 1), ob_cone(14, 1)],
      time_limit: 90, max_collisions: 8, difficulty: 1, strict_dir: false },
    { id: 3, name: "Between Two Cars", hint: "Line up first, then drive straight into the bay.", vehicle: null, arena: 28,
      start: { x: 0, z: -20, rot: 0 }, target: level_t3,
      obstacles: [...bay_cars(level_t3, ["#3a86ff", "#ffb703"]), ob_wall(0, 17.7, 14, 0.8), ob_cone(-8, -6), ob_cone(8, -6)],
      time_limit: 80, max_collisions: 6, difficulty: 2, strict_dir: false },
    { id: 4, name: "Right Angle", hint: "Swing wide, then turn into the side bay.", vehicle: null, arena: 28,
      start: { x: -16, z: -18, rot: 0 }, target: level_t4,
      obstacles: [...bay_cars(level_t4, ["#2a9d8f", "#e63946"]), ob_wall(21.7, 2, 0.8, 13), ob_pillar(6, -8), ob_pillar(6, 12), ob_cone(10, -2), ob_cone(10, 6)],
      time_limit: 80, max_collisions: 6, difficulty: 2, strict_dir: false },
    { id: 5, name: "Reverse Intro", hint: "Back into the bay so the nose points out (S / ↓ to reverse).", vehicle: null, arena: 28,
      start: { x: -10, z: -20, rot: 0 }, target: level_t5, strict_dir: true,
      obstacles: [...bay_cars(level_t5, ["#8338ec", "#f4f4f4"]), ob_wall(8, 9.7, 14, 0.8), ob_barrier(-2, -6, 8, 0)],
      time_limit: 100, max_collisions: 6, difficulty: 2 },
    { id: 6, name: "Tight Squeeze", hint: "Narrow bay. Go slow and keep it centered.", vehicle: null, arena: 28,
      start: { x: 14, z: -20, rot: 0 }, target: level_t6,
      obstacles: [...bay_cars(level_t6, ["#ffb703", "#3a86ff"]), ob_wall(-12, 13.5, 12, 0.8), ob_barrier(4, -10, 10, 0), ob_barrier(-4, 0, 8, 0), ob_cone(6, 6)],
      time_limit: 90, max_collisions: 5, difficulty: 3, strict_dir: false },
    { id: 7, name: "Pillar Garage", hint: "Weave through the pillars to the far bay.", vehicle: null, arena: 28,
      start: { x: 0, z: -22, rot: 0 }, target: level_t7,
      obstacles: [...bay_cars(level_t7, ["#e63946", "#2a9d8f"]), ob_wall(17.6, 8, 0.8, 12),
        ob_pillar(-12, -10), ob_pillar(-4, -10), ob_pillar(4, -10), ob_pillar(12, -10), ob_pillar(-8, 2), ob_pillar(0, 2), ob_pillar(8, 2)],
      time_limit: 90, max_collisions: 5, difficulty: 3, strict_dir: false },
    { id: 8, name: "Back It Up", hint: "Reverse into the narrow bay, nose pointing out.", vehicle: null, arena: 28,
      start: { x: 14, z: -20, rot: 0 }, target: level_t8, strict_dir: true,
      obstacles: [...bay_cars(level_t8, ["#ffb703", "#8338ec"]), ob_wall(-12, 11.6, 12, 0.8), ob_barrier(0, -6, 12, 0), ob_cone(-4, -16), ob_cone(-4, -12)],
      time_limit: 100, max_collisions: 4, difficulty: 3 },
    { id: 9, name: "Parallel Park", hint: "Drive past the gap, then reverse in alongside the curb.", vehicle: null, arena: 28,
      start: { x: -20, z: 0, rot: PI / 2 }, target: level_t9,
      obstacles: [...para_cars(level_t9, ["#3a86ff", "#e63946"]), ob_wall(6, -9.8, 28, 0.8, 0), ob_cone(-6, 3), ob_cone(-6, 8), ob_pillar(14, 10)],
      time_limit: 100, max_collisions: 4, difficulty: 4, strict_dir: false },
    { id: 10, name: "Van Challenge", hint: "You drive the delivery van. Plan your turns early.", vehicle: "van", arena: 28,
      start: { x: 14, z: -22, rot: 0 }, target: level_t10,
      obstacles: [...bay_cars(level_t10, ["#2a9d8f", "#ffb703"]), ob_wall(-8, 17.7, 12, 0.8), ob_barrier(4, -12, 12, 0), ob_barrier(-6, -2, 12, 0), ob_pillar(8, 8)],
      time_limit: 110, max_collisions: 5, difficulty: 4, strict_dir: false },
    { id: 11, name: "Reverse Maze", hint: "Sport sedan. Pull past, turn around, reverse into the bay.", vehicle: "sedan", arena: 28,
      start: { x: 18, z: 18, rot: PI }, target: level_t11, strict_dir: true,
      obstacles: [...bay_cars(level_t11, ["#f4f4f4", "#e63946"]), ob_wall(-17.7, -8, 0.8, 12), ob_barrier(8, 6, 14, PI / 2), ob_pillar(-2, -14), ob_pillar(-2, 0), ob_cone(4, -4), ob_cone(4, -12)],
      time_limit: 110, max_collisions: 4, difficulty: 4 },
    { id: 12, name: "Master Class", hint: "Diagonal bay, tight space, almost no mistakes allowed.", vehicle: null, arena: 28,
      start: { x: -20, z: -20, rot: PI / 4 }, target: level_t12,
      obstacles: [...bay_cars(level_t12, ["#8338ec", "#3a86ff"]), ob_pillar(-8, -4), ob_pillar(0, -12), ob_pillar(12, -6), ob_barrier(-10, 6, 10, PI / 2),
        ob_car(-6, 16, PI / 2, "#ffb703"), ob_car(18, -4, 0, "#2a9d8f"), ob_cone(2, 12), ob_cone(10, 14)],
      time_limit: 100, max_collisions: 3, difficulty: 5, strict_dir: false,
      stars: { three: { min_accuracy: 88, max_collisions: 0, max_time_frac: 0.6 }, two: { min_accuracy: 70, max_collisions: 1, max_time_frac: 0.85 } } }
  ];

  function point_segment_dist(px, pz, ax, az, bx, bz) {
    const dx = bx - ax, dz = bz - az, l2 = dx * dx + dz * dz || 1;
    const t = clamp(((px - ax) * dx + (pz - az) * dz) / l2, 0, 1);
    return Math.hypot(px - (ax + dx * t), pz - (az + dz * t));
  }

  function build_daily_level(date_str) {
    const seed = hash_string("pp3d-daily-" + date_str);
    const rng = make_rng(seed);
    const veh_id = ["hatch", "sedan", "van"][Math.floor(rng() * 3)];
    const rots = [0, PI / 2, PI, -PI / 2, PI / 4, -PI / 4, (3 * PI) / 4];
    const t = { x: (rng() * 2 - 1) * 14, z: -8 + rng() * 22, rot: rots[Math.floor(rng() * rots.length)], w: 2.8 + rng() * 0.5, l: 6.3 };
    const start = { x: clamp(-t.x, -14, 14), z: t.z > 0 ? -21 : 21, rot: t.z > 0 ? 0 : PI };
    const obstacles = [];
    if (rng() < 0.7) bay_cars(t, ["#3a86ff", "#ffb703", "#e63946", "#2a9d8f"].sort(() => rng() - 0.5)).forEach((o) => obstacles.push(o));
    const count = 5 + Math.floor(rng() * 4);
    let tries = 0;
    while (obstacles.length < count + 2 && tries < 200) {
      tries++;
      const x = (rng() * 2 - 1) * 22, z = (rng() * 2 - 1) * 22;
      if (Math.hypot(x - start.x, z - start.z) < 8) continue;
      if (Math.hypot(x - t.x, z - t.z) < 10) continue;
      if (point_segment_dist(x, z, start.x, start.z, t.x, t.z) < 3.4) continue;
      if (obstacles.some((o) => Math.hypot(o.x - x, o.z - z) < 4.5)) continue;
      const k = rng();
      if (k < 0.45) obstacles.push(ob_cone(x, z));
      else if (k < 0.7) obstacles.push(ob_barrier(x, z, 5 + rng() * 5, rng() * PI));
      else if (k < 0.85) obstacles.push(ob_pillar(x, z));
      else obstacles.push(ob_car(x, z, rng() * PI, ["#3a86ff", "#ffb703", "#e63946", "#8338ec"][Math.floor(rng() * 4)]));
    }
    return {
      id: "daily_" + date_str, daily: true, seed, name: "Daily Challenge", hint: "Same challenge for everyone today. " + get_vehicle(veh_id).name + " only.",
      vehicle: veh_id, arena: 28, start, target: t, obstacles, strict_dir: false,
      time_limit: pp3d_scoring.daily.time_limit, max_collisions: pp3d_scoring.daily.max_collisions, difficulty: 3
    };
  }

  class Pp3dLevelManager {
    constructor() { this.levels = pp3d_levels; }
    get(id) { return this.levels.find((l) => l.id === id) || null; }
    count() { return this.levels.length; }
    daily(date_str) { return build_daily_level(date_str); }
  }

  /* =====================================================================
   * LOCAL STORAGE MANAGER
   * ===================================================================== */
  class Pp3dStorage {
    constructor(key, version) { this.key = key; this.version = version; this.data = null; this.memory = null; }
    default_data() {
      return {
        version: this.version,
        player: { nickname: "Player", first_play_date: null, last_play_date: null, total_completed_levels: 0, total_play_sessions: 0 },
        progress: { unlocked_levels: [1], completed_levels: [], levels: {} },
        vehicles: { selected: "hatch", unlocked: ["hatch"], selected_paint: pp3d_vehicles[0].def_paint, customization: { rim_color: pp3d_rims[0] } },
        settings: { sound: true, music: true, quality: is_coarse_pointer() ? "low" : "medium", camera_mode: 0, camera_distance: 1, camera_smoothing: 1,
          controls: { steer_sensitivity: 1, touch_controls: "auto" } },
        daily: { last_challenge_date: null, challenge_seed: 0, completed: false, today_score: 0, best_score: 0, streak: 0, best_streak: 0, last_completed_date: null }
      };
    }
    read_raw() { try { return window.localStorage.getItem(this.key); } catch (e) { return this.memory; } }
    write_raw(s) { try { window.localStorage.setItem(this.key, s); } catch (e) { this.memory = s; } }
    migrate(d) {
      if (!d || typeof d !== "object") return null;
      let v = Number(d.version) || 0;
      if (v < 1) { d.version = 1; v = 1; }
      /* future: if (v < 2) { ...transform...; d.version = 2; } */
      return d;
    }
    sanitize(raw) {
      const d = this.default_data();
      if (!raw || typeof raw !== "object") return d;
      const num = (v, def, mn, mx) => { v = Number(v); return Number.isFinite(v) ? clamp(v, mn, mx) : def; };
      const str_or = (v, def) => (typeof v === "string" ? v : def);
      const ints = (a) => (Array.isArray(a) ? a.map(Number).filter((n) => Number.isInteger(n) && n >= 1 && n <= 9999) : []);
      const hex = (v, def) => (typeof v === "string" && /^#[0-9a-f]{6}$/i.test(v) ? v : def);
      const p = raw.player || {};
      d.player.nickname = typeof p.nickname === "string" && p.nickname.trim() ? p.nickname.trim().slice(0, 16) : d.player.nickname;
      d.player.first_play_date = str_or(p.first_play_date, null);
      d.player.last_play_date = str_or(p.last_play_date, null);
      d.player.total_completed_levels = num(p.total_completed_levels, 0, 0, 99999);
      d.player.total_play_sessions = num(p.total_play_sessions, 0, 0, 999999);
      const pr = raw.progress || {};
      d.progress.unlocked_levels = Array.from(new Set([1].concat(ints(pr.unlocked_levels))));
      d.progress.completed_levels = Array.from(new Set(ints(pr.completed_levels)));
      if (pr.levels && typeof pr.levels === "object") {
        Object.keys(pr.levels).forEach((k) => {
          if (!/^\d+$/.test(k)) return;
          const l = pr.levels[k] || {};
          d.progress.levels[k] = { stars: Math.round(num(l.stars, 0, 0, 3)), best_score: Math.round(num(l.best_score, 0, 0, 1e7)),
            best_time: l.best_time == null ? null : num(l.best_time, null, 0, 1e5), best_accuracy: Math.round(num(l.best_accuracy, 0, 0, 100)),
            attempts: Math.round(num(l.attempts, 0, 0, 1e6)) };
        });
      }
      const v = raw.vehicles || {}, ids = pp3d_vehicles.map((x) => x.id);
      d.vehicles.unlocked = Array.from(new Set(["hatch"].concat(Array.isArray(v.unlocked) ? v.unlocked.filter((x) => ids.indexOf(x) >= 0) : [])));
      d.vehicles.selected = ids.indexOf(v.selected) >= 0 && d.vehicles.unlocked.indexOf(v.selected) >= 0 ? v.selected : "hatch";
      d.vehicles.selected_paint = hex(v.selected_paint, d.vehicles.selected_paint);
      d.vehicles.customization.rim_color = hex(v.customization && v.customization.rim_color, d.vehicles.customization.rim_color);
      const s = raw.settings || {};
      d.settings.sound = typeof s.sound === "boolean" ? s.sound : d.settings.sound;
      d.settings.music = typeof s.music === "boolean" ? s.music : d.settings.music;
      d.settings.quality = ["low", "medium", "high"].indexOf(s.quality) >= 0 ? s.quality : d.settings.quality;
      d.settings.camera_mode = Math.round(num(s.camera_mode, 0, 0, 3));
      d.settings.camera_distance = num(s.camera_distance, 1, 0.7, 1.5);
      d.settings.camera_smoothing = num(s.camera_smoothing, 1, 0.5, 2);
      const c = s.controls || {};
      d.settings.controls.steer_sensitivity = num(c.steer_sensitivity, 1, 0.5, 1.5);
      d.settings.controls.touch_controls = ["auto", "on", "off"].indexOf(c.touch_controls) >= 0 ? c.touch_controls : "auto";
      const dl = raw.daily || {};
      d.daily.last_challenge_date = str_or(dl.last_challenge_date, null);
      d.daily.challenge_seed = num(dl.challenge_seed, 0, 0, 4294967296);
      d.daily.completed = !!dl.completed;
      d.daily.today_score = Math.round(num(dl.today_score, 0, 0, 1e7));
      d.daily.best_score = Math.round(num(dl.best_score, 0, 0, 1e7));
      d.daily.streak = Math.round(num(dl.streak, 0, 0, 99999));
      d.daily.best_streak = Math.round(num(dl.best_streak, 0, 0, 99999));
      d.daily.last_completed_date = str_or(dl.last_completed_date, null);
      d.version = this.version;
      return d;
    }
    load_game_data() {
      let parsed = null;
      try { const raw = this.read_raw(); parsed = raw ? JSON.parse(raw) : null; } catch (e) { parsed = null; }
      this.data = this.sanitize(this.migrate(parsed));
      return this.data;
    }
    save_game_data() { try { this.write_raw(JSON.stringify(this.data)); } catch (e) { /* ignore */ } }
    reset_game_data() { this.data = this.default_data(); this.save_game_data(); return this.data; }
    touch_session() {
      const t = local_date_string(), p = this.data.player;
      if (!p.first_play_date) p.first_play_date = t;
      p.last_play_date = t; p.total_play_sessions += 1; this.save_game_data();
    }
    get_settings() { return this.data.settings; }
    save_settings(partial) {
      const s = this.data.settings;
      Object.keys(partial).forEach((k) => {
        if (k === "controls") Object.assign(s.controls, partial.controls); else s[k] = partial[k];
      });
      this.data = this.sanitize(this.data); this.save_game_data();
    }
    get_level_progress(id) {
      return this.data.progress.levels[String(id)] || { stars: 0, best_score: 0, best_time: null, best_accuracy: 0, attempts: 0 };
    }
    save_level_progress(id, res) {
      const prev = this.get_level_progress(id), cur = Object.assign({}, prev);
      const info = { first_time: this.data.progress.completed_levels.indexOf(id) < 0, new_best_score: false, new_best_time: false, new_best_accuracy: false, prev };
      cur.attempts = prev.attempts + 1;
      if (res.score > prev.best_score) { cur.best_score = res.score; info.new_best_score = true; }
      if (prev.best_time == null || res.time < prev.best_time) { cur.best_time = res.time; info.new_best_time = true; }
      if (res.accuracy > prev.best_accuracy) { cur.best_accuracy = res.accuracy; info.new_best_accuracy = true; }
      cur.stars = Math.max(prev.stars, res.stars);
      this.data.progress.levels[String(id)] = cur;
      if (info.first_time) this.data.progress.completed_levels.push(id);
      const next = id + 1;
      if (next <= pp3d_levels.length && this.data.progress.unlocked_levels.indexOf(next) < 0) this.data.progress.unlocked_levels.push(next);
      this.data.player.total_completed_levels = this.data.progress.completed_levels.length;
      this.save_game_data();
      return info;
    }
    mark_attempt(id) {
      const p = this.get_level_progress(id); p.attempts += 1; this.data.progress.levels[String(id)] = p; this.save_game_data();
    }
    save_vehicle(partial) {
      Object.keys(partial).forEach((k) => {
        if (k === "customization") Object.assign(this.data.vehicles.customization, partial.customization); else this.data.vehicles[k] = partial[k];
      });
      this.data = this.sanitize(this.data); this.save_game_data();
    }
    save_nickname(n) { this.data.player.nickname = (n || "").trim().slice(0, 16) || "Player"; this.save_game_data(); }
    get_daily_state(today) {
      const d = this.data.daily, done = d.last_challenge_date === today && d.completed;
      let streak = 0;
      if (d.last_completed_date) { const gap = date_diff_days(d.last_completed_date, today); if (gap === 0 || gap === 1) streak = d.streak; }
      return { completed: done, today_score: done ? d.today_score : 0, best_score: d.best_score, streak, best_streak: d.best_streak };
    }
    save_daily_result(today, seed, score) {
      const d = this.data.daily;
      if (d.last_challenge_date !== today) { d.last_challenge_date = today; d.completed = false; d.today_score = 0; }
      d.challenge_seed = seed;
      const first = !d.completed;
      d.completed = true; d.today_score = Math.max(d.today_score, score); d.best_score = Math.max(d.best_score, score);
      if (first) {
        const gap = d.last_completed_date ? date_diff_days(d.last_completed_date, today) : 99;
        d.streak = gap === 1 ? d.streak + 1 : 1;
        d.best_streak = Math.max(d.best_streak, d.streak);
        d.last_completed_date = today;
      }
      this.save_game_data();
      return { first, streak: d.streak, today_score: d.today_score, best_score: d.best_score };
    }
    total_stars() { return Object.keys(this.data.progress.levels).reduce((a, k) => a + this.data.progress.levels[k].stars, 0); }
    total_best() { return Object.keys(this.data.progress.levels).reduce((a, k) => a + this.data.progress.levels[k].best_score, 0); }
    export_json() { return JSON.stringify({ app: "precision_parking_3d", version: this.version, exported_at: new Date().toISOString(), data: this.data }, null, 2); }
    import_json(text) {
      try {
        const parsed = JSON.parse(text);
        const src = parsed && parsed.data && typeof parsed.data === "object" ? parsed.data : parsed;
        const migrated = this.migrate(src);
        if (!migrated || typeof migrated !== "object" || !migrated.progress) return false;
        this.data = this.sanitize(migrated); this.save_game_data(); return true;
      } catch (e) { return false; }
    }
  }

  /* =====================================================================
   * SCORE MANAGER
   * ===================================================================== */
  class Pp3dScore {
    compute(level, stats) {
      const c = pp3d_scoring, remaining = Math.max(0, level.time_limit - stats.time);
      let score = c.base_score + stats.accuracy * c.accuracy_weight + remaining * c.time_bonus_per_sec - stats.collisions * c.collision_penalty;
      if (level.daily) score *= c.daily.points_multiplier;
      score = Math.max(c.min_score, Math.round(score));
      const st = level.stars || {};
      const t3 = Object.assign({}, c.stars.three, st.three), t2 = Object.assign({}, c.stars.two, st.two);
      const frac = stats.time / level.time_limit;
      let stars = 1;
      if (stats.accuracy >= t2.min_accuracy && stats.collisions <= t2.max_collisions && frac <= t2.max_time_frac) stars = 2;
      if (stats.accuracy >= t3.min_accuracy && stats.collisions <= t3.max_collisions && frac <= t3.max_time_frac) stars = 3;
      return { score, stars };
    }
  }

  /* =====================================================================
   * PHYSICS (custom OBB collision — deterministic, no WASM dependency)
   * ===================================================================== */
  function make_obb(x, z, w, l, rot, h, type) {
    return { x, z, hw: w / 2, hl: l / 2, rot, c: Math.cos(rot), s: Math.sin(rot), h: h || 1, type: type || "box", r: Math.hypot(w, l) / 2 };
  }
  const axes_buf = new Float64Array(8);
  function obb_test(a, b) {
    const dx = a.x - b.x, dz = a.z - b.z, rr = a.r + b.r;
    if (dx * dx + dz * dz > rr * rr) return null;
    axes_buf[0] = a.c; axes_buf[1] = -a.s; axes_buf[2] = a.s; axes_buf[3] = a.c;
    axes_buf[4] = b.c; axes_buf[5] = -b.s; axes_buf[6] = b.s; axes_buf[7] = b.c;
    let min_o = Infinity, nx = 0, nz = 0;
    for (let i = 0; i < 4; i++) {
      const ax = axes_buf[i * 2], az = axes_buf[i * 2 + 1];
      const ra = a.hw * Math.abs(ax * a.c - az * a.s) + a.hl * Math.abs(ax * a.s + az * a.c);
      const rb = b.hw * Math.abs(ax * b.c - az * b.s) + b.hl * Math.abs(ax * b.s + az * b.c);
      const d = dx * ax + dz * az, o = ra + rb - Math.abs(d);
      if (o <= 0) return null;
      if (o < min_o) { min_o = o; const sg = d >= 0 ? 1 : -1; nx = ax * sg; nz = az * sg; }
    }
    return { depth: min_o, nx, nz };
  }

  class Pp3dPhysics {
    constructor() { this.obstacles = []; this.car_box = make_obb(0, 0, 1, 1, 0, 1, "car"); this.cooldown = 0; }
    set_level(level) {
      const a = level.arena || 28, t = 1.2;
      this.obstacles = [
        make_obb(0, a + t / 2, 2 * (a + t), t, 0, 0.9, "wall"), make_obb(0, -a - t / 2, 2 * (a + t), t, 0, 0.9, "wall"),
        make_obb(a + t / 2, 0, t, 2 * a, 0, 0.9, "wall"), make_obb(-a - t / 2, 0, t, 2 * a, 0, 0.9, "wall")
      ];
      level.obstacles.forEach((o) => this.obstacles.push(make_obb(o.x, o.z, o.w, o.l, o.rot, o.h, o.type)));
    }
    step(car, veh, dt) {
      this.cooldown = Math.max(0, this.cooldown - dt);
      const cb = this.car_box;
      cb.hw = (veh.width * 0.96) / 2; cb.hl = (veh.length * 0.96) / 2; cb.r = Math.hypot(cb.hw, cb.hl);
      let impact = 0, hit = false;
      for (let it = 0; it < 3; it++) {
        cb.x = car.x; cb.z = car.z; cb.rot = car.heading; cb.c = Math.cos(car.heading); cb.s = Math.sin(car.heading);
        let any = false;
        for (let i = 0; i < this.obstacles.length; i++) {
          const o = this.obstacles[i], r = obb_test(cb, o);
          if (!r) continue;
          any = true;
          car.x += r.nx * r.depth; car.z += r.nz * r.depth;
          cb.x = car.x; cb.z = car.z;
          const vn = car.speed * (Math.sin(car.heading) * r.nx + Math.cos(car.heading) * r.nz);
          if (vn < 0) {
            const into = -vn;
            if (into > impact) impact = into;
            car.speed = into > 1.5 ? -car.speed * 0.2 : car.speed * 0.35;
          }
        }
        if (!any) break;
      }
      if (impact >= pp3d_scoring.collision_speed_threshold && this.cooldown <= 0) { hit = true; this.cooldown = pp3d_scoring.collision_cooldown; }
      return { hit, impact };
    }
  }

  /* =====================================================================
   * VEHICLE CONTROLLER (arcade bicycle model)
   * ===================================================================== */
  class Pp3dVehicle {
    constructor() { this.car = { x: 0, z: 0, heading: 0, speed: 0, steer: 0, steer_angle: 0, accel: 0 }; }
    reset(start) {
      const c = this.car; c.x = start.x; c.z = start.z; c.heading = start.rot; c.speed = 0; c.steer = 0; c.steer_angle = 0; c.accel = 0;
    }
    update(dt, ctl, veh, sens) {
      const car = this.car, prev = car.speed;
      const target = (ctl.left ? 1 : 0) - (ctl.right ? 1 : 0);
      const rate = veh.steer_rate * sens * (target === 0 ? 1.6 : 1);
      car.steer = move_toward(car.steer, target, rate * dt);
      let sp = car.speed;
      const both = ctl.accel && ctl.reverse;
      if (ctl.accel && !both) {
        if (sp < -0.2) sp += veh.brake * dt; else sp += veh.accel * dt * Math.max(0.15, 1 - Math.max(0, sp) / veh.max_speed);
      } else if (ctl.reverse && !both) {
        if (sp > 0.25) sp -= veh.brake * dt; else sp -= veh.accel * 0.7 * dt * Math.max(0.2, 1 - Math.max(0, -sp) / veh.max_reverse);
      } else if (both) {
        sp -= Math.sign(sp) * Math.min(Math.abs(sp), veh.brake * dt);
      } else {
        sp -= Math.sign(sp) * Math.min(Math.abs(sp), 2.8 * dt);
      }
      if (ctl.handbrake) sp -= Math.sign(sp) * Math.min(Math.abs(sp), 20 * dt);
      sp *= 1 - 0.04 * dt;
      sp = clamp(sp, -veh.max_reverse, veh.max_speed);
      if (!ctl.accel && !ctl.reverse && Math.abs(sp) < 0.05) sp = 0;
      car.speed = sp;
      const lock = veh.steer_max * (1 - 0.55 * Math.min(1, Math.abs(sp) / veh.max_speed));
      car.steer_angle = car.steer * lock;
      let omega = (sp / veh.wheelbase) * Math.tan(car.steer_angle);
      if (ctl.handbrake && Math.abs(sp) > 3) omega *= 1.35;
      car.heading = wrap_angle(car.heading + omega * dt);
      car.x += Math.sin(car.heading) * sp * dt;
      car.z += Math.cos(car.heading) * sp * dt;
      car.accel = (sp - prev) / Math.max(dt, 1e-4);
    }
  }

  /* =====================================================================
   * PARKING DETECTOR
   * ===================================================================== */
  class Pp3dParking {
    constructor() { this.hold = 0; this.out = { accuracy: 0, inside: false, aligned: false, slow: false, ready: false, complete: false, hold_progress: 0 }; }
    reset() { this.hold = 0; }
    evaluate(car, veh, level, dt) {
      const cfg = pp3d_scoring, t = level.target, o = this.out;
      const dxw = car.x - t.x, dzw = car.z - t.z, c = Math.cos(t.rot), s = Math.sin(t.rot);
      const lx = dxw * c - dzw * s, lz = dxw * s + dzw * c;
      const aa = Math.abs(wrap_angle(car.heading - t.rot));
      const ang_err = level.strict_dir ? aa : Math.min(aa, Math.PI - aa);
      const hw = veh.width / 2, hl = veh.length / 2, ch = Math.cos(car.heading), sh = Math.sin(car.heading), tol = cfg.edge_tolerance;
      let inside = true;
      for (let i = 0; i < 4; i++) {
        const cx = i & 1 ? hw : -hw, cz = i & 2 ? hl : -hl;
        const ex = car.x + cx * ch + cz * sh - t.x, ez = car.z - cx * sh + cz * ch - t.z;
        if (Math.abs(ex * c - ez * s) > t.w / 2 + tol || Math.abs(ex * s + ez * c) > t.l / 2 + tol) { inside = false; break; }
      }
      let accuracy = 0;
      if (Math.abs(lx) < t.w / 2 && Math.abs(lz) < t.l / 2) {
        const pos_score = Math.max(0, 1 - Math.hypot(lx, lz * 0.6) / (t.w / 2 + 0.6));
        const ang_score = 1 - Math.min(1, ang_err / 0.4);
        accuracy = Math.round(100 * (0.65 * pos_score + 0.35 * ang_score));
      }
      o.inside = inside; o.aligned = ang_err <= cfg.max_park_angle; o.slow = Math.abs(car.speed) <= cfg.max_park_speed;
      o.accuracy = accuracy; o.ready = inside && o.aligned && o.slow;
      this.hold = o.ready ? this.hold + dt : 0;
      o.hold_progress = clamp(this.hold / cfg.hold_time, 0, 1); o.complete = this.hold >= cfg.hold_time;
      return o;
    }
  }

  /* =====================================================================
   * AUDIO MANAGER (procedural WebAudio, starts after a user gesture)
   * ===================================================================== */
  class Pp3dAudio {
    constructor(get_settings) { this.get_settings = get_settings; this.ctx = null; this.engine = null; this.music_timer = null; this.noise = null; }
    unlock() {
      if (!this.ctx) {
        const AC = window.AudioContext || window.webkitAudioContext;
        if (!AC) return;
        try { this.ctx = new AC(); } catch (e) { return; }
        this.master = this.ctx.createGain(); this.master.connect(this.ctx.destination);
        this.sfx = this.ctx.createGain(); this.sfx.connect(this.master);
        this.music = this.ctx.createGain(); this.music.connect(this.master);
        const len = this.ctx.sampleRate, buf = this.ctx.createBuffer(1, len, this.ctx.sampleRate), d = buf.getChannelData(0);
        for (let i = 0; i < len; i++) d[i] = Math.random() * 2 - 1;
        this.noise = buf;
      }
      if (this.ctx.state === "suspended") this.ctx.resume();
      this.apply_settings();
    }
    apply_settings() {
      if (!this.ctx) return;
      const s = this.get_settings();
      this.sfx.gain.value = s.sound ? 0.9 : 0; this.music.gain.value = s.music ? 0.45 : 0;
      if (s.music) this.start_music(); else this.stop_music();
      if (!s.sound && this.engine) this.stop_engine();
    }
    suspend() { if (this.ctx && this.ctx.state === "running") this.ctx.suspend(); this.stop_music_timer_only(); }
    resume() { if (this.ctx) { this.ctx.resume(); this.apply_settings(); } }
    tone(freq, time, dur, type, vol, dest) {
      const c = this.ctx, o = c.createOscillator(), g = c.createGain();
      o.type = type; o.frequency.setValueAtTime(freq, time);
      g.gain.setValueAtTime(0.0001, time); g.gain.exponentialRampToValueAtTime(vol, time + 0.01); g.gain.exponentialRampToValueAtTime(0.0001, time + dur);
      o.connect(g); g.connect(dest); o.start(time); o.stop(time + dur + 0.05);
    }
    mtof(m) { return 440 * Math.pow(2, (m - 69) / 12); }
    play_click() { if (!this.ctx || !this.get_settings().sound) return; const t = this.ctx.currentTime; this.tone(660, t, 0.08, "square", 0.08, this.sfx); this.tone(880, t + 0.05, 0.08, "square", 0.06, this.sfx); }
    play_success() { if (!this.ctx || !this.get_settings().sound) return; const t = this.ctx.currentTime; [72, 76, 79, 84].forEach((m, i) => this.tone(this.mtof(m), t + i * 0.12, 0.35, "triangle", 0.2, this.sfx)); }
    play_fail() { if (!this.ctx || !this.get_settings().sound) return; const t = this.ctx.currentTime; [67, 63, 60, 55].forEach((m, i) => this.tone(this.mtof(m), t + i * 0.16, 0.3, "sawtooth", 0.1, this.sfx)); }
    play_collision(intensity) {
      if (!this.ctx || !this.get_settings().sound) return;
      const c = this.ctx, t = c.currentTime, v = clamp(intensity / 6, 0.15, 1);
      const n = c.createBufferSource(); n.buffer = this.noise;
      const lp = c.createBiquadFilter(); lp.type = "lowpass"; lp.frequency.value = 900;
      const g = c.createGain(); g.gain.setValueAtTime(0.5 * v, t); g.gain.exponentialRampToValueAtTime(0.001, t + 0.25);
      n.connect(lp); lp.connect(g); g.connect(this.sfx); n.start(t); n.stop(t + 0.3);
      const o = c.createOscillator(), og = c.createGain(); o.type = "sine"; o.frequency.setValueAtTime(140, t); o.frequency.exponentialRampToValueAtTime(40, t + 0.25);
      og.gain.setValueAtTime(0.6 * v, t); og.gain.exponentialRampToValueAtTime(0.001, t + 0.28); o.connect(og); og.connect(this.sfx); o.start(t); o.stop(t + 0.3);
    }
    start_engine() {
      if (!this.ctx || this.engine || !this.get_settings().sound) return;
      const c = this.ctx, o1 = c.createOscillator(), o2 = c.createOscillator(), lp = c.createBiquadFilter(), g = c.createGain();
      o1.type = "sawtooth"; o2.type = "square"; lp.type = "lowpass"; lp.frequency.value = 500; g.gain.value = 0;
      o1.connect(lp); o2.connect(lp); lp.connect(g); g.connect(this.sfx); o1.start(); o2.start();
      const n = c.createBufferSource(); n.buffer = this.noise; n.loop = true;
      const bp = c.createBiquadFilter(); bp.type = "bandpass"; bp.frequency.value = 1800; bp.Q.value = 6;
      const sg = c.createGain(); sg.gain.value = 0; n.connect(bp); bp.connect(sg); sg.connect(this.sfx); n.start();
      this.engine = { o1, o2, lp, g, n, sg, bp };
    }
    update_engine(speed_ratio, throttle, squeal) {
      if (!this.engine) return;
      const e = this.engine, t = this.ctx.currentTime, f = 48 + speed_ratio * 95 + throttle * 18;
      e.o1.frequency.setTargetAtTime(f, t, 0.05); e.o2.frequency.setTargetAtTime(f * 0.5, t, 0.05);
      e.lp.frequency.setTargetAtTime(350 + speed_ratio * 900 + throttle * 300, t, 0.08);
      e.g.gain.setTargetAtTime(0.05 + 0.06 * throttle + 0.03 * speed_ratio, t, 0.08);
      e.sg.gain.setTargetAtTime(squeal * 0.07, t, 0.05);
    }
    stop_engine() {
      if (!this.engine) return;
      const e = this.engine; this.engine = null;
      try { e.o1.stop(); e.o2.stop(); e.n.stop(); e.g.disconnect(); e.sg.disconnect(); } catch (er) { /* ignore */ }
    }
    start_music() {
      if (!this.ctx || this.music_timer) return;
      this.music_step = 0; this.music_next = this.ctx.currentTime + 0.1;
      this.music_timer = setInterval(() => this.schedule_music(), 200);
    }
    schedule_music() {
      const c = this.ctx; if (!c || c.state !== "running") return;
      const chords = [[57, 60, 64], [53, 57, 60], [48, 52, 55], [55, 59, 62]], arp = [0, 1, 2, 1, 2, 1, 2, 1];
      while (this.music_next < c.currentTime + 0.6) {
        const st = this.music_step, ch = chords[Math.floor(st / 16) % 4], t = this.music_next;
        this.tone(this.mtof(ch[arp[st % 8]] + 12), t, 0.3, "triangle", 0.09, this.music);
        if (st % 8 === 0) this.tone(this.mtof(ch[0] - 12), t, 1.0, "sine", 0.16, this.music);
        this.music_next += 0.25; this.music_step++;
      }
    }
    stop_music_timer_only() { if (this.music_timer) { clearInterval(this.music_timer); this.music_timer = null; } }
    stop_music() { this.stop_music_timer_only(); }
    destroy() {
      this.stop_engine(); this.stop_music_timer_only();
      if (this.ctx) { try { this.ctx.close(); } catch (e) { /* ignore */ } this.ctx = null; }
    }
  }

  /* =====================================================================
   * INPUT MANAGER
   * ===================================================================== */
  const pp3d_keymap = { KeyW: "accel", ArrowUp: "accel", KeyS: "reverse", ArrowDown: "reverse", KeyA: "left", ArrowLeft: "left", KeyD: "right", ArrowRight: "right", Space: "handbrake" };
  const pp3d_oneshot = { KeyR: "reset_car", KeyC: "camera", KeyV: "camera_reset", Escape: "toggle_pause" };

  class Pp3dInput {
    constructor(root, get_state, on_action) {
      this.root = root; this.get_state = get_state; this.on_action = on_action;
      this.kb = {}; this.touch = {}; this.touch_ids = {}; this.active = false;
      this.h_keydown = (e) => this.on_keydown(e);
      this.h_keyup = (e) => { const n = pp3d_keymap[e.code]; if (n) this.kb[n] = false; };
      this.h_blur = () => this.clear();
      this.h_global_ptr = (e) => { this.active = this.root.contains(e.target); };
      this.h_down = (e) => this.on_touch_down(e);
      this.h_up = (e) => this.on_touch_up(e);
      this.h_ctx = (e) => { if (e.target.closest && e.target.closest(".pp3d-touch,.pp3d-canvas-wrap")) e.preventDefault(); };
    }
    attach() {
      window.addEventListener("keydown", this.h_keydown); window.addEventListener("keyup", this.h_keyup); window.addEventListener("blur", this.h_blur);
      window.addEventListener("pointerdown", this.h_global_ptr, true);
      this.root.addEventListener("pointerdown", this.h_down); this.root.addEventListener("pointerup", this.h_up);
      this.root.addEventListener("pointercancel", this.h_up); this.root.addEventListener("lostpointercapture", this.h_up);
      this.root.addEventListener("contextmenu", this.h_ctx);
    }
    detach() {
      window.removeEventListener("keydown", this.h_keydown); window.removeEventListener("keyup", this.h_keyup); window.removeEventListener("blur", this.h_blur);
      window.removeEventListener("pointerdown", this.h_global_ptr, true);
      this.root.removeEventListener("pointerdown", this.h_down); this.root.removeEventListener("pointerup", this.h_up);
      this.root.removeEventListener("pointercancel", this.h_up); this.root.removeEventListener("lostpointercapture", this.h_up);
      this.root.removeEventListener("contextmenu", this.h_ctx);
    }
    is_focused() { return this.active || this.root.contains(document.activeElement); }
    on_keydown(e) {
      if (!this.is_focused()) return;
      const t = e.target;
      if (t && t.nodeType === 1 && (/^(INPUT|TEXTAREA|SELECT)$/.test(t.tagName) || t.isContentEditable)) return;
      if (e.ctrlKey || e.metaKey || e.altKey) return;
      const hold = pp3d_keymap[e.code];
      if (hold) { if (this.get_state() === "playing") { e.preventDefault(); this.kb[hold] = true; } return; }
      const one = pp3d_oneshot[e.code];
      if (one) { if (e.repeat) return; if (this.on_action(one)) e.preventDefault(); }
    }
    on_touch_down(e) {
      const el = e.target.closest ? e.target.closest("[data-pp3d-hold]") : null;
      if (!el) return;
      e.preventDefault();
      const name = el.getAttribute("data-pp3d-hold");
      try { el.setPointerCapture(e.pointerId); } catch (er) { /* ignore */ }
      this.touch_ids[e.pointerId] = { name, el }; this.touch[name] = true; el.classList.add("pp3d-pressed");
    }
    on_touch_up(e) {
      const rec = this.touch_ids[e.pointerId];
      if (!rec) return;
      delete this.touch_ids[e.pointerId]; this.touch[rec.name] = false; rec.el.classList.remove("pp3d-pressed");
    }
    clear() {
      this.kb = {}; this.touch = {};
      Object.keys(this.touch_ids).forEach((k) => this.touch_ids[k].el.classList.remove("pp3d-pressed")); this.touch_ids = {};
    }
    is_down(n) { return !!(this.kb[n] || this.touch[n]); }
  }

  /* =====================================================================
   * CAMERA CONTROLLER
   * ===================================================================== */
  class Pp3dCamera {
    constructor(T, camera) {
      this.T = T; this.camera = camera; this.mode = 0; this.heading = 0; this.orbit = 0; this.dist_scale = 1; this.smooth = 1; this.base_fov = 55; this.fov = 55;
      this.pos = new T.Vector3(); this.look = new T.Vector3(); this.want_pos = new T.Vector3(); this.want_look = new T.Vector3(); this.probe = new T.Vector3();
      this.modes = [{ dist: 7.2, h: 3.2, look_h: 0.9, ahead: 3.0 }, { dist: 10.5, h: 8.5, look_h: 0, ahead: 1.5 }, { dist: 3.5, h: 24, look_h: 0, ahead: 0 }, { cockpit: true }];
      this.eye = { x: 0.35, y: 1.1, z: -0.6 };
      this.arena = 28;
    }
    cycle() { this.mode = (this.mode + 1) % this.modes.length; return this.mode; }
    set_vehicle(veh) { const l = pp3d_cockpit_layout(veh); this.eye.x = l.x; this.eye.y = l.eye_y; this.eye.z = l.eye_z; }
    cockpit_update(dt, car) {
      const e = this.eye, c = Math.cos(car.heading), s = Math.sin(car.heading);
      if (dt <= 0) this.heading = car.heading; else this.heading += wrap_angle(car.heading - this.heading) * (1 - Math.exp(-14 * dt));
      this.pos.set(car.x + e.x * c + e.z * s, e.y, car.z - e.x * s + e.z * c);
      const yaw = this.heading + car.steer * 0.1;
      this.look.set(this.pos.x + Math.sin(yaw) * 10, e.y - 0.7, this.pos.z + Math.cos(yaw) * 10);
      this.apply(Math.abs(car.speed));
    }
    compute(car) {
      const m = this.modes[this.mode], ds = this.dist_scale, hx = Math.sin(this.heading), hz = Math.cos(this.heading);
      this.want_pos.set(car.x - hx * m.dist * ds, m.h * (0.7 + 0.3 * ds), car.z - hz * m.dist * ds);
      const ahead = m.ahead * clamp(0.4 + car.speed / 10, 0, 1);
      this.want_look.set(car.x + Math.sin(car.heading) * ahead, m.look_h, car.z + Math.cos(car.heading) * ahead);
    }
    blocked(p, obstacles) {
      for (let i = 0; i < obstacles.length; i++) {
        const o = obstacles[i];
        if (p.y > o.h + 0.2 || o.h < 1.2) continue;
        const dx = p.x - o.x, dz = p.z - o.z, lx = dx * o.c - dz * o.s, lz = dx * o.s + dz * o.c;
        if (Math.abs(lx) < o.hw + 0.35 && Math.abs(lz) < o.hl + 0.35) return true;
      }
      return false;
    }
    avoid(car, obstacles) {
      const bx = car.x, by = 1.0, bz = car.z, w = this.want_pos;
      const dx = w.x - bx, dy = w.y - by, dz = w.z - bz;
      let t = 1;
      for (let i = 0; i < 9; i++) {
        t = 1 - i * 0.08; this.probe.set(bx + dx * t, by + dy * t, bz + dz * t);
        if (!this.blocked(this.probe, obstacles)) break;
      }
      w.set(bx + dx * t, Math.max(1.0, by + dy * t), bz + dz * t);
      const lim = this.arena + 12; w.x = clamp(w.x, -lim, lim); w.z = clamp(w.z, -lim, lim);
    }
    snap(car, obstacles) {
      this.heading = car.heading;
      if (this.mode === 3) { this.cockpit_update(0, car); return; } this.compute(car); this.avoid(car, obstacles || []);
      this.pos.copy(this.want_pos); this.look.copy(this.want_look); this.apply(0);
    }
    update(dt, car, obstacles) {
      if (this.mode === 3) { this.cockpit_update(dt, car); return; }
      const diff = wrap_angle(car.heading - this.heading);
      this.heading += diff * (1 - Math.exp(-3.2 * dt / this.smooth));
      this.compute(car); this.avoid(car, obstacles);
      this.pos.lerp(this.want_pos, 1 - Math.exp((-9 * dt) / this.smooth));
      this.look.lerp(this.want_look, 1 - Math.exp(-12 * dt));
      this.apply(Math.abs(car.speed));
    }
    apply(speed) {
      this.camera.position.copy(this.pos); this.camera.lookAt(this.look);
      const base = this.mode === 3 ? Math.min(100, this.base_fov + 15) : this.base_fov, f = base + Math.min(speed, 12) * 0.35;
      if (Math.abs(f - this.fov) > 0.05) { this.fov = f; this.camera.fov = f; this.camera.updateProjectionMatrix(); }
    }
    orbit_update(dt, car, dist, h, shift) {
      this.orbit += dt * 0.3; const a = this.orbit;
      this.camera.position.set(car.x + Math.sin(a) * dist, h, car.z + Math.cos(a) * dist);
      this.camera.lookAt(car.x - Math.cos(a) * shift, 0.8, car.z + Math.sin(a) * shift);
      this.pos.copy(this.camera.position); this.heading = car.heading;
      if (Math.abs(this.camera.fov - this.base_fov) > 0.05) { this.fov = this.base_fov; this.camera.fov = this.base_fov; this.camera.updateProjectionMatrix(); }
    }
  }

  /* =====================================================================
   * SCENE MANAGER (Three.js)
   * ===================================================================== */
  class Pp3dScene {
    constructor(T, wrap) {
      this.T = T; this.wrap = wrap; this.geo_cache = new Map(); this.mat_cache = new Map(); this.tex_cache = new Map();
      this.quality = "medium"; this.pixel_cap = 1.5; this.pixel_ratio = 1; this.time = 0; this.marker = null; this.decal = null; this.player = null; this.arena = 28;
      this.player_key = ""; this.unique_mats = [];
      this.init();
    }
    init() {
      const T = this.T;
      this.renderer = new T.WebGLRenderer({ antialias: true, powerPreference: "high-performance" });
      this.renderer.shadowMap.enabled = true; this.renderer.shadowMap.type = T.PCFSoftShadowMap;
      this.renderer.domElement.className = "pp3d-canvas"; this.wrap.appendChild(this.renderer.domElement);
      this.h_lost = (e) => e.preventDefault(); this.renderer.domElement.addEventListener("webglcontextlost", this.h_lost);
      this.scene = new T.Scene(); this.scene.background = new T.Color(0xbfe6ff); this.scene.fog = new T.Fog(0xbfe6ff, 70, 190);
      this.camera = new T.PerspectiveCamera(55, 1.6, 0.1, 400);
      this.scene.add(new T.HemisphereLight(0xdff1ff, 0x5d7a45, 1.25));
      this.sun = new T.DirectionalLight(0xfff0d2, 2.6); this.sun.castShadow = true;
      const sc = this.sun.shadow.camera; sc.left = -26; sc.right = 26; sc.top = 26; sc.bottom = -26; sc.near = 1; sc.far = 100;
      this.sun.shadow.bias = -0.0004; this.sun.shadow.normalBias = 0.04;
      this.scene.add(this.sun); this.scene.add(this.sun.target);
      const grass = new T.Mesh(new T.PlaneGeometry(600, 600).rotateX(-Math.PI / 2), new T.MeshLambertMaterial({ color: 0x5f8f48 }));
      grass.position.y = -0.03; grass.receiveShadow = true; this.scene.add(grass); this.grass = grass;
      this.level_group = new T.Group(); this.scene.add(this.level_group);
      this.player_group = new T.Group(); this.scene.add(this.player_group);
      this.set_quality("medium");
    }
    /* ---- caches ---- */
    geo(key, fn) { let g = this.geo_cache.get(key); if (!g) { g = fn(); g.userData.shared = true; this.geo_cache.set(key, g); } return g; }
    mat(key, fn) { let m = this.mat_cache.get(key); if (!m) { m = fn(); m.userData.shared = true; this.mat_cache.set(key, m); } return m; }
    tex(key, w, h, draw, repeat) {
      let t = this.tex_cache.get(key);
      if (!t) {
        const T = this.T, c = document.createElement("canvas"); c.width = w; c.height = h; draw(c.getContext("2d"), w, h);
        t = new T.CanvasTexture(c); t.colorSpace = T.SRGBColorSpace; t.anisotropy = 4;
        if (repeat) { t.wrapS = t.wrapT = T.RepeatWrapping; }
        t.userData.shared = true; this.tex_cache.set(key, t);
      }
      return t;
    }
    unit_box() { return this.geo("unit_box", () => new this.T.BoxGeometry(1, 1, 1).translate(0, 0.5, 0)); }
    box_geo(w, h, l) { return this.geo("box_" + w.toFixed(3) + "_" + h.toFixed(3) + "_" + l.toFixed(3), () => new this.T.BoxGeometry(w, h, l)); }
    lam(color) { return this.mat("lam_" + color, () => new this.T.MeshLambertMaterial({ color })); }
    std(color) { return this.mat("std_" + color, () => new this.T.MeshStandardMaterial({ color, roughness: 0.4, metalness: 0.2 })); }
    /* ---- quality ---- */
    set_quality(q) {
      const tbl = { low: { pr: 1, sh: 512 }, medium: { pr: 1.5, sh: 1024 }, high: { pr: 2, sh: 2048 } }, c = tbl[q] || tbl.medium;
      this.quality = q; this.pixel_cap = Math.min(c.pr, window.devicePixelRatio || 1);
      this.sun.shadow.mapSize.set(c.sh, c.sh);
      if (this.sun.shadow.map) { this.sun.shadow.map.dispose(); this.sun.shadow.map = null; }
      this.set_pixel_ratio(this.pixel_cap);
    }
    set_pixel_ratio(pr) {
      this.pixel_ratio = clamp(pr, 0.6, this.pixel_cap); this.renderer.setPixelRatio(this.pixel_ratio);
      if (this.w) this.renderer.setSize(this.w, this.h, false);
    }
    resize(w, h) {
      this.w = Math.max(1, w); this.h = Math.max(1, h);
      this.renderer.setPixelRatio(this.pixel_ratio); this.renderer.setSize(this.w, this.h, false);
      this.camera.aspect = this.w / this.h; this.camera.updateProjectionMatrix();
      return this.camera.aspect;
    }
    /* ---- level ---- */
    clear_level() {
      const g = this.level_group;
      g.traverse((o) => {
        if (o.isInstancedMesh) o.dispose();
        if (o.geometry && !o.geometry.userData.shared) o.geometry.dispose();
        if (o.material) {
          const ms = Array.isArray(o.material) ? o.material : [o.material];
          ms.forEach((m) => { if (!m.userData.shared) { if (m.map && !m.map.userData.shared) m.map.dispose(); m.dispose(); } });
        }
      });
      while (g.children.length) g.remove(g.children[0]);
      this.marker = null; this.decal = null;
    }
    build_level(level) {
      this.clear_level();
      const T = this.T, a = level.arena || 28, g = this.level_group, rng = make_rng(hash_string("env" + level.id));
      const dens = this.quality === "low" ? 0.5 : this.quality === "medium" ? 0.8 : 1;
      this.arena = a;
      const asphalt = this.tex("asphalt", 128, 128, (cx, w, h) => {
        cx.fillStyle = "#3b3f46"; cx.fillRect(0, 0, w, h);
        for (let i = 0; i < 2600; i++) { const v = 40 + Math.floor(Math.random() * 45); cx.fillStyle = "rgba(" + v + "," + v + "," + (v + 4) + ",0.55)"; cx.fillRect(Math.random() * w, Math.random() * h, 2, 2); }
      }, true);
      const gg = new T.PlaneGeometry(a * 2, a * 2).rotateX(-Math.PI / 2), uv = gg.attributes.uv;
      for (let i = 0; i < uv.count; i++) uv.setXY(i, (uv.getX(i) * a) / 4, (uv.getY(i) * a) / 4);
      const ground = new T.Mesh(gg, this.mat("asphalt_mat", () => new T.MeshLambertMaterial({ map: asphalt }))); ground.receiveShadow = true; g.add(ground);
      /* perimeter walls */
      const wm = this.lam("#d8d2c4"), t = 1.2;
      [[0, a + t / 2, 2 * (a + t), t], [0, -a - t / 2, 2 * (a + t), t], [a + t / 2, 0, t, 2 * a], [-a - t / 2, 0, t, 2 * a]].forEach((p) => {
        const m = new T.Mesh(this.unit_box(), wm); m.scale.set(p[2], 0.9, p[3]); m.position.set(p[0], 0, p[1] === 0 ? 0 : p[1]); m.position.x = p[0]; m.receiveShadow = true; m.castShadow = true; g.add(m);
      });
      /* decor parking lines (instanced) */
      const lines = [];
      for (let x = -a + 3; x <= a - 3; x += 3.2) { lines.push({ x, z: a - 2.8, w: 0.12, l: 5 }); lines.push({ x, z: -a + 2.8, w: 0.12, l: 5 }); }
      const line_geo = this.geo("line_plane", () => new T.PlaneGeometry(1, 1).rotateX(-Math.PI / 2));
      const line_mesh = new T.InstancedMesh(line_geo, this.mat("line_mat", () => new T.MeshBasicMaterial({ color: 0xe8e8e8 })), lines.length);
      const m4 = new T.Matrix4(), q = new T.Quaternion(), p3 = new T.Vector3(), s3 = new T.Vector3(), up = new T.Vector3(0, 1, 0), col = new T.Color();
      lines.forEach((l, i) => { p3.set(l.x, 0.012, l.z); s3.set(l.w, 1, l.l); m4.compose(p3, q.identity(), s3); line_mesh.setMatrixAt(i, m4); });
      line_mesh.frustumCulled = false; g.add(line_mesh);
      /* obstacles */
      const cones = level.obstacles.filter((o) => o.type === "cone"), boxes = level.obstacles.filter((o) => o.type === "barrier" || o.type === "pillar" || o.type === "wall");
      const cars = level.obstacles.filter((o) => o.type === "car");
      if (cones.length) {
        const cg = this.geo("cone_geo", () => new T.ConeGeometry(0.28, 0.7, 10).translate(0, 0.35, 0));
        const cm = new T.InstancedMesh(cg, this.lam("#ff6a00"), cones.length);
        cones.forEach((o, i) => { p3.set(o.x, 0, o.z); s3.set(1, 1, 1); m4.compose(p3, q.identity(), s3); cm.setMatrixAt(i, m4); });
        cm.castShadow = true; cm.frustumCulled = false; g.add(cm);
      }
      if (boxes.length) {
        const bm = new T.InstancedMesh(this.unit_box(), this.lam("#ffffff"), boxes.length);
        boxes.forEach((o, i) => { q.setFromAxisAngle(up, o.rot || 0); p3.set(o.x, 0, o.z); s3.set(o.w, o.h, o.l); m4.compose(p3, q, s3); bm.setMatrixAt(i, m4); bm.setColorAt(i, col.set(o.color || "#999999")); });
        bm.instanceMatrix.needsUpdate = true; if (bm.instanceColor) bm.instanceColor.needsUpdate = true;
        bm.castShadow = true; bm.receiveShadow = true; bm.frustumCulled = false; g.add(bm);
      }
      cars.forEach((o) => { const c = this.make_car(get_vehicle("sedan"), o.color, "#d9dde3", false); c.group.position.set(o.x, 0, o.z); c.group.rotation.y = o.rot; g.add(c.group); });
      /* target decal + marker */
      const tg = level.target, tgrp = new T.Group(); tgrp.position.set(tg.x, 0.02, tg.z); tgrp.rotation.y = tg.rot;
      const tw = 256, th = Math.round(clamp((256 * tg.l) / tg.w, 256, 640)), cv = document.createElement("canvas"); cv.width = tw; cv.height = th;
      const cx = cv.getContext("2d"); cx.fillStyle = "rgba(255,255,255,0.18)"; cx.fillRect(0, 0, tw, th);
      cx.strokeStyle = "#fff"; cx.lineWidth = 12; cx.strokeRect(6, 6, tw - 12, th - 12);
      cx.fillStyle = "rgba(255,255,255,0.85)"; cx.font = "bold " + Math.round(tw * 0.5) + "px Arial"; cx.textAlign = "center"; cx.textBaseline = "middle"; cx.fillText("P", tw / 2, th / 2);
      const dt = new T.CanvasTexture(cv); dt.colorSpace = T.SRGBColorSpace; dt.anisotropy = 4;
      const dm = new T.MeshBasicMaterial({ map: dt, transparent: true, depthWrite: false, color: 0xffffff });
      const dp = new T.Mesh(new T.PlaneGeometry(tg.w, tg.l).rotateX(-Math.PI / 2), dm); dp.renderOrder = 1; tgrp.add(dp); g.add(tgrp); this.decal = dm;
      const mk_tex = this.tex("marker_p", 128, 128, (c2, w, h) => {
        c2.fillStyle = "#2ee59d"; c2.beginPath(); c2.arc(w / 2, h / 2, 58, 0, Math.PI * 2); c2.fill();
        c2.lineWidth = 8; c2.strokeStyle = "#fff"; c2.stroke(); c2.fillStyle = "#fff"; c2.font = "bold 80px Arial"; c2.textAlign = "center"; c2.textBaseline = "middle"; c2.fillText("P", w / 2, h / 2 + 4);
      });
      this.marker = new T.Sprite(new T.SpriteMaterial({ map: mk_tex, depthWrite: false, fog: false })); this.marker.scale.set(2.2, 2.2, 1); this.marker.position.set(tg.x, 3.4, tg.z); g.add(this.marker);
      /* outer decor */
      const ring = (d0, d1) => {
        const side = Math.floor(rng() * 4), u = (rng() * 2 - 1) * (a + d1), d = a + 1.2 + d0 + rng() * (d1 - d0);
        return side === 0 ? [u, d] : side === 1 ? [u, -d] : side === 2 ? [d, u] : [-d, u];
      };
      const n_trees = Math.round(46 * dens);
      const trunk = new T.InstancedMesh(this.geo("trunk", () => new T.CylinderGeometry(0.16, 0.22, 1.6, 6).translate(0, 0.8, 0)), this.lam("#6b4a2b"), n_trees);
      const leaf = new T.InstancedMesh(this.geo("leaf", () => new T.ConeGeometry(1.2, 3.2, 7).translate(0, 3.1, 0)), this.lam("#ffffff"), n_trees);
      for (let i = 0; i < n_trees; i++) {
        const pt = ring(2, 14), sc = 0.8 + rng() * 0.7; p3.set(pt[0], 0, pt[1]); s3.set(sc, sc, sc); m4.compose(p3, q.identity(), s3);
        trunk.setMatrixAt(i, m4); leaf.setMatrixAt(i, m4); leaf.setColorAt(i, col.setHSL(0.27 + rng() * 0.07, 0.5, 0.28 + rng() * 0.1));
      }
      trunk.castShadow = leaf.castShadow = true; trunk.frustumCulled = leaf.frustumCulled = false; g.add(trunk); g.add(leaf);
      const lamps = [];
      for (let u = -a; u <= a; u += 14) { lamps.push([u, a + 2.4]); lamps.push([u, -a - 2.4]); lamps.push([a + 2.4, u]); lamps.push([-a - 2.4, u]); }
      const pole = new T.InstancedMesh(this.geo("pole", () => new T.CylinderGeometry(0.07, 0.1, 6, 6).translate(0, 3, 0)), this.lam("#6c757d"), lamps.length);
      const head = new T.InstancedMesh(this.geo("lamp_head", () => new T.BoxGeometry(1.0, 0.14, 0.4).translate(0, 6.05, 0)), this.mat("lamp_mat", () => new T.MeshBasicMaterial({ color: 0xfff3c4 })), lamps.length);
      lamps.forEach((l, i) => { p3.set(l[0], 0, l[1]); s3.set(1, 1, 1); m4.compose(p3, q.identity(), s3); pole.setMatrixAt(i, m4); head.setMatrixAt(i, m4); });
      pole.castShadow = true; pole.frustumCulled = head.frustumCulled = false; g.add(pole); g.add(head);
      /* buildings */
      const win = this.tex("windows", 64, 64, (c2, w, h) => {
        c2.fillStyle = "#e9edf2"; c2.fillRect(0, 0, w, h);
        for (let r = 0; r < 2; r++) for (let k = 0; k < 2; k++) { c2.fillStyle = (r + k) % 2 ? "#2c4a6b" : "#3a5f86"; c2.fillRect(6 + k * 32, 6 + r * 32, 20, 20); }
      }, true);
      const tints = ["#f2d7b8", "#cfe0f2", "#e8c4c4", "#d5ead0"];
      for (let s = 0; s < 4; s++) for (let k = 0; k < 4; k++) {
        const bw = 8 + rng() * 8, bd = 8 + rng() * 6, bh = 10 + rng() * 22, u = -a * 1.2 + k * a * 0.8 + (rng() - 0.5) * 4, d = a + 20 + rng() * 8;
        const bg = new T.BoxGeometry(bw, bh, bd), buv = bg.attributes.uv;
        for (let i = 0; i < buv.count; i++) buv.setXY(i, (buv.getX(i) * Math.max(bw, bd)) / 5, (buv.getY(i) * bh) / 5);
        const bm2 = new T.Mesh(bg, this.mat("bld_" + ((s + k) % 4), () => new T.MeshLambertMaterial({ map: win, color: tints[(s + k) % 4] })));
        const pos = s === 0 ? [u, d] : s === 1 ? [u, -d] : s === 2 ? [d, u] : [-d, u]; bm2.position.set(pos[0], bh / 2, pos[1]); g.add(bm2);
      }
      /* signs */
      const sign_tex = (kind) => this.tex("sign_" + kind, 128, 128, (c2, w, h) => {
        c2.fillStyle = kind === "p" ? "#1b5fd1" : "#17803d"; c2.fillRect(0, 0, w, h); c2.strokeStyle = "#fff"; c2.lineWidth = 6; c2.strokeRect(5, 5, w - 10, h - 10); c2.fillStyle = "#fff";
        if (kind === "p") { c2.font = "bold 90px Arial"; c2.textAlign = "center"; c2.textBaseline = "middle"; c2.fillText("P", w / 2, h / 2 + 4); }
        else { c2.beginPath(); c2.moveTo(24, 50); c2.lineTo(70, 50); c2.lineTo(70, 28); c2.lineTo(106, 64); c2.lineTo(70, 100); c2.lineTo(70, 78); c2.lineTo(24, 78); c2.closePath(); c2.fill(); }
      });
      const post_geo = this.geo("sign_post", () => new T.CylinderGeometry(0.05, 0.05, 2.6, 6).translate(0, 1.3, 0)), plane_geo = this.geo("sign_plane", () => new T.PlaneGeometry(1.4, 1.4));
      [["p", -a * 0.5, a + 3.6], ["arrow", a * 0.45, a + 3.6], ["p", a + 3.6, -a * 0.4], ["arrow", -a - 3.6, a * 0.3], ["p", a * 0.3, -a - 3.6], ["arrow", -a * 0.4, -a - 3.6]].forEach((sg) => {
        const post = new T.Mesh(post_geo, this.lam("#8a929a")); post.position.set(sg[1], 0, sg[2]); g.add(post);
        const pl = new T.Mesh(plane_geo, this.mat("signmat_" + sg[0], () => new T.MeshBasicMaterial({ map: sign_tex(sg[0]), side: T.DoubleSide })));
        pl.position.set(sg[1], 2.3, sg[2]); pl.rotation.y = Math.atan2(-sg[1], -sg[2]); g.add(pl);
      });
    }
    set_target_state(state) {
      if (!this.decal) return;
      const c = state === 2 ? 0x4cff88 : state === 1 ? 0xffd45e : 0xffffff;
      this.decal.color.setHex(c);
    }
    /* ---- vehicles ---- */
    make_car(veh, paint, rim, is_player) {
      const T = this.T, L = veh.length, W = veh.width, gc = 0.18, g = new T.Group(), body_group = new T.Group(), parts = { front_pivots: [], spinners: [], body_group, steering: null, tail_mat: null };
      g.add(body_group);
      const add = (geo, mat, x, y, z, grp) => { const m = new T.Mesh(geo, mat); m.position.set(x, y, z); m.castShadow = true; m.receiveShadow = true; (grp || body_group).add(m); return m; };
      const body_mat = this.std(paint), glass = this.mat("glass", () => new T.MeshStandardMaterial({ color: 0x1b2a3a, roughness: 0.08, metalness: 0.6 }));
      add(this.box_geo(W, veh.body_h, L), body_mat, 0, gc + veh.body_h / 2, 0);
      const cw = W * 0.86, ch = veh.cabin_h, cl = L * veh.cabin_len, cz = L * veh.cabin_z, cy = gc + veh.body_h + ch / 2;
      add(this.box_geo(cw, ch, cl), body_mat, 0, cy, cz);
      add(this.box_geo(cw + 0.03, ch * 0.6, cl * 0.74), glass, 0, cy + ch * 0.06, cz);
      add(this.box_geo(cw * 0.88, ch * 0.6, cl + 0.03), glass, 0, cy + ch * 0.06, cz);
      const bump = this.mat("bumper", () => new T.MeshStandardMaterial({ color: 0x2b2f36, roughness: 0.7 }));
      add(this.box_geo(W * 0.98, 0.22, 0.18), bump, 0, gc + 0.2, L / 2 + 0.02); add(this.box_geo(W * 0.98, 0.22, 0.18), bump, 0, gc + 0.2, -L / 2 - 0.02);
      const head_mat = this.mat("headlight", () => new T.MeshStandardMaterial({ color: 0xffffff, emissive: 0xfff1b8, emissiveIntensity: 1.4 }));
      let tail_mat;
      if (is_player) { tail_mat = new T.MeshStandardMaterial({ color: 0x8a0f18, emissive: 0xff2020, emissiveIntensity: 0.35 }); this.unique_mats.push(tail_mat); parts.tail_mat = tail_mat; }
      else tail_mat = this.mat("taillight", () => new T.MeshStandardMaterial({ color: 0x8a0f18, emissive: 0xff2020, emissiveIntensity: 0.45 }));
      const ly = gc + veh.body_h * 0.72, lg = this.box_geo(0.28, 0.14, 0.06);
      [-1, 1].forEach((sg) => { add(lg, head_mat, sg * W * 0.3, ly, L / 2 + 0.01); add(lg, tail_mat, sg * W * 0.34, ly, -L / 2 - 0.01); });
      if (is_player) {
        const sw_group = new T.Group(); sw_group.position.set(W * 0.2, gc + veh.body_h + 0.22, cz + cl * 0.28); sw_group.rotation.x = -1.0;
        const sw = new T.Mesh(this.geo("sw_torus", () => new T.TorusGeometry(0.13, 0.025, 6, 14)), this.mat("sw_mat", () => new T.MeshStandardMaterial({ color: 0x111111 }))); sw_group.add(sw); body_group.add(sw_group); parts.steering = sw; parts.sw_group = sw_group; this.add_cockpit(g, parts, veh, cw);
      }
      const r = veh.wheel_r, tire_geo = this.geo("tire_" + r, () => new T.CylinderGeometry(r, r, 0.24, 16).rotateZ(Math.PI / 2)), hub_geo = this.geo("hub_" + r, () => new T.CylinderGeometry(r * 0.55, r * 0.55, 0.26, 10).rotateZ(Math.PI / 2));
      const tire_mat = this.mat("tire", () => new T.MeshStandardMaterial({ color: 0x15171a, roughness: 0.9 })), hub_mat = this.mat("hub_" + rim, () => new T.MeshStandardMaterial({ color: rim, roughness: 0.3, metalness: 0.7 }));
      [[-1, 1], [1, 1], [-1, -1], [1, -1]].forEach((w) => {
        const pivot = new T.Group(); pivot.position.set(w[0] * (W / 2 - 0.1), r, w[1] * veh.wheelbase / 2);
        const spin = new T.Group(); add(tire_geo, tire_mat, 0, 0, 0, spin); add(hub_geo, hub_mat, 0, 0, 0, spin); pivot.add(spin); g.add(pivot);
        parts.spinners.push(spin); if (w[1] > 0) parts.front_pivots.push(pivot);
      });
      return { group: g, parts };
    }
    add_cockpit(g, parts, veh, cw) {
      const T = this.T, lay = pp3d_cockpit_layout(veh), cock = new T.Group(), dark = this.std("#1d2128"), rubber = this.std("#15171a");
      cock.visible = false;
      const dash = new T.Mesh(this.box_geo(cw * 0.96, lay.dash_h, lay.dash_d), dark); dash.position.set(0, lay.floor + lay.dash_h / 2, lay.dash_z); cock.add(dash);
      const tilt = new T.Group(); tilt.position.set(lay.x, lay.wheel_y, lay.wheel_z); tilt.rotation.x = 0.45;
      const spin = new T.Group(); tilt.add(spin);
      spin.add(new T.Mesh(this.geo("cockpit_torus", () => new T.TorusGeometry(0.17, 0.026, 8, 22)), rubber));
      spin.add(new T.Mesh(this.box_geo(0.32, 0.03, 0.03), rubber));
      const stem = new T.Mesh(this.box_geo(0.03, 0.15, 0.03), rubber); stem.position.y = -0.075; spin.add(stem);
      const mark = new T.Mesh(this.box_geo(0.05, 0.035, 0.04), this.lam("#ffcc33")); mark.position.y = 0.17; spin.add(mark);
      cock.add(tilt); g.add(cock); parts.cockpit = cock; parts.cockpit_wheel = spin;
    }
    set_cockpit(on) {
      const p = this.player; if (!p || !p.parts.cockpit) return;
      p.parts.cockpit.visible = on; p.parts.sw_group.visible = !on;
    }
    set_player(veh, paint, rim) {
      const key = veh.id + "|" + paint + "|" + rim;
      if (this.player && this.player_key === key) return;
      this.remove_player();
      this.player = this.make_car(veh, paint, rim, true); this.player_key = key; this.player_group.add(this.player.group);
    }
    remove_player() {
      if (this.player) { this.player_group.remove(this.player.group); this.player = null; }
      this.unique_mats.forEach((m) => m.dispose()); this.unique_mats = []; this.player_key = "";
    }
    update_player(car, veh, dt, braking) {
      const p = this.player; if (!p) return;
      p.group.position.set(car.x, 0, car.z); p.group.rotation.y = car.heading;
      const ps = p.parts, T = this.T;
      ps.front_pivots.forEach((f) => { f.rotation.y = car.steer_angle; });
      const spin = (car.speed / veh.wheel_r) * dt; ps.spinners.forEach((s) => { s.rotation.x += spin; });
      const k = Math.min(1, dt * 8), bg = ps.body_group;
      bg.rotation.x += (clamp(-car.accel * 0.004, -0.05, 0.05) - bg.rotation.x) * k;
      bg.rotation.z += (clamp(car.steer * car.speed * 0.003, -0.05, 0.05) - bg.rotation.z) * k;
      if (ps.steering) ps.steering.rotation.z = -car.steer * 2.4;
      if (ps.cockpit_wheel) ps.cockpit_wheel.rotation.z = -car.steer * 2.4;
      if (ps.tail_mat) ps.tail_mat.emissiveIntensity = braking ? 1.6 : 0.35;
    }
    follow(x, z) { this.sun.position.set(x + 16, 28, z + 10); this.sun.target.position.set(x, 0, z); }
    update(dt) { this.time += dt; if (this.marker) this.marker.position.y = 3.4 + Math.sin(this.time * 2) * 0.25; }
    render() { this.renderer.render(this.scene, this.camera); }
    dispose() {
      this.clear_level(); this.remove_player();
      this.geo_cache.forEach((g) => g.dispose()); this.mat_cache.forEach((m) => m.dispose()); this.tex_cache.forEach((t) => t.dispose());
      this.geo_cache.clear(); this.mat_cache.clear(); this.tex_cache.clear();
      this.grass.geometry.dispose(); this.grass.material.dispose();
      this.renderer.domElement.removeEventListener("webglcontextlost", this.h_lost);
      this.renderer.dispose(); try { this.renderer.forceContextLoss(); } catch (e) { /* ignore */ }
      if (this.renderer.domElement.parentNode) this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
    }
  }

  /* =====================================================================
   * AD MANAGER (separate from the engine; disabled by default)
   * ===================================================================== */
  class Pp3dAds {
    constructor(root) { this.root = root; this.cfg = pp3d_config.ads; this.script = null; }
    init() {
      const c = this.cfg, top = this.root.querySelector("#pp3d-ad-top"), bottom = this.root.querySelector("#pp3d-ad-bottom");
      if (!c.adsense_client) return;
      if (!c.enabled && !c.h5_enabled) return;
      this.load_script();
      window.adsbygoogle = window.adsbygoogle || [];
      if (c.enabled) {
        [[top, c.slot_top], [bottom, c.slot_bottom]].forEach((pair) => {
          if (!pair[0] || !pair[1]) return;
          pair[0].innerHTML = '<ins class="adsbygoogle" style="display:block" data-ad-client="' + c.adsense_client + '" data-ad-slot="' + pair[1] + '" data-ad-format="auto" data-full-width-responsive="true"></ins>';
          pair[0].hidden = false;
          try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) { /* ignore */ }
        });
      }
      if (c.h5_enabled) { try { window.adsbygoogle.push({ preloadAdBreaks: "on", sound: "on" }); } catch (e) { /* ignore */ } }
    }
    load_script() {
      const c = this.cfg, src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=" + encodeURIComponent(c.adsense_client);
      if (document.querySelector('script[src^="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"]')) return;
      const s = document.createElement("script"); s.async = true; s.crossOrigin = "anonymous"; s.src = src;
      if (c.h5_enabled) { s.setAttribute("data-ad-client", c.adsense_client); if (c.h5_test_mode) s.setAttribute("data-adbreak-test", "on"); s.setAttribute("data-ad-frequency-hint", "30s"); }
      document.head.appendChild(s); this.script = s;
    }
    /* Call ONLY at natural transitions after an explicit user click (e.g. "Next level"). */
    show_break(name, before, after, done) {
      let finished = false;
      const finish = () => { if (finished) return; finished = true; done(); };
      if (!this.cfg.h5_enabled || !this.cfg.adsense_client || !window.adsbygoogle) { finish(); return; }
      try {
        window.adsbygoogle.push({ type: "next", name, beforeAd: before, afterAd: after, adBreakDone: finish });
        setTimeout(finish, 8000);
      } catch (e) { finish(); }
    }
  }

  /* =====================================================================
   * UI MANAGER
   * ===================================================================== */
  class Pp3dUI {
    constructor(root) {
      this.root = root;
      const q = (id) => root.querySelector("#" + id);
      this.el = {
        frame: q("pp3d-frame"), wrap: q("pp3d-canvas-wrap"), loading: q("pp3d-loading"), loading_text: q("pp3d-loading-text"), hud: q("pp3d-hud"), touch: q("pp3d-touch"),
        level: q("pp3d-hud-level"), col: q("pp3d-hud-collisions"), col_wrap: q("pp3d-hud-col-wrap"), acc: q("pp3d-hud-accuracy"), timer: q("pp3d-hud-timer"),
        speed: q("pp3d-hud-speed"), gear: q("pp3d-hud-gear"), hold: q("pp3d-hold"), hold_fill: q("pp3d-hold-fill"), banner: q("pp3d-banner"), toast: q("pp3d-toast"),
        level_grid: q("pp3d-level-grid"), veh_list: q("pp3d-veh-list"), paint: q("pp3d-paint-swatches"), rim: q("pp3d-rim-swatches"),
        menu_best: q("pp3d-menu-best"), menu_stars: q("pp3d-menu-stars"), menu_player: q("pp3d-menu-player"), menu_daily: q("pp3d-menu-daily"),
        set_nick: q("pp3d-set-nick"), set_quality: q("pp3d-set-quality"), set_camdist: q("pp3d-set-camdist"), set_camsmooth: q("pp3d-set-camsmooth"), set_steer: q("pp3d-set-steer"), set_touch: q("pp3d-set-touch"),
        done_title: q("pp3d-done-title"), done_stars: q("pp3d-done-stars"), done_badge: q("pp3d-done-badge"), done_score: q("pp3d-done-score"), done_score_best: q("pp3d-done-score-best"),
        done_time: q("pp3d-done-time"), done_time_best: q("pp3d-done-time-best"), done_col: q("pp3d-done-col"), done_acc: q("pp3d-done-acc"), done_acc_best: q("pp3d-done-acc-best"),
        done_extra: q("pp3d-done-extra"), btn_next: q("pp3d-btn-next"), fail_title: q("pp3d-fail-title"), fail_text: q("pp3d-fail-text"), btn_reset: q("pp3d-btn-reset"), import_file: q("pp3d-import-file")
      };
      this.toast_timer = null; this.reset_timer = null; this.cache = {};
    }
    set_text(key, el, v) { if (this.cache[key] !== v) { this.cache[key] = v; el.textContent = v; } }
    show_screen(name) {
      this.root.querySelectorAll("[data-pp3d-screen]").forEach((s) => s.classList.toggle("pp3d-is-active", s.getAttribute("data-pp3d-screen") === name));
      this.current = name;
    }
    set_hud(on) { this.el.hud.classList.toggle("pp3d-on", on); }
    set_touch(on) { this.el.touch.hidden = !on; }
    toast(msg, ms) {
      const t = this.el.toast; t.textContent = msg; t.classList.add("pp3d-show");
      clearTimeout(this.toast_timer); this.toast_timer = setTimeout(() => t.classList.remove("pp3d-show"), ms || 2600);
    }
    banner(msg) { const b = this.el.banner; b.textContent = msg; b.classList.remove("pp3d-show"); void b.offsetWidth; b.classList.add("pp3d-show"); }
    flash_collision() { const w = this.el.col_wrap; w.classList.remove("pp3d-flash"); void w.offsetWidth; w.classList.add("pp3d-flash"); }
    stars_html(n, animate) {
      let h = ""; for (let i = 0; i < 3; i++) h += '<span class="' + (animate ? (i < n ? "pp3d-on" : "pp3d-off") : "") + '"' + (animate ? ' style="animation-delay:' + (0.25 + i * 0.3) + 's"' : "") + ">★</span>"; return h;
    }
    mini_stars(n) { let h = ""; for (let i = 0; i < 3; i++) h += i < n ? "★" : '<span class="pp3d-star-off">★</span>'; return h; }
    render_menu(storage, today) {
      const d = storage.data, ds = storage.get_daily_state(today);
      this.el.menu_best.textContent = storage.total_best(); this.el.menu_stars.textContent = storage.total_stars() + "/" + pp3d_levels.length * 3;
      this.el.menu_player.textContent = "👤 " + d.player.nickname;
      this.el.menu_daily.textContent = ds.completed ? "✔ " + ds.streak + "🔥" : ds.streak ? "(" + ds.streak + "🔥)" : "";
    }
    render_levels(storage) {
      const unlocked = storage.data.progress.unlocked_levels;
      this.el.level_grid.innerHTML = pp3d_levels.map((l) => {
        const p = storage.get_level_progress(l.id), locked = unlocked.indexOf(l.id) < 0;
        return '<button type="button" class="pp3d-level-card' + (locked ? " pp3d-locked" : "") + '" data-pp3d-action="start_level" data-level="' + l.id + '"' + (locked ? " disabled" : "") + ">" +
          '<span class="pp3d-level-num">' + (locked ? "🔒" : l.id) + '</span><span>' + l.name + '</span><span class="pp3d-level-stars">' + this.mini_stars(p.stars) + "</span>" +
          '<span class="pp3d-level-meta">' + (p.best_time != null ? "Best " + format_time(p.best_time) : l.vehicle ? get_vehicle(l.vehicle).name : "Not played") + "</span></button>";
      }).join("");
    }
    render_vehicles(storage) {
      const v = storage.data.vehicles, done = storage.data.progress.completed_levels.length;
      const bar = (label, val) => "<span>" + label + '</span><span class="pp3d-bar"><span style="width:' + Math.round(clamp(val, 0.05, 1) * 100) + '%"></span></span>';
      this.el.veh_list.innerHTML = pp3d_vehicles.map((x) => {
        const open = v.unlocked.indexOf(x.id) >= 0;
        return '<button type="button" class="pp3d-veh-card' + (v.selected === x.id ? " pp3d-selected" : "") + (open ? "" : " pp3d-locked") + '" data-pp3d-action="select_vehicle" data-vehicle="' + x.id + '"' + (open ? "" : " disabled") + ">" +
          '<span class="pp3d-veh-name">' + x.name + '</span><span class="pp3d-veh-tag">' + (open ? (v.selected === x.id ? "Selected" : "Select") : "🔒 Complete " + x.unlock_levels + " levels (" + done + "/" + x.unlock_levels + ")") + "</span>" +
          '<span class="pp3d-veh-bars">' + bar("Speed", x.max_speed / 13) + bar("Accel", x.accel / 8) + bar("Handling", (x.steer_max * x.steer_rate) / 2.3) + bar("Size", x.length / 5.4) + "</span></button>";
      }).join("");
      const sw = (list, cur, act) => list.map((c) => '<button type="button" class="pp3d-swatch' + (c === cur ? " pp3d-selected" : "") + '" style="background:' + c + '" data-pp3d-action="' + act + '" data-color="' + c + '" aria-label="' + c + '"></button>').join("");
      this.el.paint.innerHTML = sw(pp3d_paints, v.selected_paint, "select_paint"); this.el.rim.innerHTML = sw(pp3d_rims, v.customization.rim_color, "select_rim");
    }
    sync_settings(storage) {
      const s = storage.data.settings, e = this.el;
      e.set_nick.value = storage.data.player.nickname; e.set_quality.value = s.quality; e.set_camdist.value = s.camera_distance; e.set_camsmooth.value = s.camera_smoothing;
      e.set_steer.value = s.controls.steer_sensitivity; e.set_touch.value = s.controls.touch_controls;
      this.root.querySelectorAll("#pp3d-btn-sound,#pp3d-pause-sound,#pp3d-set-sound").forEach((b) => { b.classList.toggle("pp3d-off", !s.sound); if (b.id === "pp3d-set-sound") b.textContent = s.sound ? "On" : "Off"; });
      this.root.querySelectorAll("#pp3d-btn-music,#pp3d-pause-music,#pp3d-set-music").forEach((b) => { b.classList.toggle("pp3d-off", !s.music); if (b.id === "pp3d-set-music") b.textContent = s.music ? "On" : "Off"; });
    }
    show_complete(o) {
      const e = this.el;
      e.done_title.textContent = o.daily ? "Daily Challenge Complete!" : "Level Completed!";
      e.done_stars.innerHTML = this.stars_html(o.stars, true);
      e.done_badge.hidden = !(o.new_record);
      e.done_score.textContent = o.score; e.done_time.textContent = format_time(o.time); e.done_col.textContent = o.collisions; e.done_acc.textContent = o.accuracy + "%";
      e.done_score_best.textContent = "Best: " + o.best_score; e.done_time_best.textContent = o.best_time != null ? "Best: " + format_time(o.best_time) : ""; e.done_acc_best.textContent = "Best: " + o.best_accuracy + "%";
      e.done_extra.textContent = o.extra || ""; e.btn_next.hidden = !o.has_next; this.show_screen("complete");
    }
    show_fail(title, text) { this.el.fail_title.textContent = title; this.el.fail_text.textContent = text; this.show_screen("failed"); }
  }

  /* =====================================================================
   * GAME (orchestrator)
   * ===================================================================== */
  class Pp3dGame {
    constructor(root, T) {
      this.root = root; this.T = T; this.state = "menu"; this.destroyed = false; this.raf = 0; this.last = 0; this.frame_ms = 16; this.adapt_t = 0;
      this.level = null; this.veh = pp3d_vehicles[0]; this.loaded_key = ""; this.timer = 0; this.timer_started = false; this.collisions = 0; this.hud_t = 0; this.mode = "level"; this.visible = true; this.in_view = true;
    }
    init() {
      const root = this.root;
      this.storage = new Pp3dStorage(pp3d_config.storage_key, pp3d_config.storage_version); this.storage.load_game_data(); this.storage.touch_session();
      this.ui = new Pp3dUI(root); this.levels = new Pp3dLevelManager(); this.score = new Pp3dScore(); this.physics = new Pp3dPhysics(); this.vehicle = new Pp3dVehicle(); this.parking = new Pp3dParking();
      this.audio = new Pp3dAudio(() => this.storage.get_settings()); this.ads = new Pp3dAds(root);
      this.scene = new Pp3dScene(this.T, this.ui.el.wrap); this.cam = new Pp3dCamera(this.T, this.scene.camera);
      this.input = new Pp3dInput(root, () => this.state, (a) => this.on_key_action(a));
      root.setAttribute("tabindex", "-1");
      this.h_click = (e) => this.on_click(e); this.h_change = (e) => this.on_change(e);
      root.addEventListener("click", this.h_click); root.addEventListener("change", this.h_change); root.addEventListener("input", this.h_change);
      this.input.attach();
      this.ro = new ResizeObserver(() => this.on_resize()); this.ro.observe(this.ui.el.frame);
      this.h_vis = () => this.on_visibility(); document.addEventListener("visibilitychange", this.h_vis);
      if ("IntersectionObserver" in window) { this.io = new IntersectionObserver((en) => this.on_intersect(en[0].isIntersecting), { threshold: 0.05 }); this.io.observe(root); }
      this.h_fs = () => this.on_resize(); document.addEventListener("fullscreenchange", this.h_fs);
      this.apply_settings_all(); this.on_resize(); this.ads.init();
      this.enter_menu(true);
      this.ui.el.loading.classList.add("pp3d-done"); this.start_loop();
    }
    /* ---- settings ---- */
    apply_settings_all() {
      const s = this.storage.get_settings();
      this.scene.set_quality(s.quality); this.cam.mode = s.camera_mode; this.cam.dist_scale = s.camera_distance; this.cam.smooth = s.camera_smoothing;
      this.ui.sync_settings(this.storage); this.update_touch_visibility();
      if (this.scene.w) this.scene.set_pixel_ratio(this.scene.pixel_cap);
    }
    update_touch_visibility() {
      const mode = this.storage.get_settings().controls.touch_controls, show = mode === "on" || (mode === "auto" && is_coarse_pointer());
      this.touch_enabled = show; this.ui.set_touch(show && this.state === "playing");
    }
    /* ---- resize / visibility ---- */
    on_resize() {
      const f = this.ui.el.frame, w = f.clientWidth, h = f.clientHeight; if (!w || !h) return;
      const aspect = this.scene.resize(w, h); this.cam.base_fov = aspect >= 1.3 ? 55 : clamp(55 + (1.3 - aspect) * 35, 55, 80); this.cam.fov = -1; this.wide = w > 720;
    }
    on_visibility() {
      if (document.hidden) { this.visible = false; if (this.state === "playing") this.pause_game(); this.audio.suspend(); this.stop_loop(); }
      else { this.visible = true; this.audio.resume(); if (this.in_view) this.start_loop(); }
    }
    on_intersect(v) {
      this.in_view = v;
      if (!v) { if (this.state === "playing") this.pause_game(); this.stop_loop(); } else if (this.visible) this.start_loop();
    }
    /* ---- loop ---- */
    start_loop() { if (this.raf || this.destroyed) return; this.last = performance.now(); this.raf = requestAnimationFrame((t) => this.loop(t)); }
    stop_loop() { if (this.raf) { cancelAnimationFrame(this.raf); this.raf = 0; } }
    loop(now) {
      if (this.destroyed) return;
      this.raf = requestAnimationFrame((t) => this.loop(t));
      const dt = Math.min(0.05, Math.max(0.0005, (now - this.last) / 1000)); this.last = now;
      this.frame_ms += (dt * 1000 - this.frame_ms) * 0.05; this.adapt_t += dt;
      if (this.adapt_t > 2) {
        this.adapt_t = 0; const sc = this.scene;
        if (this.frame_ms > 22 && sc.pixel_ratio > 0.75) sc.set_pixel_ratio(sc.pixel_ratio - 0.25);
        else if (this.frame_ms < 14.5 && sc.pixel_ratio < sc.pixel_cap) sc.set_pixel_ratio(sc.pixel_ratio + 0.25);
      }
      this.update(dt); this.scene.render();
    }
    update(dt) {
      this.scene.update(dt);
      if (this.state === "playing") this.update_play(dt);
      else if (this.state === "menu" || this.state === "complete") {
        const shift = this.state === "menu" && this.wide ? 2.4 : 0;
        this.cam.orbit_update(dt, this.vehicle.car, this.state === "menu" ? 7.5 : 8, 3.2, shift);
        this.scene.follow(this.vehicle.car.x, this.vehicle.car.z);
      }
    }
    /* ---- play ---- */
    update_play(dt) {
      const inp = this.input, car = this.vehicle.car, veh = this.veh, level = this.level;
      const ctl = { accel: inp.is_down("accel"), reverse: inp.is_down("reverse"), left: inp.is_down("left"), right: inp.is_down("right"), handbrake: inp.is_down("handbrake") };
      if (!this.timer_started && (ctl.accel || ctl.reverse)) this.timer_started = true;
      if (this.timer_started) this.timer += dt;
      const sens = this.storage.get_settings().controls.steer_sensitivity, steps = Math.max(1, Math.ceil(dt / 0.0111)), sdt = dt / steps;
      let hit = false, impact = 0;
      for (let i = 0; i < steps; i++) {
        this.vehicle.update(sdt, ctl, veh, sens);
        const r = this.physics.step(car, veh, sdt); if (r.hit) hit = true; if (r.impact > impact) impact = r.impact;
      }
      if (hit) { this.collisions++; this.audio.play_collision(impact); this.ui.flash_collision(); }
      const pk = this.parking.evaluate(car, veh, level, dt);
      this.scene.set_target_state(pk.ready ? 2 : pk.inside ? 1 : 0);
      const braking = (ctl.reverse && car.speed > 0.3) || ctl.handbrake;
      this.scene.update_player(car, veh, dt, braking); this.scene.follow(car.x, car.z);
      this.cam.update(dt, car, this.physics.obstacles);
      const sr = Math.abs(car.speed) / veh.max_speed;
      this.audio.update_engine(sr, ctl.accel || (ctl.reverse && car.speed <= 0.3) ? 1 : 0, (braking && Math.abs(car.speed) > 3) || (ctl.handbrake && Math.abs(car.speed) > 2) ? 1 : 0);
      this.hud_t += dt; if (this.hud_t > 0.08) { this.hud_t = 0; this.update_hud(pk, ctl); }
      if (pk.complete) { this.finish_level(pk.accuracy); return; }
      if (this.timer >= level.time_limit) this.fail_level("Time's up!", "You ran out of time. Park faster next time.");
      else if (this.collisions > level.max_collisions) this.fail_level("Too many collisions", "You exceeded the " + level.max_collisions + " allowed collisions.");
    }
    update_hud(pk, ctl) {
      const ui = this.ui, e = ui.el, car = this.vehicle.car, left = Math.max(0, this.level.time_limit - this.timer);
      ui.set_text("timer", e.timer, format_time(Math.ceil(left))); e.timer.classList.toggle("pp3d-warn", left < 10 && this.timer_started);
      ui.set_text("speed", e.speed, String(Math.round(Math.abs(car.speed) * 4.5)));
      ui.set_text("gear", e.gear, Math.abs(car.speed) < 0.15 && !ctl.accel && !ctl.reverse ? "N" : car.speed < -0.05 ? "R" : "D");
      ui.set_text("col", e.col, this.collisions + "/" + this.level.max_collisions); ui.set_text("acc", e.acc, pk.accuracy + "%");
      e.hold.classList.toggle("pp3d-on", pk.hold_progress > 0); e.hold_fill.style.width = Math.round(pk.hold_progress * 100) + "%";
    }
    /* ---- level flow ---- */
    level_key(l) { return String(l.id); }
    prepare_level(level) {
      this.level = level;
      const s = this.storage.data.vehicles, veh_id = level.vehicle || s.selected; this.veh = get_vehicle(veh_id);
      if (this.loaded_key !== this.level_key(level)) { this.scene.build_level(level); this.physics.set_level(level); this.cam.arena = level.arena || 28; this.loaded_key = this.level_key(level); }
      const paint = level.vehicle && level.vehicle !== s.selected ? this.veh.def_paint : s.selected_paint;
      this.scene.set_player(this.veh, paint, s.customization.rim_color);
      this.vehicle.reset(level.start); this.parking.reset(); this.scene.set_target_state(0);
      const c = this.vehicle.car; this.scene.update_player(c, this.veh, 0.016, false); this.scene.follow(c.x, c.z); this.cam.set_vehicle(this.veh); this.cam.snap(c, this.physics.obstacles); this.sync_cockpit();
    }
    start_level(level, mode) {
      this.audio.unlock(); this.audio.play_click(); this.input.active = true; this.input.clear(); this.root.focus({ preventScroll: true });
      this.mode = mode || "level"; this.prepare_level(level);
      this.timer = 0; this.timer_started = false; this.collisions = 0; this.hud_t = 1; this.state = "playing";
      this.ui.show_screen(null); this.ui.set_hud(true); this.ui.set_touch(this.touch_enabled); this.sync_cockpit();
      this.ui.el.level.textContent = level.daily ? "Daily Challenge · " + this.veh.name : "Level " + level.id + " · " + level.name;
      this.ui.cache = {}; this.ui.banner(level.hint); this.audio.start_engine();
      if (!level.daily) this.storage.mark_attempt(level.id);
    }
    restart() { this.start_level(this.level, this.mode); }
    pause_game() {
      if (this.state !== "playing") return; this.state = "paused"; this.input.clear(); this.audio.stop_engine(); this.ui.set_touch(false); this.ui.show_screen("pause");
    }
    resume_game() {
      if (this.state !== "paused") return; this.state = "playing"; this.last = performance.now(); this.ui.show_screen(null); this.ui.set_touch(this.touch_enabled); this.audio.start_engine(); this.root.focus({ preventScroll: true });
    }
    finish_level(accuracy) {
      const level = this.level, stats = { time: this.timer, collisions: this.collisions, accuracy }, res = this.score.compute(level, stats);
      this.state = "complete"; this.sync_cockpit(); this.input.clear(); this.audio.stop_engine(); this.audio.play_success(); this.ui.set_hud(false); this.ui.set_touch(false); this.vehicle.car.speed = 0;
      let info, extra = "", best_score = res.score, best_time = stats.time, best_acc = accuracy, new_record = false, has_next = false;
      if (level.daily) {
        const d = this.storage.save_daily_result(local_date_string(), level.seed, res.score);
        best_score = d.best_score; new_record = res.score >= d.best_score; extra = "Daily streak: " + d.streak + " 🔥 · Today's best: " + d.today_score;
      } else {
        info = this.storage.save_level_progress(level.id, { score: res.score, time: stats.time, accuracy, stars: res.stars });
        const p = this.storage.get_level_progress(level.id); best_score = p.best_score; best_time = p.best_time; best_acc = p.best_accuracy;
        new_record = info.new_best_score || info.new_best_time; has_next = level.id < pp3d_levels.length;
        const unlocked = this.check_vehicle_unlocks(); if (unlocked.length) extra = "🚗 Unlocked: " + unlocked.join(", ");
      }
      this.ui.show_complete({ daily: !!level.daily, stars: res.stars, score: res.score, time: stats.time, collisions: stats.collisions, accuracy, best_score, best_time, best_accuracy: best_acc, new_record, extra, has_next });
    }
    fail_level(title, text) {
      this.state = "failed"; this.input.clear(); this.audio.stop_engine(); this.audio.play_fail(); this.ui.set_hud(false); this.ui.set_touch(false); this.ui.show_fail(title, text);
    }
    check_vehicle_unlocks() {
      const done = this.storage.data.progress.completed_levels.length, v = this.storage.data.vehicles, added = [];
      pp3d_vehicles.forEach((x) => { if (x.unlock_levels <= done && v.unlocked.indexOf(x.id) < 0) { v.unlocked.push(x.id); added.push(x.name); } });
      if (added.length) this.storage.save_vehicle({ unlocked: v.unlocked });
      return added;
    }
    next_level_id() {
      const d = this.storage.data.progress; for (let i = 1; i <= pp3d_levels.length; i++) if (d.completed_levels.indexOf(i) < 0 && d.unlocked_levels.indexOf(i) >= 0) return i;
      return 1;
    }
    enter_menu(first) {
      this.state = "menu"; this.input.clear(); this.audio.stop_engine(); this.ui.set_hud(false); this.ui.set_touch(false);
      const level = first || !this.level ? this.levels.get(1) : this.level; this.prepare_level(level);
      this.ui.render_menu(this.storage, local_date_string()); this.ui.sync_settings(this.storage); this.ui.show_screen("menu");
    }
    /* ---- events ---- */
    on_key_action(a) {
      const st = this.state;
      if (a === "toggle_pause") { if (st === "playing") { this.pause_game(); return true; } if (st === "paused") { this.resume_game(); return true; } return false; }
      if (st !== "playing") return false;
      if (a === "camera") { this.do_camera(); return true; }
      if (a === "camera_reset") { this.cam.snap(this.vehicle.car, this.physics.obstacles); return true; }
      if (a === "reset_car") { this.reset_car(); return true; }
      return false;
    }
    sync_cockpit() {
      const s = this.state; this.scene.set_cockpit(this.cam.mode === 3 && (s === "playing" || s === "paused" || s === "failed"));
    }
    do_camera() {
      const m = this.cam.cycle(); this.storage.save_settings({ camera_mode: m }); this.cam.snap(this.vehicle.car, this.physics.obstacles);
      this.sync_cockpit(); this.ui.toast(["Chase camera", "High camera", "Top-down camera", "Cockpit view"][m], 1200);
    }
    reset_car() {
      this.vehicle.reset(this.level.start); this.parking.reset(); this.collisions = Math.min(this.collisions + 1, 9999); this.ui.flash_collision();
      this.cam.snap(this.vehicle.car, this.physics.obstacles); this.ui.toast("Car reset (+1 collision)", 1500);
    }
    on_click(e) {
      const el = e.target.closest ? e.target.closest("[data-pp3d-action]") : null; if (!el || !this.root.contains(el)) return;
      const a = el.getAttribute("data-pp3d-action"); this.audio.unlock(); this.audio.play_click(); this.input.active = true;
      const ui = this.ui, st = this.storage;
      switch (a) {
        case "play": this.start_level(this.levels.get(this.next_level_id()), "level"); break;
        case "open_levels": ui.render_levels(st); ui.show_screen("levels"); break;
        case "open_vehicles": ui.render_vehicles(st); ui.show_screen("vehicles"); this.prepare_level(this.level); break;
        case "open_settings": this.settings_from = this.state === "paused" ? "pause" : "menu"; ui.sync_settings(st); ui.show_screen("settings"); break;
        case "settings_back": if (this.state === "paused") ui.show_screen("pause"); else { ui.render_menu(st, local_date_string()); ui.show_screen("menu"); } break;
        case "menu": this.enter_menu(false); break;
        case "daily": this.start_level(this.levels.daily(local_date_string()), "daily"); break;
        case "start_level": { const id = Number(el.getAttribute("data-level")); if (st.data.progress.unlocked_levels.indexOf(id) >= 0) this.start_level(this.levels.get(id), "level"); break; }
        case "select_vehicle": {
          const id = el.getAttribute("data-vehicle"); if (st.data.vehicles.unlocked.indexOf(id) < 0) break;
          const v = get_vehicle(id); st.save_vehicle({ selected: id, selected_paint: v.def_paint }); ui.render_vehicles(st); this.prepare_level(this.level); break;
        }
        case "select_paint": st.save_vehicle({ selected_paint: el.getAttribute("data-color") }); ui.render_vehicles(st); this.prepare_level(this.level); break;
        case "select_rim": st.save_vehicle({ customization: { rim_color: el.getAttribute("data-color") } }); ui.render_vehicles(st); this.prepare_level(this.level); break;
        case "pause": this.pause_game(); break;
        case "resume": this.resume_game(); break;
        case "restart": this.restart(); break;
        case "next": this.go_next(); break;
        case "camera": if (this.state === "playing") this.do_camera(); break;
        case "reset_car": if (this.state === "playing") this.reset_car(); break;
        case "fullscreen": this.toggle_fullscreen(); break;
        case "toggle_sound": st.save_settings({ sound: !st.get_settings().sound }); this.audio.apply_settings(); if (this.state === "playing") this.audio.start_engine(); ui.sync_settings(st); break;
        case "toggle_music": st.save_settings({ music: !st.get_settings().music }); this.audio.apply_settings(); ui.sync_settings(st); break;
        case "export": this.export_progress(); break;
        case "import": ui.el.import_file.click(); break;
        case "reset_data": this.confirm_reset(el); break;
        default: break;
      }
    }
    go_next() {
      const level = this.level; if (!level || level.daily) { this.enter_menu(false); return; }
      const next = this.levels.get(level.id + 1); if (!next) { this.enter_menu(false); return; }
      this.ads.show_break("next-level", () => { this.audio.suspend(); }, () => { this.audio.resume(); }, () => { if (!this.destroyed) this.start_level(next, "level"); });
    }
    on_change(e) {
      const t = e.target, id = t.id, st = this.storage; if (!id) return;
      if (id === "pp3d-set-nick" && e.type === "change") { st.save_nickname(t.value); this.ui.sync_settings(st); }
      else if (id === "pp3d-set-quality") { st.save_settings({ quality: t.value }); this.scene.set_quality(t.value); this.loaded_key = ""; this.prepare_level(this.level); }
      else if (id === "pp3d-set-camdist") { st.save_settings({ camera_distance: Number(t.value) }); this.cam.dist_scale = st.get_settings().camera_distance; }
      else if (id === "pp3d-set-camsmooth") { st.save_settings({ camera_smoothing: Number(t.value) }); this.cam.smooth = st.get_settings().camera_smoothing; }
      else if (id === "pp3d-set-steer") st.save_settings({ controls: { steer_sensitivity: Number(t.value) } });
      else if (id === "pp3d-set-touch") { st.save_settings({ controls: { touch_controls: t.value } }); this.update_touch_visibility(); }
      else if (id === "pp3d-import-file" && e.type === "change") this.import_progress(t);
    }
    toggle_fullscreen() {
      const r = this.root;
      try {
        if (document.fullscreenElement || document.webkitFullscreenElement) { (document.exitFullscreen || document.webkitExitFullscreen).call(document); }
        else { (r.requestFullscreen || r.webkitRequestFullscreen).call(r); }
      } catch (e) { this.ui.toast("Fullscreen not available"); }
    }
    export_progress() {
      const blob = new Blob([this.storage.export_json()], { type: "application/json" }), url = URL.createObjectURL(blob), a = document.createElement("a");
      a.href = url; a.download = "precision-parking-3d-progress.json"; this.root.appendChild(a); a.click(); this.root.removeChild(a); setTimeout(() => URL.revokeObjectURL(url), 2000);
      this.ui.toast("Progress exported");
    }
    import_progress(input) {
      const f = input.files && input.files[0]; if (!f) return;
      const rd = new FileReader();
      rd.onload = () => {
        const ok = this.storage.import_json(String(rd.result || ""));
        if (ok) { this.apply_settings_all(); this.check_vehicle_unlocks(); this.ui.render_menu(this.storage, local_date_string()); this.ui.toast("Progress imported"); } else this.ui.toast("Invalid progress file");
        input.value = "";
      };
      rd.onerror = () => { this.ui.toast("Could not read file"); input.value = ""; };
      rd.readAsText(f);
    }
    confirm_reset(btn) {
      if (!this.reset_armed) {
        this.reset_armed = true; btn.textContent = "Click again to confirm";
        clearTimeout(this.ui.reset_timer); this.ui.reset_timer = setTimeout(() => { this.reset_armed = false; btn.textContent = "Reset progress"; }, 3500); return;
      }
      this.reset_armed = false; btn.textContent = "Reset progress"; this.storage.reset_game_data(); this.storage.touch_session(); this.apply_settings_all();
      this.ui.render_menu(this.storage, local_date_string()); this.ui.toast("Progress reset");
    }
    /* ---- teardown ---- */
    destroy() {
      if (this.destroyed) return; this.destroyed = true; this.stop_loop();
      try { this.ro.disconnect(); if (this.io) this.io.disconnect(); } catch (e) { /* ignore */ }
      document.removeEventListener("visibilitychange", this.h_vis); document.removeEventListener("fullscreenchange", this.h_fs);
      this.root.removeEventListener("click", this.h_click); this.root.removeEventListener("change", this.h_change); this.root.removeEventListener("input", this.h_change);
      this.input.detach(); this.audio.destroy(); this.scene.dispose();
      clearTimeout(this.ui.toast_timer); clearTimeout(this.ui.reset_timer);
    }
  }

  /* =====================================================================
   * BOOTSTRAP
   * ===================================================================== */
  const pp3d_api = { instance: null, booting: false };
  async function pp3d_init() {
    if (pp3d_api.instance || pp3d_api.booting) return;
    const root = document.getElementById(pp3d_config.root_id); if (!root) return;
    pp3d_api.booting = true;
    const note = root.querySelector("#pp3d-loading-text");
    try {
      const T = await import(pp3d_config.three_url);
      const g = new Pp3dGame(root, T); g.init(); pp3d_api.instance = g;
    } catch (err) {
      if (note) note.textContent = "Could not start the game (WebGL or network problem).";
      if (window.console) console.error("[Precision Parking 3D]", err);
    }
    pp3d_api.booting = false;
  }
  function pp3d_destroy() { if (pp3d_api.instance) { pp3d_api.instance.destroy(); pp3d_api.instance = null; } }
  window.PrecisionParking3D = { init: pp3d_init, destroy: pp3d_destroy };
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", pp3d_init); else pp3d_init();
})();
    </script>
    
    <style>
        /* ===== Precision Parking 3D — all selectors scoped to the game container / pp3d- prefix ===== */
#precision-parking-game{
    position:relative;display:block;width:100%;max-width:1100px;margin:0 auto;font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;color:#fff;line-height:1.25;-webkit-tap-highlight-color:transparent;outline:none;
    margin-top: 20px;
}
#precision-parking-game [hidden]{display:none!important}
#precision-parking-game .pp3d-frame,#precision-parking-game .pp3d-frame *{box-sizing:border-box}

.pp3d-frame{position:relative;width:100%;aspect-ratio:16/9;min-height:300px;max-height:82vh;overflow:hidden;background:#0c2033;border-radius:14px;box-shadow:0 8px 30px rgba(0,0,0,.35);user-select:none;-webkit-user-select:none;-webkit-touch-callout:none}
@media (max-width:720px) and (orientation:portrait){.pp3d-frame{aspect-ratio:3/4;max-height:88vh}}
@media (max-height:520px) and (orientation:landscape){.pp3d-frame{max-height:100vh;border-radius:0}}
#precision-parking-game:fullscreen{max-width:none;background:#000;display:flex;align-items:center}
#precision-parking-game:-webkit-full-screen{max-width:none;background:#000;display:flex;align-items:center}
#precision-parking-game:fullscreen .pp3d-frame{aspect-ratio:auto;height:100%;max-height:none;border-radius:0}
#precision-parking-game:-webkit-full-screen .pp3d-frame{aspect-ratio:auto;height:100%;max-height:none;border-radius:0}

.pp3d-canvas-wrap{position:absolute;inset:0;touch-action:none}
.pp3d-canvas{display:block;width:100%;height:100%;touch-action:none;outline:none}

.pp3d-loading{position:absolute;inset:0;z-index:50;display:flex;flex-direction:column;gap:14px;align-items:center;justify-content:center;background:#0c2033;font-weight:600;transition:opacity .4s}
.pp3d-loading.pp3d-done{opacity:0;pointer-events:none}
.pp3d-spinner{width:38px;height:38px;border-radius:50%;border:4px solid rgba(255,255,255,.2);border-top-color:#ffcc33;animation:pp3d-spin 1s linear infinite}
@keyframes pp3d-spin{to{transform:rotate(360deg)}}

/* Buttons (all:unset defeats host-site button styles) */
.pp3d-btn{all:unset;box-sizing:border-box;display:inline-flex;align-items:center;justify-content:center;gap:6px;cursor:pointer;font:600 16px/1.2 system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;color:#fff;text-align:center;padding:11px 18px;border-radius:12px;background:#223b55;border:2px solid rgba(255,255,255,.12);transition:transform .12s,background .15s,opacity .2s;-webkit-tap-highlight-color:transparent;touch-action:manipulation}
.pp3d-btn:hover{background:#2c4a6b}
.pp3d-btn:active{transform:scale(.96)}
.pp3d-btn:focus-visible{outline:3px solid #ffcc33;outline-offset:2px}
.pp3d-btn[disabled]{opacity:.45;cursor:not-allowed}
.pp3d-btn small{font-weight:500;opacity:.8}
.pp3d-btn-primary{background:linear-gradient(180deg,#ffd447,#f5a300);color:#2b1b00;border-color:#ffe38a;box-shadow:0 4px 0 #b97a00}
.pp3d-btn-primary:hover{background:linear-gradient(180deg,#ffe07a,#ffb81f)}
.pp3d-btn-secondary{background:#1c3550}
.pp3d-btn-danger{background:#7a1f2b}
.pp3d-btn-danger:hover{background:#a02838}
.pp3d-btn-big{font-size:22px;padding:15px 22px}
.pp3d-btn-sm{padding:7px 12px;font-size:14px}
.pp3d-iconbtn{width:42px;height:42px;padding:0;font-size:18px;background:rgba(10,24,40,.6);backdrop-filter:blur(4px)}
.pp3d-chipbtn{padding:7px 12px;font-size:14px;border-radius:20px}
.pp3d-chipbtn.pp3d-off{opacity:.55;text-decoration:line-through}

/* HUD */
.pp3d-hud{position:absolute;inset:0;z-index:10;pointer-events:none;opacity:0;transition:opacity .3s}
.pp3d-hud.pp3d-on{opacity:1}
.pp3d-hud-left{position:absolute;top:10px;left:10px;display:flex;flex-direction:column;gap:6px}
.pp3d-chip-row{display:flex;gap:6px}
.pp3d-chip{background:rgba(10,24,40,.62);backdrop-filter:blur(4px);border-radius:10px;padding:6px 10px;font-size:13px;font-weight:600;white-space:nowrap}
.pp3d-chip-level{font-size:14px}
.pp3d-chip-col.pp3d-flash{animation:pp3d-flash .6s}
@keyframes pp3d-flash{0%{background:#e63946;transform:scale(1.15)}100%{background:rgba(10,24,40,.62);transform:scale(1)}}
.pp3d-hud-center{position:absolute;top:10px;left:50%;transform:translateX(-50%)}
.pp3d-timer{background:rgba(10,24,40,.62);backdrop-filter:blur(4px);border-radius:12px;padding:6px 16px;font-size:24px;font-weight:800;font-variant-numeric:tabular-nums;letter-spacing:1px}
.pp3d-timer.pp3d-warn{color:#ff6b6b;animation:pp3d-pulse .8s infinite}
@keyframes pp3d-pulse{50%{transform:scale(1.08)}}
.pp3d-hud-right{position:absolute;top:10px;right:10px;display:flex;gap:6px;pointer-events:auto}
.pp3d-hud-bottom{position:absolute;left:50%;bottom:10px;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:6px}
.pp3d-speedo{display:flex;align-items:center;gap:10px;background:rgba(10,24,40,.62);backdrop-filter:blur(4px);border-radius:14px;padding:5px 14px;font-size:14px}
.pp3d-speedo b{font-size:22px;font-variant-numeric:tabular-nums}
.pp3d-gear{display:inline-block;min-width:26px;text-align:center;font-weight:800;background:#ffcc33;color:#2b1b00;border-radius:6px;padding:1px 6px}
.pp3d-hold{width:150px;height:8px;border-radius:6px;background:rgba(10,24,40,.6);overflow:hidden;opacity:0;transition:opacity .2s}
.pp3d-hold.pp3d-on{opacity:1}
.pp3d-hold-fill{height:100%;width:0;background:linear-gradient(90deg,#2ee59d,#9dff7a)}

.pp3d-banner{position:absolute;left:50%;top:22%;transform:translate(-50%,-10px);z-index:12;max-width:86%;text-align:center;background:rgba(10,24,40,.78);backdrop-filter:blur(5px);padding:10px 18px;border-radius:14px;font-weight:600;font-size:15px;opacity:0;pointer-events:none}
.pp3d-banner.pp3d-show{animation:pp3d-banner 4s ease forwards}
@keyframes pp3d-banner{0%{opacity:0;transform:translate(-50%,-10px)}10%,80%{opacity:1;transform:translate(-50%,0)}100%{opacity:0;transform:translate(-50%,-6px)}}
.pp3d-toast{position:absolute;left:50%;bottom:18%;transform:translateX(-50%);z-index:60;background:#2ee59d;color:#052b1d;font-weight:700;padding:9px 16px;border-radius:20px;opacity:0;pointer-events:none;transition:opacity .25s;max-width:90%;text-align:center}
.pp3d-toast.pp3d-show{opacity:1}

/* Touch controls */
.pp3d-touch{position:absolute;inset:0;z-index:11;pointer-events:none;touch-action:none}
.pp3d-touch *{touch-action:none;-webkit-touch-callout:none}
.pp3d-touch-left{position:absolute;left:12px;bottom:12px;display:flex;gap:12px;pointer-events:auto}
.pp3d-touch-right{position:absolute;right:12px;bottom:12px;display:flex;flex-direction:column;align-items:flex-end;gap:10px;pointer-events:auto}
.pp3d-touch-small{display:flex;gap:8px}
.pp3d-touch-pedals{display:flex;gap:12px}
.pp3d-touchbtn{width:clamp(58px,15vmin,96px);height:clamp(58px,15vmin,96px);padding:0;font-size:clamp(22px,6vmin,36px);border-radius:50%;background:rgba(10,24,40,.55);border:3px solid rgba(255,255,255,.35);backdrop-filter:blur(3px)}
.pp3d-touchbtn.pp3d-pressed{background:rgba(255,204,51,.75);transform:scale(.92)}
.pp3d-touchbtn-sm{width:clamp(40px,10vmin,56px);height:clamp(40px,10vmin,56px);font-size:clamp(16px,4vmin,22px)}
.pp3d-touchbtn-gas{background:rgba(46,229,157,.4)}
.pp3d-touchbtn-rev{background:rgba(230,57,70,.4)}

/* Screens */
.pp3d-screen{position:absolute;inset:0;z-index:30;display:flex;align-items:center;justify-content:center;padding:clamp(8px,2.5vmin,26px);background:rgba(7,18,32,.6);backdrop-filter:blur(3px);opacity:0;visibility:hidden;pointer-events:none;transition:opacity .3s,visibility .3s;overflow:auto;touch-action:pan-y}
.pp3d-screen.pp3d-is-active{opacity:1;visibility:visible;pointer-events:auto}
.pp3d-screen-menu{background:linear-gradient(90deg,rgba(7,18,32,.78) 0,rgba(7,18,32,.25) 60%,rgba(7,18,32,0) 100%);justify-content:flex-start;backdrop-filter:none}
.pp3d-screen-side{justify-content:flex-start;background:linear-gradient(90deg,rgba(7,18,32,.8) 0,rgba(7,18,32,.2) 70%,rgba(7,18,32,0) 100%);backdrop-filter:none}
@media (max-width:720px){.pp3d-screen-menu,.pp3d-screen-side{justify-content:center;background:rgba(7,18,32,.65)}}
.pp3d-card{display:flex;flex-direction:column;gap:12px;width:min(420px,100%);max-height:100%;overflow:auto;padding:clamp(14px,3vmin,24px);background:rgba(13,30,48,.92);border:1px solid rgba(255,255,255,.12);border-radius:18px;box-shadow:0 10px 40px rgba(0,0,0,.45);transform:translateY(14px) scale(.98);transition:transform .3s}
.pp3d-screen.pp3d-is-active .pp3d-card{transform:none}
.pp3d-card-wide{width:min(760px,100%)}
.pp3d-card-side{width:min(440px,100%)}
.pp3d-card-narrow{width:min(360px,100%)}
.pp3d-card-head{display:flex;align-items:center;justify-content:space-between;gap:10px}
.pp3d-h2{margin:0;padding:0;font-size:24px;font-weight:800;color:#fff;border:0}
.pp3d-h3{margin:4px 0 0;padding:0;font-size:14px;font-weight:700;color:#9fc3e6;text-transform:uppercase;letter-spacing:1px;border:0}
.pp3d-center{text-align:center}
.pp3d-dim{color:#9fb3c8;font-size:13px;margin:0}
.pp3d-note{margin:0;font-size:12px;color:#7f97ae;text-align:center}

.pp3d-logo{display:flex;flex-direction:column;align-items:center;line-height:1;padding:4px 0 2px}
.pp3d-logo-top{font-size:14px;letter-spacing:8px;color:#9fc3e6;font-weight:700}
.pp3d-logo-main{font-size:clamp(30px,6vmin,42px);font-weight:900;font-style:italic;background:linear-gradient(180deg,#fff,#ffcc33);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent}
.pp3d-logo-main i{color:#2ee59d;-webkit-text-fill-color:#2ee59d}
.pp3d-menu-stats{display:flex;flex-wrap:wrap;justify-content:center;gap:6px 14px;font-size:13px;color:#cfe3f6}
.pp3d-btn-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.pp3d-menu-toggles{display:flex;justify-content:center;gap:8px}

/* Levels */
.pp3d-level-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px;overflow:auto}
.pp3d-level-card{all:unset;box-sizing:border-box;cursor:pointer;display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 8px;border-radius:14px;background:#1c3550;border:2px solid rgba(255,255,255,.1);text-align:center;color:#fff;font:600 13px/1.2 system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;transition:transform .12s,background .15s}
.pp3d-level-card:hover{background:#2a4a6d;transform:translateY(-2px)}
.pp3d-level-card:focus-visible{outline:3px solid #ffcc33}
.pp3d-level-card.pp3d-locked{opacity:.4;cursor:not-allowed;transform:none}
.pp3d-level-num{font-size:26px;font-weight:900;color:#ffcc33}
.pp3d-level-stars{font-size:16px;letter-spacing:2px;color:#ffcc33}
.pp3d-star-off{color:#4a5f75}
.pp3d-level-meta{font-size:11px;color:#9fb3c8;font-weight:500}

/* Vehicles */
.pp3d-veh-list{display:flex;flex-direction:column;gap:8px}
.pp3d-veh-card{all:unset;box-sizing:border-box;cursor:pointer;display:grid;grid-template-columns:1fr auto;gap:4px 10px;padding:10px 12px;border-radius:14px;background:#1c3550;border:2px solid rgba(255,255,255,.1);color:#fff;font:600 14px/1.2 system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif}
.pp3d-veh-card:hover{background:#2a4a6d}
.pp3d-veh-card:focus-visible{outline:3px solid #ffcc33}
.pp3d-veh-card.pp3d-selected{border-color:#2ee59d;background:#1d4a49}
.pp3d-veh-card.pp3d-locked{opacity:.5;cursor:not-allowed}
.pp3d-veh-name{font-size:16px;font-weight:800}
.pp3d-veh-tag{font-size:12px;color:#ffcc33}
.pp3d-veh-bars{grid-column:1/3;display:grid;grid-template-columns:auto 1fr;gap:3px 8px;font-size:11px;color:#9fb3c8;font-weight:500;align-items:center}
.pp3d-bar{height:6px;border-radius:4px;background:rgba(255,255,255,.12);overflow:hidden}
.pp3d-bar>span{display:block;height:100%;background:linear-gradient(90deg,#2ee59d,#ffcc33)}
.pp3d-swatches{display:flex;flex-wrap:wrap;gap:8px}
.pp3d-swatch{all:unset;box-sizing:border-box;width:32px;height:32px;border-radius:50%;cursor:pointer;border:3px solid rgba(255,255,255,.25)}
.pp3d-swatch:focus-visible{outline:3px solid #ffcc33}
.pp3d-swatch.pp3d-selected{border-color:#fff;transform:scale(1.15)}

/* Settings form */
.pp3d-form{display:flex;flex-direction:column;gap:10px;overflow:auto}
.pp3d-row{display:flex;align-items:center;justify-content:space-between;gap:14px;font-size:14px;font-weight:600}
.pp3d-row-wrap{flex-wrap:wrap;justify-content:flex-start}
.pp3d-input{box-sizing:border-box;min-width:140px;max-width:55%;padding:8px 10px;border-radius:10px;border:2px solid rgba(255,255,255,.18);background:#12283d;color:#fff;font:500 14px system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;height:auto;margin:0}
.pp3d-range{min-width:140px;max-width:55%;margin:0;accent-color:#ffcc33}

/* Complete */
.pp3d-stars{display:flex;justify-content:center;gap:8px;font-size:48px;line-height:1}
.pp3d-stars span{color:#4a5f75;transform:scale(.3);opacity:0}
.pp3d-stars span.pp3d-on{color:#ffcc33;animation:pp3d-pop .5s forwards;text-shadow:0 0 18px rgba(255,204,51,.7)}
.pp3d-stars span.pp3d-off{animation:pp3d-pop .4s forwards}
@keyframes pp3d-pop{0%{transform:scale(.3);opacity:0}70%{transform:scale(1.25);opacity:1}100%{transform:scale(1);opacity:1}}
.pp3d-badge{align-self:center;background:#2ee59d;color:#052b1d;font-weight:800;border-radius:20px;padding:4px 14px;font-size:13px}
.pp3d-stats{width:100%;border-collapse:collapse;font-size:15px;margin:0}
.pp3d-stats td{padding:5px 4px;border:0;background:none;color:#fff}
.pp3d-stats td:nth-child(2){text-align:right}
.pp3d-stats td:nth-child(3){text-align:right;font-size:12px}

/* Ads (outside the frame; never over gameplay) */
.pp3d-ad{display:block;width:100%;min-height:90px;margin:10px 0;text-align:center;overflow:hidden}
.pp3d-ad-top{margin-top:0}

@media (prefers-reduced-motion:reduce){.pp3d-screen,.pp3d-card,.pp3d-btn{transition:none}.pp3d-banner.pp3d-show,.pp3d-timer.pp3d-warn{animation:none;opacity:1}}
    </style>

@endsection