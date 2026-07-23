@extends('template.layout')
@section('content')
    <section id="landing" data-screen="landing"
        class="w-full font-[Arial,Helvetica,sans-serif] text-[#050505] overflow-x-hidden">
        <div class="min-h-screen flex flex-col items-center justify-center overflow-hidden px-[4.5vw] pt-10.5 pb-6">
            <p class="m-0 mb-1.5 text-[clamp(20px,2.2vw,32px)] font-extrabold">WELCOME TO</p>
            <h1 class="z-3 flex items-center gap-[clamp(6px,1.1vw,18px)] m-0 -mb-16 text-[clamp(72px,10.8vw,162px)] font-normal leading-[0.9] tracking-[-0.08em] whitespace-nowrap max-[760px]:text-[clamp(50px,16vw,86px)] max-[760px]:-mb-9"
                aria-label="Map of Feelings">
                <span>Map</span><span
                    class="font-['Brush_Script_MT','Segoe_Script',cursive] text-[0.68em] italic -rotate-12 translate-y-1.5 tracking-[-0.13em]">of</span><span>Feelings</span>
            </h1>
            <div id="moodBars"
                class="z-1 grid grid-cols-[repeat(10,minmax(58px,1fr))] gap-2.5 items-stretch w-[min(1120px,94vw)] h-[min(50vh,402px)] max-[760px]:h-[48vh] max-[760px]:gap-1.25 max-[760px]:grid-cols-[repeat(10,minmax(25px,1fr))]"
                aria-label="Choose a feeling"></div>
            <h2 class="m-0 mt-7.5 mb-2 text-center text-[clamp(27px,3vw,43px)] leading-none">HOW ARE YOU FEELING TODAY?
            </h2>
            <p class="m-0 text-[clamp(14px,1.25vw,18px)] font-bold">Choose the symbol</p>
        </div>
    </section>

    {{-- PAGE 2 — MAPPING / FINDING --}}
    {{-- Catatan: grid dipindah ke div dalam, section luar cuma urus visibility (dikontrol JS via style.display) --}}
    <section id="mapping" data-screen="mapping" class="w-full relative min-h-screen overflow-hidden" style="display:none"
        aria-live="polite">
        <div class="relative min-h-screen grid place-items-center p-8">
            <div id="mappingField" class="absolute inset-0" aria-hidden="true"></div>
            <h2 id="mappingText"
                class="z-2 m-0 max-w-155 text-center whitespace-pre-line font-semibold text-[clamp(34px,4vw,58px)] leading-[1.05] after:content-[''] after:inline-block after:w-[.09em] after:h-[.9em] after:ml-[.12em] after:bg-current after:align-[-.08em] after:animate-[caret_.75s_steps(1)_infinite] motion-reduce:after:animate-none">
            </h2>
        </div>
    </section>

    {{-- PAGE 3 — COORDINATE --}}
    <section id="coordinate" data-screen="coordinate" class="w-full relative min-h-screen [background:var(--page-gradient)]"
        style="display:none">
        <div class="min-h-screen flex flex-col items-center justify-center px-6 py-10 text-center">
            <h2 class="m-0 mb-11 font-semibold text-[clamp(35px,4vw,58px)] leading-[1.02]">FOUND YOUR<br />COORDINATE!</h2>
            <div class="mb-10 w-9.5 h-9.5 rounded-full border border-black grid place-items-center bg-white/45 shadow-[0_0_0_4px_transparent,0_0_0_5px_#000,0_0_0_9px_transparent,0_0_0_10px_#000] animate-[markerPulse_1.25s_ease-in-out_infinite_alternate] motion-reduce:animate-none"
                aria-hidden="true">
                <span id="coordinateEmoji" class="text-[22px]"></span>
            </div>
            <button id="coordinateButton" type="button"
                class="min-w-[min(590px,82vw)] min-h-24 rounded-[30px] bg-black text-white px-10.5 py-6.5 font-extrabold text-[clamp(20px,2.2vw,31px)] transition-[transform,box-shadow] duration-200 ease-out hover:-translate-y-1.5 hover:shadow-[0_18px_34px_rgba(0,0,0,.2)] focus-visible:outline-none focus-visible:-translate-y-1.5 focus-visible:shadow-[0_18px_34px_rgba(0,0,0,.2)]">
                <span id="coordinateName">The Quiet Breaking Point</span>
            </button>
            <p class="mt-4.5 mb-0 font-bold opacity-70">Click the coordinate to continue</p>
        </div>
    </section>

    {{-- PAGE 4 — SONG RESULT --}}
    <section id="result" data-screen="result" class="w-full relative min-h-screen [background:var(--page-gradient)]"
        style="display:none">
        <div class="min-h-screen px-5.5 pt-13.5 pb-17.5 text-center">
            <h2 class="mx-auto mb-8.5 font-semibold text-[clamp(29px,3.5vw,48px)]">YOUR FEELING REMINDS US OF..</h2>
            <article
                class="w-[min(680px,92vw)] mx-auto rounded-[42px] bg-black text-white px-12 pt-12 pb-10.5 shadow-[0_24px_70px_rgba(0,0,0,.2)]">
                <img id="resultArtwork" src="" alt="Song artwork"
                    class="block w-[min(320px,72vw)] aspect-square object-cover mx-auto mb-9.5 bg-white" />
                <div class="text-center">
                    <p class="mt-7 mb-1.75 text-[12px] font-extrabold tracking-[.14em] opacity-[.66]">REKOMENDASI</p>
                    <h3 id="resultSong" class="m-0 text-[clamp(29px,3.3vw,44px)]">Aku Harus Pergi</h3>
                    <p class="mt-7 mb-1.75 text-[12px] font-extrabold tracking-[.14em] opacity-[.66]">COORDINATE</p>
                    <h4 id="resultCoordinate" class="m-0 text-[clamp(21px,2.4vw,31px)]">The Quiet Breaking Point</h4>
                    <p id="resultMood" class="mt-2.25 mb-0 opacity-[.72]"></p>
                    <p class="mt-7 mb-1.75 text-[12px] font-extrabold tracking-[.14em] opacity-[.66]">KENAPA LAGU INI?</p>
                    <p id="resultWhy" class="max-w-135 mx-auto leading-[1.55] text-[clamp(16px,1.6vw,20px)]"></p>
                    <p id="resultAffirmation"
                        class="max-w-135 mx-auto mt-7.5 italic opacity-[.86] leading-[1.55] text-[clamp(16px,1.6vw,20px)]">
                    </p>

                    <div class="flex flex-wrap justify-center gap-2.5 mt-8.5">
                        <a id="spotifyLink" href="#" target="_blank" rel="noopener"
                            class="rounded-full border border-white bg-white text-black font-extrabold no-underline px-5 py-3.25 transition-transform duration-200 hover:-translate-y-0.5 focus-visible:-translate-y-0.5">Spotify</a>
                        <a id="youtubeLink" href="#" target="_blank" rel="noopener"
                            class="rounded-full border border-white bg-white text-black font-extrabold no-underline px-5 py-3.25 transition-transform duration-200 hover:-translate-y-0.5 focus-visible:-translate-y-0.5">YouTube</a>
                        <button id="saveCoordinate" type="button"
                            class="rounded-full border border-white bg-white text-black font-extrabold px-5 py-3.25 transition-transform duration-200 hover:-translate-y-0.5 focus-visible:-translate-y-0.5">Save
                            Coordinate</button>
                    </div>

                    <button id="restartButton" type="button"
                        class="mt-4 rounded-full border border-white bg-transparent text-white font-extrabold px-5 py-3.25">Map
                        Another Feeling</button>
                </div>
            </article>
        </div>
    </section>

    <script>
        // Data lagu lengkap.
        window.MAP_OF_FEELINGS = [{
                id: "heartbroken",
                emoji: "😭",
                feeling: "Heartbroken",
                nuance: "Trying to let go",
                song: "Aku Harus Pergi",
                coordinate: "The Quiet Breaking Point",
                barGradient: "linear-gradient(180deg,#6eb8ff 0%,#1f80f0 48%,#0640d8 100%)",
                pageGradient: "radial-gradient(circle at 82% 5%,#ffffff 0%,#c9ddf8 31%,#6f9ee9 58%,#187cf0 100%)",
                artwork: "{{ asset('assets/artwork/aku-harus-pergi.svg') }}",
                why: "Rekomendasi lagu karena Aku Harus Pergi bicara tentang menerima bahwa melepas juga bisa menjadi bentuk cinta.",
                affirmation: "Some goodbyes are not proof that love failed. Sometimes leaving is the first way you protect what is left of you.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "anxious",
                emoji: "😟",
                feeling: "Anxious",
                nuance: "Misunderstood",
                song: "Tak Peka",
                coordinate: "The Unread Signal",
                barGradient: "linear-gradient(180deg,#f18c9e 0%,#e8405d 48%,#df123f 100%)",
                pageGradient: "radial-gradient(circle at 80% 6%,#ffe7eb 0%,#ef8799 34%,#d92d49 67%,#b80727 100%)",
                artwork: "{{ asset('assets/artwork/tak-peka.svg') }}",
                why: "Tak Peka cocok untuk rasa capek karena tidak dimengerti dan komunikasi yang meleset.",
                affirmation: "Sometimes you are not hard to love. You are just tired of translating your heart.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "angry",
                emoji: "😡",
                feeling: "Angry",
                nuance: "Accused",
                song: "Tak Mendua",
                coordinate: "The Trust Checkpoint",
                barGradient: "linear-gradient(180deg,#9bd8bd 0%,#d5ca8d 47%,#ff9b58 100%)",
                pageGradient: "radial-gradient(circle at 87% 7%,#00c7db 0%,#79d5ca 24%,#ffbe43 59%,#ff6f91 100%)",
                artwork: "{{ asset('assets/artwork/tak-mendua.svg') }}",
                why: "Lagu ini masuk saat kamu merasa dituduh, tidak dipercaya, atau terus-menerus harus membela diri.",
                affirmation: "Being loyal should not feel like standing in court. The heart also needs to be believed.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "betrayed",
                emoji: "💔",
                feeling: "Betrayed",
                nuance: "Trust cracking",
                song: "Hilang Warasnya",
                coordinate: "The Fracture Line",
                barGradient: "linear-gradient(180deg,#ffd7a2 0%,#ffb348 50%,#ff9e22 100%)",
                pageGradient: "radial-gradient(circle at 84% 8%,#fff3d9 0%,#ffc46f 41%,#ff9d2d 72%,#ef7b00 100%)",
                artwork: "{{ asset('assets/artwork/hilang-warasnya.svg') }}",
                why: "Hilang Warasnya cocok untuk fase ketika kepercayaan runtuh pelan-pelan dan kehangatan mulai terasa asing.",
                affirmation: "Some hearts do not break all at once. They crack quietly, one disappointment at a time.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "numb",
                emoji: "😶",
                feeling: "Numb",
                nuance: "Still not enough",
                song: "Sumpah Percuma",
                coordinate: "The Empty Trophy Room",
                barGradient: "linear-gradient(180deg,#cbc2ff 0%,#aaa4ff 47%,#7789f2 100%)",
                pageGradient: "radial-gradient(circle at 76% 9%,#6797ff 0%,#a78ef4 39%,#d498f0 72%,#8c80e7 100%)",
                artwork: "{{ asset('assets/artwork/sumpah-percuma.svg') }}",
                why: "Lagu ini menjadi jawaban untuk rasa hampa meski dari luar semuanya terlihat cukup.",
                affirmation: "You can have everything people clap for and still need something no one sees.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "grief",
                emoji: "😢",
                feeling: "Grief",
                nuance: "Missing someone",
                song: "Pesan Rindu",
                coordinate: "The Message That Stayed",
                barGradient: "linear-gradient(180deg,#ffd5a2 0%,#ffb233 49%,#ff9700 100%)",
                pageGradient: "radial-gradient(circle at 17% 82%,#ffd400 0%,#ffac20 39%,#ff6d0b 77%,#ff6500 100%)",
                artwork: "{{ asset('assets/artwork/pesan-rindu.svg') }}",
                why: "Pesan Rindu menjadi soundtrack untuk rindu yang tidak selesai, terutama setelah kehilangan.",
                affirmation: "Not every message needs a reply. Some messages stay because love still knows the way home.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "flirty",
                emoji: "🥰",
                feeling: "Flirty",
                nuance: "Private love",
                song: "Yang Tau Tau Aja",
                coordinate: "The Hidden Corner",
                barGradient: "linear-gradient(180deg,#d5f1df 0%,#eeefad 49%,#f6ec72 100%)",
                pageGradient: "radial-gradient(circle at 9% 43%,#e18fe9 0%,#9dd7ef 26%,#d9efba 51%,#fff37b 78%,#ffc65a 100%)",
                artwork: "{{ asset('assets/artwork/yang-tau-tau-aja.svg') }}",
                why: "Yang Tau Tau Aja cocok untuk hubungan yang ringan, rahasia, dan cukup diketahui lingkar terdekat.",
                affirmation: "Some feelings do not need an announcement. Sometimes the sweetest thing is knowing only a few people know.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "longing",
                emoji: "🥺",
                feeling: "Longing",
                nuance: "Growing apart",
                song: "Sedih Harus Kau Buang",
                coordinate: "The Last Day of Somewhere",
                barGradient: "linear-gradient(180deg,#d6fa72 0%,#c5f000 49%,#a8d900 100%)",
                pageGradient: "radial-gradient(circle at 30% 78%,#d6ff23 0%,#c6f000 48%,#9fd000 100%)",
                artwork: "{{ asset('assets/artwork/sedih-harus-kau-buang.svg') }}",
                why: "Lagu ini pas untuk nostalgia, perpisahan masa sekolah atau kampus, dan rasa yang harus dilepas.",
                affirmation: "Some sadness asks to be thanked, folded neatly, and left behind.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "hopeful",
                emoji: "🥹",
                feeling: "Hopeful",
                nuance: "Waiting for timing",
                song: "Fatamorgana",
                coordinate: "The Distant Light",
                barGradient: "linear-gradient(180deg,#fff7b4 0%,#fff04a 51%,#ffea00 100%)",
                pageGradient: "radial-gradient(circle at 48% 50%,#fff9c8 0%,#fff367 38%,#ffe500 80%,#ffd900 100%)",
                artwork: "{{ asset('assets/artwork/fatamorgana.svg') }}",
                why: "Fatamorgana cocok untuk kamu yang sedang menunggu, berdoa, dan percaya pada waktu yang tepat.",
                affirmation: "Hope is not always loud. Sometimes it is just you still looking at the horizon.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "peaceful",
                emoji: "🙂",
                feeling: "Peaceful",
                nuance: "Lonely in a crowd",
                song: "Sorak Sepi",
                coordinate: "The Silent Stage",
                barGradient: "linear-gradient(180deg,#bfe7c8 0%,#45b865 48%,#00a52d 100%)",
                pageGradient: "radial-gradient(circle at 21% 82%,#50c653 0%,#31973a 46%,#1b5b2a 100%)",
                artwork: "{{ asset('assets/artwork/sorak-sepi.svg') }}",
                why: "Sorak Sepi menjadi penutup: kesepian yang sunyi, dewasa, dan tidak perlu dilawan keras-keras.",
                affirmation: "The loudest room can still leave space for silence. You are allowed to rest after being seen.",
                spotify: "#",
                youtube: "#"
            }
        ];

        (function() {
            const MOODS = window.MAP_OF_FEELINGS;
            const moodBars = document.getElementById('moodBars');

            function renderLanding() {
                moodBars.innerHTML = '';

                MOODS.forEach((mood, index) => {
                    const button = document.createElement('button');
                    button.type = 'button';

                    button.className = [
                        'group relative border-0 p-0',
                        '[background:var(--bar-gradient)]',
                        'origin-bottom',
                        'transition-[filter,scale] duration-200 ease-out',
                        'hover:saturate-[1.18] hover:brightness-[1.03] hover:scale-[1.035] hover:z-[4]',
                        'focus-visible:outline-none focus-visible:saturate-[1.18] focus-visible:brightness-[1.03] focus-visible:scale-[1.035] focus-visible:z-[4]',
                        'animate-[barFloat_var(--float-duration)_ease-in-out_var(--float-delay)_infinite_alternate]',
                        'motion-reduce:animate-none'
                    ].join(' ');

                    button.style.setProperty('--bar-gradient', mood.barGradient);
                    button.style.setProperty('--float-duration', `${2.8 + (index % 4) * .42}s`);
                    button.style.setProperty('--float-delay', `${index * -.19}s`);
                    button.style.setProperty('--float-y', `${index % 2 === 0 ? -10 : 12}px`);
                    button.style.setProperty('--emoji-delay', `${index * -.14}s`);
                    button.setAttribute('aria-label', `${mood.feeling}: ${mood.song}`);

                    button.innerHTML = `
                    <span
                        aria-hidden="true"
                        class="absolute left-1/2 top-[46%] -translate-x-1/2 -translate-y-1/2 grid place-items-center w-[clamp(42px,4.2vw,64px)] h-[clamp(42px,4.2vw,64px)] rounded-full border-2 border-black bg-white/[.86] text-[clamp(23px,2.35vw,35px)] shadow-[0_8px_18px_rgba(0,0,0,.13)] animate-[emojiFloat_2.3s_ease-in-out_var(--emoji-delay)_infinite_alternate] motion-reduce:animate-none max-[760px]:w-[34px] max-[760px]:h-[34px] max-[760px]:text-[18px]"
                    >${mood.emoji}</span>
                    <span
                        class="absolute left-1/2 bottom-3 -translate-x-1/2 w-full text-center font-extrabold text-[11px] opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-visible:opacity-100 max-[760px]:hidden"
                    >${mood.feeling}</span>
                `;

                    button.addEventListener('click', () => beginJourney(mood));

                    moodBars.appendChild(button);
                });
            }

            // ===== Screen management =====
            // Dikontrol lewat inline style.display, BUKAN class Tailwind "hidden" —
            // supaya gak bentrok sama class display lain (grid/flex) yang ada di elemen yang sama.
            const screens = document.querySelectorAll('[data-screen]');

            function setScreen(name) {
                screens.forEach((screen) => {
                    const isActive = screen.dataset.screen === name;

                    if (isActive) {
                        screen.style.opacity = '0';
                        screen.style.display = '';
                        void screen.offsetWidth; // force reflow biar animasi fade selalu re-trigger
                        screen.style.animation = 'pageIn .45s ease forwards';
                    } else {
                        screen.style.display = 'none';
                        screen.style.animation = '';
                    }
                });
                window.scrollTo(0, 0);
            }

            // ===== Timers =====
            let timerIds = [];

            function clearTimers() {
                timerIds.forEach(clearTimeout);
                timerIds = [];
            }

            function wait(ms, fn) {
                const id = setTimeout(fn, ms);
                timerIds.push(id);
                return id;
            }

            // ===== Typewriter text (mapping screen) =====
            const mappingText = document.getElementById('mappingText');

            function typeText(text, speed = 54, onDone) {
                mappingText.textContent = '';
                let index = 0;
                const tick = () => {
                    mappingText.textContent = text.slice(0, index + 1);
                    index += 1;
                    if (index < text.length) wait(speed, tick);
                    else if (onDone) onDone();
                };
                tick();
            }

            // ===== Map dots (mapping screen) =====
            const mappingField = document.getElementById('mappingField');
            const dotPositions = [
                [15, 24],
                [34, 26],
                [52, 34],
                [70, 36],
                [88, 32],
                [6, 50],
                [43, 66],
                [61, 66],
                [79, 78],
                [24, 78]
            ];

            function renderMapDots(selected, finding = false) {
                mappingField.innerHTML = '';

                MOODS.forEach((mood, index) => {
                    const isSelected = finding && mood.id === selected.id;
                    const dot = document.createElement('span');
                    dot.style.setProperty('--x', `${dotPositions[index][0]}%`);
                    dot.style.setProperty('--y', `${dotPositions[index][1]}%`);
                    dot.style.setProperty('--delay', `${(index % 5) * -.21}s`);

                    if (isSelected) {
                        dot.className = [
                            'absolute left-[var(--x)] top-[var(--y)] -translate-x-1/2 -translate-y-1/2',
                            'grid place-items-center w-[clamp(48px,4.3vw,68px)] h-[clamp(48px,4.3vw,68px)]',
                            'rounded-full bg-white/90 border border-black text-[clamp(24px,2.3vw,36px)]',
                            'shadow-[0_0_0_5px_#fff,0_0_0_6px_#000,0_0_0_10px_#fff,0_0_0_11px_#000]',
                            'animate-[selectedBlink_.62s_ease-in-out_infinite_alternate]',
                            'motion-reduce:animate-none'
                        ].join(' ');
                        dot.textContent = mood.emoji;
                    } else {
                        dot.className = [
                            'absolute left-[var(--x)] top-[var(--y)] -translate-x-1/2 -translate-y-1/2',
                            'w-[clamp(18px,1.7vw,26px)] h-[clamp(18px,1.7vw,26px)] rounded-full bg-black',
                            'animate-[dotPulse_1.05s_ease-in-out_var(--delay)_infinite_alternate]',
                            'motion-reduce:animate-none'
                        ].join(' ');
                    }

                    mappingField.appendChild(dot);
                });
            }

            // ===== Journey: landing -> mapping -> coordinate =====
            let selectedMood = null;

            function beginJourney(mood) {
                clearTimers();
                selectedMood = mood;
                setScreen('mapping');

                // Total loading time: sekitar 5 detik.
                renderMapDots(mood, false);
                typeText('Mapping\nyour feelings', 48);

                wait(2500, () => {
                    renderMapDots(mood, true);
                    typeText('Finding\nyour place..', 50);
                });

                wait(5000, () => {
                    prepareCoordinate(mood);
                    setScreen('coordinate');
                });
            }

            function prepareCoordinate(mood) {
                document.documentElement.style.setProperty('--page-gradient', mood.pageGradient);

                document.getElementById('coordinateName').textContent = mood.coordinate;
                document.getElementById('coordinateEmoji').textContent = mood.emoji;

                document.getElementById('resultSong').textContent = mood.song;
                document.getElementById('resultCoordinate').textContent = mood.coordinate;
                document.getElementById('resultMood').textContent = `${mood.feeling} · ${mood.nuance}`;
                document.getElementById('resultWhy').textContent = mood.why;
                document.getElementById('resultAffirmation').textContent = mood.affirmation;
                document.getElementById('resultArtwork').src = mood.artwork;
                document.getElementById('resultArtwork').alt = `${mood.song} artwork`;
                document.getElementById('spotifyLink').href = mood.spotify || '#';
                document.getElementById('youtubeLink').href = mood.youtube || '#';
            }

            document.getElementById('coordinateButton').addEventListener('click', () => setScreen('result'));

            document.getElementById('restartButton').addEventListener('click', () => {
                clearTimers();
                selectedMood = null;
                setScreen('landing');
            });

            // ===== Save Coordinate (export gambar hasil) =====
            document.getElementById('saveCoordinate').addEventListener('click', () => {
                if (!selectedMood) return;

                const canvas = document.createElement('canvas');
                canvas.width = 1080;
                canvas.height = 1350;
                const ctx = canvas.getContext('2d');

                const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
                gradient.addColorStop(0, '#ffffff');
                gradient.addColorStop(.38, selectedMood.id === 'heartbroken' ? '#9dc6f6' : '#dddddd');
                gradient.addColorStop(1, getFallbackColor(selectedMood.id));
                ctx.fillStyle = gradient;
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                ctx.textAlign = 'center';
                ctx.fillStyle = '#000';
                ctx.font = '800 42px Arial';
                ctx.fillText('MAP OF FEELINGS', 540, 115);
                ctx.font = '800 34px Arial';
                ctx.fillText('YOUR CURRENT COORDINATE', 540, 225);

                roundedRect(ctx, 110, 315, 860, 340, 44);
                ctx.fillStyle = '#000';
                ctx.fill();
                ctx.fillStyle = '#fff';
                ctx.font = '800 58px Arial';
                wrapText(ctx, selectedMood.coordinate, 540, 455, 760, 70);
                ctx.font = '400 34px Arial';
                ctx.fillText(`${selectedMood.feeling} · ${selectedMood.song}`, 540, 590);

                ctx.fillStyle = '#000';
                ctx.font = 'italic 36px Arial';
                wrapText(ctx, selectedMood.affirmation, 540, 810, 840, 52);
                ctx.font = '800 27px Arial';
                ctx.fillText('EVERY FEELING HAS A PLACE.', 540, 1240);

                const link = document.createElement('a');
                link.download = `map-of-feelings-${selectedMood.id}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            });

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
                }
            }

            function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
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
                lines.forEach((item, index) => ctx.fillText(item, x, y + index * lineHeight));
            }

            function getFallbackColor(id) {
                return ({
                    heartbroken: '#136fe8',
                    anxious: '#c51f3d',
                    angry: '#ff8b62',
                    betrayed: '#ef9a2e',
                    numb: '#9d87ef',
                    grief: '#ff8d00',
                    flirty: '#f3dc77',
                    longing: '#b6e400',
                    hopeful: '#ffe500',
                    peaceful: '#238c39'
                })[id] || '#7ca2e5';
            }

            renderLanding();
            setScreen('landing');
        })();
    </script>
@endsection
