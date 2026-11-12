<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LinkedOut</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  html, body { width: 100%; height: 100%; background: #000; overflow: hidden; font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif; }
  #wrap { position: absolute; left: 50%; top: 50%; width: 1920px; height: 1080px; transform-origin: center center; }
  #stage { position: relative; width: 1920px; height: 1080px; overflow: hidden; background: #000; }
  #world { position: absolute; inset: 0; }
  #bg { position: absolute; inset: 0; transform-origin: 50% 60%; filter: blur(1.6px) saturate(1.05); }
  #chars { position: absolute; inset: 0; transform-origin: 50% 60%; }
  #grade { position: absolute; inset: 0; pointer-events: none; mix-blend-mode: soft-light; }
  #bloom { position: absolute; inset: 0; pointer-events: none; mix-blend-mode: screen; background: radial-gradient(ellipse at 30% 20%, rgba(255,240,210,.14), transparent 55%); }
  #vignette { position: absolute; inset: 0; pointer-events: none; background: radial-gradient(ellipse at 50% 55%, rgba(0,0,0,0) 48%, rgba(0,0,0,.55) 100%); }
  #grain { position: absolute; inset: 0; pointer-events: none; opacity: .08; mix-blend-mode: overlay; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='240' height='240'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='2' stitchTiles='stitch'/></filter><rect width='100%25' height='100%25' filter='url(%23n)'/></svg>"); }

  .char { position: absolute; width: 240px; height: 480px; bottom: 150px; transform: translateX(-50%); }
  .char svg { width: 100%; height: 100%; overflow: visible; filter: drop-shadow(0 18px 16px rgba(0,0,0,.4)); }
  .char .tag { position: absolute; left: 50%; transform: translateX(-50%); bottom: -50px; white-space: nowrap; font-size: 19px; font-weight: 700; letter-spacing: 3px; color: #f2f5fb; background: rgba(8,12,22,.74); padding: 4px 16px; border-radius: 999px; border: 1px solid var(--accent); }
  .char .torso_g { transform-box: view-box; transform-origin: 120px 330px; animation: breathe 4.2s ease-in-out infinite; }
  .char .head_g { transform-box: view-box; transform-origin: 120px 182px; }
  .char .eye_g { transform-box: fill-box; transform-origin: center; animation: blink 5.5s infinite; }
  .char .mouth_in { transform-box: fill-box; transform-origin: center; }
  .char .jaw { transform-box: fill-box; transform-origin: center; }
  .char.talking .head_g { animation: headtalk 1.5s ease-in-out infinite; }
  .char.talking .mouth_in { animation: mouthopen .27s infinite alternate ease-in-out; }
  .char.talking .jaw { animation: jawmove .27s infinite alternate ease-in-out; }
  @keyframes breathe { 0%, 100% { transform: scaleY(1); } 50% { transform: scaleY(1.012); } }
  @keyframes blink { 0%, 94%, 100% { transform: scaleY(1); } 97% { transform: scaleY(.08); } }
  @keyframes headtalk { 0%, 100% { transform: rotate(-1deg) translateY(0); } 50% { transform: rotate(1.2deg) translateY(-1.5px); } }
  @keyframes mouthopen { from { transform: scaleY(1); } to { transform: scaleY(9); } }
  @keyframes jawmove { from { transform: translateY(0); } to { transform: translateY(4.5px); } }
  body.paused .char *, body.paused #flash { animation-play-state: paused !important; }

  .cap { position: absolute; left: 50%; bottom: 500px; transform: translateX(calc(-50% + var(--shift, 0px))); width: max-content; max-width: 860px; background: rgba(11,15,28,.93); color: #f4f6fb; font-size: 29px; line-height: 1.38; font-weight: 500; text-align: left; padding: 14px 28px 18px 24px; border-radius: 14px; border-left: 6px solid var(--accent); box-shadow: 0 12px 34px rgba(0,0,0,.5); opacity: 0; transition: opacity .25s; z-index: 10; --accent: #888; }
  .cap.on { opacity: 1; }
  .cap .who { display: block; font-size: 15px; font-weight: 700; letter-spacing: 3.5px; color: var(--accent); margin-bottom: 4px; }
  .cap::after { content: ""; position: absolute; left: calc(50% - var(--shift, 0px)); bottom: -13px; margin-left: -13px; border: 13px solid transparent; border-top-color: rgba(11,15,28,.93); border-bottom: 0; }

  #term { position: absolute; left: 330px; top: 16px; width: 1260px; height: 200px; background: rgba(5,10,18,.95); border: 1px solid rgba(110,200,160,.45); border-radius: 12px; box-shadow: 0 16px 50px rgba(0,0,0,.6), 0 0 40px rgba(60,200,140,.12); display: none; z-index: 5; overflow: hidden; }
  #term_bar { height: 34px; background: rgba(255,255,255,.06); border-bottom: 1px solid rgba(255,255,255,.07); display: flex; align-items: center; padding: 0 16px; gap: 8px; color: #8a97ad; font-size: 15px; letter-spacing: 1px; }
  #term_bar i { width: 11px; height: 11px; border-radius: 50%; display: inline-block; }
  #term_bar i:nth-child(1) { background: #ff5f57; } #term_bar i:nth-child(2) { background: #febc2e; } #term_bar i:nth-child(3) { background: #28c840; }
  #term_title { margin-left: 14px; }
  #term_body { position: absolute; left: 0; right: 0; top: 34px; bottom: 0; overflow: hidden; display: flex; align-items: flex-end; }
  #term_text { padding: 0 22px 10px; color: #7dffb8; font-family: 'Cascadia Mono', Consolas, 'Courier New', monospace; font-size: 19px; line-height: 26px; white-space: pre; width: 100%; overflow: hidden; text-shadow: 0 0 8px rgba(80,255,170,.35); }

  #slug { position: absolute; left: 56px; bottom: 44px; z-index: 15; opacity: 0; transition: opacity .6s; padding-left: 18px; border-left: 3px solid #35d0ba; color: #eef2fa; font-size: 28px; letter-spacing: 4px; font-weight: 600; text-shadow: 0 2px 10px rgba(0,0,0,.8); }
  #slug.show { opacity: 1; }

  #title_card { position: absolute; inset: 0; background: radial-gradient(ellipse at 50% 45%, #1a1512 0%, #070605 70%); color: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; opacity: 0; z-index: 20; padding: 0 200px; pointer-events: none; }
  #title_main { font-family: Georgia, 'Times New Roman', serif; font-size: 104px; font-weight: 700; letter-spacing: 16px; color: #f4efe6; text-transform: uppercase; }
  #title_rule { width: 140px; height: 2px; background: #35d0ba; margin: 34px 0 30px; }
  #title_sub { font-family: Georgia, 'Times New Roman', serif; font-size: 40px; font-style: italic; letter-spacing: 4px; color: #b9a98f; }
  #title_card.card #title_main { font-size: 54px; font-weight: 400; letter-spacing: 1px; line-height: 1.5; text-transform: none; max-width: 1400px; }
  #title_card.card #title_rule, #title_card.card #title_sub { display: none; }

  #credits { position: absolute; inset: 0; background: radial-gradient(ellipse at 50% 45%, #1a1512 0%, #050403 75%); overflow: hidden; display: none; z-index: 25; }
  #credits_inner { position: absolute; left: 0; width: 100%; text-align: center; color: #d6cbb8; font-family: Georgia, 'Times New Roman', serif; font-size: 38px; line-height: 1.8; padding: 0 200px; }
  #credits_inner h2 { font-size: 30px; font-weight: 400; color: #35d0ba; margin-top: 56px; letter-spacing: 8px; }

  #osd { position: absolute; right: 48px; top: 40px; color: #fff; font-size: 30px; font-weight: 600; letter-spacing: 1px; background: rgba(8,12,22,.78); border: 1px solid rgba(255,255,255,.18); padding: 12px 26px; border-radius: 999px; opacity: 0; transition: opacity .25s; z-index: 60; pointer-events: none; }
  #osd.show { opacity: 1; }

  #start_screen { position: absolute; inset: 0; background: radial-gradient(ellipse at 50% 45%, #1a1512 0%, #050403 72%); color: #fff; z-index: 50; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; text-align: center; }
  #start_screen h1 { font-family: Georgia, 'Times New Roman', serif; font-size: 112px; letter-spacing: 16px; font-weight: 700; color: #f4efe6; }
  #start_screen .rule { width: 140px; height: 2px; background: #35d0ba; margin: 34px 0 28px; }
  #start_screen h2 { font-family: Georgia, 'Times New Roman', serif; font-size: 40px; font-style: italic; letter-spacing: 5px; font-weight: 400; color: #b9a98f; }
  #start_screen p { margin-top: 90px; font-size: 24px; letter-spacing: 6px; color: #7d7466; text-transform: uppercase; line-height: 2; }
</style>
</head>
<body>
<div id="wrap">
  <div id="stage">
    <div id="world"><div id="bg"></div><div id="chars"></div></div>
    <div id="grade"></div>
    <div id="bloom"></div>
    <div id="vignette"></div>
    <div id="grain"></div>
    <div id="term"><div id="term_bar"><i></i><i></i><i></i><span id="term_title"></span></div><div id="term_body"><div id="term_text"></div></div></div>
    <div id="slug"></div>
    <div id="title_card"><div id="title_main"></div><div id="title_rule"></div><div id="title_sub"></div></div>
    <div id="credits"><div id="credits_inner"></div></div>
    <div id="osd"></div>
    <div id="start_screen"><h1>LINKEDOUT</h1><div class="rule"></div><h2>Everyone Fails</h2><p>Press Space to begin<br>Space pause &middot; &larr; &rarr; 10s &middot; M sound</p></div>
  </div>
</div>

<script>
(function (root) {
  var fig_uid = 0;

  function shade(hex, pct) {
    var n = parseInt(hex.slice(1), 16), r = n >> 16, g = (n >> 8) & 255, b = n & 255;
    var t = pct < 0 ? 0 : 255, p = Math.abs(pct) / 100;
    r = Math.round((t - r) * p + r); g = Math.round((t - g) * p + g); b = Math.round((t - b) * p + b);
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
  }
  function rnd(seed) { var x = Math.sin(seed * 127.1) * 43758.5453; return x - Math.floor(x); }
  function lerp(a, b, t) { return a + (b - a) * t; }
  function R(x, y, w, h, fill, ex) { return "<rect x='" + x + "' y='" + y + "' width='" + w + "' height='" + h + "' fill='" + fill + "'" + (ex ? " " + ex : "") + "/>"; }
  function C(cx, cy, r, fill, ex) { return "<circle cx='" + cx + "' cy='" + cy + "' r='" + r + "' fill='" + fill + "'" + (ex ? " " + ex : "") + "/>"; }
  function P(points, fill, ex) { return "<polygon points='" + points + "' fill='" + fill + "'" + (ex ? " " + ex : "") + "/>"; }
  function grad(id, stops, x2, y2) {
    var parts = stops.map(function (s) { return "<stop offset='" + s[0] + "' stop-color='" + s[1] + "'/>"; }).join("");
    return "<linearGradient id='" + id + "' x1='0' y1='0' x2='" + (x2 || 0) + "' y2='" + (y2 === undefined ? 1 : y2) + "'>" + parts + "</linearGradient>";
  }
  function radial(id, color, opacity) {
    return "<radialGradient id='" + id + "'><stop offset='0' stop-color='" + color + "' stop-opacity='" + opacity + "'/><stop offset='1' stop-color='" + color + "' stop-opacity='0'/></radialGradient>";
  }
  function svg_wrap(defs, inner) {
    return "<svg width='1920' height='1080' viewBox='0 0 1920 1080' preserveAspectRatio='xMidYMid slice' xmlns='http://www.w3.org/2000/svg'><defs>" + defs + "<filter id='bl'><feGaussianBlur stdDeviation='5'/></filter><filter id='bl2'><feGaussianBlur stdDeviation='2'/></filter></defs>" + inner + "</svg>";
  }
  function floor_lines(color, count, spread) {
    var s = "";
    for (var i = 0; i <= count; i++) {
      var x1 = -300 + i * (2520 / count);
      s += "<line x1='" + x1 + "' y1='1080' x2='" + (960 + (x1 - 960) * spread) + "' y2='890' stroke='" + color + "' stroke-width='2'/>";
    }
    return s;
  }

  /* ---------------- figure ---------------- */
  function build_figure(look) {
    fig_uid += 1;
    var u = "f" + fig_uid + "_";
    var skin = look.skin, hair = look.hair, top = look.top, top2 = look.top2 || "#f2f4f8", pants = look.pants || "#272b36";
    var female = !!look.female, outfit = look.outfit || "shirt";
    var lip = female ? "#b0555c" : shade(skin, -26);
    var defs =
      "<radialGradient id='" + u + "sk' cx='.4' cy='.35' r='.85'><stop offset='0' stop-color='" + shade(skin, 12) + "'/><stop offset='.65' stop-color='" + skin + "'/><stop offset='1' stop-color='" + shade(skin, -24) + "'/></radialGradient>" +
      "<linearGradient id='" + u + "tp' x1='0' y1='0' x2='1' y2='0'><stop offset='0' stop-color='" + shade(top, 14) + "'/><stop offset='.55' stop-color='" + top + "'/><stop offset='1' stop-color='" + shade(top, -26) + "'/></linearGradient>" +
      "<linearGradient id='" + u + "pn' x1='0' y1='0' x2='1' y2='0'><stop offset='0' stop-color='" + shade(pants, 10) + "'/><stop offset='1' stop-color='" + shade(pants, -22) + "'/></linearGradient>" +
      "<linearGradient id='" + u + "hr' x1='0' y1='0' x2='0' y2='1'><stop offset='0' stop-color='" + shade(hair, 22) + "'/><stop offset='.5' stop-color='" + hair + "'/><stop offset='1' stop-color='" + shade(hair, -22) + "'/></linearGradient>" +
      "<linearGradient id='" + u + "dp' x1='0' y1='0' x2='1' y2='1'><stop offset='0' stop-color='" + shade(look.dupatta || "#e8dcc6", 10) + "'/><stop offset='1' stop-color='" + shade(look.dupatta || "#e8dcc6", -22) + "'/></linearGradient>";
    var s = "";
    s += "<ellipse cx='120' cy='472' rx='92' ry='9' fill='rgba(0,0,0,.4)'/>";

    var long_outfit = outfit === "kurta", robe = outfit === "robe";
    if (!robe) {
      if (long_outfit) {
        s += "<path d='M74 388 L118 388 L116 462 L80 462 Z' fill='url(#" + u + "pn)'/><path d='M122 388 L166 388 L160 462 L124 462 Z' fill='url(#" + u + "pn)'/>";
      } else {
        s += "<path d='M84 322 L119 322 L117 460 L92 460 Z' fill='url(#" + u + "pn)'/><path d='M121 322 L156 322 L148 460 L123 460 Z' fill='url(#" + u + "pn)'/>";
        s += "<path d='M104 330 L104 452' stroke='rgba(0,0,0,.18)' stroke-width='2'/><path d='M138 330 L136 452' stroke='rgba(0,0,0,.18)' stroke-width='2'/>";
      }
    }
    s += "<path d='M84 458 L118 458 L120 470 Q102 477 80 472 Q78 463 84 458 Z' fill='#16181d'/><path d='M122 458 L156 458 Q162 463 160 472 Q138 477 120 470 Z' fill='#16181d'/>";
    s += "<path d='M86 462 Q100 460 114 462' stroke='rgba(255,255,255,.18)' stroke-width='2' fill='none'/><path d='M126 462 Q140 460 154 462' stroke='rgba(255,255,255,.18)' stroke-width='2' fill='none'/>";

    var sleeve = robe ? "#101114" : "url(#" + u + "tp)";
    var arm = robe
      ? "<path d='M64 200 Q40 212 36 250 L30 330 Q40 346 62 340 L80 262 L90 214 Z' fill='" + sleeve + "'/>"
      : "<path d='M68 200 Q50 208 48 236 L44 294 Q42 316 50 322 L72 320 L76 262 L86 214 Z' fill='" + sleeve + "' stroke='rgba(0,0,0,.22)' stroke-width='2'/>";
    var hand = "<path d='M48 316 Q44 338 50 348 Q58 356 66 350 Q72 340 70 318 Z' fill='" + skin + "'/><path d='M54 340 L55 350 M59 342 L60 352 M64 340 L65 350' stroke='rgba(0,0,0,.22)' stroke-width='1.5'/>";
    if (robe) { hand = "<path d='M38 338 Q36 352 44 358 Q54 362 62 356 Q66 346 62 338 Z' fill='" + skin + "'/>"; }
    var arm_g = "<g>" + arm + hand + "</g>";
    s += arm_g + "<g transform='translate(240,0) scale(-1,1)'>" + arm_g + "</g>";

    var torso = long_outfit ? "M66 204 Q70 184 100 178 L140 178 Q170 184 174 204 L188 394 Q120 408 52 394 Z"
      : robe ? "M60 202 Q66 182 100 176 L140 176 Q174 182 180 202 L200 452 Q120 466 40 452 Z"
      : "M66 204 Q70 184 100 178 L140 178 Q170 184 174 204 L182 322 Q120 338 58 322 Z";
    s += "<g class='torso_g'>";
    s += "<path d='" + torso + "' fill='" + (robe ? "#15161a" : "url(#" + u + "tp)") + "' stroke='rgba(0,0,0,.25)' stroke-width='2'/>";
    s += "<path d='M104 160 L104 188 Q120 198 136 188 L136 160 Z' fill='" + shade(skin, -6) + "'/>";

    if (outfit === "shirt") {
      s += "<path d='M98 176 L120 212 L106 216 L92 184 Z' fill='" + shade(top, 22) + "' stroke='rgba(0,0,0,.2)'/><path d='M142 176 L120 212 L134 216 L148 184 Z' fill='" + shade(top, 22) + "' stroke='rgba(0,0,0,.2)'/>";
      s += "<path d='M120 212 L120 324' stroke='rgba(0,0,0,.25)' stroke-width='2'/>" + C(120, 236, 2.4, "rgba(255,255,255,.55)") + C(120, 266, 2.4, "rgba(255,255,255,.55)") + C(120, 296, 2.4, "rgba(255,255,255,.55)");
      s += "<path d='M78 250 Q96 262 112 252' stroke='rgba(0,0,0,.12)' stroke-width='3' fill='none'/><path d='M130 270 Q150 280 166 268' stroke='rgba(0,0,0,.12)' stroke-width='3' fill='none'/>";
    } else if (outfit === "blazer") {
      s += "<path d='M104 178 L120 258 L136 178 Z' fill='" + top2 + "'/>";
      if (look.tie) { s += "<path d='M112 192 L128 192 L131 272 L120 286 L109 272 Z' fill='" + look.tie + "'/><path d='M112 188 L128 188 L126 200 L114 200 Z' fill='" + shade(look.tie, -20) + "'/>"; }
      s += "<path d='M98 178 L120 262 L92 308 L78 226 Z' fill='" + shade(top, -8) + "' stroke='rgba(0,0,0,.3)' stroke-width='2'/><path d='M142 178 L120 262 L148 308 L162 226 Z' fill='" + shade(top, -8) + "' stroke='rgba(0,0,0,.3)' stroke-width='2'/>";
      s += C(124, 300, 3, "rgba(0,0,0,.45)") + "<path d='M70 214 Q96 224 112 262' stroke='rgba(255,255,255,.1)' stroke-width='3' fill='none'/>";
    } else if (outfit === "hoodie") {
      s += "<path d='M84 190 Q120 166 156 190 Q150 214 120 216 Q90 214 84 190 Z' fill='" + shade(top, -26) + "'/><path d='M104 180 Q120 204 136 180 Z' fill='" + skin + "'/>";
      s += "<path d='M112 204 L110 250 M128 204 L130 250' stroke='#e6e6e6' stroke-width='2.4'/>" + C(110, 252, 3, "#d8d8d8") + C(130, 252, 3, "#d8d8d8");
      s += "<path d='M82 292 L158 292 L168 324 L72 324 Z' fill='" + shade(top, -12) + "' stroke='rgba(0,0,0,.22)' stroke-width='2'/>";
    } else if (outfit === "kurta") {
      s += "<path d='M120 178 L120 262' stroke='rgba(0,0,0,.3)' stroke-width='2.5'/>" + C(120, 214, 2.6, shade(top, 40)) + C(120, 240, 2.6, shade(top, 40)) + C(120, 266, 2.6, shade(top, 40));
      s += "<path d='M100 178 Q120 196 140 178' stroke='" + shade(top, 30) + "' stroke-width='5' fill='none'/><path d='M66 300 Q120 316 174 300' stroke='rgba(255,255,255,.12)' stroke-width='3' fill='none'/>";
    } else if (robe) {
      s += "<path d='M104 176 L120 238 L136 176 Z' fill='#f5f5f5'/><path d='M112 190 L120 236 M128 190 L120 236' stroke='rgba(0,0,0,.25)' stroke-width='1.5'/>";
      s += "<path d='M92 176 L120 330 L70 440 L66 220 Z' fill='rgba(255,255,255,.05)'/><path d='M120 240 L120 456' stroke='rgba(255,255,255,.08)' stroke-width='3'/>";
    }
    if (look.dupatta && !look.scarf) {
      s += "<path d='M70 196 Q96 188 122 216 Q132 254 118 340 L94 340 Q92 262 70 222 Z' fill='url(#" + u + "dp)' stroke='rgba(0,0,0,.18)'/><path d='M170 196 Q146 188 120 214 Q108 244 118 306 L142 306 Q150 252 170 222 Z' fill='url(#" + u + "dp)' stroke='rgba(0,0,0,.18)'/>";
      s += "<path d='M100 220 Q104 270 100 330 M138 228 Q132 266 134 300' stroke='rgba(0,0,0,.14)' stroke-width='2' fill='none'/>";
    } else if (look.dupatta && look.scarf) {
      s += "<path d='M64 200 Q96 188 120 214 Q144 188 176 200 L186 330 Q150 346 138 310 L120 250 L102 310 Q90 346 54 330 Z' fill='url(#" + u + "dp)' stroke='rgba(0,0,0,.18)'/><path d='M96 230 Q100 290 84 330 M144 230 Q140 290 156 330' stroke='rgba(0,0,0,.14)' stroke-width='2' fill='none'/>";
    }
    s += "<path d='" + torso + "' fill='url(#" + u + "tp)' opacity='.0'/>";
    s += "</g>";
    s += "<path d='M104 170 Q120 190 136 170 L136 178 Q120 196 104 178 Z' fill='rgba(0,0,0,.2)'/>";

    var back_hair = "", front_hair = "", st = look.hair_style;
    var hr = "url(#" + u + "hr)";
    if (st === "long") {
      back_hair = "<path d='M80 114 C72 58 100 48 122 48 C150 48 170 64 160 118 L168 226 Q152 238 148 202 L146 150 L94 150 L92 202 Q88 238 72 226 Z' fill='" + hr + "'/>";
      front_hair = "<path d='M84 116 C88 84 104 72 122 72 C142 72 158 84 156 116 C148 94 134 86 120 86 C106 86 94 94 84 116 Z' fill='" + hr + "'/><path d='M120 74 Q116 84 112 90' stroke='rgba(255,255,255,.12)' stroke-width='2' fill='none'/>";
    } else if (st === "bob") {
      back_hair = "<path d='M80 116 C72 58 100 50 122 50 C150 50 170 64 160 118 L162 172 Q150 180 146 162 L94 162 Q90 180 78 172 Z' fill='" + hr + "'/>";
      front_hair = "<path d='M82 120 C84 82 104 68 124 70 C146 72 158 90 158 120 C150 96 136 86 120 86 C104 86 90 96 82 120 Z' fill='" + hr + "'/><path d='M110 76 Q130 74 148 90' stroke='rgba(255,255,255,.14)' stroke-width='2.5' fill='none'/>";
    } else if (st === "short") {
      front_hair = "<path d='M82 116 C78 80 98 62 122 62 C148 62 164 80 158 116 C154 96 142 86 122 84 C102 86 88 96 82 116 Z' fill='" + hr + "'/><path d='M96 70 Q122 60 146 76' stroke='rgba(255,255,255,.16)' stroke-width='3' fill='none'/>";
    } else if (st === "side") {
      front_hair = "<path d='M82 118 C76 78 100 60 126 62 C154 64 166 88 158 118 C154 100 144 90 128 86 C110 84 94 90 82 118 Z' fill='" + hr + "'/><path d='M100 66 Q116 86 90 104' stroke='rgba(0,0,0,.25)' stroke-width='2' fill='none'/><path d='M104 66 Q136 60 152 80' stroke='rgba(255,255,255,.16)' stroke-width='3' fill='none'/>";
    } else if (st === "crop") {
      front_hair = "<path d='M84 112 C82 84 100 70 122 70 C144 70 160 84 158 112 C152 94 140 88 122 88 C104 88 90 94 84 112 Z' fill='" + hr + "'/>";
    } else if (st === "scarf") {
      var dp = "url(#" + u + "dp)";
      back_hair = "<path d='M76 132 C68 62 98 44 122 44 C152 44 174 64 166 134 C164 160 152 176 154 204 L88 204 C90 176 78 160 76 132 Z' fill='" + dp + "' stroke='rgba(0,0,0,.2)'/>";
      front_hair = "<path d='M88 120 C90 92 106 78 122 78 C140 78 154 92 154 120 C148 100 136 92 121 92 C106 92 94 100 88 120 Z' fill='" + shade(look.dupatta || "#e8dcc6", -14) + "'/>";
    }

    var h = "<g class='head_g'>" + back_hair;
    h += "<ellipse cx='84' cy='126' rx='7' ry='13' fill='" + skin + "'/><ellipse cx='84' cy='127' rx='3.5' ry='8' fill='rgba(0,0,0,.16)'/><ellipse cx='156' cy='126' rx='7' ry='13' fill='" + skin + "'/><ellipse cx='156' cy='127' rx='3.5' ry='8' fill='rgba(0,0,0,.16)'/>";
    h += "<path d='M84 118 C84 86 100 72 120 72 C140 72 156 86 156 118 C156 148 144 174 120 178 C96 174 84 148 84 118 Z' fill='url(#" + u + "sk)' stroke='rgba(0,0,0,.14)' stroke-width='1.5'/>";
    if (female) { h += "<ellipse cx='96' cy='144' rx='9' ry='5' fill='rgba(214,92,100,.14)'/><ellipse cx='144' cy='144' rx='9' ry='5' fill='rgba(214,92,100,.14)'/>"; }
    if (look.old) { h += "<path d='M98 92 Q120 86 142 92 M100 98 Q120 93 140 98' stroke='rgba(0,0,0,.12)' stroke-width='1.6' fill='none'/><path d='M96 134 Q100 140 98 146 M144 134 Q140 140 142 146' stroke='rgba(0,0,0,.12)' stroke-width='1.5' fill='none'/>"; }
    var bc = look.beard_color || hair;
    if (look.beard === "full") { h += "<path d='M84 128 Q86 178 120 186 Q154 178 156 128 Q150 152 138 158 Q120 148 102 158 Q90 152 84 128 Z' fill='" + bc + "' opacity='.95'/>"; }
    if (look.beard === "stubble") { h += "<path d='M86 132 Q90 176 120 184 Q150 176 154 132 Q148 154 138 158 Q120 150 102 158 Q92 154 86 132 Z' fill='" + bc + "' opacity='.38'/>"; }
    if (look.beard === "full" || look.beard === "stubble") { h += "<path d='M104 152 Q112 147 120 150 Q128 147 136 152 Q128 156 120 154 Q112 156 104 152 Z' fill='" + bc + "' opacity='" + (look.beard === "full" ? 1 : 0.55) + "'/>"; }
    var iris = look.iris || "#3b2a1d";
    [103, 137].forEach(function (cx) {
      h += "<g class='eye_g'><ellipse cx='" + cx + "' cy='120' rx='7.6' ry='4.7' fill='#f3efe9'/>" + C(cx, 120.4, 3.7, iris) + C(cx, 120.4, 1.9, "#0b0b0b") + C(cx - 1.2, 119.2, 0.9, "#fff") + "</g>";
      h += "<path d='M" + (cx - 8) + " 120 Q" + cx + " " + (female ? 112 : 113.5) + " " + (cx + 8) + " 120' stroke='rgba(20,10,10," + (female ? 0.85 : 0.6) + ")' stroke-width='" + (female ? 2.4 : 1.7) + "' fill='none' stroke-linecap='round'/>";
      h += "<path d='M" + (cx - 7) + " 114 Q" + cx + " 109 " + (cx + 7) + " 114' stroke='rgba(0,0,0,.16)' stroke-width='1.4' fill='none'/>";
    });
    h += "<path d='M93 109 Q103 103 113 108' stroke='" + hair + "' stroke-width='" + (female ? 3 : 3.8) + "' fill='none' stroke-linecap='round'/><path d='M127 108 Q137 103 147 109' stroke='" + hair + "' stroke-width='" + (female ? 3 : 3.8) + "' fill='none' stroke-linecap='round'/>";
    h += "<path d='M120 118 L120 138' stroke='rgba(255,255,255,.13)' stroke-width='3' fill='none'/><path d='M112 122 Q108 138 114 145' stroke='rgba(0,0,0,.14)' stroke-width='2' fill='none'/><path d='M114 145 Q120 151 126 145' stroke='rgba(0,0,0,.32)' stroke-width='1.8' fill='none'/><ellipse cx='116.5' cy='145.5' rx='1.6' ry='1' fill='rgba(0,0,0,.35)'/><ellipse cx='123.5' cy='145.5' rx='1.6' ry='1' fill='rgba(0,0,0,.35)'/>";
    h += "<ellipse class='mouth_in' cx='120' cy='159' rx='8' ry='0.6' fill='#35100f'/>";
    h += "<path d='M106 158 Q113 152 120 155 Q127 152 134 158 Q127 159.5 120 159 Q113 159.5 106 158 Z' fill='" + lip + "'/>";
    h += "<g class='jaw'><path d='M107 159 Q120 170 133 159 Q120 164 107 159 Z' fill='" + shade(lip, 12) + "'/></g>";
    if (look.glasses) {
      h += "<rect x='88' y='108' width='30' height='23' rx='8' fill='rgba(190,215,255,.1)' stroke='#17171b' stroke-width='2.6'/><rect x='122' y='108' width='30' height='23' rx='8' fill='rgba(190,215,255,.1)' stroke='#17171b' stroke-width='2.6'/>";
      h += "<path d='M118 117 Q120 115 122 117' stroke='#17171b' stroke-width='2.4' fill='none'/><path d='M88 116 L82 114 M152 116 L158 114' stroke='#17171b' stroke-width='2.4'/><path d='M93 112 L100 126 M127 112 L134 126' stroke='rgba(255,255,255,.3)' stroke-width='2.4'/>";
    }
    h += front_hair + "</g>";
    s += h;
    return "<svg viewBox='0 0 240 480' xmlns='http://www.w3.org/2000/svg'><defs>" + defs + "</defs>" + s + "</svg>";
  }

  /* ---------------- backgrounds ---------------- */
  function bg_cafe() {
    var defs = grad("w", [[0, "#e3d6c4"], [1, "#c4b29b"]]) + grad("fl", [[0, "#92704f"], [1, "#5a432e"]]) + grad("sk", [[0, "#bfe0f6"], [1, "#f4fbff"]]) + radial("lg", "#ffd9a0", 0.6) +
      "<clipPath id='wc'><rect x='110' y='90' width='820' height='640'/></clipPath><pattern id='brick' width='80' height='36' patternUnits='userSpaceOnUse'><rect width='80' height='36' fill='#a85d44'/><path d='M0 18H80M40 0V18M0 18V36M0 36H80' stroke='#7e4331' stroke-width='3' fill='none'/></pattern>";
    var s = R(0, 0, 1920, 890, "url(#w)") + R(980, 0, 940, 890, "url(#brick)") + R(980, 0, 940, 890, "rgba(0,0,0,.2)");
    s += R(110, 90, 820, 640, "url(#sk)") + "<g clip-path='url(#wc)' filter='url(#bl)'>";
    for (var i = 0; i < 16; i++) { s += C(120 + i * 55, 560 - rnd(i) * 140, 60 + rnd(i + 4) * 50, ["#4f8a4a", "#3f7a3f", "#5f9a55", "#2f6a38"][i % 4]); }
    s += "</g>" + R(383, 90, 12, 640, "#f5f1ea") + R(656, 90, 12, 640, "#f5f1ea") + R(110, 410, 820, 12, "#f5f1ea") + "<rect x='110' y='90' width='820' height='640' fill='none' stroke='#8c7a66' stroke-width='10'/>" + R(96, 730, 848, 18, "#b9a58c");
    s += P("150,90 520,90 940,890 300,890", "rgba(255,240,210,.13)");
    [300, 480].forEach(function (y) {
      s += R(1090, y, 720, 14, "#5a432e");
      for (var k = 0; k < 6; k++) { var bx = 1110 + k * 112; if (k % 2) { s += R(bx, y - 70, 60, 70, "#7a5a45") + "<ellipse cx='" + (bx + 30) + "' cy='" + (y - 90) + "' rx='42' ry='36' fill='#3f8a4d'/>" + "<ellipse cx='" + (bx + 14) + "' cy='" + (y - 116) + "' rx='22' ry='34' fill='#4aa05a'/>"; } else { for (var b = 0; b < 5; b++) { s += R(bx + b * 16, y - 60 - rnd(k * 5 + b) * 30, 13, 60 + rnd(k * 5 + b) * 30, ["#c0553a", "#2f5f8a", "#d9b24a", "#4a7a55", "#7a4a6a"][b]); } } }
    });
    [1180, 1520, 1800].forEach(function (x) { s += "<line x1='" + x + "' y1='0' x2='" + x + "' y2='130' stroke='#222' stroke-width='3'/>" + C(x, 190, 160, "url(#lg)") + "<path d='M" + (x - 34) + " 168 Q" + x + " 112 " + (x + 34) + " 168 Z' fill='#2d2d2d'/>"; });
    [[420, 6], [1500, 8]].forEach(function (t) { s += "<ellipse cx='" + t[0] + "' cy='812' rx='160' ry='24' fill='#6b4a30'/>" + R(t[0] - 10, 830, 20, 60, "#3a2818") + P((t[0] - 40) + ",800 " + (t[0] + 40) + ",800 " + (t[0] + 34) + ",766 " + (t[0] - 34) + ",766", "#2a2d36") + R(t[0] + 70, 786, 24, 20, "#f3f0ea"); });
    s += R(0, 890, 1920, 190, "url(#fl)") + floor_lines("rgba(0,0,0,.26)", 22, 0.8) + P("0,890 1920,890 1920,930 0,930", "rgba(255,255,255,.08)");
    return svg_wrap(defs, s);
  }
  function bg_home() {
    var defs = grad("w", [[0, "#3b3036"], [1, "#241c22"]]) + grad("n", [[0, "#0d1a33"], [1, "#2a2f55"]]) + grad("fl", [[0, "#4a3426"], [1, "#2a1d15"]]) + radial("lg", "#ffd9a0", 0.65);
    var s = R(0, 0, 1920, 890, "url(#w)") + R(1240, 120, 520, 600, "url(#n)");
    s += "<g filter='url(#bl2)'>";
    for (var i = 0; i < 70; i++) { s += R(1250 + rnd(i) * 500, 400 + rnd(i + 9) * 300, 6 + rnd(i + 3) * 10, 8 + rnd(i + 5) * 22, rnd(i + 2) > 0.5 ? "#ffd88a" : "#9ec3ff", "opacity='.8'"); }
    s += "</g><rect x='1240' y='120' width='520' height='600' fill='none' stroke='#5a4a52' stroke-width='10'/>" + R(1495, 120, 10, 600, "#5a4a52");
    s += R(1180, 90, 90, 660, "#6a4a52") + R(1730, 90, 90, 660, "#6a4a52");
    for (var f = 0; f < 5; f++) { s += R(1190 + f * 16, 90, 3, 660, "rgba(0,0,0,.2)") + R(1740 + f * 16, 90, 3, 660, "rgba(0,0,0,.2)"); }
    s += R(80, 560, 700, 150, "#5d4a54", "rx='30'") + R(60, 640, 740, 240, "#6a5560", "rx='40'") + R(110, 600, 280, 120, "#7a6470", "rx='22'") + R(440, 600, 280, 120, "#7a6470", "rx='22'");
    s += R(300, 230, 170, 220, "#e8dcc6", "stroke='#2a1f1c' stroke-width='10'") + R(330, 260, 110, 160, "#c0553a") + C(385, 340, 36, "#f0b45a");
    s += R(520, 280, 120, 90, "#d8cdb6", "stroke='#2a1f1c' stroke-width='8'") + R(540, 300, 80, 50, "#4a6a8a");
    s += C(960, 520, 300, "url(#lg)") + "<line x1='960' y1='580' x2='960' y2='880' stroke='#222' stroke-width='6'/>" + P("910,590 1010,590 990,520 930,520", "#f3d9a8") + R(920, 872, 80, 14, "#222");
    s += R(0, 890, 1920, 190, "url(#fl)") + floor_lines("rgba(0,0,0,.28)", 22, 0.8) + "<ellipse cx='960' cy='990' rx='760' ry='70' fill='#7a3b3b' opacity='.55'/>" + R(780, 800, 360, 24, "#3a2418") + R(800, 824, 16, 60, "#2a1810") + R(1104, 824, 16, 60, "#2a1810");
    return svg_wrap(defs, s);
  }
  function bg_vc() {
    var defs = grad("sk", [[0, "#243a6b"], [0.6, "#8a74a6"], [1, "#f4a574"]]) + grad("fl", [[0, "#242a38"], [1, "#12151d"]]) + radial("sun", "#ffd0a0", 0.8);
    var s = R(0, 0, 1920, 890, "#171c2a") + R(100, 60, 1720, 760, "url(#sk)") + C(960, 700, 420, "url(#sun)");
    s += "<g opacity='.55'>"; for (var i = 0; i < 20; i++) { var h = 120 + rnd(i) * 300; s += R(100 + i * 88, 800 - h, 70, h, "#56628a"); } s += "</g>";
    for (var j = 0; j < 14; j++) { var h2 = 160 + rnd(j + 20) * 360; s += R(100 + j * 125, 800 - h2, 100, h2, "#1d2440"); for (var w = 0; w < 14; w++) { if (rnd(j * 20 + w) > 0.55) { s += R(110 + j * 125 + (w % 4) * 22, 800 - h2 + 16 + Math.floor(w / 4) * 34, 10, 14, "#ffd88a", "opacity='.85'"); } } }
    for (var m = 0; m <= 8; m++) { s += R(100 + m * 215 - 4, 60, 8, 760, "#10131c"); }
    s += "<rect x='100' y='60' width='1720' height='760' fill='none' stroke='#10131c' stroke-width='10'/>" + R(100, 800, 1720, 20, "#10131c");
    s += R(0, 890, 1920, 190, "url(#fl)") + P("160,780 1760,780 1840,880 80,880", "#2f3446") + P("160,780 1760,780 1750,792 170,792", "rgba(255,255,255,.2)");
    [260, 560, 860, 1160, 1460].forEach(function (x) { s += R(x, 700, 120, 100, "#1a1e2a", "rx='26'"); });
    s += P("0,890 1920,890 1920,930 0,930", "rgba(255,255,255,.05)");
    return svg_wrap(defs, s);
  }
  function bg_startup() {
    var defs = grad("w", [[0, "#2a3340"], [1, "#171c25"]]) + grad("fl", [[0, "#2c3038"], [1, "#16181d"]]) + radial("lg", "#ffd88a", 0.7);
    var s = R(0, 0, 1920, 890, "url(#w)") + R(330, 110, 700, 400, "#f3f5f7", "stroke='#9aa4b2' stroke-width='10'");
    s += R(370, 160, 150, 70, "none", "stroke='#2f6fd0' stroke-width='5'") + R(600, 160, 150, 70, "none", "stroke='#d0412f' stroke-width='5'") + R(830, 160, 150, 70, "none", "stroke='#2f9a5a' stroke-width='5'");
    s += "<path d='M520 195 L600 195 M750 195 L830 195 M445 230 L445 330 M675 230 L675 330' stroke='#444' stroke-width='4' fill='none'/><path d='M380 380 Q520 330 640 400 T960 360' stroke='#d0412f' stroke-width='5' fill='none'/>" + R(380, 430, 220, 12, "#aab", "") + R(380, 460, 340, 12, "#aab", "");
    for (var r = 0; r < 4; r++) { for (var c = 0; c < 6; c++) { s += R(1180 + c * 86, 150 + r * 86, 74, 74, ["#ffd24a", "#ff8aa8", "#7be0a8", "#8ac4ff"][(r + c) % 4], "transform='rotate(" + ((r * 7 + c * 3) % 6 - 3) + " " + (1217 + c * 86) + " " + (187 + r * 86) + ")'"); } }
    s += "<path d='M0 60 Q480 150 960 60 T1920 60' stroke='#111' stroke-width='3' fill='none'/>";
    for (var b = 0; b < 12; b++) { var bx = b * 160 + 40, by = 60 + Math.sin(b * 0.9) * 50 + 30; s += C(bx, by, 90, "url(#lg)", "opacity='.55'") + C(bx, by, 9, "#fff0c0"); }
    [[170, 0], [1000, 1]].forEach(function (d) { s += R(d[0], 796, 640, 20, "#c9b79c") + R(d[0] + 20, 816, 14, 74, "#6a5a45") + R(d[0] + 606, 816, 14, 74, "#6a5a45"); [60, 360].forEach(function (mx) { s += R(d[0] + mx, 640, 220, 150, "#0b1220", "stroke='#4a5668' stroke-width='6'"); for (var l = 0; l < 6; l++) { s += R(d[0] + mx + 16, 654 + l * 21, 40 + rnd(l * 3 + mx) * 130, 8, ["#6fb3ff", "#7dffb8", "#ffd88a"][l % 3], "opacity='.8'"); } s += R(d[0] + mx + 100, 790, 20, 8, "#4a5668"); }); });
    s += R(0, 890, 1920, 190, "url(#fl)") + P("0,890 1920,890 1920,930 0,930", "rgba(255,255,255,.05)");
    return svg_wrap(defs, s);
  }
  function bg_lawfirm() {
    var defs = grad("w", [[0, "#4a3322"], [1, "#2a1c12"]]) + grad("sk", [[0, "#cfe0ee"], [1, "#f4f8fb"]]) + grad("fl", [[0, "#3a2c2c"], [1, "#1e1616"]]) + radial("lg", "#9be0a0", 0.5);
    var s = R(0, 0, 1920, 890, "url(#w)");
    [[0, 520], [1400, 520]].forEach(function (sh) {
      s += R(sh[0], 40, sh[1], 850, "#33220f");
      for (var r = 0; r < 6; r++) { var x = sh[0] + 14; while (x < sh[0] + sh[1] - 30) { var bw = 18 + rnd(r * 40 + x) * 20, bh = 90 + rnd(r * 90 + x) * 50; s += R(x, 40 + (r + 1) * 140 - bh, bw, bh, ["#7a2a2a", "#2a4a6a", "#5a3a1a", "#2f5a3a", "#8a6a2a", "#4a2a4a"][Math.floor(rnd(x + r) * 6)]); x += bw + 2; } s += R(sh[0], 40 + (r + 1) * 140, sh[1], 8, "#5a3d22"); }
    });
    s += R(600, 110, 720, 600, "url(#sk)");
    for (var k = 0; k < 28; k++) { s += R(600, 110 + k * 22, 720, 10, "rgba(120,100,70,.5)"); }
    s += "<rect x='600' y='110' width='720' height='600' fill='none' stroke='#2a1c12' stroke-width='12'/>" + P("640,110 960,110 1100,890 520,890", "rgba(255,245,220,.1)");
    s += R(700, 740, 520, 30, "#3a2616") + C(1140, 640, 110, "url(#lg)") + "<path d='M1110 700 Q1140 620 1170 700Z' fill='#1f5a36'/>" + R(1134, 700, 12, 40, "#c9a64a");
    s += R(560, 760, 800, 26, "#3a2616") + R(560, 786, 800, 100, "#2a1a0c");
    s += R(0, 890, 1920, 190, "url(#fl)") + P("0,890 1920,890 1920,930 0,930", "rgba(255,255,255,.05)");
    return svg_wrap(defs, s);
  }
  function bg_court() {
    var defs = grad("w", [[0, "#e4d8c2"], [1, "#c9b99a"]]) + grad("wd", [[0, "#6b4a30"], [1, "#3e2918"]]) + grad("fl", [[0, "#2c3a3c"], [1, "#171f20"]]);
    var s = R(0, 0, 1920, 440, "url(#w)") + R(0, 440, 1920, 450, "url(#wd)");
    for (var p = 0; p < 15; p++) { s += R(p * 130 + 20, 470, 100, 390, "none", "stroke='rgba(0,0,0,.35)' stroke-width='4'") + R(p * 130 + 36, 490, 68, 350, "none", "stroke='rgba(255,255,255,.08)' stroke-width='3'"); }
    s += R(0, 430, 1920, 16, "#2a1a0c");
    s += C(960, 230, 86, "#c8a64a") + C(960, 230, 66, "#9a7a2a", "stroke='#e6cf80' stroke-width='4'") + "<path d='M960 184 L972 220 L1010 220 L980 242 L992 278 L960 256 L928 278 L940 242 L910 220 L948 220 Z' fill='#e6cf80'/>";
    s += "<line x1='260' y1='80' x2='260' y2='880' stroke='#b9a05a' stroke-width='10'/>" + C(260, 72, 14, "#e6cf80");
    for (var f = 0; f < 7; f++) { s += R(270, 120 + f * 24, 230, 24, f % 2 ? "#f4f4f4" : "#b82a2f"); } s += R(270, 120, 100, 96, "#22308a");
    s += "<line x1='1660' y1='80' x2='1660' y2='880' stroke='#b9a05a' stroke-width='10'/>" + C(1660, 72, 14, "#e6cf80") + R(1450, 120, 210, 160, "#22308a") + C(1555, 200, 38, "#e6cf80", "opacity='.8'");
    s += R(600, 560, 720, 330, "#4a2f1c", "stroke='#2a1a0c' stroke-width='6'") + R(580, 540, 760, 28, "#6a4529") + R(640, 600, 640, 250, "none", "stroke='rgba(255,255,255,.1)' stroke-width='4'") + R(940, 600, 4, 250, "rgba(0,0,0,.35)");
    for (var l = 0; l < 9; l++) { s += C(200 + l * 190, 36, 22, "rgba(255,240,200,.9)", "filter='url(#bl2)'"); }
    s += R(0, 890, 1920, 190, "url(#fl)") + P("0,890 1920,890 1920,930 0,930", "rgba(255,255,255,.05)");
    return svg_wrap(defs, s);
  }
  function bg_steps() {
    var defs = grad("sk", [[0, "#7fbdf0"], [1, "#e8f4fc"]]) + grad("fl", [[0, "#aaa79f"], [1, "#74726d"]]);
    var s = R(0, 0, 1920, 890, "url(#sk)") + "<g opacity='.85'><ellipse cx='400' cy='170' rx='220' ry='44' fill='#fff'/><ellipse cx='560' cy='140' rx='140' ry='36' fill='#fff'/><ellipse cx='1500' cy='230' rx='260' ry='46' fill='#fff'/></g>";
    s += P("360,330 960,160 1560,330", "#d8d4c8", "stroke='#a9a598' stroke-width='6'") + R(340, 330, 1240, 60, "#cfcabd") + R(340, 390, 1240, 20, "#bdb8aa");
    for (var c = 0; c < 8; c++) { var cx = 400 + c * 160; s += R(cx, 410, 70, 300, "#e6e2d6") + R(cx - 10, 400, 90, 20, "#d3cec0") + R(cx - 10, 700, 90, 20, "#d3cec0") + R(cx + 14, 420, 4, 280, "rgba(0,0,0,.1)") + R(cx + 34, 420, 4, 280, "rgba(0,0,0,.1)") + R(cx + 54, 420, 4, 280, "rgba(0,0,0,.1)"); }
    s += R(340, 720, 1240, 50, "#c2beb2");
    for (var st = 0; st < 5; st++) { s += R(300 - st * 40, 770 + st * 24, 1320 + st * 80, 24, st % 2 ? "#d0ccc0" : "#c4c0b4"); }
    s += R(0, 890, 1920, 190, "url(#fl)") + "<line x1='0' y1='890' x2='1920' y2='890' stroke='rgba(0,0,0,.2)' stroke-width='3'/>" + floor_lines("rgba(0,0,0,.14)", 14, 0.9);
    return svg_wrap(defs, s);
  }
  function bg_conf() {
    var defs = grad("w", [[0, "#e8e3d8"], [1, "#cfc8b8"]]) + grad("sk", [[0, "#cfe5f5"], [1, "#fafdff"]]) + grad("fl", [[0, "#69767e"], [1, "#3a444a"]]);
    var s = R(0, 0, 1920, 890, "url(#w)") + R(180, 110, 760, 520, "url(#sk)");
    for (var k = 0; k < 26; k++) { s += R(180, 110 + k * 20, 760, 9, "rgba(210,200,175,.8)"); }
    s += "<rect x='180' y='110' width='760' height='520' fill='none' stroke='#8a8372' stroke-width='10'/>" + P("260,110 640,110 880,890 380,890", "rgba(255,255,255,.12)");
    s += R(1120, 150, 560, 340, "#fafafa", "stroke='#9aa4b2' stroke-width='10'") + "<path d='M1170 230 L1400 230 M1170 290 L1500 290 M1170 350 L1350 350' stroke='#2f6fd0' stroke-width='6'/>" + R(1560, 190, 70, 70, "#ffd24a");
    [300, 560, 820, 1080, 1340, 1600].forEach(function (x) { s += R(x, 690, 110, 110, "#2c333a", "rx='24'"); });
    s += R(160, 790, 1600, 24, "#7a5a3d") + R(160, 814, 1600, 76, "#4a3622") + R(900, 740, 40, 52, "#bcd8e8", "opacity='.8'");
    s += R(0, 890, 1920, 190, "url(#fl)") + P("0,890 1920,890 1920,930 0,930", "rgba(255,255,255,.05)");
    return svg_wrap(defs, s);
  }

  var set_table = {
    cafe: { fn: bg_cafe, tint: "rgba(255,210,150,.2)" },
    home: { fn: bg_home, tint: "rgba(255,170,100,.22)" },
    vc: { fn: bg_vc, tint: "rgba(120,120,220,.22)" },
    startup: { fn: bg_startup, tint: "rgba(80,140,255,.2)" },
    lawfirm: { fn: bg_lawfirm, tint: "rgba(255,190,110,.2)" },
    court: { fn: bg_court, tint: "rgba(255,210,140,.18)" },
    steps: { fn: bg_steps, tint: "rgba(255,240,200,.18)" },
    conf: { fn: bg_conf, tint: "rgba(150,190,230,.2)" }
  };

  root.lo_lib = { build_figure: build_figure, set_table: set_table, shade: shade };
  if (typeof module !== "undefined") { module.exports = root.lo_lib; }
})(typeof window !== "undefined" ? window : globalThis);

</script>
<script>
var movie_data = {
  timing: {
    base_line_ms: 2200, per_char_ms: 58, gap_ms: 450,
    intro_ms: 2800, outro_pause_ms: 600, fade_ms: 800,
    title_hold_ms: 4200, title_total_ms: 5000,
    card_hold_ms: 5200, card_total_ms: 6000,
    credits_scroll_ms: 80000, credits_total_ms: 81000
  },

  people: {
    hamza: { name: "ETHAN", accent: "#35d0ba", skin: "#ecc19c", hair: "#5a3d28", hair_style: "side", outfit: "shirt", top: "#4d6b8f", pants: "#2a2f3a", beard: "stubble", voice: { gender: "m", pitch: 1.0, rate: 1.0, lang: ["en-GB", "en-US"] } },
    areeba: { name: "CLAIRE", accent: "#ff7a90", skin: "#efc9a4", hair: "#6b4a2e", hair_style: "long", outfit: "blazer", top: "#8a3b4a", top2: "#f4f4f6", pants: "#2c2f3a", female: true, glasses: true, iris: "#4a6a8a", voice: { gender: "f", pitch: 1.12, rate: 1.03, lang: ["en-GB", "en-US"] } },
    bilal: { name: "RYAN", accent: "#ffb454", skin: "#f0cfae", hair: "#2a1d14", hair_style: "short", outfit: "hoodie", top: "#4b7a5e", pants: "#2c3b57", beard: "full", voice: { gender: "m", pitch: 0.82, rate: 1.06, lang: ["en-GB", "en-US"] } },
    saira: { name: "RACHEL", accent: "#b58cff", skin: "#8a5a3c", hair: "#140e0b", hair_style: "bob", outfit: "blazer", top: "#26335a", top2: "#f4f4f6", pants: "#26335a", female: true, voice: { gender: "f", pitch: 0.95, rate: 0.98, lang: ["en-GB", "en-US"] } },
    whitmore: { name: "WHITMORE", accent: "#d8dce8", skin: "#efc9a4", hair: "#7a6a5a", hair_style: "side", outfit: "blazer", top: "#3a3f4a", top2: "#f4f4f6", tie: "#6a1f2b", pants: "#33373f", iris: "#4a6a8a", voice: { gender: "m", pitch: 0.76, rate: 0.95, lang: ["en-US", "en-GB"] } },
    monroe: { name: "JUDGE MONROE", accent: "#e8c64a", skin: "#e8c0a0", hair: "#b9b9bd", hair_style: "bob", outfit: "robe", top: "#15161a", female: true, old: true, iris: "#4a6a8a", voice: { gender: "f", pitch: 0.82, rate: 0.92, lang: ["en-US", "en-GB"] } },
    nasreen: { name: "MOM", accent: "#e68a6a", skin: "#efc9a4", hair: "#9a9a9a", hair_style: "bob", outfit: "shirt", top: "#7a2f3a", pants: "#4a4a52", female: true, old: true, glasses: true, voice: { gender: "f", pitch: 0.9, rate: 0.9, lang: ["en-GB", "en-US"] } },
    faisal: { name: "MARCUS", accent: "#7ab0ff", skin: "#6b4631", hair: "#1a1512", hair_style: "crop", outfit: "blazer", top: "#8d93a0", top2: "#2a3b63", pants: "#2e323c", beard: "full", beard_color: "#3a3430", voice: { gender: "m", pitch: 0.9, rate: 1.0, lang: ["en-GB", "en-US"] } },
    sana: { name: "JESSICA", accent: "#4de0c0", skin: "#f0cfae", hair: "#8a5a2e", hair_style: "long", outfit: "shirt", top: "#2f8f8a", pants: "#2a2d36", female: true, voice: { gender: "f", pitch: 1.2, rate: 1.05, lang: ["en-GB", "en-US"] } }
  },

  timeline: [
    { type: "title", main: "LINKEDOUT", sub: "Everyone Fails" },
    { type: "title", main: "ACT ONE", sub: "The Idea" },
    { type: "cards", cards: [
      "2024. Ethan Cole's startup, Orbit, shuts down after three years.",
      "2025. Every professional feed he opens is full of promotions and product launches."
    ] },

    { type: "scene", slug: "INT. COWORKING CAFE, SAN FRANCISCO. MORNING", set: "cafe",
      chars: [["hamza", 520], ["areeba", 960], ["bilal", 1400]],
      lines: [
        ["areeba", "You've been scrolling for twenty minutes. Say something."],
        ["hamza", "Everyone I know got promoted this month. Look at this one. 'Humbled and thrilled to announce.'"],
        ["bilal", "That's the standard opening. Humbled and thrilled."],
        ["hamza", "I've applied to fourteen jobs since Orbit shut down. Fourteen rejections. Nobody posts about that."],
        ["areeba", "Because nobody wants to read it."],
        ["hamza", "I'd read it. It would have helped me three months ago."],
        ["bilal", "You want a feed of people being rejected."],
        ["hamza", "Not rejected. Honest. What went wrong, what they learned, what they'd do differently."],
        ["areeba", "That's a blog."],
        ["hamza", "Blogs don't have a network. People follow each other, comment, give advice. Same structure, opposite content."],
        ["bilal", "So the reverse of LinkedIn."],
        ["hamza", "Something like that. I was thinking of calling it LinkedOut."],
        ["areeba", "That's a good joke. I don't know if it's a good name."],
        ["hamza", "It's both. The joke is why people will remember it."],
        ["bilal", "Who's going to post? Nobody puts their failures under their real name."],
        ["hamza", "Some will. I will. The first post is mine."],
        ["areeba", "What would you write?"],
        ["hamza", "That I spent three years building a product people liked and didn't pay for."],
        ["areeba", "That's not a failure, that's a pricing problem."],
        ["hamza", "It's both."],
        ["bilal", "I'll build it, on one condition."],
        ["hamza", "Name it."],
        ["bilal", "We don't call it a startup until somebody uses it who isn't related to us."],
        ["areeba", "I'll do the design. Give me a week, and nothing blue."],
        ["hamza", "Why nothing blue?"],
        ["areeba", "Because everything in that feed is blue. If we look like them, we sound like them."],
        ["hamza", "Fair. Nothing blue."]
      ] },

    { type: "scene", slug: "INT. ETHAN'S APARTMENT. NIGHT", set: "home",
      chars: [["hamza", 700], ["nasreen", 1200]],
      lines: [
        ["nasreen", "You haven't eaten. I kept dinner warm."],
        ["hamza", "Thanks, Mom. I'm not hungry."],
        ["nasreen", "You're thinking about the computer thing again."],
        ["hamza", "It's a website, Mom. A place where people write about their failures."],
        ["nasreen", "Why would anyone want to write about that?"],
        ["hamza", "Because everyone has some, and most people feel alone with them."],
        ["nasreen", "Hm."],
        ["hamza", "You don't like it?"],
        ["nasreen", "I didn't say that. I'm thinking. Do you remember my shop?"],
        ["hamza", "The tailoring shop on Mall Road."],
        ["nasreen", "It closed in two years. I owed money to three people. I told nobody."],
        ["hamza", "You never told me that."],
        ["nasreen", "You were nine. Your father knew. My sister knew. That was all."],
        ["hamza", "Why didn't you tell anyone else?"],
        ["nasreen", "People would have looked at me differently. That's what I thought, anyway."],
        ["hamza", "Did they, eventually?"],
        ["nasreen", "When I finally mentioned it, three women said it had happened to them too."],
        ["hamza", "That's exactly what I want to build."],
        ["nasreen", "Then build it. And eat first."],
        ["hamza", "Fine. Can I have dinner?"],
        ["nasreen", "It's been warm since seven. Go."]
      ] },

    { type: "scene", slug: "INT. VENTURE FIRM, 30TH FLOOR. DAY", set: "vc",
      chars: [["hamza", 560], ["areeba", 900], ["faisal", 1450]],
      lines: [
        ["faisal", "I like the idea. I'll say that first."],
        ["hamza", "That sounds like a no is coming."],
        ["faisal", "A polite one. Walk me through the revenue."],
        ["hamza", "Premium accounts for people who want private groups. A coaching marketplace later. Possibly ads."],
        ["faisal", "Which advertisers want to appear next to a post titled 'How I lost two million dollars'?"],
        ["areeba", "Plenty of brands say they care about authenticity."],
        ["faisal", "They say that in a deck. They don't buy it with a budget."],
        ["hamza", "Maybe not at first. But engagement on honest posts is much higher. We tested it on a forum."],
        ["faisal", "How much higher?"],
        ["hamza", "Comments per post were about four times what you see on a typical professional network."],
        ["faisal", "That's good. It doesn't tell me anyone will pay."],
        ["hamza", "True. It tells you people care."],
        ["faisal", "Caring is the easy part. I invest in things I can explain to my partners in two sentences."],
        ["areeba", "A professional network for what went wrong. People learn from each other's mistakes."],
        ["faisal", "That's one sentence. And it's better than yours, Ethan."],
        ["hamza", "She's the designer."],
        ["faisal", "Then she should be pitching. I'm passing for now. Come back with ten thousand users."],
        ["hamza", "And if we do?"],
        ["faisal", "Then I'll be the first to admit I was wrong."],
        ["areeba", "We'll hold you to that."],
        ["faisal", "Please do. I enjoy being wrong when it's profitable."]
      ] },

    { type: "title", main: "ACT TWO", sub: "The Launch" },

    { type: "scene", slug: "INT. STARTUP OFFICE. NIGHT", set: "startup", term: true, term_title: "api-server: bash",
      chars: [["bilal", 520], ["areeba", 960], ["hamza", 1400]],
      lines: [
        ["bilal", "Schema first. A post has a body and a lesson, and the author can be null if it's anonymous.", "$ psql -d linkedout -c '\\d posts'\n id uuid PK | author_id uuid NULL | body text | lesson text | created_at timestamptz"],
        ["areeba", "Why a separate lesson field?"],
        ["hamza", "So every post ends with something useful. It keeps the site from turning into a complaint board."],
        ["bilal", "Anonymous posting is the part I'm nervous about. People will abuse it."],
        ["hamza", "So how do we limit it?"],
        ["bilal", "Rate limit by a salted hash of the IP, rotated daily. We never store the raw address.", "$ redis-cli --scan --pattern 'rl:*' | head -3\nrl:9c1f4e:post\nrl:b27d03:post\nrl:41aa9e:post"],
        ["areeba", "What happens if somebody posts a real person's name? I can see that going badly."],
        ["bilal", "Moderation pipeline. Every post goes through a classifier before it's visible.", "$ curl -s localhost:8080/moderate -d @sample.json | jq\n{\"toxicity\": 0.03, \"pii\": [\"person_name\"], \"action\": \"hold_for_review\"}"],
        ["bilal", "Names, emails and phone numbers get flagged for a human to look at."],
        ["hamza", "How many humans do we have?"],
        ["areeba", "Three. All of us."],
        ["bilal", "So the threshold stays strict for now. Better to hold a harmless post than publish a harmful one."],
        ["areeba", "I'll write the community rules. Short, and in plain English."],
        ["hamza", "What's rule one?"],
        ["areeba", "Be honest about your own story. Don't tell other people's."],
        ["bilal", "Good. That one's enforceable."],
        ["hamza", "Ready to deploy?"],
        ["bilal", "Staging first. I want one real test with ten people.", "$ fly deploy --app linkedout-staging\n==> Monitoring deployment\n1 desired, 1 placed, 1 healthy"],
        ["areeba", "Ten people from where?"],
        ["hamza", "My phone contacts. All the ones who didn't reply to my job applications."],
        ["bilal", "That's petty."],
        ["hamza", "That's validation."]
      ] },

    { type: "scene", slug: "INT. STARTUP OFFICE. LAUNCH DAY", set: "startup", term: true, term_title: "live-metrics",
      chars: [["bilal", 520], ["areeba", 960], ["hamza", 1400]],
      lines: [
        ["areeba", "It's live. How many people are on it?", "$ linkedout-stats --live\nactive_users: 212\nposts_today: 61"],
        ["bilal", "Two hundred twelve. Sixty-one posts."],
        ["hamza", "Who posted?"],
        ["areeba", "A teacher who failed the bar exam twice. A chef whose restaurant closed after eight months."],
        ["hamza", "Read me the chef's."],
        ["areeba", "'Ran out of cash on a Tuesday. Paid staff first, rent second. Lesson: keep six months of runway.'"],
        ["hamza", "That's exactly it."],
        ["bilal", "Someone posted us on a tech forum. Traffic's climbing.", "$ linkedout-stats --live\nactive_users: 2,940\nposts_today: 780\nreq/s: 412"],
        ["areeba", "Is the server okay?"],
        ["bilal", "Database is at sixty percent CPU. It's fine. For now."],
        ["hamza", "What's for now?"],
        ["bilal", "If it triples, I'll need more capacity.", "$ fly scale count 3 --app linkedout-prod\nScaling to 3 machines"],
        ["hamza", "Do it."],
        ["bilal", "Already did."],
        ["areeba", "Ethan, look at the comments. People are helping each other."],
        ["hamza", "A man is telling a stranger how he rebuilt after bankruptcy."],
        ["areeba", "This is the thing you described at the café."],
        ["hamza", "I didn't believe it would work."],
        ["bilal", "Twelve thousand signups since this morning.", "$ linkedout-stats --live\nsignups_total: 12,404\nposts_today: 3,118\nmod_queue: 94"],
        ["areeba", "The moderation queue has ninety-four items."],
        ["bilal", "I'll start on it. Somebody get coffee."],
        ["hamza", "I'll go. Back in ten."],
        ["areeba", "Ethan."],
        ["hamza", "Yeah?"],
        ["areeba", "That's more than ten thousand users. Call Faisal."],
        ["hamza", "Tomorrow. Tonight I want to watch it."]
      ] },

    { type: "scene", slug: "INT. STARTUP OFFICE. TWO WEEKS LATER", set: "startup",
      chars: [["sana", 520], ["hamza", 960], ["areeba", 1400]],
      lines: [
        ["sana", "Thanks for making time. You're past a million signups."],
        ["hamza", "One point two, as of this morning."],
        ["sana", "Why do you think it caught on?"],
        ["hamza", "People were tired of performing. Every other platform asks you to look good. This one asks you to be accurate."],
        ["sana", "The name has gotten as much attention as the product."],
        ["hamza", "That's mostly Areeba's fault for not talking me out of it."],
        ["areeba", "I tried once. He ignored me."],
        ["sana", "Did you think about how the name might look to the company it's playing on?"],
        ["hamza", "For about a minute. We aren't copying their product. It's a joke about the opposite."],
        ["sana", "Are you worried they'll respond?"],
        ["hamza", "No."],
        ["areeba", "A little."],
        ["hamza", "A little. But it's satire, and we say so on the about page."],
        ["sana", "Has anyone from the company contacted you?"],
        ["hamza", "Not yet."],
        ["sana", "Last question. What's your most popular post?"],
        ["areeba", "Yours, actually. 'Why my startup failed.' Eight hundred thousand reads."],
        ["hamza", "That one shouldn't count. I'm the founder."],
        ["sana", "It counts. People read it because it's honest."],
        ["hamza", "Fair. Thank you."]
      ] },

    { type: "title", main: "ACT THREE", sub: "The Letter" },

    { type: "scene", slug: "INT. STARTUP OFFICE. MORNING", set: "startup",
      chars: [["bilal", 520], ["hamza", 960], ["areeba", 1400]],
      lines: [
        ["bilal", "You need to see this email. It came to the legal address."],
        ["hamza", "Which legal address?"],
        ["bilal", "The one I set up because it was free. It's from a law firm."],
        ["areeba", "Read it."],
        ["hamza", "'We represent LinkedIn Corporation. Your service, operating as LinkedOut, uses a name and branding confusingly similar to our client's marks.'"],
        ["areeba", "Confusingly similar. We're the opposite."],
        ["hamza", "'Please cease use of the name within fourteen days, or our client will pursue all available remedies.'"],
        ["bilal", "Fourteen days."],
        ["hamza", "They want us to rename it."],
        ["areeba", "Can they make us?"],
        ["hamza", "I don't know. I'm a programmer, not a lawyer."],
        ["bilal", "We could just change it. It's a name."],
        ["areeba", "It's the name. Everyone knows it as LinkedOut."],
        ["bilal", "Everyone also knows us for working servers. Which cost money. Which we won't have if we get sued."],
        ["hamza", "We're not getting sued. They're asking."],
        ["bilal", "A letter from a law firm is how it starts."],
        ["areeba", "Let's talk to someone before we decide anything."],
        ["hamza", "Who? We have forty thousand dollars."],
        ["areeba", "My old roommate's sister is a trademark attorney. Rachel Whitfield."],
        ["hamza", "Call her."],
        ["areeba", "She's expensive, Ethan."],
        ["hamza", "Call her anyway."]
      ] },

    { type: "scene", slug: "INT. WHITFIELD LAW OFFICE. DAY", set: "lawfirm",
      chars: [["hamza", 520], ["saira", 960], ["areeba", 1400]],
      lines: [
        ["saira", "I've read the letter. Before I say anything, did you choose the name on purpose?"],
        ["hamza", "Yes. It's a joke on the other name."],
        ["saira", "That helps and it hurts. It helps because it's parody. It hurts because you chose to reference them."],
        ["areeba", "Isn't parody protected?"],
        ["saira", "Partly. There's a Supreme Court case, Jack Daniel's against VIP Products, from 2023. It involved a dog toy."],
        ["hamza", "A dog toy?"],
        ["saira", "A chew toy shaped like a whiskey bottle. The court said that when you use a parody as your own brand, the ordinary confusion test applies."],
        ["hamza", "So we're treated like any other business."],
        ["saira", "On the legal test, yes. But parody still matters. It's evidence that people won't think you're affiliated."],
        ["areeba", "So what's the actual question?"],
        ["saira", "Whether an ordinary user would be confused about who runs the site. Then there's dilution, which is a separate claim about weakening a famous brand."],
        ["hamza", "Are we going to lose?"],
        ["saira", "I don't know yet. You have good facts. Your design is different, your product is different, and the name announces that it's the opposite."],
        ["areeba", "And the bad facts?"],
        ["saira", "The name is very close. And a company that size can afford a long case."],
        ["hamza", "How long?"],
        ["saira", "If they sue, eighteen months to two years is common."],
        ["hamza", "We have forty thousand dollars."],
        ["saira", "Then here's what I'd do. Don't answer the letter yourself. I'll write the response, and I'll bill you at a rate you can survive."],
        ["areeba", "Why would you do that?"],
        ["saira", "Because I left a big firm two years ago to take cases I believe in. This is one."],
        ["hamza", "Thank you."],
        ["saira", "Don't thank me yet. Let's draft it carefully."]
      ] },

    { type: "scene", slug: "INT. STARTUP OFFICE. EVENING", set: "startup",
      chars: [["bilal", 520], ["hamza", 960], ["areeba", 1400]],
      lines: [
        ["bilal", "Faisal's firm just called. They're pulling back."],
        ["hamza", "After the ten thousand users? We have a million."],
        ["bilal", "His partners saw the legal letter. They don't want to fund a lawsuit."],
        ["areeba", "That was fast."],
        ["hamza", "I'll call him."],
        ["bilal", "Don't. He was polite. It was a final answer."],
        ["areeba", "So we're doing this alone."],
        ["bilal", "We're doing this with forty thousand dollars and a lawyer on a discount."],
        ["hamza", "I know the situation."],
        ["bilal", "Do you? I've been up since four, and I want to know if we're rebranding."],
        ["hamza", "I haven't decided."],
        ["bilal", "That's not an answer. The longer we wait, the more it costs."],
        ["areeba", "He's right about the cost. I'm also right that the name is what people love."],
        ["hamza", "So we disagree."],
        ["areeba", "We do. I'd rather argue now than resent each other later."],
        ["bilal", "I'm not against fighting. I'm saying we need a plan for losing."],
        ["hamza", "That's reasonable."],
        ["bilal", "If we lose, we rename, and we keep every user. That's the plan."],
        ["areeba", "And if we win?"],
        ["bilal", "Then I'll buy lunch."],
        ["hamza", "You've never bought lunch."],
        ["bilal", "That's how confident I am we'll lose."],
        ["areeba", "Charming."]
      ] },

    { type: "scene", slug: "INT. WHITFIELD LAW OFFICE. THREE WEEKS LATER", set: "lawfirm",
      chars: [["hamza", 520], ["saira", 960], ["areeba", 1400]],
      lines: [
        ["saira", "They filed. Northern District of California."],
        ["hamza", "What are they claiming?"],
        ["saira", "Trademark infringement, dilution, and unfair competition. They want an injunction and legal fees."],
        ["areeba", "An injunction means we have to stop?"],
        ["saira", "It means a court orders you to stop using the name. They've asked for a preliminary one, which would apply while the case is ongoing."],
        ["hamza", "That could happen in weeks."],
        ["saira", "A hearing on it could be in about three months. That's the one that matters."],
        ["areeba", "What do we need to win it?"],
        ["saira", "Evidence of how real users understand the site. Not what we say, what they say."],
        ["hamza", "We have a million users."],
        ["saira", "Then we ask a few hundred of them, properly. That's a survey, designed by an expert."],
        ["hamza", "That sounds expensive."],
        ["saira", "It is. Fifteen thousand dollars, at least."],
        ["hamza", "That's a third of what we have."],
        ["saira", "It's also the strongest evidence in a case like this. Judges pay attention to it."],
        ["areeba", "Do it."],
        ["hamza", "Areeba..."],
        ["areeba", "I'll take a pay cut. I'm serious."],
        ["saira", "You should both think about it before deciding."],
        ["hamza", "We've been thinking about it for three weeks. Do the survey."],
        ["saira", "Understood. I'll also need your server logs and any user emails that mention the company."],
        ["hamza", "Why the emails?"],
        ["saira", "Because they'll ask for them. If anyone wrote 'I thought you were LinkedIn,' I'd rather read it first."]
      ] },

    { type: "title", main: "ACT FOUR", sub: "Discovery" },

    { type: "scene", slug: "INT. CONFERENCE ROOM. DEPOSITION", set: "conf",
      chars: [["hamza", 560], ["saira", 900], ["whitmore", 1400]],
      lines: [
        ["whitmore", "Mr. Cole, thank you for coming. I'll ask some questions, and your attorney may object. Please answer as best you can."],
        ["hamza", "Understood."],
        ["whitmore", "Why did you choose the name LinkedOut?"],
        ["hamza", "It's a joke on the other name. It means the opposite of a professional highlight reel."],
        ["whitmore", "So you intended to evoke my client's brand."],
        ["hamza", "I intended to make people smile and to say we're different."],
        ["whitmore", "But you knew people would think of LinkedIn."],
        ["hamza", "Yes."],
        ["whitmore", "Thank you. I'm going to show you an email. Exhibit twelve."],
        ["hamza", "I've read it."],
        ["whitmore", "A user writes, 'Is this made by the LinkedIn team? Love it.' Do you remember responding?"],
        ["hamza", "I said no. We're not connected to them."],
        ["whitmore", "So at least one person thought you were."],
        ["hamza", "One person out of one million two hundred thousand."],
        ["whitmore", "Mr. Cole, I'm asking about this email."],
        ["hamza", "Sorry. Yes. One person asked."],
        ["saira", "Objection to the characterization. The witness answered."],
        ["whitmore", "I'll move on. Did you consult a lawyer before choosing the name?"],
        ["hamza", "No."],
        ["whitmore", "Why not?"],
        ["hamza", "We had forty thousand dollars. I used it on servers."],
        ["whitmore", "That's candid."],
        ["hamza", "I try to be. It's sort of the whole product."],
        ["whitmore", "Noted. No further questions today."]
      ] },

    { type: "scene", slug: "INT. ETHAN'S APARTMENT. NIGHT", set: "home",
      chars: [["hamza", 700], ["nasreen", 1200]],
      lines: [
        ["nasreen", "You've been looking at that screen for an hour."],
        ["hamza", "The lawyers say I'll have to explain myself in court. I'm not sure I can."],
        ["nasreen", "Explain what?"],
        ["hamza", "Why I picked a name that bothered a company a thousand times my size."],
        ["nasreen", "Why did you?"],
        ["hamza", "Because it was funny, and because I wanted people to notice."],
        ["nasreen", "So say that."],
        ["hamza", "It sounds careless."],
        ["nasreen", "Ethan, when your father bought a house with a leaking roof, he told the bank it was careless of him. They gave him the loan anyway. Honesty works."],
        ["hamza", "That's very specific."],
        ["nasreen", "It's also true. Have you written about this on your own website?"],
        ["hamza", "Not about this."],
        ["nasreen", "Then do it. You tell everyone else to."],
        ["hamza", "It's a good point. I hate that it is."],
        ["nasreen", "I've heard that before."],
        ["hamza", "Okay. Give me ten minutes."]
      ] },

    { type: "scene", slug: "INT. STARTUP OFFICE. NEXT MORNING", set: "startup",
      chars: [["areeba", 520], ["hamza", 960], ["bilal", 1400]],
      lines: [
        ["areeba", "Ethan. Your post."],
        ["hamza", "What about it?"],
        ["areeba", "Four hundred thousand reads overnight."],
        ["bilal", "And a lot of comments. Read the top one."],
        ["hamza", "'I've never been sued for anything. Keep going. Your honesty is why I trust this place.'"],
        ["bilal", "Someone else wrote that they weren't confused for a second. They said it's obviously a different company."],
        ["areeba", "Saira called. She wants to use some of those."],
        ["hamza", "Use them how?"],
        ["areeba", "If users sign a short statement about how they understand the site, it can go into the record. They're called declarations."],
        ["bilal", "How many do we need?"],
        ["areeba", "She said a few dozen would help. We already have three hundred volunteers."],
        ["hamza", "People want to do this?"],
        ["areeba", "They said they came here because they were tired of pretending. They don't want to see it shut down over a name."],
        ["bilal", "The survey results are also back."],
        ["hamza", "And?"],
        ["bilal", "Four hundred respondents. Three percent thought we're affiliated with the other company. In the control group, which used a different name, it was two percent."],
        ["areeba", "So the name adds only one percent."],
        ["bilal", "That's roughly what Saira said it would look like."],
        ["hamza", "One percent. That's small."],
        ["areeba", "It's small. Whether it's small enough is the judge's call."],
        ["hamza", "That's a better position than I thought."],
        ["bilal", "I'm still buying lunch only if we win."]
      ] },

    { type: "scene", slug: "INT. FEDERAL COURTHOUSE, MEDIATION ROOM. DAY", set: "conf",
      chars: [["hamza", 560], ["saira", 900], ["whitmore", 1400]],
      lines: [
        ["whitmore", "Thank you for coming. My client would prefer to resolve this without a hearing."],
        ["saira", "So would ours. What are you proposing?"],
        ["whitmore", "A rename. We'd allow a transition period of ninety days, and each side bears its own costs."],
        ["hamza", "Rename to what?"],
        ["whitmore", "Anything that doesn't reference our client's marks."],
        ["hamza", "What if we kept the name and added a clear disclaimer on every page?"],
        ["whitmore", "That doesn't resolve the dilution concern."],
        ["saira", "Our survey shows one percent net confusion. That's not a basis for an injunction."],
        ["whitmore", "We have our own expert, who reads the same data differently."],
        ["saira", "Then we'll argue about it in front of the judge."],
        ["whitmore", "That's your right. I'd also remind you the case would continue after the hearing."],
        ["hamza", "Mr. Whitmore, can I ask you something directly?"],
        ["whitmore", "Of course."],
        ["hamza", "Does your client care about this, or is it routine?"],
        ["whitmore", "Protecting the brand is routine. That's not an insult. If a company doesn't enforce, it can lose the mark."],
        ["hamza", "I understand that. I only want to know if you think we're a threat."],
        ["whitmore", "Honestly? No. I think your product is interesting."],
        ["hamza", "Then why are we here?"],
        ["whitmore", "Because the name is close, and the law doesn't ask about intentions. It asks about effect."],
        ["saira", "Which is why we'll see you at the hearing."],
        ["whitmore", "I expected that. Good luck."],
        ["hamza", "Thank you. You too, I suppose."],
        ["whitmore", "I'll accept that."]
      ] },

    { type: "title", main: "ACT FIVE", sub: "The Hearing" },

    { type: "scene", slug: "INT. FEDERAL COURTROOM. MORNING", set: "court",
      chars: [["whitmore", 430], ["monroe", 960], ["saira", 1400], ["hamza", 1680]],
      lines: [
        ["monroe", "We're here on the plaintiff's motion for a preliminary injunction. Mr. Whitmore, you may begin."],
        ["whitmore", "Thank you, Your Honor. The defendant adopted a name that mirrors my client's mark with a single substitution. That's not subtle."],
        ["monroe", "Is subtle the standard, Mr. Whitmore?"],
        ["whitmore", "No, Your Honor. The standard is likelihood of confusion. And when the marks are this close, the other factors follow."],
        ["monroe", "Which factors matter most here?"],
        ["whitmore", "Similarity of the marks, the strength of our mark, and evidence of actual confusion. We have at least one documented instance."],
        ["monroe", "One instance."],
        ["whitmore", "One that was written down, Your Honor. Most confused customers never write."],
        ["monroe", "That's an assumption. Do you have evidence of it?"],
        ["whitmore", "Our expert estimates a meaningful level of confusion based on survey methods."],
        ["monroe", "I'll read both experts' reports. Ms. Whitfield, your response."],
        ["saira", "Thank you, Your Honor. We don't dispute that the names share a word. We dispute that a reasonable user would think this is the same company."],
        ["monroe", "Why wouldn't they?"],
        ["saira", "Because the product is the opposite of the plaintiff's. The tagline, the design and the rules all say so. The name is a joke about the contrast."],
        ["monroe", "The Supreme Court said parody used as a brand doesn't get special treatment."],
        ["saira", "Correct, Your Honor. We aren't asking for special treatment. We're asking you to weigh parody as evidence that no one is misled."],
        ["monroe", "And the survey?"],
        ["saira", "Four hundred respondents. Net confusion of one percent. That's well below the levels courts have found significant."],
        ["monroe", "Mr. Whitmore's expert disagrees on the control group."],
        ["saira", "Our control used a neutral name. His used a name that shares words with a famous brand. That inflates the baseline."],
        ["monroe", "That's a real methodological dispute. I'll take it under advisement."],
        ["monroe", "Mr. Cole, I'd like to hear from you, briefly. Not as a witness, as the founder."],
        ["hamza", "Thank you, Your Honor. I made a joke and called it a company. I should have thought it through legally. But I never wanted anyone to think we were them."],
        ["monroe", "Why does the name matter so much to you?"],
        ["hamza", "Because the people who use it already know what it means. It's a place where saying the opposite of a success story is allowed."],
        ["monroe", "Would you accept a prominent disclaimer?"],
        ["hamza", "Yes. Immediately."],
        ["whitmore", "Your Honor, a disclaimer doesn't address dilution."],
        ["monroe", "I understand your position, Mr. Whitmore. I'll issue a written decision within thirty days. We're adjourned."]
      ] },

    { type: "scene", slug: "EXT. COURTHOUSE STEPS. AFTERNOON", set: "steps",
      chars: [["bilal", 420], ["areeba", 780], ["hamza", 1140], ["saira", 1500]],
      lines: [
        ["bilal", "Do you think it went well?"],
        ["saira", "I think the judge asked fair questions. That's all I'll say."],
        ["areeba", "She asked about a disclaimer twice."],
        ["saira", "She did. Which tells me she's looking for something in between."],
        ["hamza", "In between what?"],
        ["saira", "Between shutting you down and doing nothing."],
        ["hamza", "Is that bad?"],
        ["saira", "It's normal. Judges like middle ground."],
        ["bilal", "Can I say something stupid?"],
        ["hamza", "Please."],
        ["bilal", "I was ready to lose. I'd already drafted the rename announcement."],
        ["areeba", "When?"],
        ["bilal", "Three weeks ago. I never sent it."],
        ["hamza", "You wrote it yourself?"],
        ["bilal", "It's decent. 'Same community, new name.'"],
        ["areeba", "That's not bad."],
        ["hamza", "Keep it. We might need it."],
        ["saira", "Whatever she decides, you did this properly. Most people don't."],
        ["hamza", "Thanks, Saira. I mean it."],
        ["saira", "Go home. Eat something. I'll call the moment I hear."]
      ] },

    { type: "scene", slug: "INT. STARTUP OFFICE. THIRTY DAYS LATER", set: "startup",
      chars: [["bilal", 420], ["areeba", 780], ["hamza", 1140], ["saira", 1500]],
      lines: [
        ["saira", "I have the decision. I'll read the conclusion first, then summarize."],
        ["hamza", "Go."],
        ["saira", "The court denies the motion for a preliminary injunction."],
        ["areeba", "We won?"],
        ["saira", "Not the whole case. This was one motion. But on the injunction, yes."],
        ["bilal", "What did she say?"],
        ["saira", "She found the marks similar but the overall likelihood of confusion low. She cited the survey, and said the plaintiff hadn't shown irreparable harm."],
        ["hamza", "What about the dilution claim?"],
        ["saira", "It continues, but she was skeptical. She said it's weaker for a site that identifies itself as the opposite."],
        ["areeba", "And the disclaimer?"],
        ["saira", "She strongly encouraged it. It isn't an order, but she said it would help both sides."],
        ["hamza", "We'll add it today."],
        ["bilal", "I'll add it in an hour."],
        ["saira", "There's more. Mr. Whitmore called me an hour ago. The company is willing to dismiss with a short agreement."],
        ["hamza", "What's in the agreement?"],
        ["saira", "You keep the name. You add the disclaimer. You keep your colors and logo clearly different from theirs. And nobody pays anybody."],
        ["hamza", "That's all?"],
        ["saira", "That's all. I'd take it."],
        ["areeba", "Ethan?"],
        ["hamza", "Yes. Tell him yes."],
        ["saira", "I'll send it for signature this afternoon."],
        ["bilal", "I'm buying lunch."],
        ["areeba", "You said only if we won."],
        ["bilal", "We won. Mostly."]
      ] },

    { type: "title", main: "ACT SIX", sub: "Afterwards" },

    { type: "scene", slug: "INT. COWORKING CAFE. THREE MONTHS LATER", set: "cafe",
      chars: [["areeba", 520], ["hamza", 960], ["bilal", 1400], ["faisal", 1760]],
      lines: [
        ["areeba", "Faisal's on the phone. He wants to talk."],
        ["hamza", "Tell him I'm busy."],
        ["areeba", "You're not busy. You're reading a post."],
        ["hamza", "It's a good one. A woman ran a bakery for six years and closed it. She says it was the best thing that happened to her."],
        ["bilal", "That's a very optimistic failure."],
        ["hamza", "She earned it."],
        ["areeba", "Faisal, hi. Yes. He's right here."],
        ["faisal", "Ethan. I said I'd admit I was wrong. I was wrong."],
        ["hamza", "Thank you for saying it out loud."],
        ["faisal", "I'd like to invest. Properly this time."],
        ["hamza", "I'd like to talk about it. One condition."],
        ["faisal", "Name it."],
        ["hamza", "You post a failure on the site first. A real one."],
        ["faisal", "My partners will not enjoy that."],
        ["hamza", "That's the point."],
        ["faisal", "Give me a week. I have a long list."],
        ["areeba", "Ryan, that's your cue."],
        ["bilal", "To buy lunch? Already done."],
        ["hamza", "Then what's left?"],
        ["areeba", "Reading the next one."],
        ["hamza", "Go ahead."],
        ["areeba", "'I applied to fourteen jobs and heard back from none. Then I built something instead.'"],
        ["hamza", "That's mine."],
        ["areeba", "I know. It's still the best one."]
      ] },

    { type: "scene", slug: "INT. ETHAN'S APARTMENT. NIGHT", set: "home",
      chars: [["hamza", 700], ["nasreen", 1200]],
      lines: [
        ["nasreen", "I read your post again today."],
        ["hamza", "Which one?"],
        ["nasreen", "The one about the lawsuit. It's the first time you wrote about being afraid."],
        ["hamza", "I wasn't sure I should."],
        ["nasreen", "You should. People trust it more."],
        ["hamza", "That's what everyone said."],
        ["nasreen", "Then everyone is right. Shall I make chai?"],
        ["hamza", "I'll make it."],
        ["nasreen", "You'll burn it."],
        ["hamza", "I'll burn it. Then I'll post about it."],
        ["nasreen", "Do that. And give me the computer. I have something to write."],
        ["hamza", "You do?"],
        ["nasreen", "About the shop. It's time."],
        ["hamza", "Mom..."],
        ["nasreen", "Don't make it dramatic. Pass me the laptop."],
        ["hamza", "Here."],
        ["nasreen", "Thank you, honey."]
      ] },

    { type: "title", main: "LINKEDOUT", sub: "Everyone Fails" },

    { type: "credits", lines: [
      "#CAST",
      "Ethan Cole",
      "Claire Donovan",
      "Ryan Brooks",
      "Rachel Whitfield",
      "Linda Cole",
      "Marcus Hale",
      "Jessica Moore",
      "Daniel Whitmore",
      "Judge Patricia Monroe",
      "",
      "#NOTE",
      "This is a work of fiction. Names, characters and events are imaginary.",
      "LinkedIn is a trademark of its owner. No affiliation or endorsement is implied.",
      "",
      "#LINKEDOUT"
    ] }
  ]
};
if (typeof module !== "undefined") { module.exports = movie_data; }

</script>
<script>
var wrap_el = document.getElementById("wrap");
var stage_el = document.getElementById("stage");
var bg_el = document.getElementById("bg");
var chars_el = document.getElementById("chars");
var grade_el = document.getElementById("grade");
var term_el = document.getElementById("term");
var term_title_el = document.getElementById("term_title");
var term_text_el = document.getElementById("term_text");
var slug_el = document.getElementById("slug");
var title_card_el = document.getElementById("title_card");
var title_main_el = document.getElementById("title_main");
var title_sub_el = document.getElementById("title_sub");
var credits_el = document.getElementById("credits");
var credits_inner_el = document.getElementById("credits_inner");
var start_screen_el = document.getElementById("start_screen");
var osd_el = document.getElementById("osd");

var timing = movie_data.timing;
var seek_step_ms = 10000;
var segments = [];
var total_ms = 0;
var cur_ms = 0;
var last_now = 0;
var is_playing = false;
var is_started = false;
var active_seg_index = -1;
var active_state_key = "";
var char_map = {};
var credits_end_offset = 0;
var osd_timer = null;

/* ---------- speech ---------- */
var speech_ok = "speechSynthesis" in window;
var is_muted = false;
var voice_map = {};
var voice_map_ready = false;
var speech_active_key = "";
var speech_desired = null;
var current_utter = null;
var male_re = /(david|mark|daniel|alex|fred|george|james|guy|ryan|thomas|oliver|arthur|gordon|male|rishi|ravi|liam|aaron|eric|christopher|brian|andrew)/i;
var female_re = /(zira|samantha|karen|hazel|susan|victoria|aria|jenny|emma|female|moira|tessa|fiona|heera|veena|kate|serena|libby|sonia|michelle|ava|jane|nicole|allison)/i;

function build_voice_map() {
  if (!speech_ok) { return; }
  var all = speechSynthesis.getVoices().filter(function (v) { return /^en/i.test(v.lang); });
  if (!all.length) { return; }
  voice_map = {};
  var used = {};
  Object.keys(movie_data.people).forEach(function (key) {
    var cfg = movie_data.people[key].voice;
    if (!cfg) { return; }
    var pool = all.filter(function (v) { return (cfg.gender === "m" ? male_re.test(v.name) && !female_re.test(v.name) : female_re.test(v.name) && !male_re.test(v.name)); });
    if (!pool.length) { pool = all; }
    var ranked = pool.slice().sort(function (a, b) {
      var ia = cfg.lang.indexOf(a.lang.replace("_", "-")); var ib = cfg.lang.indexOf(b.lang.replace("_", "-"));
      return (ia < 0 ? 9 : ia) - (ib < 0 ? 9 : ib);
    });
    var pick = ranked.filter(function (v) { return !used[v.name]; })[0] || ranked[0];
    used[pick.name] = true;
    voice_map[key] = pick;
  });
  voice_map_ready = true;
}
if (speech_ok) { speechSynthesis.onvoiceschanged = build_voice_map; build_voice_map(); }

function speak_line(entry) {
  if (!speech_ok || is_muted) { return; }
  if (!voice_map_ready) { build_voice_map(); }
  speechSynthesis.cancel();
  speechSynthesis.resume();
  setTimeout(function () {
    if (speech_active_key !== entry.key || !is_playing || is_muted) { return; }
    var cfg = movie_data.people[entry.who].voice;
    var utter = new SpeechSynthesisUtterance(entry.text);
    var voice = voice_map[entry.who];
    if (voice) { utter.voice = voice; utter.lang = voice.lang; } else { utter.lang = "en-US"; }
    utter.pitch = cfg.pitch;
    var est_ms = entry.text.length * 62 / cfg.rate;
    var need = est_ms / (entry.window_ms * 0.94);
    var rate = cfg.rate * (need > 1 ? Math.min(1.4, need) : 1);
    utter.rate = clamp_value(rate, 0.6, 1.6);
    current_utter = utter;
    speechSynthesis.speak(utter);
  }, 80);
}

function sync_speech() {
  if (!speech_ok || !is_playing || is_muted) { return; }
  var want = speech_desired ? speech_desired.key : "";
  if (want === speech_active_key) { return; }
  speech_active_key = want;
  if (speech_desired) { speak_line(speech_desired); } else { speechSynthesis.cancel(); }
}

/* ---------- layout ---------- */
function fit_stage() {
  var scale_value = Math.min(window.innerWidth / 1920, window.innerHeight / 1080);
  wrap_el.style.transform = "translate(-50%, -50%) scale(" + scale_value + ")";
}
window.addEventListener("resize", fit_stage);
fit_stage();

function line_ms(text) { return timing.base_line_ms + timing.per_char_ms * text.length; }
function clamp_value(value, min_value, max_value) { return Math.max(min_value, Math.min(max_value, value)); }

function build_char(char_key, x_pos) {
  var person = movie_data.people[char_key];
  var el = document.createElement("div");
  el.className = "char";
  el.style.left = x_pos + "px";
  el.style.setProperty("--accent", person.accent);
  el.innerHTML = "<div class='cap'></div>" + lo_lib.build_figure(person) + "<div class='tag'>" + person.name + "</div>";
  chars_el.appendChild(el);
  return el;
}

function build_segments() {
  var cursor = 0;
  movie_data.timeline.forEach(function (item) {
    if (item.type === "title") {
      segments.push({ type: "title", start: cursor, dur: timing.title_total_ms, hold: timing.title_hold_ms, main: item.main, sub: item.sub || "", is_card: false });
      cursor += timing.title_total_ms;
    } else if (item.type === "cards") {
      item.cards.forEach(function (card_text) {
        segments.push({ type: "title", start: cursor, dur: timing.card_total_ms, hold: timing.card_hold_ms, main: card_text, sub: "", is_card: true });
        cursor += timing.card_total_ms;
      });
    } else if (item.type === "scene") {
      var line_starts = [];
      var offset = timing.intro_ms;
      item.lines.forEach(function (line_item) {
        line_starts.push(offset);
        offset += line_ms(line_item[1]) + timing.gap_ms;
      });
      var total_dur = offset + timing.outro_pause_ms + timing.fade_ms;
      segments.push({ type: "scene", start: cursor, dur: total_dur, data: item, line_starts: line_starts, lines_end: offset });
      cursor += total_dur;
    } else if (item.type === "credits") {
      segments.push({ type: "credits", start: cursor, dur: timing.credits_total_ms, data: item });
      cursor += timing.credits_total_ms;
    }
  });
  total_ms = cursor;
}

function prepare_credits() {
  var credits_data = null;
  segments.forEach(function (seg) { if (seg.type === "credits") { credits_data = seg.data; } });
  if (!credits_data) { return; }
  var html_parts = ["<div style='height:60px'></div>"];
  credits_data.lines.forEach(function (text_line) {
    if (text_line.charAt(0) === "#") { html_parts.push("<h2>" + text_line.slice(1) + "</h2>"); }
    else { html_parts.push("<div>" + (text_line || "&nbsp;") + "</div>"); }
  });
  credits_inner_el.innerHTML = html_parts.join("");
  credits_el.style.display = "block";
  credits_end_offset = -(credits_inner_el.offsetHeight + 40);
  credits_el.style.display = "none";
}

function clear_scene() {
  chars_el.innerHTML = "";
  bg_el.innerHTML = "";
  term_el.style.display = "none";
  term_text_el.textContent = "";
  slug_el.classList.remove("show");
  grade_el.style.background = "transparent";
  bg_el.style.transform = "scale(1)";
  chars_el.style.transform = "scale(1)";
  char_map = {};
  active_state_key = "";
}

function setup_scene(seg) {
  var scene_data = seg.data;
  var set_data = lo_lib.set_table[scene_data.set];
  bg_el.innerHTML = set_data.fn();
  grade_el.style.background = set_data.tint;
  term_el.style.display = scene_data.term ? "block" : "none";
  term_title_el.textContent = scene_data.term_title || "terminal";
  slug_el.textContent = scene_data.slug;
  scene_data.chars.forEach(function (item) {
    var el = build_char(item[0], item[1]);
    if (item[3] !== undefined) { el.style.display = "none"; }
    char_map[item[0]] = { el: el, x: item[1], enter: item[3] };
  });
}

function render_title(seg, local) {
  var fade_in = clamp_value(local / 600, 0, 1);
  var fade_out = clamp_value((seg.hold - local) / 700, 0, 1);
  title_card_el.style.opacity = Math.min(fade_in, fade_out);
}

function render_scene(seg, local, seg_index) {
  var lines = seg.data.lines;
  var line_index = -1;
  for (var k = 0; k < lines.length; k++) {
    if (local >= seg.line_starts[k]) { line_index = k; }
  }
  var is_speaking = false;
  if (line_index >= 0) {
    is_speaking = local < seg.line_starts[line_index] + line_ms(lines[line_index][1]);
  }
  speech_desired = is_speaking ? { key: seg_index + ":" + line_index, who: lines[line_index][0], text: lines[line_index][1], window_ms: line_ms(lines[line_index][1]) } : null;
  var state_key = line_index + ":" + is_speaking;
  if (state_key !== active_state_key) {
    active_state_key = state_key;
    Object.keys(char_map).forEach(function (key) {
      var entry = char_map[key];
      entry.el.classList.remove("talking");
      entry.el.querySelector(".cap").classList.remove("on");
      if (entry.enter !== undefined) {
        entry.el.style.display = line_index >= entry.enter ? "block" : "none";
      }
    });
    if (line_index >= 0 && is_speaking) {
      var speaker = char_map[lines[line_index][0]];
      var cap_el = speaker.el.querySelector(".cap");
      var person = movie_data.people[lines[line_index][0]];
      cap_el.style.setProperty("--accent", person.accent);
      cap_el.style.setProperty("--shift", "0px");
      cap_el.innerHTML = "<span class='who'>" + person.name + "</span>" + lines[line_index][1];
      var cap_width = cap_el.offsetWidth;
      var left_edge = speaker.x - cap_width / 2;
      var right_edge = speaker.x + cap_width / 2;
      var shift_value = 0;
      if (left_edge < 70) { shift_value = 70 - left_edge; }
      if (right_edge + shift_value > 1850) { shift_value = 1850 - right_edge; }
      cap_el.style.setProperty("--shift", shift_value + "px");
      cap_el.classList.add("on");
      speaker.el.classList.add("talking");
    }
    var term_lines = [];
    for (var j = 0; j <= line_index; j++) {
      if (lines[j][2]) { term_lines = term_lines.concat(lines[j][2].split("\n")); }
    }
    term_text_el.textContent = term_lines.slice(-6).join("\n");
  }
  slug_el.classList.toggle("show", local < timing.intro_ms);
  var progress = clamp_value(local / seg.dur, 0, 1);
  bg_el.style.transform = "scale(" + (1 + 0.02 * progress) + ")";
  chars_el.style.transform = "scale(" + (1 + 0.035 * progress) + ")";
  var outro_start = seg.lines_end + timing.outro_pause_ms;
  stage_el.style.opacity = local > outro_start ? clamp_value(1 - (local - outro_start) / timing.fade_ms, 0, 1) : 1;
}

function render_credits(seg, local) {
  var progress = clamp_value(local / timing.credits_scroll_ms, 0, 1);
  var y_pos = 1080 + (credits_end_offset - 1080) * progress;
  credits_inner_el.style.transform = "translateY(" + y_pos + "px)";
}

function render_time(t) {
  var seg_index = segments.length - 1;
  for (var i = 0; i < segments.length; i++) {
    if (t >= segments[i].start && t < segments[i].start + segments[i].dur) { seg_index = i; break; }
  }
  var seg = segments[seg_index];
  var local = t - seg.start;
  if (seg_index !== active_seg_index) {
    clear_scene();
    active_seg_index = seg_index;
    stage_el.style.opacity = 1;
    title_card_el.style.opacity = 0;
    credits_el.style.display = "none";
    if (seg.type === "title") {
      title_main_el.textContent = seg.main;
      title_sub_el.textContent = seg.sub;
      title_card_el.className = seg.is_card ? "card" : "";
    } else if (seg.type === "scene") {
      setup_scene(seg);
    } else if (seg.type === "credits") {
      credits_el.style.display = "block";
    }
  }
  if (seg.type !== "scene") { speech_desired = null; }
  if (seg.type === "title") { render_title(seg, local); }
  else if (seg.type === "scene") { render_scene(seg, local, seg_index); }
  else if (seg.type === "credits") { render_credits(seg, local); }
}

/* ---------- playback ---------- */
function show_osd(text) {
  osd_el.textContent = text;
  osd_el.classList.add("show");
  clearTimeout(osd_timer);
  osd_timer = setTimeout(function () { osd_el.classList.remove("show"); }, 900);
}
function set_playing(value) {
  is_playing = value;
  document.body.classList.toggle("paused", !value);
}
function toggle_play() {
  if (!is_playing && cur_ms >= total_ms - 1) { cur_ms = 0; active_seg_index = -1; speech_active_key = ""; }
  var next_state = !is_playing;
  if (speech_ok) {
    if (next_state) {
      if (speech_active_key === "__seek__") { speechSynthesis.cancel(); }
      speechSynthesis.resume();
    } else {
      speechSynthesis.pause();
    }
  }
  set_playing(next_state);
  show_osd(is_playing ? "▶  Play" : "⏸  Pause");
}
function seek_by(delta_ms) {
  cur_ms = clamp_value(cur_ms + delta_ms, 0, total_ms - 1);
  render_time(cur_ms);
  speech_active_key = "__seek__";
  if (speech_ok && is_playing) { speechSynthesis.cancel(); }
  show_osd(delta_ms > 0 ? "+10s  ⏩" : "⏪  -10s");
}
function toggle_mute() {
  is_muted = !is_muted;
  if (speech_ok) { speechSynthesis.cancel(); }
  speech_active_key = "__seek__";
  show_osd(is_muted ? "🔇  Sound off" : "🔊  Sound on");
}
function tick(now) {
  if (is_playing) {
    cur_ms += now - last_now;
    if (cur_ms >= total_ms - 1) { cur_ms = total_ms - 1; set_playing(false); if (speech_ok) { speechSynthesis.cancel(); } }
    render_time(cur_ms);
    sync_speech();
  }
  last_now = now;
  requestAnimationFrame(tick);
}
function begin_movie() {
  if (is_started) { return; }
  is_started = true;
  start_screen_el.style.display = "none";
  document.body.style.cursor = "none";
  cur_ms = 0;
  render_time(0);
  set_playing(true);
}

document.addEventListener("keydown", function (event) {
  if (event.code === "Space") {
    event.preventDefault();
    if (event.repeat) { return; }
    if (!is_started) { begin_movie(); return; }
    toggle_play();
  } else if (event.code === "ArrowRight" && is_started) {
    event.preventDefault();
    seek_by(seek_step_ms);
  } else if (event.code === "ArrowLeft" && is_started) {
    event.preventDefault();
    seek_by(-seek_step_ms);
  } else if (event.code === "KeyM") {
    toggle_mute();
  }
});
start_screen_el.addEventListener("click", begin_movie);

build_segments();
prepare_credits();
document.body.classList.add("paused");
requestAnimationFrame(function (now) { last_now = now; requestAnimationFrame(tick); });
</script>
</body>
</html>
