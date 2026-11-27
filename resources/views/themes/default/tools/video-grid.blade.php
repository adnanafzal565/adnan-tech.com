<div id="video-grid-app"></div>

<script type="text/babel">

    /*
      VideoGrid
      A 2 x 2 grid of four independent video frames that touch each other, with no gaps.
    
        Video 1   Video 2
        Video 3   Video 4
    
      - Each frame has its own file picker, its own <video> element and its own state,
        so play, pause, seek and mute only ever touch the video you clicked.
      - Each frame's controls sit on top of its video. The "Hide controls" button in the
        header removes them from every frame at once, leaving only the videos.
      - Click a video to play or pause it (this works whether controls are shown or hidden).
      - Each frame can crop the video (drag a box and its handles), then zoom and pan the
        picture inside the frame. Cropping is a display crop: the file is not changed.
      - No props are required. Use it as: <VideoGrid />
    */
    
    // ---------- Constants ----------
    
    const SLOT_COUNT = 4; // how many frames the grid has
    const MIN_CROP = 0.08; // smallest crop box, as a fraction of the video's width or height
    const MAX_ZOOM = 4; // largest zoom inside a frame
    const CLICK_SLOP = 5; // pointer movement (px) below which a press counts as a click, not a drag
    const CROP_PAD = 16; // space kept around the video while cropping, so edge handles stay reachable
    const CROP_PAD_BOTTOM = 58; // extra space at the bottom while cropping, for the crop buttons
    const FULL_CROP = { x: 0, y: 0, w: 1, h: 1 }; // "no crop": the whole video
    const DEFAULT_VIEW = { zoom: 1, panX: 0, panY: 0 }; // no zoom, picture centred
    
    // Where each crop handle sits on the crop box, and which cursor it shows.
    const HANDLES = {
      nw: { left: "0%", top: "0%", cursor: "nwse-resize" },
      n: { left: "50%", top: "0%", cursor: "ns-resize" },
      ne: { left: "100%", top: "0%", cursor: "nesw-resize" },
      e: { left: "100%", top: "50%", cursor: "ew-resize" },
      se: { left: "100%", top: "100%", cursor: "nwse-resize" },
      s: { left: "50%", top: "100%", cursor: "ns-resize" },
      sw: { left: "0%", top: "100%", cursor: "nesw-resize" },
      w: { left: "0%", top: "50%", cursor: "ew-resize" },
    };
    
    // Keep a number between a minimum and a maximum.
    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
    
    // Turn seconds into m:ss for the time display.
    const formatTime = (seconds) => {
      if (!Number.isFinite(seconds)) return "0:00";
      const whole = Math.floor(seconds);
      return `${Math.floor(whole / 60)}:${String(whole % 60).padStart(2, "0")}`;
    };
    
    // ---------- Styles (every style in this file comes from this one object) ----------
    
    const style = {
      page: {
        minHeight: "100vh",
        background: "#f3f5f7",
        color: "#17202a",
        fontFamily: "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif",
        padding: "1.5rem 1rem 3rem",
        boxSizing: "border-box",
      },
      shell: { maxWidth: "72rem", margin: "0 auto" },
      header: {
        display: "flex",
        flexWrap: "wrap",
        alignItems: "center",
        justifyContent: "space-between",
        gap: "0.75rem",
        marginBottom: "1rem",
      },
      title: { margin: 0, fontSize: "1.5rem", fontWeight: 700, letterSpacing: "-0.01em" },
      subtitle: { margin: "0.2rem 0 0", fontSize: "0.92rem", color: "#5b6773" },
    
      // The grid: two columns, no gap, so the four frames touch.
      grid: {
        display: "grid",
        gridTemplateColumns: "repeat(2, minmax(0, 1fr))",
        gap: 0,
        background: "#0c1116",
        borderRadius: 10,
        overflow: "hidden",
      },
    
      // One frame (this is the whole cell: the video and its controls are drawn inside it).
      cell: {
        position: "relative",
        width: "100%",
        aspectRatio: "16 / 9",
        background: "#0c1116",
        overflow: "hidden",
        userSelect: "none",
        minWidth: 0,
      },
      emptyFrame: {
        position: "absolute",
        inset: "0.5rem",
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
        gap: "0.5rem",
        color: "#9aa7b3",
        fontSize: "0.88rem",
        border: "2px dashed #3a4652",
        borderRadius: 8,
        boxSizing: "border-box",
      },
      frameMessage: {
        position: "absolute",
        inset: 0,
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        padding: "1rem",
        textAlign: "center",
        background: "rgba(12, 17, 22, 0.9)",
        color: "#ffd9d9",
        fontSize: "0.88rem",
      },
      hiddenInput: { display: "none" },
    
      // Strip along the top of a frame with the video's name. It ignores the pointer, so clicks pass through.
      topBar: {
        position: "absolute",
        top: 0,
        left: 0,
        right: 0,
        display: "flex",
        alignItems: "baseline",
        gap: "0.6rem",
        padding: "0.45rem 0.7rem 1rem",
        background: "linear-gradient(to bottom, rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0))",
        color: "#ffffff",
        fontSize: "0.85rem",
        pointerEvents: "none",
        minWidth: 0,
      },
      cellTitle: { fontWeight: 700, flexShrink: 0 },
      fileName: {
        color: "rgba(255, 255, 255, 0.8)",
        fontSize: "0.8rem",
        overflow: "hidden",
        textOverflow: "ellipsis",
        whiteSpace: "nowrap",
        minWidth: 0,
      },
      badge: {
        marginLeft: "auto",
        flexShrink: 0,
        fontSize: "0.75rem",
        color: "#0c1116",
        background: "#9be3da",
        borderRadius: 999,
        padding: "0.05rem 0.55rem",
      },
    
      // Control panel along the bottom of a frame.
      panel: {
        position: "absolute",
        left: 0,
        right: 0,
        bottom: 0,
        display: "flex",
        flexDirection: "column",
        gap: "0.35rem",
        padding: "0.5rem 0.6rem",
        background: "rgba(10, 14, 18, 0.8)",
        color: "#ffffff",
      },
      row: { display: "flex", alignItems: "center", gap: "0.4rem", flexWrap: "wrap" },
      range: { flex: 1, minWidth: "4rem", accentColor: "#2bb3a3" },
      time: {
        fontSize: "0.75rem",
        color: "rgba(255, 255, 255, 0.85)",
        fontVariantNumeric: "tabular-nums",
        whiteSpace: "nowrap",
      },
      sliderLabel: {
        display: "flex",
        alignItems: "center",
        gap: "0.4rem",
        flex: 1,
        minWidth: "7rem",
        fontSize: "0.8rem",
      },
      zoomValue: {
        fontSize: "0.75rem",
        color: "rgba(255, 255, 255, 0.85)",
        minWidth: "2.2rem",
        fontVariantNumeric: "tabular-nums",
      },
      panelHint: { margin: 0, fontSize: "0.75rem", color: "rgba(255, 255, 255, 0.8)" },
    
      // Button on the light page (the Hide controls / Show controls toggle).
      button: (disabled) => ({
        font: "inherit",
        fontSize: "0.88rem",
        padding: "0.45rem 0.9rem",
        borderRadius: 6,
        border: "1px solid #c9d2da",
        background: "#ffffff",
        color: "#17202a",
        cursor: disabled ? "not-allowed" : "pointer",
        opacity: disabled ? 0.5 : 1,
      }),
    
      // Button on top of a video. kind is "primary", "plain" or "danger".
      overlayButton: (kind, disabled) => ({
        font: "inherit",
        fontSize: "0.8rem",
        padding: "0.3rem 0.65rem",
        borderRadius: 6,
        border: `1px solid ${kind === "primary" ? "#2bb3a3" : "rgba(255, 255, 255, 0.35)"}`,
        background: kind === "primary" ? "#0f766e" : "rgba(255, 255, 255, 0.12)",
        color: kind === "danger" ? "#ffb4b4" : "#ffffff",
        fontWeight: kind === "primary" ? 600 : 400,
        minWidth: kind === "primary" ? "4.2rem" : undefined,
        cursor: disabled ? "not-allowed" : "pointer",
        opacity: disabled ? 0.45 : 1,
      }),
    
      // The <video> element. It is sized and positioned from the computed layout.
      videoLayer: (layout) =>
        layout.ready
          ? {
              position: "absolute",
              left: 0,
              top: 0,
              width: layout.width,
              height: layout.height,
              maxWidth: "none",
              transform: `translate(${layout.tx}px, ${layout.ty}px)`,
              clipPath: layout.clip,
              pointerEvents: "none",
              willChange: "transform",
            }
          : { position: "absolute", inset: 0, width: "100%", height: "100%", opacity: 0, pointerEvents: "none" },
    
      // A transparent layer over the video: a click plays or pauses, a drag pans a zoomed-in picture.
      clickSurface: (canPan, dragging) => ({
        position: "absolute",
        inset: 0,
        cursor: canPan ? (dragging ? "grabbing" : "grab") : "pointer",
        touchAction: canPan ? "none" : "manipulation",
      }),
    
      // Crop editor: a box the size of the displayed video, with the crop rectangle inside it.
      cropArea: (layout) => ({
        position: "absolute",
        left: layout.tx,
        top: layout.ty,
        width: layout.width,
        height: layout.height,
      }),
      cropRect: (rect) => ({
        position: "absolute",
        left: `${rect.x * 100}%`,
        top: `${rect.y * 100}%`,
        width: `${rect.w * 100}%`,
        height: `${rect.h * 100}%`,
        boxSizing: "border-box",
        border: "2px solid #ffffff",
        boxShadow: "0 0 0 9999px rgba(0, 0, 0, 0.55)",
        cursor: "move",
        touchAction: "none",
      }),
      handle: (name) => ({
        position: "absolute",
        left: HANDLES[name].left,
        top: HANDLES[name].top,
        width: 14,
        height: 14,
        transform: "translate(-50%, -50%)",
        background: "#ffffff",
        border: "2px solid #0f766e",
        borderRadius: 3,
        boxSizing: "border-box",
        cursor: HANDLES[name].cursor,
        touchAction: "none",
      }),
    };
    
    // ---------- One frame ----------
    
    function VideoCell({ index, source, controlsHidden, onPick, onClear }) {
      const label = `Video ${index + 1}`;
    
      // Refs to DOM elements and to drags in progress.
      const videoRef = React.useRef(null);
      const frameRef = React.useRef(null);
      const inputRef = React.useRef(null);
      const panDrag = React.useRef(null);
      const cropDrag = React.useRef(null);
    
      // Playback state, mirrored from the <video> element's own events.
      const [playing, setPlaying] = React.useState(false);
      const [muted, setMuted] = React.useState(false);
      const [time, setTime] = React.useState(0);
      const [duration, setDuration] = React.useState(0);
      const [failed, setFailed] = React.useState(false);
    
      // Picture state: natural size of the video, size of the frame, and the edit settings.
      const [natural, setNatural] = React.useState(null);
      const [frameSize, setFrameSize] = React.useState({ w: 0, h: 0 });
      const [mode, setMode] = React.useState("view"); // "view" or "crop"
      const [crop, setCrop] = React.useState(FULL_CROP); // the applied crop
      const [draft, setDraft] = React.useState(FULL_CROP); // the crop being edited
      const [view, setView] = React.useState(DEFAULT_VIEW); // zoom and pan inside the frame
      const [dragging, setDragging] = React.useState(false);
    
      // Track the frame's size in pixels, so the picture can be scaled to fit it.
      React.useEffect(() => {
        const frame = frameRef.current;
        if (!frame || typeof ResizeObserver === "undefined") return undefined;
        const observer = new ResizeObserver((entries) => {
          const box = entries[0].contentRect;
          setFrameSize({ w: box.width, h: box.height });
        });
        observer.observe(frame);
        return () => observer.disconnect();
      }, []);
    
      // If the controls get hidden while this frame is cropping, leave crop mode (the unapplied box is discarded).
      React.useEffect(() => {
        if (controlsHidden) setMode("view");
      }, [controlsHidden]);
    
      // Ctrl or Cmd + scroll (and trackpad pinch) zooms. Plain scrolling still scrolls the page.
      React.useEffect(() => {
        const frame = frameRef.current;
        if (!frame || !source) return undefined;
        const onWheel = (event) => {
          if (mode !== "view" || !(event.ctrlKey || event.metaKey)) return;
          event.preventDefault();
          const factor = event.deltaY < 0 ? 1.1 : 1 / 1.1;
          setView((v) => ({ ...v, zoom: clamp(v.zoom * factor, 1, MAX_ZOOM) }));
        };
        frame.addEventListener("wheel", onWheel, { passive: false });
        return () => frame.removeEventListener("wheel", onWheel);
      }, [source, mode]);
    
      // Work out where the <video> goes inside the frame.
      // In crop mode the whole video is shown with some space around it. Otherwise the crop
      // region is fitted to the frame, then zoomed and panned. Pan is limited so the picture
      // never drifts off the frame.
      const layout = React.useMemo(() => {
        if (!natural || !frameSize.w || !frameSize.h) return { ready: false };
    
        if (mode === "crop") {
          const availW = Math.max(1, frameSize.w - CROP_PAD * 2);
          const availH = Math.max(1, frameSize.h - CROP_PAD - CROP_PAD_BOTTOM);
          const scale = Math.min(availW / natural.w, availH / natural.h);
          const width = natural.w * scale;
          const height = natural.h * scale;
          return {
            ready: true,
            width,
            height,
            tx: CROP_PAD + (availW - width) / 2,
            ty: CROP_PAD + (availH - height) / 2,
            clip: "none",
            maxPanX: 0,
            maxPanY: 0,
            panX: 0,
            panY: 0,
          };
        }
    
        const regionW = crop.w * natural.w;
        const regionH = crop.h * natural.h;
        const scale = Math.min(frameSize.w / regionW, frameSize.h / regionH) * view.zoom;
        const maxPanX = Math.max(0, (regionW * scale - frameSize.w) / 2);
        const maxPanY = Math.max(0, (regionH * scale - frameSize.h) / 2);
        const panX = clamp(view.panX, -maxPanX, maxPanX);
        const panY = clamp(view.panY, -maxPanY, maxPanY);
        const centreX = (crop.x + crop.w / 2) * natural.w;
        const centreY = (crop.y + crop.h / 2) * natural.h;
        const isFull = crop.x === 0 && crop.y === 0 && crop.w === 1 && crop.h === 1;
        return {
          ready: true,
          width: natural.w * scale,
          height: natural.h * scale,
          tx: frameSize.w / 2 - centreX * scale + panX,
          ty: frameSize.h / 2 - centreY * scale + panY,
          clip: isFull
            ? "none"
            : `inset(${crop.y * 100}% ${(1 - crop.x - crop.w) * 100}% ${(1 - crop.y - crop.h) * 100}% ${crop.x * 100}%)`,
          maxPanX,
          maxPanY,
          panX,
          panY,
        };
      }, [natural, frameSize, mode, crop, view]);
    
      const isCropped = crop.x !== 0 || crop.y !== 0 || crop.w !== 1 || crop.h !== 1;
      const isEdited = isCropped || view.zoom !== 1 || view.panX !== 0 || view.panY !== 0;
      const canPan = mode === "view" && layout.ready && view.zoom > 1;
    
      // ----- Playback: these only ever touch this cell's own <video> element -----
    
      const togglePlay = React.useCallback(() => {
        const video = videoRef.current;
        if (!video) return;
        if (video.paused) {
          const attempt = video.play();
          if (attempt && attempt.catch) attempt.catch(() => setPlaying(false));
        } else {
          video.pause();
        }
      }, []);
    
      const toggleMute = React.useCallback(() => {
        const video = videoRef.current;
        if (video) video.muted = !video.muted;
      }, []);
    
      const seekTo = React.useCallback((event) => {
        const video = videoRef.current;
        if (video) video.currentTime = Number(event.target.value);
      }, []);
    
      const handleLoaded = React.useCallback((event) => {
        const video = event.currentTarget;
        if (!video.videoWidth || !video.videoHeight) {
          setFailed(true); // audio-only or unreadable file
          return;
        }
        setNatural({ w: video.videoWidth, h: video.videoHeight });
        setDuration(video.duration);
        setFailed(false);
      }, []);
    
      const handleFile = React.useCallback(
        (event) => {
          const file = event.target.files && event.target.files[0];
          if (file) onPick(index, file);
          event.target.value = ""; // lets you pick the same file again later
        },
        [index, onPick]
      );
    
      // ----- Click to play or pause, and drag to pan -----
      // A press that barely moves is a click and toggles playback. A press that moves is a drag
      // and, when the picture is zoomed in, pans it.
    
      const beginPan = React.useCallback(
        (event) => {
          event.currentTarget.setPointerCapture(event.pointerId);
          panDrag.current = {
            x: event.clientX,
            y: event.clientY,
            panX: layout.panX || 0,
            panY: layout.panY || 0,
            moved: false,
          };
        },
        [layout]
      );
    
      const movePan = React.useCallback(
        (event) => {
          const start = panDrag.current;
          if (!start) return;
          const dx = event.clientX - start.x;
          const dy = event.clientY - start.y;
          if (!start.moved && Math.hypot(dx, dy) < CLICK_SLOP) return;
          start.moved = true;
          if (!canPan) return;
          setDragging(true);
          setView((v) => ({
            ...v,
            panX: clamp(start.panX + dx, -layout.maxPanX, layout.maxPanX),
            panY: clamp(start.panY + dy, -layout.maxPanY, layout.maxPanY),
          }));
        },
        [canPan, layout]
      );
    
      const endPan = React.useCallback(
        (event) => {
          const start = panDrag.current;
          panDrag.current = null;
          setDragging(false);
          if (start && !start.moved && event.type === "pointerup") togglePlay();
        },
        [togglePlay]
      );
    
      const surfaceKeyDown = React.useCallback(
        (event) => {
          if (event.key === " " || event.key === "Enter") {
            event.preventDefault();
            togglePlay();
          }
        },
        [togglePlay]
      );
    
      // ----- Crop: drag the box (move) or one of its eight handles (resize) -----
    
      const beginCrop = React.useCallback(
        (event, handle) => {
          event.stopPropagation();
          event.currentTarget.setPointerCapture(event.pointerId);
          cropDrag.current = { handle, x: event.clientX, y: event.clientY, rect: draft };
        },
        [draft]
      );
    
      const moveCrop = React.useCallback(
        (event) => {
          event.stopPropagation();
          const start = cropDrag.current;
          if (!start || !layout.ready) return;
          const dx = (event.clientX - start.x) / layout.width; // pointer movement as a fraction of the video
          const dy = (event.clientY - start.y) / layout.height;
          const r = start.rect;
          let { x, y, w, h } = r;
          if (start.handle === "move") {
            x = clamp(r.x + dx, 0, 1 - r.w);
            y = clamp(r.y + dy, 0, 1 - r.h);
          } else {
            if (start.handle.includes("w")) {
              x = clamp(r.x + dx, 0, r.x + r.w - MIN_CROP);
              w = r.x + r.w - x;
            }
            if (start.handle.includes("e")) w = clamp(r.w + dx, MIN_CROP, 1 - r.x);
            if (start.handle.includes("n")) {
              y = clamp(r.y + dy, 0, r.y + r.h - MIN_CROP);
              h = r.y + r.h - y;
            }
            if (start.handle.includes("s")) h = clamp(r.h + dy, MIN_CROP, 1 - r.y);
          }
          setDraft({ x, y, w, h });
        },
        [layout]
      );
    
      const endCrop = React.useCallback((event) => {
        event.stopPropagation();
        cropDrag.current = null;
      }, []);
    
      const dragProps = (handle) => ({
        onPointerDown: (event) => beginCrop(event, handle),
        onPointerMove: moveCrop,
        onPointerUp: endCrop,
        onPointerCancel: endCrop,
      });
    
      const startCrop = () => {
        setDraft(crop);
        setMode("crop");
      };
      const applyCrop = () => {
        setCrop(draft);
        setView(DEFAULT_VIEW); // a new crop starts centred and at 1x
        setMode("view");
      };
      const resetEdits = () => {
        setCrop(FULL_CROP);
        setView(DEFAULT_VIEW);
      };
      const openPicker = () => {
        if (inputRef.current) inputRef.current.click();
      };
    
      // ----- Render -----
    
      return (
        <div ref={frameRef} style={style.cell} role="group" aria-label={`${label} frame`}>
          <input ref={inputRef} type="file" accept="video/*" style={style.hiddenInput} onChange={handleFile} />
    
          {source ? (
            <>
              <video
                ref={videoRef}
                src={source.url}
                preload="metadata"
                playsInline
                style={style.videoLayer(layout)}
                onLoadedMetadata={handleLoaded}
                onError={() => setFailed(true)}
                onPlay={() => setPlaying(true)}
                onPause={() => setPlaying(false)}
                onEnded={() => setPlaying(false)}
                onTimeUpdate={(event) => setTime(event.currentTarget.currentTime)}
                onVolumeChange={(event) => setMuted(event.currentTarget.muted)}
              />
    
              {mode === "view" && (
                <div
                  style={style.clickSurface(canPan, dragging)}
                  role="button"
                  tabIndex={0}
                  aria-pressed={playing}
                  aria-label={`Play or pause ${label.toLowerCase()}`}
                  onPointerDown={beginPan}
                  onPointerMove={movePan}
                  onPointerUp={endPan}
                  onPointerCancel={endPan}
                  onKeyDown={surfaceKeyDown}
                />
              )}
    
              {mode === "crop" && layout.ready && (
                <div style={style.cropArea(layout)}>
                  <div style={style.cropRect(draft)} {...dragProps("move")}>
                    {Object.keys(HANDLES).map((name) => (
                      <span key={name} style={style.handle(name)} {...dragProps(name)} />
                    ))}
                  </div>
                </div>
              )}
    
              {failed && (
                <div style={style.frameMessage}>This file can't be played here. Try an MP4 (H.264) or WebM video.</div>
              )}
    
              {!controlsHidden && (
                <>
                  <div style={style.topBar}>
                    <span style={style.cellTitle}>{label}</span>
                    <span style={style.fileName} title={source.name}>
                      {source.name}
                    </span>
                    {isEdited && mode === "view" && (
                      <span style={style.badge}>
                        {isCropped ? "Cropped" : "Adjusted"}
                        {view.zoom !== 1 ? `, ${view.zoom.toFixed(1)}x` : ""}
                      </span>
                    )}
                  </div>
    
                  <div style={style.panel}>
                    {mode === "view" ? (
                      <>
                        <div style={style.row}>
                          <button
                            type="button"
                            style={style.overlayButton("primary", false)}
                            onClick={togglePlay}
                            aria-label={`${playing ? "Pause" : "Play"} ${label.toLowerCase()}`}
                          >
                            {playing ? "Pause" : "Play"}
                          </button>
                          <input
                            type="range"
                            style={style.range}
                            min={0}
                            max={duration || 0}
                            step="0.01"
                            value={Math.min(time, duration || 0)}
                            onChange={seekTo}
                            disabled={!duration}
                            aria-label={`Seek ${label.toLowerCase()}`}
                          />
                          <span style={style.time}>
                            {formatTime(time)} / {formatTime(duration)}
                          </span>
                          <button
                            type="button"
                            style={style.overlayButton("plain", false)}
                            onClick={toggleMute}
                            aria-pressed={muted}
                            aria-label={`${muted ? "Unmute" : "Mute"} ${label.toLowerCase()}`}
                          >
                            {muted ? "Unmute" : "Mute"}
                          </button>
                        </div>
    
                        <div style={style.row}>
                          <label style={style.sliderLabel}>
                            Zoom
                            <input
                              type="range"
                              style={style.range}
                              min={1}
                              max={MAX_ZOOM}
                              step="0.01"
                              value={view.zoom}
                              onChange={(event) => setView((v) => ({ ...v, zoom: Number(event.target.value) }))}
                              disabled={!layout.ready}
                            />
                            <span style={style.zoomValue}>{view.zoom.toFixed(1)}x</span>
                          </label>
                          <button
                            type="button"
                            style={style.overlayButton("plain", !layout.ready)}
                            onClick={startCrop}
                            disabled={!layout.ready}
                          >
                            Crop
                          </button>
                          <button
                            type="button"
                            style={style.overlayButton("plain", !isEdited)}
                            onClick={resetEdits}
                            disabled={!isEdited}
                          >
                            Reset
                          </button>
                          <button type="button" style={style.overlayButton("plain", false)} onClick={openPicker}>
                            Replace
                          </button>
                          <button type="button" style={style.overlayButton("danger", false)} onClick={() => onClear(index)}>
                            Remove
                          </button>
                        </div>
                      </>
                    ) : (
                      <div style={style.row}>
                        <button type="button" style={style.overlayButton("primary", false)} onClick={applyCrop}>
                          Apply crop
                        </button>
                        <button type="button" style={style.overlayButton("plain", false)} onClick={() => setMode("view")}>
                          Cancel
                        </button>
                        <button type="button" style={style.overlayButton("plain", false)} onClick={() => setDraft(FULL_CROP)}>
                          Full frame
                        </button>
                        <p style={style.panelHint}>Drag the box or its handles.</p>
                      </div>
                    )}
                  </div>
                </>
              )}
            </>
          ) : (
            <div style={style.emptyFrame}>
              <span>No video yet</span>
              <button type="button" style={style.overlayButton("primary", false)} onClick={openPicker}>
                Select {label.toLowerCase()}
              </button>
            </div>
          )}
        </div>
      );
    }
    
    // ---------- The grid ----------
    
    function VideoGrid() {
      // One entry per frame: null (empty) or { url, name }.
      const [sources, setSources] = React.useState(() => Array(SLOT_COUNT).fill(null));
      const [controlsHidden, setControlsHidden] = React.useState(false);
      const sourcesRef = React.useRef(sources);
    
      // Keep a ref to the latest sources, and free every video URL when the grid unmounts.
      React.useEffect(() => {
        sourcesRef.current = sources;
      }, [sources]);
      React.useEffect(
        () => () => {
          sourcesRef.current.forEach((item) => item && URL.revokeObjectURL(item.url));
        },
        []
      );
    
      // Put one file in one frame (or empty the frame when file is null).
      const setSlot = React.useCallback((index, file) => {
        const current = sourcesRef.current[index];
        if (current) URL.revokeObjectURL(current.url);
        const next = file ? { url: URL.createObjectURL(file), name: file.name } : null;
        setSources((previous) => previous.map((item, i) => (i === index ? next : item)));
      }, []);
    
      const clearSlot = React.useCallback((index) => setSlot(index, null), [setSlot]);
    
      const loadedCount = sources.filter(Boolean).length;
    
      return (
        <div style={style.page}>
          <div style={style.shell}>
            <div style={style.header}>
              <div>
                <h1 style={style.title}>Video grid</h1>
                <p style={style.subtitle}>
                  {loadedCount} of {SLOT_COUNT} frames loaded. Click a video to play or pause it.
                </p>
              </div>
              <button
                type="button"
                style={style.button(false)}
                onClick={() => setControlsHidden((hidden) => !hidden)}
                aria-pressed={controlsHidden}
              >
                {controlsHidden ? "Show controls" : "Hide controls"}
              </button>
            </div>
    
            <div style={style.grid}>
              {sources.map((source, index) => (
                <VideoCell
                  key={`${index}-${source ? source.url : "empty"}`}
                  index={index}
                  source={source}
                  controlsHidden={controlsHidden}
                  onPick={setSlot}
                  onClear={clearSlot}
                />
              ))}
            </div>
          </div>
        </div>
      );
    }
    
    ReactDOM.createRoot(
        document.getElementById("video-grid-app")
    ).render(<VideoGrid />);
</script>