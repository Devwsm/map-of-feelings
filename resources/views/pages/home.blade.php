{{--
    Path: resources/views/pages/home.blade.php
    Rewrite total dari tema mood-bar lama ke tema "orbit" sesuai desain baru dari tim.
--}}
@extends('template.layout')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@section('content')
    <div class="mof-body w-full overflow-x-hidden" id="mofRoot">
        <div class="mof-noise" aria-hidden="true"></div>
        <div class="mof-cursor-glow" id="cursorGlow" aria-hidden="true"></div>

        <header
            class="fixed inset-x-0 top-0 z-50 flex items-center justify-between gap-4 border-b border-black/5 bg-white/70 px-4 py-4 backdrop-blur-md sm:px-8 sm:py-5">
            <button id="brandHome" type="button" aria-label="Kembali ke awal"
                class="absolute left-1/2 top-1/2 flex -translate-x-1/2 -translate-y-1/2 cursor-pointer items-center border-0 bg-transparent p-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 lg:translate-y-0 lg:shrink-0">
                <img src="{{ asset('assets/logo/Whisnu Santika MOF.svg') }}" alt="Whisnu Santika MOF"
                    class="block h-4 w-auto sm:h-5">
            </button>

            <div class="flex items-center gap-2 sm:gap-3 md:gap-5">
                <div class="hidden gap-5 font-mono text-xs tracking-widest text-black/60 lg:flex">
                    <span id="liveCoordinate">LINTANG 00.0000 / BUJUR 00.0000</span>
                    <span id="atlasStatus">PERASAAN &middot; SIAGA</span>
                </div>
            </div>
        </header>

        <main id="mofApp" class="w-full">

            {{-- LANDING --}}
            <section id="landing" data-screen="landing"
                class="mof-screen relative min-h-screen overflow-hidden px-5 pb-10 pt-28 text-center sm:px-8 sm:pt-36">
                <div class="mof-hero-glow" aria-hidden="true"></div>

                {{-- Orbit + fragments: absolute, center sendiri, independen dari flow konten --}}
                <div class="absolute left-1/2 top-1/2 aspect-square w-3/4 max-w-3xl -translate-x-1/2 -translate-y-1/2"
                    aria-hidden="true">
                    <div class="mof-orbit-ring"></div>
                    <div class="mof-orbit-ring mof-orbit-b"></div>
                    <div class="mof-orbit-ring mof-orbit-c"></div>
                    {{-- Pecahan warna interaktif, pengganti bola "moon" polos di tengah orbit (update desain terbaru dari tim) --}}
                    <svg id="mofFragments" class="mof-fragments" viewBox="0 0 320 320" aria-hidden="true">
                        <defs>
                            <linearGradient id="mofBlue" x1="0" y1="0" x2="1" y2="1">
                                <stop stop-color="#1757ff" />
                                <stop offset="1" stop-color="#72b7ff" />
                            </linearGradient>
                            <linearGradient id="mofSun" x1="0" y1="0" x2="1" y2="1">
                                <stop stop-color="#ff8b39" />
                                <stop offset="1" stop-color="#ffe26d" />
                            </linearGradient>
                            <linearGradient id="mofMint" x1="0" y1="0" x2="1" y2="1">
                                <stop stop-color="#57ef80" />
                                <stop offset="1" stop-color="#25bac7" />
                            </linearGradient>
                            <linearGradient id="mofRose" x1="0" y1="0" x2="1" y2="1">
                                <stop stop-color="#ff8f77" />
                                <stop offset="1" stop-color="#eab7ff" />
                            </linearGradient>
                            <linearGradient id="mofEmber" x1="0" y1="0" x2="1" y2="1">
                                <stop stop-color="#6d241b" />
                                <stop offset="1" stop-color="#f05b4f" />
                            </linearGradient>
                            <linearGradient id="mofLime" x1="0" y1="0" x2="1" y2="1">
                                <stop stop-color="#dfff55" />
                                <stop offset="1" stop-color="#73e37a" />
                            </linearGradient>
                            <filter id="mofGlow">
                                <feGaussianBlur stdDeviation="8" result="blur" />
                                <feMerge>
                                    <feMergeNode in="blur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>
                        </defs>
                        <g class="mof-fragment-glow" filter="url(#mofGlow)">
                            <rect x="93" y="79" width="134" height="145" rx="6" fill="#ff667f"
                                opacity=".22" />
                        </g>
                        <g class="mof-frag mof-frag-a">
                            <rect x="91" y="64" width="71" height="55" fill="url(#mofBlue)" />
                            <rect x="162" y="64" width="58" height="31" fill="url(#mofSun)" />
                        </g>
                        <g class="mof-frag mof-frag-b">
                            <rect x="54" y="119" width="65" height="74" fill="url(#mofMint)" />
                            <rect x="119" y="119" width="43" height="42" fill="url(#mofRose)" />
                        </g>
                        <g class="mof-frag mof-frag-c">
                            <rect x="162" y="95" width="91" height="66" fill="url(#mofLime)" />
                            <rect x="220" y="71" width="34" height="24" fill="#22d3d5" />
                        </g>
                        <g class="mof-frag mof-frag-d">
                            <rect x="119" y="161" width="68" height="76" fill="url(#mofEmber)" />
                            <rect x="78" y="193" width="41" height="27" fill="#ffb655" />
                        </g>
                        <g class="mof-frag mof-frag-e">
                            <rect x="187" y="161" width="68" height="55" fill="url(#mofBlue)" />
                            <rect x="187" y="216" width="42" height="33" fill="url(#mofRose)" />
                        </g>
                        <g class="mof-frag mof-frag-f">
                            <rect x="42" y="98" width="12" height="35" fill="#ff667f" />
                            <rect x="254" y="133" width="18" height="48" fill="#ff9e47" />
                            <rect x="151" y="42" width="28" height="22" fill="#dcff50" />
                        </g>
                        <g class="mof-frag mof-frag-g">
                            <rect x="65" y="220" width="54" height="20" fill="#37d9b0" />
                            <rect x="229" y="216" width="29" height="19" fill="#e8ff78" />
                            <rect x="144" y="237" width="18" height="30" fill="#5689ff" />
                        </g>
                    </svg>
                </div>

                {{-- Konten: logo nempel atas, teks+button nempel bawah, tengah dibiarkan kosong biar orbit kelihatan --}}
                <div class="relative z-10 flex w-full flex-col items-center justify-around min-h-[75vh] sm:min-h-[80vh]">
                    <img src="{{ asset('assets/logo/logo-map-of-feelings.svg') }}" alt="Map of Feelings"
                        class="mx-auto block w-3/4 max-w-xl">

                    <div class="mx-auto flex w-full max-w-3xl flex-col items-center gap-6">
                        <p class="mx-auto max-w-xl text-sm leading-relaxed text-black/60 sm:text-base md:text-lg">
                            Setiap perasaan punya tempatnya sendiri. Temukan koordinat emosimu dan lagu yang sedang
                            berbicara paling dekat denganmu.
                        </p>
                        <button id="enterMap" type="button"
                            class="rounded-full border border-black bg-black px-5 py-3.5 font-mono text-xs tracking-widest text-white transition hover:-translate-y-0.5 hover:shadow-lg sm:px-6 sm:py-4">
                            MULAI PERJALANAN
                        </button>
                    </div>
                </div>

                {{-- Audio ambient landing + tombol mute/unmute --}}
                <audio id="landingAudio" src="{{ asset('assets/audio/landing.wav') }}" loop preload="auto"></audio>
                <button id="landingAudioToggle" type="button" aria-label="Mute atau unmute musik" aria-pressed="true"
                    class="fixed bottom-5 right-5 z-40 grid h-11 w-11 place-items-center rounded-full border border-black/10 bg-white/90 text-black shadow-lg backdrop-blur transition hover:-translate-y-0.5 sm:bottom-7 sm:right-7 sm:h-12 sm:w-12">
                    <i id="landingAudioIcon" class="bi bi-volume-mute-fill text-base"></i>
                </button>
            </section>

            {{-- ATLAS --}}
            <section id="atlas" data-screen="atlas" class="mof-screen z-50 px-4 pb-16 pt-28 sm:px-8">
                <div class="mx-auto mb-8 max-w-7xl text-center">
                    <img src="{{ asset('assets/logo/logo-map-of-feelings.svg') }}" alt="Map of Feelings"
                        class="mx-auto mb-3 block w-full max-w-sm">
                    <h2 class="text-3xl font-semibold tracking-tight sm:text-4xl md:text-5xl lg:text-6xl">
                        Bagaimana perasaanmu hari ini?
                    </h2>
                    <p class="mt-4 font-mono text-xs tracking-widest text-black/50">
                        SOROT &middot; RASAKAN &middot; PILIH
                    </p>
                </div>

                <div id="mapShell" class="mof-map-shell mx-auto min-h-screen w-full max-w-7xl">
                    <div class="mof-grid-lines"></div>
                    <div class="mof-map-glow"></div>
                    <div id="emotionNodes"></div>

                    <div class="mof-map-caption flex flex-wrap gap-3 font-mono text-xs tracking-widest">
                        <span>PERASAANMU</span>
                        <span>VISIBILITAS: BERUBAH</span>
                    </div>
                </div>
            </section>

            {{-- QUESTION --}}
            <section id="question" data-screen="question"
                class="mof-screen grid min-h-screen place-items-center px-4 pb-16 pt-28 sm:px-8">
                <div class="relative w-full max-w-4xl text-center">
                    <button id="questionBack" type="button"
                        class="absolute left-0 top-0 cursor-pointer border-0 bg-transparent p-0 font-mono text-xs tracking-widest text-black/50 transition-colors hover:text-black/80 sm:-top-12">
                        &larr; KEMBALI
                    </button>
                    <p id="questionFeeling" class="mb-4 font-mono text-xs tracking-widest text-blue-400">
                        SEDIH
                    </p>
                    <h2 id="questionTitle"
                        class="mb-8 text-3xl font-semibold leading-tight tracking-tight sm:mb-10 sm:text-4xl md:text-5xl lg:text-6xl">
                    </h2>
                    <div id="questionChoices" class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4"></div>
                    <p class="mt-6 font-mono text-xs tracking-widest text-black/50">
                        Pilih jawaban yang terasa paling dekat denganmu.
                    </p>
                </div>
            </section>

            {{-- MAPPING --}}
            <section id="mapping" data-screen="mapping"
                class="mof-screen mof-mapping-screen relative grid min-h-screen place-items-center overflow-hidden px-5"
                aria-live="polite">
                <div id="mappingField" class="mof-mapping-field" aria-hidden="true"></div>

                <div class="relative z-10 w-full max-w-2xl text-center">
                    <h2 id="mappingText"
                        class="whitespace-pre-line text-3xl font-medium leading-tight tracking-tight sm:text-4xl md:text-6xl lg:text-7xl">
                    </h2>
                    <div class="mof-mapping-progress-bar">
                        <span id="mappingProgress"></span>
                    </div>
                </div>
            </section>

            {{-- COORDINATE --}}
            <section id="coordinate" data-screen="coordinate"
                class="mof-screen mof-coordinate-screen relative grid min-h-screen place-items-center overflow-hidden px-5">
                <div class="mof-coordinate-aura"></div>

                <div class="relative z-10 flex w-full max-w-3xl flex-col items-center px-2 text-center">
                    <p class="mb-5 font-mono text-xs tracking-widest">
                        PERASAANMU PUNYA TEMPAT
                    </p>
                    <h2 class="text-3xl font-medium leading-tight tracking-tight sm:text-4xl md:text-6xl lg:text-7xl">
                        Kami
                        menemukan<br>
                        koordinatmu.
                    </h2>
                    <button type="button" id="coordinateMarkerButton" aria-label="Lihat lagu yang terhubung"
                        class="mof-coordinate-marker my-10 cursor-pointer border-0 bg-transparent p-0 sm:my-11"></button>
                    <button id="coordinateButton" type="button" class="mof-coordinate-button w-full max-w-md">
                        <span id="coordinateFeeling" class="font-mono text-xs tracking-widest text-white/70">
                            PERASAAN
                        </span>
                        <span id="coordinateName" class="mof-coordinate-name">
                            Titik Patah yang Sunyi
                        </span>
                    </button>
                    <button type="button" id="coordinateHintButton"
                        class="mt-6 cursor-pointer border-0 bg-transparent p-0 font-mono text-xs tracking-widest text-black/60 underline-offset-4 hover:underline">
                        Klik koordinat untuk melihat lagu yang terhubung
                    </button>
                </div>
            </section>
        </main>

        {{-- RESULT PANEL --}}
        <audio id="resultAudio" preload="auto"></audio>
        <aside id="emotionPanel" class="mof-emotion-panel" aria-hidden="true">
            <button id="panelClose" type="button" aria-label="Tutup"
                class="fixed right-4 top-4 z-10 grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-white/90 shadow-lg sm:right-6 sm:top-6 sm:h-12 sm:w-12">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>

            <div class="relative grid place-items-center px-5 pb-10 pt-24 sm:px-12 sm:pb-16 sm:pt-24">
                <div class="mof-artwork-frame w-full max-w-lg">
                    <img id="resultArtwork" src="" alt="Artwork lagu" class="h-auto w-full">
                </div>

                <div id="panelIndex"
                    class="absolute bottom-5 left-5 font-mono text-xs tracking-widest text-black/50 sm:bottom-7 sm:left-8">
                    01 / 10
                </div>
            </div>

            <div class="mx-auto w-11/12 max-w-3xl py-12 sm:py-24">
                <div id="resultAnswerWrap" class="mb-6">
                    <span class="mb-1 block font-mono text-xs tracking-widest text-black/50">
                        JAWABANMU
                    </span>
                    <span id="resultAnswer" class="block text-sm text-black/60 sm:text-base md:text-lg"></span>
                </div>

                <p id="panelCoordinate" class="mb-2 font-mono text-xs tracking-widest text-black/50">
                    TITIK PATAH YANG SUNYI
                </p>
                <h2 id="resultSong"
                    class="text-3xl font-bold leading-none tracking-tight sm:text-4xl md:text-6xl lg:text-8xl"> Aku Harus
                    Pergi
                </h2>
                <p id="resultMood" class="mb-8 mt-6 text-sm text-black/60 sm:mt-7 sm:text-base md:text-lg"></p>

                <div
                    class="mb-8 grid grid-cols-1 divide-y divide-black/10 border-y border-black/10 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
                    <div class="py-4 sm:pr-5">
                        <span class="mb-1 block font-mono text-xs tracking-widest text-black/50">
                            KONDISI EMOSI
                        </span>
                        <span id="panelState" class="block text-xl font-bold"></span>
                    </div>
                    <div class="py-4 sm:pl-5">
                        <span class="mb-1 block font-mono text-xs tracking-widest text-black/50">
                            CUACA ATLAS
                        </span>
                        <span id="panelWeather" class="block text-xl font-bold"></span>
                    </div>
                </div>

                <div class="mb-6">
                    <span class="mb-1 block font-mono text-xs tracking-widest text-black/50">
                        ANALISIS
                    </span>
                    <span id="resultAnalysis" class="block text-xl font-bold"></span>
                </div>

                <p id="resultAffirmation" class="my-7 text-lg italic text-black"></p>

                <div class="my-7 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
                    <label class="grid gap-2">
                        <span class="font-mono text-xs tracking-widest text-black/50">NAMA</span>
                        <input id="visitorName" type="text" maxlength="40" autocomplete="name"
                            placeholder="Tulis nama kamu"
                            class="min-h-12 w-full rounded-2xl border border-black/15 bg-white/80 px-4 py-3 text-sm outline-none focus:border-blue-400">
                    </label>

                    <label class="grid gap-2">
                        <span class="font-mono text-xs tracking-widest text-black/50">NAMA INSTAGRAM</span>
                        <input id="visitorInstagram" type="text" maxlength="40" autocapitalize="none"
                            spellcheck="false" placeholder="@username"
                            class="min-h-12 w-full rounded-2xl border border-black/15 bg-white/80 px-4 py-3 text-sm outline-none focus:border-blue-400">
                    </label>

                    <p id="coordinateFormError" class="min-h-4 text-xs text-red-600 sm:col-span-2" aria-live="polite">
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:gap-3.5">
                    <a id="mofLink" href="#" target="_blank" rel="noopener"
                        class="flex items-center justify-center rounded-full border border-black/15 bg-white/80 px-5 py-3 text-center font-mono text-xs tracking-widest transition hover:-translate-y-0.5 hover:bg-white">
                        PRE SAVE MAP OF FEELINGS
                    </a>
                    <button id="saveCoordinate" type="button"
                        class="rounded-full border border-black/15 bg-white/80 px-5 py-3 font-mono text-xs tracking-widest transition hover:-translate-y-0.5 hover:bg-white disabled:cursor-wait disabled:opacity-50">
                        SIMPAN KOORDINAT
                    </button>
                </div>

                <button id="restartButton" type="button"
                    class="mt-7 cursor-pointer border-0 border-b border-black/15 bg-transparent pb-2 font-mono font-bold text-xs tracking-widest text-black/55">
                    PETAKAN PERASAAN LAIN
                </button>
            </div>
        </aside>

        {{-- Di luar #emotionPanel dengan sengaja: panel pakai `transform` buat animasi
        slide-up, dan itu bikin descendant `position: fixed` ikut acuan ke box panel
        (jadi ikut keseret pas discroll) alih-alih ke viewport asli. Ditaruh di luar
        + show/hide via JS (openPanel/closePanel) biar bener-bener diem di pojok layar. --}}
        <button id="resultAudioToggle" type="button" aria-label="Mute atau unmute lagu" aria-pressed="true"
            style="display: none;"
            class="fixed bottom-5 right-5 grid h-11 w-11 place-items-center rounded-full border border-black/10 bg-white/90 text-black shadow-lg backdrop-blur transition hover:-translate-y-0.5 sm:bottom-7 sm:right-7 sm:h-12 sm:w-12">
            <i id="resultAudioIcon" class="bi bi-volume-up-fill text-base"></i>
        </button>

        <footer
            class="flex flex-col gap-2 border-t border-black/10 bg-white/90 px-5 py-6 font-mono text-xs tracking-widest text-black/55 sm:flex-row sm:items-center sm:justify-between sm:px-8 sm:py-7">
            <span>MAP OF FEELINGS &middot; FROM WHISNU'S STORY TO EVERYONE'S STORY</span>
            <div class="flex flex-col md:flex-row">
                <div class="flex gap-2">
                    <a href="{{ route('dashboard') }}">
                        <span>PANEL</span>
                    </a>
                    <span>&middot;</span>
                    <a href="{{ route('privacy-policy') }}">
                        <span>PRIVACY POLICY</span>
                    </a>
                    <span>&middot;</span>
                </div>
                <div class="flex">
                    <span>&copy; WAHSUDAH MONDAY 2026 &middot;</span>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Data mood sekarang dari database (tabel moods), bukan hardcode lagi.
        // Diisi/diedit lewat panel (role: panel) di /dashboard/panel.
        window.MAP_OF_FEELINGS = @json($moods->map->toJsPayload()->values());

        (function() {
            const MOODS = window.MAP_OF_FEELINGS;
            const root = document.getElementById('mofRoot');

            const screens = Object.fromEntries(
                ['landing', 'atlas', 'question', 'mapping', 'coordinate'].map((id) => [id, document.getElementById(
                    id)])
            );

            const emotionNodes = document.getElementById('emotionNodes');
            const mappingField = document.getElementById('mappingField');
            const mappingText = document.getElementById('mappingText');
            const panel = document.getElementById('emotionPanel');
            const resultAudio = document.getElementById('resultAudio');
            const liveCoordinate = document.getElementById('liveCoordinate');
            const atlasStatus = document.getElementById('atlasStatus');
            const mapShell = document.getElementById('mapShell');
            const questionFeeling = document.getElementById('questionFeeling');
            const questionTitle = document.getElementById('questionTitle');
            const questionChoices = document.getElementById('questionChoices');

            let selectedMood = null;
            let selectedAnswer = '';
            let landingAudioWasPlaying = false;
            let timers = [];
            let orbitInterval = null;

            const positions = [
                [16, 24],
                [34, 29],
                [53, 20],
                [72, 31],
                [87, 22],
                [11, 64],
                [30, 71],
                [52, 56],
                [70, 72],
                [86, 61]
            ];

            const coords = [
                'LINTANG -06.2088 / BUJUR 106.8456',
                'LINTANG -07.7956 / BUJUR 110.3695',
                'LINTANG 01.3521 / BUJUR 103.8198',
                'LINTANG -08.3405 / BUJUR 115.0920',
                'LINTANG -02.5489 / BUJUR 118.0149',
                'LINTANG -06.9147 / BUJUR 107.6098',
                'LINTANG -07.2575 / BUJUR 112.7521',
                'LINTANG 03.5952 / BUJUR 98.6722',
                'LINTANG -05.1477 / BUJUR 119.4327',
                'LINTANG 00.7893 / BUJUR 113.9213'
            ];

            function getHexMatches(text) {
                return text.match(/#([0-9a-f]{6})/gi) || [];
            }

            function hexToRgb(hex) {
                const clean = (hex || '#7aaef7').replace('#', '');
                return `${parseInt(clean.slice(0, 2), 16)}, ${parseInt(clean.slice(2, 4), 16)}, ${parseInt(clean.slice(4, 6), 16)}`;
            }

            function getMoodPrimaryHex(mood) {
                const colors = getHexMatches(mood.barGradient);
                return colors[0] || '#7aaef7';
            }

            function getMoodSecondaryHex(mood) {
                const colors = getHexMatches(mood.barGradient);
                return colors[colors.length - 1] || colors[0] || '#4b82eb';
            }

            function setMoodTheme(mood) {
                document.documentElement.style.setProperty('--mof-mood-rgb', hexToRgb(getMoodPrimaryHex(mood)));
            }

            function setOrbitColors(primaryHex, secondaryHex) {
                document.documentElement.style.setProperty('--mof-orbit-primary-rgb', hexToRgb(primaryHex));
                document.documentElement.style.setProperty('--mof-orbit-secondary-rgb', hexToRgb(secondaryHex));
            }

            function applyMoodHover(mood) {
                document.documentElement.style.setProperty('--mof-hover-rgb', hexToRgb(getMoodPrimaryHex(mood)));
                document.documentElement.style.setProperty('--mof-map-hover-gradient', mood.pageGradient || mood
                    .barGradient);
                root.classList.add('mood-hover');
                if (mapShell) mapShell.classList.add('active-hover');
            }

            function clearMoodHover() {
                root.classList.remove('mood-hover');
                if (mapShell) mapShell.classList.remove('active-hover');
                document.documentElement.style.setProperty('--mof-hover-rgb', '115, 173, 255');
                document.documentElement.style.setProperty(
                    '--mof-map-hover-gradient',
                    'radial-gradient(circle at 50% 50%, rgba(115,173,255,.16), transparent 32%), linear-gradient(180deg, #ffffff 0%, #f8f9fb 100%)'
                );
            }

            function startOrbitCycle() {
                let orbitIndex = 0;
                const applyOrbitColor = () => {
                    const mood = MOODS[orbitIndex];
                    setOrbitColors(getMoodPrimaryHex(mood), getMoodSecondaryHex(mood));
                    orbitIndex = (orbitIndex + 1) % MOODS.length;
                };
                applyOrbitColor();
                clearInterval(orbitInterval);
                orbitInterval = setInterval(applyOrbitColor, 2200);
            }

            // Section #landing di-`display:none` pas pindah screen, dan animasi
            // CSS .mof-frag-* (infinite loop 7.2s) gak restart dari 0% pas
            // section-nya ditampilin lagi — dia nerusin dari titik acak di
            // tengah siklus, kadang keliatan numpuk kayak "bekas" hasil
            // sebelumnya. Paksa restart tiap balik ke landing lewat reset().
            function restartFragmentAnimations() {
                const fragmentsSvg = document.getElementById('mofFragments');
                if (!fragmentsSvg) return;
                fragmentsSvg.querySelectorAll('.mof-frag, .mof-fragment-glow').forEach((el) => {
                    el.style.animation = 'none';
                    void el.getBBox(); // paksa reflow di SVG biar browser "lupa" animation state lama
                    el.style.animation = '';
                });
            }


            function setScreen(name) {
                root.classList.toggle('journey-landing', name === 'landing');
                Object.entries(screens).forEach(([key, screen]) => {
                    if (screen) screen.classList.toggle('active', key === name);
                });
                if (name !== 'atlas') clearMoodHover();
                window.scrollTo(0, 0);
            }

            function clearTimers() {
                timers.forEach(clearTimeout);
                timers = [];
            }

            function wait(ms, callback) {
                const id = setTimeout(callback, ms);
                timers.push(id);
                return id;
            }

            function typeText(text, speed = 45) {
                mappingText.textContent = '';
                let index = 0;
                const tick = () => {
                    mappingText.textContent = text.slice(0, ++index);
                    if (index < text.length) wait(speed, tick);
                };
                tick();
            }

            function renderAtlas() {
                emotionNodes.innerHTML = '';

                MOODS.forEach((mood, index) => {
                    const button = document.createElement('button');
                    const rgb = hexToRgb(getMoodPrimaryHex(mood));

                    button.type = 'button';
                    button.className = 'mof-emotion-node';
                    button.style.setProperty('--x', `${positions[index][0]}%`);
                    button.style.setProperty('--y', `${positions[index][1]}%`);
                    button.style.setProperty('--node-rgb', rgb);

                    button.innerHTML = `
                    <span class="mof-pulse"></span>
                    <span class="mof-node-core"></span>
                    <span class="mof-node-label">${String(index + 1).padStart(2, '0')} &middot; ${mood.feeling.toUpperCase()}</span>
                `;

                    const handleHover = () => {
                        liveCoordinate.textContent = coords[index];
                        atlasStatus.textContent = `PERASAAN \u00b7 ${mood.feeling.toUpperCase()}`;
                        setMoodTheme(mood);
                        applyMoodHover(mood);
                    };

                    button.addEventListener('mouseenter', handleHover);
                    button.addEventListener('focus', handleHover);
                    // Mobile/tablet gak punya hover, jadi warnanya di-apply juga pas disentuh/dipilih.
                    button.addEventListener('touchstart', handleHover, {
                        passive: true
                    });
                    button.addEventListener('click', () => {
                        handleHover();
                        openQuestion(mood, index);
                    });

                    emotionNodes.appendChild(button);
                });
            }

            function renderMapDots(selectedMoodData, selectedIndex, finding = false) {
                mappingField.innerHTML = '';

                MOODS.forEach((mood, index) => {
                    const dot = document.createElement('span');
                    dot.className = `mof-map-dot${finding && index === selectedIndex ? ' selected' : ''}`;
                    dot.style.setProperty('--x', `${positions[index][0]}%`);
                    dot.style.setProperty('--y', `${positions[index][1]}%`);
                    dot.style.setProperty('--delay', `${(index % 5) * -0.21}s`);
                    dot.style.setProperty('--dot-rgb', hexToRgb(getMoodPrimaryHex(mood)));

                    if (finding && index === selectedIndex) {
                        dot.setAttribute('aria-label', selectedMoodData.feeling);
                    }

                    mappingField.appendChild(dot);
                });
            }

            function openQuestion(mood, index) {
                clearTimers();
                selectedMood = {
                    ...mood,
                    index
                };
                selectedAnswer = '';
                setMoodTheme(mood);

                questionFeeling.textContent = mood.feeling.toUpperCase();
                questionTitle.textContent = mood.question;

                questionChoices.innerHTML = '';
                mood.choices.forEach((choice, choiceIndex) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'mof-question-choice';
                    button.innerHTML =
                        `<span>${String(choiceIndex + 1).padStart(2, '0')}</span><strong>${choice}</strong>`;
                    button.addEventListener('click', () => {
                        selectedAnswer = choice;
                        beginJourney(mood, index);
                    });
                    questionChoices.appendChild(button);
                });

                atlasStatus.textContent = `REFLEKSI \u00b7 ${mood.feeling.toUpperCase()}`;
                setScreen('question');
            }

            function beginJourney(mood, index) {
                clearTimers();
                selectedMood = {
                    ...mood,
                    index
                };
                setMoodTheme(mood);
                atlasStatus.textContent = 'MEMINDAI \u00b7 00%';
                setScreen('mapping');

                renderMapDots(mood, index, false);
                typeText('Memetakan\nperasaanmu', 48);

                wait(2500, () => {
                    renderMapDots(mood, index, true);
                    typeText('Mencari\ntempatmu', 50);
                    atlasStatus.textContent = 'MEMINDAI \u00b7 50%';
                });

                wait(5000, () => {
                    prepareCoordinate(selectedMood);
                    atlasStatus.textContent = 'KOORDINAT DITEMUKAN';
                    setScreen('coordinate');
                });
            }

            function prepareCoordinate(mood) {
                document.documentElement.style.setProperty('--mof-coordinate-gradient', mood.pageGradient);
                document.documentElement.style.setProperty('--mof-panel-accent-rgb', hexToRgb(getMoodPrimaryHex(mood)));
                document.documentElement.style.setProperty('--mof-panel-gradient', mood.pageGradient);

                document.getElementById('coordinateName').textContent = mood.coordinate;
                document.getElementById('coordinateFeeling').textContent =
                    `${mood.feeling.toUpperCase()} \u00b7 ${mood.nuance.toUpperCase()}`;

                document.getElementById('panelIndex').textContent = `${String(mood.index + 1).padStart(2, '0')} / 10`;
                document.getElementById('panelCoordinate').textContent = mood.coordinate;
                const resultSong = document.getElementById('resultSong');
                resultSong.textContent = mood.song;
                resultSong.style.color = mood.colorText || '#0c0d0f'; // fallback kalau kosong
                document.getElementById('resultMood').textContent = `${mood.feeling} \u2014 ${mood.nuance}`;
                document.getElementById('panelState').textContent = mood.nuance;
                document.getElementById('panelWeather').textContent = mood.weatherText;

                const resultAnswerWrap = document.getElementById('resultAnswerWrap');
                if (mood.answer) {
                    document.getElementById('resultAnswer').textContent = mood.answer;
                    resultAnswerWrap.style.display = '';
                } else {
                    resultAnswerWrap.style.display = 'none';
                }
                document.getElementById('resultAnalysis').textContent = mood.why;

                document.getElementById('resultAffirmation').textContent = mood.affirmation;

                const artwork = document.getElementById('resultArtwork');
                artwork.src = mood.artwork;
                artwork.alt = `${mood.song} artwork`;

                document.getElementById('mofLink').href = mood.mof || '#';
                liveCoordinate.textContent = coords[mood.index];

                preloadArtwork(mood);
            }

            let audioPlayToken = 0; // penanda sesi audio aktif
            let resultAudioPlayPromise = null; // promise play() yang lagi pending, biar stop nunggu settle dulu

            function stopResultAudio() {
                audioPlayToken += 1; // batalkan fade/play sesi sebelumnya
                if (!resultAudio) return;

                const finishStop = () => {
                    resultAudio.pause();
                    resultAudio.currentTime = 0;
                    resultAudio.removeAttribute('src');
                    resultAudio.load();
                };

                if (resultAudioPlayPromise) {
                    // Browser nge-log warning sendiri kalau pause() dipanggil sebelum
                    // promise play() settle (resolve/reject) — bukan exception JS biasa
                    // jadi gak ketangkep try/catch. Tunggu promise-nya kelar dulu.
                    resultAudioPlayPromise.then(finishStop).catch(finishStop);
                } else {
                    finishStop();
                }
            }

            async function playResultAudio(mood) {
                if (!resultAudio || !mood || !mood.audio) return;
                const myToken = ++audioPlayToken; // sesi ini
                if (resultAudio.getAttribute('src') !== mood.audio) {
                    resultAudio.src = mood.audio;
                    resultAudio.load();
                }

                resultAudio.volume = 0;
                const playPromise = resultAudio.play();
                resultAudioPlayPromise = playPromise;

                try {
                    await playPromise;
                    if (resultAudioPlayPromise === playPromise) resultAudioPlayPromise = null;

                    // kalau sesi sudah dibatalkan (panel ditutup / dibuka ulang) selama menunggu play(), stop di sini
                    if (myToken !== audioPlayToken) return;
                    const targetVolume = 0.6;
                    const fadeStart = performance.now();
                    const fadeDuration = 900;

                    const fade = (now) => {
                        // stop kalau sesi berubah ATAU audio sudah kepause
                        if (myToken !== audioPlayToken || resultAudio.paused) return;
                        const progress = Math.max(0, Math.min((now - fadeStart) / fadeDuration, 1));
                        resultAudio.volume = Math.max(0, Math.min(1, targetVolume * progress));
                        if (progress < 1) requestAnimationFrame(fade);
                    };

                    requestAnimationFrame(fade);
                } catch (error) {
                    if (resultAudioPlayPromise === playPromise) resultAudioPlayPromise = null;
                    // AbortError normal terjadi kalau panel ditutup cepat sebelum play() selesai — bukan bug
                    if (error && error.name !== 'AbortError') {
                        console.warn(`Audio tidak dapat diputar otomatis: ${mood.audio}`, error);
                    }
                }
            }

            // Mute/unmute lagu di result panel. Pakai .muted (bukan pause) biar
            // playback & fade-in volume yang lagi jalan gak keganggu, cuma dibisukan.
            const resultAudioToggle = document.getElementById('resultAudioToggle');
            const resultAudioIcon = document.getElementById('resultAudioIcon');
            let resultAudioMuted = false;

            function updateResultAudioIcon() {
                if (!resultAudioIcon) return;
                resultAudioIcon.className = resultAudioMuted ?
                    'bi bi-volume-mute-fill text-base' :
                    'bi bi-volume-up-fill text-base';
                if (resultAudioToggle) {
                    resultAudioToggle.setAttribute('aria-pressed', resultAudioMuted ? 'false' : 'true');
                }
            }

            if (resultAudioToggle && resultAudio) {
                resultAudio.muted = resultAudioMuted;
                resultAudioToggle.addEventListener('click', () => {
                    resultAudioMuted = !resultAudioMuted;
                    resultAudio.muted = resultAudioMuted;
                    updateResultAudioIcon();
                });
            }

            function openPanel() {
                panel.classList.add('open');
                panel.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
                if (resultAudioToggle) resultAudioToggle.style.display = 'grid';

                // Reset scroll ke atas tiap kali panel dibuka ulang (mis. abis
                // "Petakan Perasaan Lain"), khususnya di mobile — sebelumnya panel
                // nyangkut di posisi scroll terakhir karena elemennya dipakai ulang.
                panel.scrollTop = 0;

                // Biar gak numpuk sama audio result, audio landing di-pause
                // otomatis dulu selama panel hasil lagunya kebuka.
                const landingAudioEl = document.getElementById('landingAudio');
                landingAudioWasPlaying = !!(landingAudioEl && !landingAudioEl.paused);
                if (landingAudioEl && landingAudioWasPlaying) landingAudioEl.pause();

                playResultAudio(selectedMood);
            }

            function closePanel() {
                // Chrome blokir aria-hidden kalau ada descendant yang masih fokus
                // pas panel-nya di-hide (biasanya #panelClose sendiri abis diklik).
                // Blur dulu elemen yang fokus sebelum aria-hidden di-set true.
                if (panel.contains(document.activeElement)) {
                    document.activeElement.blur();
                }
                panel.classList.remove('open');
                panel.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                if (resultAudioToggle) resultAudioToggle.style.display = 'none';
                stopResultAudio();

                // Lanjutin lagi audio landing kalau sebelum panel dibuka dia lagi main.
                if (landingAudioWasPlaying) {
                    const landingAudioEl = document.getElementById('landingAudio');
                    if (landingAudioEl) landingAudioEl.play().catch(() => {});
                    landingAudioWasPlaying = false;
                }
            }

            function reset() {
                clearTimers();
                selectedMood = null;
                selectedAnswer = '';
                closePanel();

                const visitorName = document.getElementById('visitorName');
                const visitorInstagram = document.getElementById('visitorInstagram');
                const formError = document.getElementById('coordinateFormError');
                if (visitorName) visitorName.value = '';
                if (visitorInstagram) visitorInstagram.value = '';
                if (formError) formError.textContent = '';

                setMoodTheme(MOODS[0]);
                clearMoodHover();
                liveCoordinate.textContent = 'LINTANG 00.0000 / BUJUR 00.0000';
                atlasStatus.textContent = 'PERASAAN \u00b7 SIAGA';
                setScreen('landing');
                restartFragmentAnimations();
            }

            function roundedRect(ctx, x, y, width, height, radius) {
                ctx.beginPath();
                if (ctx.roundRect) {
                    ctx.roundRect(x, y, width, height, radius);
                } else {
                    ctx.moveTo(x + radius, y);
                    ctx.arcTo(x + width, y, x + width, y + height, radius);
                    ctx.arcTo(x + width, y + height, x, y + height, radius);
                    ctx.arcTo(x, y + height, x, y, radius);
                    ctx.arcTo(x, y, x + width, y, radius);
                    ctx.closePath();
                }
            }

            function wrapTextLines(ctx, text, maxWidth) {
                const words = text.split(' ');
                const lines = [];
                let line = '';
                words.forEach((word) => {
                    const test = line ? `${line} ${word}` : word;
                    if (ctx.measureText(test).width > maxWidth && line) {
                        lines.push(line);
                        line = word;
                    } else {
                        line = test;
                    }
                });
                lines.push(line);
                return lines;
            }

            function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
                wrapTextLines(ctx, text, maxWidth).forEach((item, index) => ctx.fillText(item, x, y + index *
                    lineHeight));
            }

            function showDownloadFeedback(message) {
                let feedback = document.querySelector('.mof-download-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className =
                        'mof-download-feedback font-mono tracking-widest fixed right-7 bottom-7 z-[130] rounded-full bg-black text-white px-4.5 py-3.5 text-[10px] opacity-0 translate-y-2.5 pointer-events-none transition-all';
                    document.body.appendChild(feedback);
                }
                feedback.textContent = message || 'KOORDINAT TERSIMPAN';
                feedback.classList.remove('opacity-0', 'translate-y-2.5');
                setTimeout(() => feedback.classList.add('opacity-0', 'translate-y-2.5'), 1800);
            }

            // Gambar artwork sama origin (di-serve dari public/assets), jadi canvas gak
            // butuh embedded base64 fallback lagi kayak versi standalone prototype dulu.
            function loadImage(src) {
                return new Promise((resolve, reject) => {
                    const image = new Image();
                    image.onload = () => resolve(image);
                    image.onerror = reject;
                    image.src = src;
                });
            }

            // Artwork di-preload di background begitu koordinat ketemu (jauh sebelum
            // user klik "Simpan Koordinat"), bukan pas tombolnya diklik. Ini penting
            // buat navigator.share(): kalau buildCoordinateCardBlob() masih harus
            // nunggu network fetch gambar saat itu juga, jeda antara klik tombol asli
            // dan pemanggilan share() jadi kepanjangan — beberapa browser (terutama
            // Safari/iOS) langsung nolak share() begitu dianggap gak lagi "respons
            // langsung" ke gesture user. Dengan di-preload duluan, pas tombol diklik
            // gambarnya kemungkinan besar sudah siap di cache ini.
            let cachedArtworkImage = null;
            let cachedArtworkSrc = null;

            function preloadArtwork(mood) {
                if (!mood || !mood.artwork || cachedArtworkSrc === mood.artwork) return;
                cachedArtworkSrc = mood.artwork;
                cachedArtworkImage = null;
                loadImage(mood.artwork)
                    .then((img) => {
                        if (cachedArtworkSrc === mood.artwork) cachedArtworkImage = img;
                    })
                    .catch(() => {});
            }

            function normalizeInstagram(value) {
                const clean = value.trim().replace(/^@+/, '').replace(/\s+/g, '');
                return clean ? `@${clean}` : '';
            }

            function canvasToBlob(canvas) {
                return new Promise((resolve, reject) => {
                    if (!canvas.toBlob) {
                        try {
                            const dataUrl = canvas.toDataURL('image/png');
                            const binary = atob(dataUrl.split(',')[1]);
                            const bytes = new Uint8Array(binary.length);
                            for (let i = 0; i < binary.length; i += 1) bytes[i] = binary.charCodeAt(i);
                            resolve(new Blob([bytes], {
                                type: 'image/png'
                            }));
                        } catch (error) {
                            reject(error);
                        }
                        return;
                    }
                    canvas.toBlob((blob) => (blob ? resolve(blob) : reject(new Error('PNG gagal dibuat'))),
                        'image/png', 1);
                });
            }

            // Nge-submit data koordinat ke server (non-blocking) — kalau gagal, PNG tetap lanjut dibuat.
            async function submitCoordinateToServer(visitorName, visitorInstagram) {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    const response = await fetch('{{ route('coordinate.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken || '',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            mood_key: selectedMood.id,
                            visitor_name: visitorName || null,
                            visitor_instagram: visitorInstagram || null,
                            selected_answer: selectedAnswer || null,
                        }),
                    });

                    // PNG tetap lanjut dibuat/didownload meski ini gagal (misal 429
                    // kena rate limit) — cuma dicatat di console buat debugging,
                    // gak mengganggu pengalaman user.
                    if (!response.ok) {
                        console.warn('Server menolak simpan data koordinat, status:', response.status);
                    }
                } catch (error) {
                    console.warn('Gagal menyimpan data koordinat ke server:', error);
                }
            }

            // Gambar kartu koordinat ke canvas lalu balikin sebagai Blob PNG.
            // Dipakai bareng sama tombol simpan (download) dan tombol bagikan (Web Share API).
            // Ukuran 1080x1920 (9:16) biar pas kalau di-upload langsung ke IG Story
            // tanpa ada crop/letterbox.
            //
            // Konten disusun sebagai list "block" berurutan (masing-masing punya
            // `gap` = jarak sebelum block itu, dan `height` = tinggi visualnya).
            // Dua manfaatnya:
            // 1. Block nama & instagram cuma dimasukkan ke list kalau memang diisi
            //    user — kalau kosong, block-nya (termasuk gap-nya) beneran hilang
            //    dari perhitungan, bukan cuma teksnya yang disembunyikan.
            // 2. Semua teks digambar pakai textBaseline 'top' (bukan default
            //    alphabetic), jadi tinggi tiap block bisa dihitung apa adanya dari
            //    ujung atas teksnya. Ini bikin padding atas card (sebelum block
            //    pertama) dan padding bawah card (sesudah block terakhir) sama-sama
            //    persis PAD — sebelumnya beda karena baseline default naruh titik
            //    acuan teks di garis bawah huruf, bukan di tengah/atas glyph, jadi
            //    jarak kosong di atas vs di bawah kelihatan gak konsisten.
            async function buildCoordinateCardBlob(visitorName, visitorInstagram) {
                const canvas = document.createElement('canvas');
                canvas.width = 1080;
                canvas.height = 1920;
                const ctx = canvas.getContext('2d');

                const colors = getHexMatches(selectedMood.pageGradient);
                const bg = ctx.createLinearGradient(0, 0, 1080, 1920);
                bg.addColorStop(0, colors[0] || '#ffffff');
                bg.addColorStop(.55, colors[1] || getMoodPrimaryHex(selectedMood));
                bg.addColorStop(1, colors[colors.length - 1] || getMoodSecondaryHex(selectedMood));
                ctx.fillStyle = bg;
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Padding sama rata di 4 sisi: MARGIN (canvas -> tepi card), PAD (tepi card -> konten)
                const MARGIN = 56;
                const PAD = 56;
                const cardLeft = MARGIN;
                const cardWidth = canvas.width - MARGIN * 2;
                const contentLeft = cardLeft + PAD;
                const contentWidth = cardWidth - PAD * 2;
                const contentCenterX = cardLeft + cardWidth / 2;
                const artworkSize = contentWidth;

                ctx.textAlign = 'center';
                ctx.textBaseline = 'top';

                // Pakai gambar yang sudah di-preload kalau ada (lihat preloadArtwork),
                // biar gak perlu nunggu network fetch lagi pas tombol simpan diklik.
                const artwork = await (async () => {
                    if (cachedArtworkSrc === selectedMood.artwork && cachedArtworkImage) {
                        return cachedArtworkImage;
                    }
                    try {
                        return await loadImage(selectedMood.artwork);
                    } catch (error) {
                        return null;
                    }
                })();

                ctx.font = '700 60px Arial';
                const songLines = wrapTextLines(ctx, selectedMood.song, contentWidth);

                ctx.font = '17px Arial';
                const answerLines = selectedAnswer ?
                    wrapTextLines(ctx, `\u201c${selectedAnswer}\u201d`, contentWidth - 40) : [];

                const blocks = [];

                blocks.push({
                    gap: 0,
                    height: 30,
                    draw: (y) => {
                        ctx.fillStyle = '#0c0d0f';
                        ctx.font = '24px monospace';
                        ctx.fillText('MAP OF FEELINGS', contentCenterX, y);
                    }
                });

                blocks.push({
                    gap: 46,
                    height: artworkSize,
                    draw: (y) => {
                        if (artwork) {
                            ctx.save();
                            roundedRect(ctx, contentLeft, y, artworkSize, artworkSize, 28);
                            ctx.clip();
                            ctx.drawImage(artwork, contentLeft, y, artworkSize, artworkSize);
                            ctx.restore();
                        } else {
                            ctx.strokeStyle = `rgba(${hexToRgb(getMoodPrimaryHex(selectedMood))}, .75)`;
                            ctx.lineWidth = 4;
                            ctx.beginPath();
                            ctx.arc(contentCenterX, y + artworkSize / 2, 100, 0, Math.PI * 2);
                            ctx.stroke();
                            ctx.fillStyle = '#0c0d0f';
                            ctx.font = '600 48px Arial';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(selectedMood.feeling, contentCenterX, y + artworkSize / 2);
                            ctx.textBaseline = 'top';
                        }
                    }
                });

                blocks.push({
                    gap: 46,
                    height: 26,
                    draw: (y) => {
                        ctx.fillStyle = '#0c0d0f';
                        ctx.font = '20px monospace';
                        ctx.fillText(selectedMood.coordinate.toUpperCase(), contentCenterX, y);
                    }
                });

                blocks.push({
                    gap: 70,
                    height: songLines.length * 66,
                    draw: (y) => {
                        ctx.fillStyle = '#0c0d0f';
                        ctx.font = '700 60px Arial';
                        songLines.forEach((line, i) => ctx.fillText(line, contentCenterX, y + i * 66));
                    }
                });

                blocks.push({
                    gap: 38,
                    height: 32,
                    draw: (y) => {
                        ctx.fillStyle = '#0c0d0f';
                        ctx.font = '25px Arial';
                        ctx.fillText(`${selectedMood.feeling} \u00b7 ${selectedMood.nuance}`,
                            contentCenterX, y);
                    }
                });

                if (answerLines.length) {
                    blocks.push({
                        gap: 28,
                        height: answerLines.length * 22,
                        draw: (y) => {
                            ctx.fillStyle = '#55585e';
                            ctx.font = '17px Arial';
                            answerLines.forEach((line, i) => ctx.fillText(line, contentCenterX, y + i *
                                22));
                        }
                    });
                }

                if (visitorName) {
                    blocks.push({
                        gap: 40,
                        height: 26,
                        draw: (y) => {
                            ctx.fillStyle = '#6d6d73';
                            ctx.font = '20px Arial';
                            ctx.fillText(visitorName, contentCenterX, y);
                        }
                    });
                }

                if (visitorInstagram) {
                    blocks.push({
                        gap: 28,
                        height: 24,
                        draw: (y) => {
                            ctx.fillStyle = '#6d6d73';
                            ctx.font = '18px monospace';
                            ctx.fillText(visitorInstagram, contentCenterX, y);
                        }
                    });
                }

                blocks.push({
                    gap: 40,
                    height: 24,
                    draw: (y) => {
                        ctx.fillStyle = '#0c0d0f';
                        ctx.font = '18px monospace';
                        ctx.fillText("FROM WHISNU'S STORY TO EVERYONE'S STORY", contentCenterX, y);
                    }
                });

                const contentHeight = blocks.reduce((sum, block) => sum + block.gap + block.height, 0);
                const cardHeight = contentHeight + PAD * 2;
                const cardTop = (canvas.height - cardHeight) / 2;

                ctx.fillStyle = 'rgba(255,255,255,.92)';
                roundedRect(ctx, cardLeft, cardTop, cardWidth, cardHeight, 50);
                ctx.fill();

                let cursorY = cardTop + PAD;
                blocks.forEach((block) => {
                    cursorY += block.gap;
                    block.draw(cursorY);
                    cursorY += block.height;
                });

                return canvasToBlob(canvas);
            }

            function coordinateFileName(visitorName) {
                const safeName = visitorName.toLowerCase().replace(/[^a-z0-9]+/gi, '-').replace(/^-|-$/g, '') ||
                    'coordinate';
                return `map-of-feelings-${safeName}-${selectedMood.id}.png`;
            }

            async function saveCoordinateCard() {
                if (!selectedMood) return;

                const nameInput = document.getElementById('visitorName');
                const instagramInput = document.getElementById('visitorInstagram');
                const saveButton = document.getElementById('saveCoordinate');
                const visitorName = nameInput.value.trim();
                const visitorInstagram = normalizeInstagram(instagramInput.value);

                saveButton.disabled = true;
                saveButton.textContent = 'MENYIAPKAN PNG...';

                // 1. Simpan data pengunjung ke server. Sengaja gak di-`await` di sini:
                //    kalau ditunggu duluan, waktu network request ini ikut "memakan"
                //    masa berlaku user-activation dari klik tombol simpan — dan
                //    beberapa browser (terutama Safari/iOS) langsung menolak
                //    navigator.share() di bawah begitu dianggap gak lagi respons
                //    langsung ke gesture user. submitCoordinateToServer sudah punya
                //    try/catch sendiri, jadi aman dibiarkan jalan di background.
                submitCoordinateToServer(visitorName, visitorInstagram);

                try {
                    // 2. Bikin gambar PNG-nya
                    const blob = await buildCoordinateCardBlob(visitorName, visitorInstagram);
                    const fileName = coordinateFileName(visitorName);
                    const file = new File([blob], fileName, {
                        type: 'image/png'
                    });

                    // 3. Coba buka share sheet DULUAN, sebelum trigger download.
                    //    Urutan ini sengaja: navigator.share() butuh dipanggil sedekat
                    //    mungkin ke klik tombol asli (user-activation). Kalau download
                    //    (link.click() di bawah) dipicu lebih dulu — apalagi sampai
                    //    memunculkan dialog "Save As" di sebagian browser — itu bisa
                    //    dianggap "menyela" gesture user, dan share() sesudahnya jadi
                    //    ditolak diam-diam. canShare({files}) sendiri juga cuma balik
                    //    true di sebagian browser (kebanyakan Android Chrome & iOS
                    //    Safari 15+) — di desktop Chrome/Firefox umumnya memang belum
                    //    dukung share file sama sekali, jadi share bakal dilewati dan
                    //    itu wajar, bukan bug.
                    if (navigator.canShare && navigator.canShare({
                            files: [file]
                        })) {
                        try {
                            await navigator.share({
                                files: [file],
                                title: 'Map of Feelings',
                                text: 'Koordinat perasaanku hari ini di Map of Feelings \u2014 ' +
                                    selectedMood.song,
                            });
                        } catch (shareError) {
                            // AbortError = user cancel share sheet-nya sendiri, PNG tetap lanjut didownload.
                            if (shareError?.name !== 'AbortError') {
                                console.warn('Gagal membuka share sheet:', shareError);
                            }
                        }
                    }

                    // 4. Download PNG-nya ke device user, terlepas dari berhasil/gagal/
                    //    dilewatinya share di atas.
                    const objectUrl = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.download = fileName;
                    link.href = objectUrl;
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    setTimeout(() => URL.revokeObjectURL(objectUrl), 1500);
                    showDownloadFeedback('KOORDINAT BERHASIL DISIMPAN');
                } catch (error) {
                    console.error(error);
                    showDownloadFeedback('GAGAL MENYIMPAN');
                } finally {
                    saveButton.disabled = false;
                    saveButton.textContent = 'SIMPAN KOORDINAT';
                }
            }

            window.addEventListener('mousemove', (event) => {
                const glow = document.getElementById('cursorGlow');
                glow.style.left = `${event.clientX}px`;
                glow.style.top = `${event.clientY}px`;
            });

            mapShell.addEventListener('mousemove', (event) => {
                const rect = mapShell.getBoundingClientRect();
                const x = ((event.clientX - rect.left) / rect.width - 0.5) * 14;
                const y = ((event.clientY - rect.top) / rect.height - 0.5) * 14;
                const gridLines = mapShell.querySelector('.mof-grid-lines');
                if (gridLines) {
                    gridLines.style.transform =
                        `perspective(900px) rotateX(66deg) scale(1.45) translate(${x}px, calc(20% + ${y}px))`;
                }
            });

            mapShell.addEventListener('mouseleave', () => {
                atlasStatus.textContent = 'PERASAAN \u00b7 SIAGA';
                liveCoordinate.textContent = 'LINTANG 00.0000 / BUJUR 00.0000';
                clearMoodHover();
            });

            document.getElementById('enterMap').addEventListener('click', () => setScreen('atlas'));
            document.getElementById('questionBack').addEventListener('click', () => setScreen('atlas'));
            document.getElementById('brandHome').addEventListener('click', reset);
            document.getElementById('coordinateButton').addEventListener('click', openPanel);
            document.getElementById('coordinateMarkerButton').addEventListener('click', openPanel);
            document.getElementById('coordinateHintButton').addEventListener('click', openPanel);
            document.getElementById('panelClose').addEventListener('click', closePanel);
            document.getElementById('restartButton').addEventListener('click', reset);
            document.getElementById('saveCoordinate').addEventListener('click', saveCoordinateCard);

            // Audio ambient landing (landing.wav) + tombol pause/resume
            const landingAudio = document.getElementById('landingAudio');
            const landingAudioToggle = document.getElementById('landingAudioToggle');
            const landingAudioIcon = document.getElementById('landingAudioIcon');

            function updateLandingAudioIcon() {
                if (!landingAudioIcon || !landingAudio) return;
                landingAudioIcon.className = landingAudio.paused ?
                    'bi bi-volume-mute-fill text-base' :
                    'bi bi-volume-up-fill text-base';
                landingAudioToggle.setAttribute('aria-pressed', landingAudio.paused ? 'false' : 'true');
            }

            if (landingAudio && landingAudioToggle) {
                landingAudio.volume = 0.6;
                landingAudio.muted = false;
                updateLandingAudioIcon();

                // Kalau file landing.wav gagal dimuat (path salah/format gak didukung
                // browser), ini bakal muncul di console biar gampang ditelusuri.
                landingAudio.addEventListener('error', () => {
                    console.warn('landing.wav gagal dimuat, cek path/format filenya:', landingAudio
                        .currentSrc || landingAudio.src);
                });

                landingAudio.addEventListener('play', updateLandingAudioIcon);
                landingAudio.addEventListener('pause', updateLandingAudioIcon);

                // Langsung coba diputar begitu masuk website (gak mulai dari mute).
                const tryAutoplay = () => landingAudio.play().catch(() => {});
                tryAutoplay();

                // Beberapa browser tetap blokir autoplay bersuara walau volume/muted
                // sudah diatur. Kalau itu terjadi, begitu user berinteraksi pertama
                // kali di halaman (klik/tap/keyboard di mana pun), audio otomatis
                // mulai diputar sendiri.
                const resumeOnFirstInteraction = (event) => {
                    const isToggleClick = event.target && event.target.closest &&
                        event.target.closest('#landingAudioToggle');
                    // Kalau interaksi pertama itu justru klik tombol toggle sendiri,
                    // biarkan handler klik tombol di bawah yang urus play/pause-nya —
                    // supaya gak tabrakan: audio keburu diputar di sini, terus
                    // langsung ke-pause lagi sama klik tombolnya sendiri.
                    if (!isToggleClick && landingAudio.paused) tryAutoplay();
                    ['pointerdown', 'keydown', 'touchstart'].forEach((evt) =>
                        document.removeEventListener(evt, resumeOnFirstInteraction));
                };
                ['pointerdown', 'keydown', 'touchstart'].forEach((evt) =>
                    document.addEventListener(evt, resumeOnFirstInteraction, {
                        once: true,
                        passive: true
                    }));

                // Tombol tetap ada buat pause/lanjutkan audio kapan pun user mau.
                landingAudioToggle.addEventListener('click', () => {
                    if (landingAudio.paused) {
                        landingAudio.play().catch((error) => {
                            console.warn('Gagal memutar landing.wav:', error);
                        });
                    } else {
                        landingAudio.pause();
                    }
                });
            }

            renderAtlas();
            setMoodTheme(MOODS[0]);
            clearMoodHover();
            startOrbitCycle();
            setScreen('landing');
            restartFragmentAnimations();
        })();
    </script>
@endsection
