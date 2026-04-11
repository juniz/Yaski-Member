@extends('layouts.master')

@section('title')
Setting Template Sertifikat
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
<style>
    .template-canvas-wrapper {
        position: relative;
        display: inline-block;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: #e9ecef;
        cursor: default;
    }
    .template-canvas-wrapper canvas {
        display: block;
    }
    .config-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 16px;
    }
    .config-section h6 {
        color: #495057;
        margin-bottom: 12px;
        font-weight: 600;
    }
    .color-input-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .color-input-group input[type="color"] {
        width: 40px;
        height: 36px;
        padding: 2px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        cursor: pointer;
    }
    .drag-handle {
        cursor: move !important;
    }
    .element-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        margin-right: 4px;
    }
    .badge-nama { background: #28a745; color: #fff; }
    .badge-nosertifikat { background: #fd7e14; color: #fff; }
    .badge-instansi { background: #6f42c1; color: #fff; }
    .badge-qr { background: #0d6efd; color: #fff; }
    .drag-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 12px;
    }
</style>
@endsection

@section('content')
@component('components.alert')@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white mb-0">
                    <i class="bx bx-certification"></i> Setting Template Sertifikat
                    @if(isset($workshop))
                        - {{ $workshop->nama }}
                    @endif
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('workshop.setting.simpan', ['id' => $id]) }}" enctype="multipart/form-data" id="settingForm">
                    @csrf

                    <div class="row">
                        {{-- Left: Template Upload & Interactive Preview --}}
                        <div class="col-lg-8">
                            <div class="config-section">
                                <h6><i class="bx bx-image"></i> Template Desain Sertifikat</h6>

                                <div class="mb-3">
                                    <label for="file_template" class="form-label fw-bold">Upload Template</label>
                                    <input class="form-control" type="file" id="file_template" name="file_template"
                                           accept="image/jpeg,image/png,image/jpg">
                                    <small class="text-muted">Format: JPG/PNG, Maks: 5MB. Disarankan resolusi tinggi.</small>
                                    @error('file_template')
                                        <span class="text-danger d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="drag-info">
                                    <i class="bx bx-move"></i> <strong>Drag & Drop</strong> — Klik dan seret elemen di preview untuk mengatur posisi.
                                    Legenda:
                                    <span class="element-badge badge-nama">Nama</span>
                                    <span class="element-badge badge-nosertifikat">No. Sertifikat</span>
                                    <span class="element-badge badge-instansi">Instansi</span>
                                    <span class="element-badge badge-qr">QR Code</span>
                                </div>

                                <div class="template-canvas-wrapper" id="canvasWrapper">
                                    <canvas id="mainCanvas" width="800" height="400" style="max-width:100%;"></canvas>
                                </div>
                            </div>

                            <div class="config-section">
                                <h6><i class="bx bx-text"></i> Deskripsi Workshop (Opsional)</h6>
                                <textarea class="form-control" name="deskripsi" rows="2" placeholder="Deskripsi workshop...">{{ $setting->deskripsi ?? '' }}</textarea>
                            </div>
                        </div>

                        {{-- Right: Properties Panel --}}
                        <div class="col-lg-4">
                            {{-- Nama Config --}}
                            <div class="config-section">
                                <h6><span class="element-badge badge-nama">●</span> Nama Peserta</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label small">X</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="nama_x"
                                               id="nama_x" value="{{ $setting->nama_x ?? 500 }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Y</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="nama_y"
                                               id="nama_y" value="{{ $setting->nama_y ?? 400 }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Font Size</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="nama_font_size"
                                               id="nama_font_size" value="{{ $setting->nama_font_size ?? 40 }}" min="8" max="120">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Warna</label>
                                        <div class="color-input-group">
                                            <input type="color" class="pos-input" name="nama_color" id="nama_color"
                                                   value="{{ $setting->nama_color ?? '#000000' }}">
                                            <small id="nama_color_label">{{ $setting->nama_color ?? '#000000' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- No Sertifikat Config --}}
                            <div class="config-section">
                                <h6><span class="element-badge badge-nosertifikat">●</span> No. Sertifikat</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label small">X</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="no_sertifikat_x"
                                               id="no_sertifikat_x" value="{{ $setting->no_sertifikat_x ?? 500 }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Y</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="no_sertifikat_y"
                                               id="no_sertifikat_y" value="{{ $setting->no_sertifikat_y ?? 350 }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Font Size</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="no_sertifikat_font_size"
                                               id="no_sertifikat_font_size" value="{{ $setting->no_sertifikat_font_size ?? 20 }}" min="8" max="120">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Warna</label>
                                        <div class="color-input-group">
                                            <input type="color" class="pos-input" name="no_sertifikat_color" id="no_sertifikat_color"
                                                   value="{{ $setting->no_sertifikat_color ?? '#333333' }}">
                                            <small id="no_sertifikat_color_label">{{ $setting->no_sertifikat_color ?? '#333333' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Instansi Config --}}
                            <div class="config-section">
                                <h6><span class="element-badge badge-instansi">●</span> Instansi</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label small">X</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="instansi_x"
                                               id="instansi_x" value="{{ $setting->instansi_x ?? 500 }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Y</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="instansi_y"
                                               id="instansi_y" value="{{ $setting->instansi_y ?? 460 }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Font Size</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="instansi_font_size"
                                               id="instansi_font_size" value="{{ $setting->instansi_font_size ?? 24 }}" min="8" max="120">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Warna</label>
                                        <div class="color-input-group">
                                            <input type="color" class="pos-input" name="instansi_color" id="instansi_color"
                                                   value="{{ $setting->instansi_color ?? '#333333' }}">
                                            <small id="instansi_color_label">{{ $setting->instansi_color ?? '#333333' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- QR Code Config --}}
                            <div class="config-section">
                                <h6><span class="element-badge badge-qr">●</span> QR Code Validasi</h6>
                                <div class="mb-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input pos-input" type="checkbox" id="qr_enabled" name="qr_enabled"
                                               {{ ($setting->qr_enabled ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="qr_enabled">Tampilkan QR Code</label>
                                    </div>
                                    <small class="text-muted">QR berisi link validasi sertifikat</small>
                                </div>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <label class="form-label small">X</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="qr_x"
                                               id="qr_x" value="{{ $setting->qr_x ?? 900 }}">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label small">Y</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="qr_y"
                                               id="qr_y" value="{{ $setting->qr_y ?? 500 }}">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label small">Ukuran</label>
                                        <input type="number" class="form-control form-control-sm pos-input" name="qr_size"
                                               id="qr_size" value="{{ $setting->qr_size ?? 150 }}" min="50" max="500">
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bx bx-save"></i> Simpan Setting
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
(function() {
    // --- State ---
    const canvas = document.getElementById('mainCanvas');
    const ctx = canvas.getContext('2d');
    let templateImg = null;
    let naturalW = 0, naturalH = 0;
    let scale = 1; // ratio from natural to canvas display

    // Draggable elements
    const elements = {
        nama: {
            label: 'Nama Peserta Contoh',
            color: '#28a745',
            getX: () => parseInt(document.getElementById('nama_x').value) || 500,
            getY: () => parseInt(document.getElementById('nama_y').value) || 400,
            getFontSize: () => parseInt(document.getElementById('nama_font_size').value) || 40,
            getColor: () => document.getElementById('nama_color').value || '#000000',
            setX: (v) => { document.getElementById('nama_x').value = v; },
            setY: (v) => { document.getElementById('nama_y').value = v; },
        },
        no_sertifikat: {
            label: '2026/YASKI/04/001',
            color: '#fd7e14',
            getX: () => parseInt(document.getElementById('no_sertifikat_x').value) || 500,
            getY: () => parseInt(document.getElementById('no_sertifikat_y').value) || 350,
            getFontSize: () => parseInt(document.getElementById('no_sertifikat_font_size').value) || 20,
            getColor: () => document.getElementById('no_sertifikat_color').value || '#333333',
            setX: (v) => { document.getElementById('no_sertifikat_x').value = v; },
            setY: (v) => { document.getElementById('no_sertifikat_y').value = v; },
        },
        instansi: {
            label: 'RS Contoh Instansi',
            color: '#6f42c1',
            getX: () => parseInt(document.getElementById('instansi_x').value) || 500,
            getY: () => parseInt(document.getElementById('instansi_y').value) || 460,
            getFontSize: () => parseInt(document.getElementById('instansi_font_size').value) || 24,
            getColor: () => document.getElementById('instansi_color').value || '#333333',
            setX: (v) => { document.getElementById('instansi_x').value = v; },
            setY: (v) => { document.getElementById('instansi_y').value = v; },
        },
        qr: {
            label: 'QR',
            color: '#0d6efd',
            getX: () => parseInt(document.getElementById('qr_x').value) || 900,
            getY: () => parseInt(document.getElementById('qr_y').value) || 500,
            getSize: () => parseInt(document.getElementById('qr_size').value) || 150,
            isEnabled: () => document.getElementById('qr_enabled').checked,
            setX: (v) => { document.getElementById('qr_x').value = v; },
            setY: (v) => { document.getElementById('qr_y').value = v; },
        }
    };

    let dragging = null; // key of element being dragged
    let dragOffsetX = 0, dragOffsetY = 0;
    let hovering = null; // key of hovered element

    // --- Template Image Loading ---
    @if($setting && $setting->file_template)
        templateImg = new Image();
        templateImg.crossOrigin = 'anonymous';
        templateImg.onload = function() {
            naturalW = templateImg.naturalWidth;
            naturalH = templateImg.naturalHeight;
            resizeCanvas();
            render();
        };
        templateImg.onerror = function() {
            console.error('Failed to load template image');
            renderPlaceholder();
        };
        templateImg.src = "{{ asset('storage/workshop/template/' . $id . '/' . $setting->file_template) }}";
    @else
        renderPlaceholder();
    @endif

    // File upload preview
    document.getElementById('file_template').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                templateImg = new Image();
                templateImg.onload = function() {
                    naturalW = templateImg.naturalWidth;
                    naturalH = templateImg.naturalHeight;
                    resizeCanvas();
                    render();
                };
                templateImg.src = ev.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    function resizeCanvas() {
        // Fit canvas to container width, maintaining aspect ratio
        const wrapper = document.getElementById('canvasWrapper');
        const maxW = wrapper.parentElement.clientWidth - 4; // account for border
        const ratio = naturalH / naturalW;
        const displayW = Math.min(maxW, 1000);
        const displayH = displayW * ratio;

        canvas.width = displayW;
        canvas.height = displayH;
        scale = displayW / naturalW;
    }

    function renderPlaceholder() {
        canvas.width = 800;
        canvas.height = 400;
        ctx.fillStyle = '#e9ecef';
        ctx.fillRect(0, 0, 800, 400);
        ctx.fillStyle = '#6c757d';
        ctx.font = '18px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('Upload template sertifikat untuk memulai', 400, 180);
        ctx.font = '14px Arial';
        ctx.fillText('Setelah upload, Anda bisa drag & drop elemen di sini', 400, 220);
    }

    // --- Rendering ---
    function render() {
        if (!templateImg || !templateImg.complete) {
            renderPlaceholder();
            return;
        }

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw template
        ctx.drawImage(templateImg, 0, 0, canvas.width, canvas.height);

        // Draw text elements
        drawElement('nama');
        drawElement('no_sertifikat');
        drawElement('instansi');

        // Draw QR element
        if (elements.qr.isEnabled()) {
            drawQrElement();
        }
    }

    function drawElement(key) {
        const el = elements[key];
        const x = el.getX() * scale;
        const y = el.getY() * scale;
        const fontSize = el.getFontSize() * scale;
        const textColor = el.getColor();
        const isHover = (hovering === key);
        const isDrag = (dragging === key);

        // Draw sample text
        ctx.font = `bold ${Math.max(10, fontSize)}px Arial, sans-serif`;
        ctx.fillStyle = textColor;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(el.label, x, y);

        // Measure text for hit area
        const metrics = ctx.measureText(el.label);
        const tw = metrics.width;
        const th = fontSize;

        // Draw selection/hover box
        if (isHover || isDrag) {
            ctx.strokeStyle = el.color;
            ctx.lineWidth = 2;
            ctx.setLineDash([4, 3]);
            ctx.strokeRect(x - tw/2 - 6, y - th/2 - 4, tw + 12, th + 8);
            ctx.setLineDash([]);
        }

        // Draw colored label badge
        const badgeText = key === 'no_sertifikat' ? 'No.Sertifikat' : key.charAt(0).toUpperCase() + key.slice(1);
        ctx.font = 'bold 10px Arial';
        const badgeW = ctx.measureText(badgeText).width + 8;
        const badgeX = x - tw/2 - 6;
        const badgeY = y - th/2 - 18;

        ctx.fillStyle = el.color;
        ctx.beginPath();
        ctx.roundRect(badgeX, badgeY, badgeW, 14, 3);
        ctx.fill();
        ctx.fillStyle = '#fff';
        ctx.textAlign = 'left';
        ctx.textBaseline = 'top';
        ctx.fillText(badgeText, badgeX + 4, badgeY + 2);

        // Draw crosshair
        ctx.strokeStyle = el.color + '80';
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(x - 12, y);
        ctx.lineTo(x + 12, y);
        ctx.moveTo(x, y - 12);
        ctx.lineTo(x, y + 12);
        ctx.stroke();
    }

    function drawQrElement() {
        const el = elements.qr;
        const x = el.getX() * scale;
        const y = el.getY() * scale;
        const size = el.getSize() * scale;
        const half = size / 2;
        const isHover = (hovering === 'qr');
        const isDrag = (dragging === 'qr');

        // Draw QR placeholder box
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(x - half, y - half, size, size);

        ctx.strokeStyle = isHover || isDrag ? '#0d6efd' : '#333';
        ctx.lineWidth = isHover || isDrag ? 3 : 2;
        ctx.strokeRect(x - half, y - half, size, size);

        // Draw QR pattern simulation
        const cellCount = 7;
        const cellSize = size / (cellCount + 4);
        const startX = x - half + cellSize * 2;
        const startY = y - half + cellSize * 2;

        ctx.fillStyle = '#000';
        // Corner squares (simplified QR look)
        for (let r = 0; r < cellCount; r++) {
            for (let c = 0; c < cellCount; c++) {
                // Draw finder patterns at corners
                const isCorner = (r < 3 && c < 3) || (r < 3 && c >= cellCount-3) || (r >= cellCount-3 && c < 3);
                const isBorder = (r === 0 || r === cellCount-1 || c === 0 || c === cellCount-1) && isCorner;
                const isCenter = (r === 1 && c === 1) || (r === 1 && c === cellCount-2) || (r === cellCount-2 && c === 1);

                if (isBorder || isCenter || (Math.random() > 0.55 && !isCorner)) {
                    ctx.fillRect(startX + c * cellSize, startY + r * cellSize, cellSize - 1, cellSize - 1);
                }
            }
        }

        // Label badge
        ctx.fillStyle = '#0d6efd';
        const badgeText = 'QR Code';
        ctx.font = 'bold 10px Arial';
        const badgeW = ctx.measureText(badgeText).width + 8;
        ctx.beginPath();
        ctx.roundRect(x - half, y - half - 18, badgeW, 14, 3);
        ctx.fill();
        ctx.fillStyle = '#fff';
        ctx.textAlign = 'left';
        ctx.textBaseline = 'top';
        ctx.font = 'bold 10px Arial';
        ctx.fillText(badgeText, x - half + 4, y - half - 16);

        // Scan text
        ctx.fillStyle = '#0d6efd';
        ctx.font = `${Math.max(8, size * 0.1)}px Arial`;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'top';
        ctx.fillText('Scan untuk validasi', x, y + half + 4);
    }

    // --- Hit Testing ---
    function getElementAt(mx, my) {
        // Check QR first (on top)
        if (elements.qr.isEnabled()) {
            const qx = elements.qr.getX() * scale;
            const qy = elements.qr.getY() * scale;
            const qs = elements.qr.getSize() * scale / 2;
            if (mx >= qx - qs - 10 && mx <= qx + qs + 10 && my >= qy - qs - 10 && my <= qy + qs + 10) {
                return 'qr';
            }
        }

        // Check text elements
        for (const key of ['nama', 'no_sertifikat', 'instansi']) {
            const el = elements[key];
            const x = el.getX() * scale;
            const y = el.getY() * scale;
            const fontSize = el.getFontSize() * scale;

            ctx.font = `bold ${Math.max(10, fontSize)}px Arial, sans-serif`;
            const tw = ctx.measureText(el.label).width;
            const th = fontSize;

            if (mx >= x - tw/2 - 10 && mx <= x + tw/2 + 10 && my >= y - th/2 - 10 && my <= y + th/2 + 10) {
                return key;
            }
        }

        return null;
    }

    function getMousePos(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleFactorX = canvas.width / rect.width;
        const scaleFactorY = canvas.height / rect.height;
        return {
            x: (e.clientX - rect.left) * scaleFactorX,
            y: (e.clientY - rect.top) * scaleFactorY
        };
    }

    // --- Mouse Events for Drag & Drop ---
    canvas.addEventListener('mousedown', function(e) {
        if (!templateImg || !templateImg.complete) return;
        const pos = getMousePos(e);
        const hit = getElementAt(pos.x, pos.y);
        if (hit) {
            dragging = hit;
            const el = elements[hit];
            dragOffsetX = pos.x - el.getX() * scale;
            dragOffsetY = pos.y - el.getY() * scale;
            canvas.style.cursor = 'grabbing';
            e.preventDefault();
        }
    });

    canvas.addEventListener('mousemove', function(e) {
        if (!templateImg || !templateImg.complete) return;
        const pos = getMousePos(e);

        if (dragging) {
            const el = elements[dragging];
            const newX = Math.round((pos.x - dragOffsetX) / scale);
            const newY = Math.round((pos.y - dragOffsetY) / scale);
            el.setX(Math.max(0, Math.min(naturalW, newX)));
            el.setY(Math.max(0, Math.min(naturalH, newY)));
            render();
        } else {
            const hit = getElementAt(pos.x, pos.y);
            if (hit !== hovering) {
                hovering = hit;
                canvas.style.cursor = hit ? 'grab' : 'default';
                render();
            }
        }
    });

    canvas.addEventListener('mouseup', function(e) {
        if (dragging) {
            dragging = null;
            canvas.style.cursor = hovering ? 'grab' : 'default';
        }
    });

    canvas.addEventListener('mouseleave', function(e) {
        if (dragging) {
            dragging = null;
        }
        hovering = null;
        canvas.style.cursor = 'default';
        if (templateImg && templateImg.complete) render();
    });

    // --- Touch Events for Mobile Drag ---
    canvas.addEventListener('touchstart', function(e) {
        if (!templateImg || !templateImg.complete) return;
        const touch = e.touches[0];
        const pos = getMousePos(touch);
        const hit = getElementAt(pos.x, pos.y);
        if (hit) {
            dragging = hit;
            const el = elements[hit];
            dragOffsetX = pos.x - el.getX() * scale;
            dragOffsetY = pos.y - el.getY() * scale;
            e.preventDefault();
        }
    }, { passive: false });

    canvas.addEventListener('touchmove', function(e) {
        if (!dragging) return;
        const touch = e.touches[0];
        const pos = getMousePos(touch);
        const el = elements[dragging];
        const newX = Math.round((pos.x - dragOffsetX) / scale);
        const newY = Math.round((pos.y - dragOffsetY) / scale);
        el.setX(Math.max(0, Math.min(naturalW, newX)));
        el.setY(Math.max(0, Math.min(naturalH, newY)));
        render();
        e.preventDefault();
    }, { passive: false });

    canvas.addEventListener('touchend', function(e) {
        dragging = null;
    });

    // --- Input change handlers ---
    document.querySelectorAll('.pos-input').forEach(function(input) {
        input.addEventListener('input', function() {
            // Update color label
            if (this.type === 'color') {
                const label = document.getElementById(this.id + '_label');
                if (label) label.textContent = this.value;
            }
            if (templateImg && templateImg.complete) render();
        });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (templateImg && templateImg.complete && naturalW > 0) {
            resizeCanvas();
            render();
        }
    });

    // Polyfill for roundRect if needed
    if (!ctx.roundRect) {
        CanvasRenderingContext2D.prototype.roundRect = function(x, y, w, h, r) {
            if (w < 2 * r) r = w / 2;
            if (h < 2 * r) r = h / 2;
            this.moveTo(x + r, y);
            this.arcTo(x + w, y, x + w, y + h, r);
            this.arcTo(x + w, y + h, x, y + h, r);
            this.arcTo(x, y + h, x, y, r);
            this.arcTo(x, y, x + w, y, r);
            this.closePath();
        };
    }
})();
</script>
@endsection
