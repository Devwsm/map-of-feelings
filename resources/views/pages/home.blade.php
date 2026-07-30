@extends('template.layout')

@section('content')
    <div class="mof-body w-full" id="mofRoot">
        <div class="mof-noise" aria-hidden="true"></div>
        <div class="mof-cursor-glow" id="cursorGlow" aria-hidden="true"></div>

        <header
            class="fixed inset-x-0 top-0 z-[70] flex items-center justify-between px-6 py-5 sm:px-8 backdrop-blur-md bg-white/70 border-b border-black/5">
            <button id="brandHome" type="button" aria-label="Kembali ke awal"
                class="flex items-center border-0 bg-transparent p-0 cursor-pointer">
                <img src="{{ asset('assets/logo/logo-map-of-feelings.svg') }}" alt="Map of Feelings"
                    class="block h-[18px] sm:h-[22px] w-auto" />
            </button>

            <div class="flex items-center gap-4 sm:gap-5">
                <div class="hidden sm:flex gap-5 font-mono tracking-widest text-[10px] text-black/60">
                    <span id="liveCoordinate">LINTANG 00.0000 / BUJUR 00.0000</span>
                    <span id="atlasStatus">AREA 01 &middot; SIAGA</span>
                </div>
                <a href="{{ route('login') }}"
                    class="font-mono tracking-widest rounded-full border border-black/20 bg-white/80 px-4 py-2.5 text-[10px] hover:bg-white transition-colors">MASUK
                    PENGELOLA</a>
            </div>
        </header>

        <main id="mofApp" class="w-full">

            {{-- LANDING / HERO --}}
            <section id="landing" data-screen="landing"
                class="mof-screen place-items-center text-center overflow-hidden px-6 pt-[110px] pb-10 sm:pt-[140px]">
                <div class="relative z-[4] max-w-3xl">
                    <img src="{{ asset('assets/logo/logo-map-of-feelings.svg') }}" alt="Map of Feelings"
                        class="block w-[min(520px,74vw)] h-auto mx-auto mb-8" />
                    <p class="max-w-xl mx-auto mb-8 text-black/60 text-base sm:text-lg leading-relaxed">Setiap perasaan
                        punya tempatnya sendiri. Temukan koordinat emosimu dan lagu yang sedang berbicara paling dekat
                        denganmu.</p>
                    <button id="enterMap" type="button"
                        class="font-mono tracking-widest rounded-full border border-black bg-black text-white px-6 py-4 text-[11px] hover:-translate-y-0.5 hover:shadow-lg transition">MULAI
                        PERJALANAN</button>
                </div>

                <div class="absolute w-[min(70vmin,760px)] aspect-square" aria-hidden="true">
                    <div class="mof-orbit-ring"></div>
                    <div class="mof-orbit-ring mof-orbit-b"></div>
                    <div class="mof-orbit-ring mof-orbit-c"></div>
                    <div class="mof-moon"></div>
                </div>
            </section>

            {{-- ATLAS --}}
            <section id="atlas" data-screen="atlas" class="mof-screen px-5 pt-[110px] pb-16 sm:px-8">
                <div class="max-w-[1400px] mx-auto mb-8 text-center">
                    <img src="{{ asset('assets/logo/logo-map-of-feelings.svg') }}" alt="Map of Feelings"
                        class="block w-[min(340px,62vw)] h-auto mx-auto mb-3" />
                    <h2 class="text-4xl sm:text-6xl font-light tracking-tight">Bagaimana perasaanmu hari ini?</h2>
                    <p class="font-mono tracking-widest mt-4 text-[10px] text-black/50">SOROT &middot; RASAKAN &middot;
                        PILIH</p>
                </div>

                <div class="mof-map-shell max-w-[1400px] mx-auto min-h-[600px] sm:min-h-[680px]" id="mapShell">
                    <div class="mof-grid-lines"></div>
                    <div class="mof-map-glow"></div>
                    <div id="emotionNodes"></div>
                    <div class="mof-map-caption font-mono tracking-widest">
                        <span>AREA 01</span><span class="hidden sm:inline">KEDALAMAN: BATIN</span><span>VISIBILITAS:
                            BERUBAH</span>
                    </div>
                </div>
            </section>

            {{-- QUESTION --}}
            <section id="question" data-screen="question" class="mof-screen place-items-center px-5 pt-[100px] pb-16">
                <div class="relative w-[min(920px,92vw)] text-center">
                    <button id="questionBack" type="button"
                        class="font-mono tracking-widest absolute left-0 -top-12 border-0 bg-transparent p-0 text-black/50 hover:text-black/80 transition-colors cursor-pointer">&larr;
                        KEMBALI</button>

                    <p id="questionFeeling"
                        class="font-mono tracking-widest mb-4 text-[11px] text-[color:rgb(var(--mof-mood-rgb,122,174,247))]">
                        SEDIH</p>
                    <h2 id="questionTitle" class="mb-10 text-3xl sm:text-6xl font-normal leading-tight tracking-tight"></h2>
                    <div id="questionChoices" class="grid grid-cols-1 sm:grid-cols-2 gap-3.5"></div>
                    <p class="font-mono tracking-widest mt-6 text-[10px] text-black/50">Pilih jawaban yang terasa paling
                        dekat denganmu.</p>
                </div>
            </section>

            {{-- MAPPING --}}
            <section id="mapping" data-screen="mapping"
                class="mof-screen mof-mapping-screen place-items-center overflow-hidden" aria-live="polite">
                <div id="mappingField" class="mof-mapping-field" aria-hidden="true"></div>
                <div class="relative z-[3] w-[min(650px,85vw)] text-center">
                    <p class="font-mono tracking-widest mb-2 text-[11px] text-black/50">MEMETAKAN PERASAANMU</p>
                    <h2 id="mappingText"
                        class="whitespace-pre-line text-4xl sm:text-7xl font-light leading-none tracking-tight"></h2>
                    <div class="mof-mapping-progress-bar"><span id="mappingProgress"></span></div>
                </div>
            </section>

            {{-- COORDINATE --}}
            <section id="coordinate" data-screen="coordinate"
                class="mof-screen mof-coordinate-screen place-items-center overflow-hidden">
                <div class="mof-coordinate-aura"></div>
                <div class="relative z-[2] flex flex-col items-center text-center px-6">
                    <p class="font-mono tracking-widest mb-5 text-[11px]">PERASAANMU PUNYA TEMPAT</p>
                    <h2 class="m-0 text-4xl sm:text-7xl font-light leading-none tracking-tight">Kami
                        menemukan<br />koordinatmu.</h2>

                    <div class="mof-coordinate-marker my-11"></div>

                    <button id="coordinateButton" type="button" class="mof-coordinate-button">
                        <small id="coordinateFeeling"
                            class="font-mono tracking-widest text-[10px] text-white/72">PERASAAN</small>
                        <strong id="coordinateName">Titik Patah yang Sunyi</strong>
                    </button>

                    <p class="font-mono tracking-widest mt-6 text-[10px] text-black/60">Klik koordinat untuk melihat lagu
                        yang terhubung</p>
                </div>
            </section>
        </main>

        {{-- RESULT PANEL --}}
        <aside id="emotionPanel" class="mof-emotion-panel" aria-hidden="true">
            <button id="panelClose" type="button" aria-label="Tutup"
                class="fixed right-6 top-6 z-[5] w-12 h-12 rounded-full border border-black/10 bg-white/90 text-2xl shadow-lg">&times;</button>

            <div class="grid place-items-center relative px-6 py-[90px] sm:px-[6vw]">
                <div class="mof-artwork-frame">
                    <img id="resultArtwork" src="" alt="Artwork lagu" />
                </div>
                <div class="font-mono tracking-widest absolute left-8 bottom-7 text-[10px] text-black/50" id="panelIndex">
                    01 / 10</div>
            </div>

            <div class="self-center w-[min(760px,86%)] py-16 sm:py-[100px]">
                <p id="panelCoordinate" class="font-mono tracking-widest mb-2 text-[11px] text-black/50">TITIK PATAH YANG
                    SUNYI</p>
                <h2 id="resultSong" class="m-0 text-5xl sm:text-8xl font-light leading-[0.9] tracking-tighter">Aku Harus
                    Pergi</h2>
                <p id="resultMood" class="mt-7 mb-8 text-lg text-black/55"></p>

                <div class="grid grid-cols-2 border-y border-black/10 mb-8">
                    <div class="py-4"><span
                            class="font-mono tracking-widest block mb-1.5 text-[9px] text-black/50">KONDISI
                            EMOSI</span><strong id="panelState" class="text-xl"></strong></div>
                    <div class="py-4"><span
                            class="font-mono tracking-widest block mb-1.5 text-[9px] text-black/50">CUACA
                            ATLAS</span><strong id="panelWeather" class="text-xl"></strong></div>
                </div>

                <p class="font-mono tracking-widest mb-2 text-[9px] text-black/50">KENAPA LAGU INI?</p>
                <p id="resultWhy" class="mb-7 text-black/55 leading-loose"></p>
                <p id="resultAffirmation" class="my-7 italic text-lg text-black"></p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 my-7">
                    <label class="grid gap-2">
                        <span class="font-mono tracking-widest text-[9px] text-black/50">NAMA</span>
                        <input id="visitorName" type="text" maxlength="40" autocomplete="name"
                            placeholder="Tulis nama kamu"
                            class="w-full min-h-[50px] rounded-2xl border border-black/15 bg-white/80 px-4 py-3.5 text-sm outline-none focus:border-[color:rgb(var(--mof-panel-accent-rgb,122,174,247))]" />
                    </label>
                    <label class="grid gap-2">
                        <span class="font-mono tracking-widest text-[9px] text-black/50">NAMA INSTAGRAM</span>
                        <input id="visitorInstagram" type="text" maxlength="40" autocapitalize="none"
                            spellcheck="false" placeholder="@username"
                            class="w-full min-h-[50px] rounded-2xl border border-black/15 bg-white/80 px-4 py-3.5 text-sm outline-none focus:border-[color:rgb(var(--mof-panel-accent-rgb,122,174,247))]" />
                    </label>
                    <p id="coordinateFormError" class="sm:col-span-2 min-h-4 text-xs text-red-600" aria-live="polite">
                    </p>
                </div>

                <div class="flex flex-wrap gap-2.5">
                    <a id="spotifyLink" href="#" target="_blank" rel="noopener"
                        class="font-mono tracking-widest rounded-full border border-black/15 bg-white/80 px-4.5 py-3.5 text-[10px] hover:bg-white hover:-translate-y-0.5 transition">DENGARKAN
                        DI SPOTIFY</a>
                    <a id="youtubeLink" href="#" target="_blank" rel="noopener"
                        class="font-mono tracking-widest rounded-full border border-black/15 bg-white/80 px-4.5 py-3.5 text-[10px] hover:bg-white hover:-translate-y-0.5 transition">TONTON
                        DI YOUTUBE</a>
                    <button id="saveCoordinate" type="button"
                        class="font-mono tracking-widest rounded-full border border-black/15 bg-white/80 px-4.5 py-3.5 text-[10px] hover:bg-white hover:-translate-y-0.5 transition disabled:opacity-50 disabled:cursor-wait">SIMPAN
                        KOORDINAT</button>
                </div>

                <button id="restartButton" type="button"
                    class="font-mono tracking-widest mt-7 border-0 border-b border-black/15 bg-transparent pb-2.5 text-[10px] text-black/55 cursor-pointer">PETAKAN
                    PERASAAN LAIN</button>
            </div>
        </aside>

        <footer
            class="flex flex-col sm:flex-row justify-between gap-1 px-6 py-6 sm:px-8 sm:py-7 border-t border-black/10 bg-white/90 font-mono tracking-widest text-[9px] text-black/55">
            <span>MAP OF FEELINGS &middot; SETIAP PERASAAN PUNYA KOORDINAT</span>
            <span>&copy; WAHSUDAH MONDAY 2026</span>
        </footer>
    </div>

    <script>
        // Data lagu lengkap.
        window.MAP_OF_FEELINGS = [{
                id: "sedih",
                feeling: "Sedih",
                nuance: "Memilih pergi demi diri sendiri",
                song: "Aku Harus Pergi",
                question: "Apa yang paling berat saat kamu memilih pergi demi dirimu sendiri?",
                choices: [
                    "Meninggalkan seseorang yang masih disayangi",
                    "Menerima bahwa hubungan telah selesai",
                    "Berhenti mengharapkan perubahan",
                    "Meyakini bahwa pergi adalah keputusan yang tepat"
                ],
                coordinate: "Titik Patah yang Sunyi",
                barGradient: "linear-gradient(180deg,#DCEBFF 0%,#6FA6F5 50%,#0954E3 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#DCEBFF 0%,#6FA6F5 48%,#0954E3 100%)",
                artwork: "{{ asset('assets/artwork/aku-harus-pergi.svg') }}",
                why: "Aku Harus Pergi berbicara tentang keberanian memilih pergi, bukan karena rasa sudah hilang, tetapi karena diri sendiri juga perlu diselamatkan.",
                affirmation: "Pergi tidak selalu berarti menyerah. Kadang itu adalah cara pertama untuk kembali memilih dirimu sendiri.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "serba-salah",
                feeling: "Serba Salah",
                nuance: "Tidak memahami keinginan pasangan",
                song: "Tak Peka",
                question: "Apa yang paling sering membuatmu merasa serba salah dalam hubungan?",
                choices: [
                    "Takut tidak memahami keinginan pasangan",
                    "Merasa apa pun yang dilakukan tetap salah",
                    "Lelah menebak tanpa mendapat penjelasan",
                    "Bingung antara salah paham atau tidak lagi sejalan"
                ],
                coordinate: "Sinyal yang Tak Terbaca",
                barGradient: "linear-gradient(180deg,#3EAD9C 0%,#8DB36E 50%,#FCA547 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#3EAD9C 0%,#8DB36E 48%,#FCA547 100%)",
                artwork: "{{ asset('assets/artwork/tak-peka.svg') }}",
                why: "Tak Peka mewakili rasa lelah ketika niat baik terus meleset dan kamu merasa selalu salah karena tidak memahami sesuatu yang tak pernah benar-benar dijelaskan.",
                affirmation: "Kamu tidak harus terus menerjemahkan sesuatu yang tidak pernah disampaikan dengan jujur.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "curiga",
                feeling: "Curiga",
                nuance: "Menguji kesetiaan",
                song: "Tak Mendua",
                question: "Ketika memilih tetap setia, apa yang paling ingin kamu jaga?",
                choices: [
                    "Kepercayaan dalam hubungan",
                    "Komitmen yang telah disepakati",
                    "Perasaan yang hanya ditujukan kepada satu orang",
                    "Keyakinan bahwa cinta tidak perlu terbagi"
                ],
                coordinate: "Titik Uji Kepercayaan",
                barGradient: "linear-gradient(180deg,#F8DDD0 0%,#F2A17A 50%,#BCC59A 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#F8DDD0 0%,#F2A17A 48%,#BCC59A 100%)",
                artwork: "{{ asset('assets/artwork/tak-mendua.svg') }}",
                why: "Tak Mendua adalah penegasan bahwa kesetiaan bukan sekadar ucapan, tetapi keputusan untuk menjaga kepercayaan dan tetap memilih satu orang.",
                affirmation: "Kesetiaan tidak seharusnya terasa seperti pembelaan tanpa akhir. Hati juga perlu dipercaya.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "lelah",
                feeling: "Lelah",
                nuance: "Terjebak dalam hubungan yang tidak sehat",
                song: "Hilang Warasnya",
                question: "Apa yang paling sulit saat terjebak dalam hubungan yang tidak sehat?",
                choices: [
                    "Melepaskan seseorang yang terus menyakiti",
                    "Menyadari bahwa hubungan ini tidak lagi sehat",
                    "Kehilangan diri sendiri secara perlahan",
                    "Tidak mengetahui kapan keadaan mulai berubah"
                ],
                coordinate: "Garis Retak",
                barGradient: "linear-gradient(180deg,#7D351F 0%,#A6503C 50%,#C48773 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#7D351F 0%,#A6503C 48%,#C48773 100%)",
                artwork: "{{ asset('assets/artwork/hilang-warasnya.svg') }}",
                why: "Hilang Warasnya menggambarkan kelelahan ketika hubungan perlahan mengikis ketenangan, kepercayaan, dan rasa mengenali diri sendiri.",
                affirmation: "Kamu tidak harus kehilangan dirimu sendiri untuk mempertahankan sebuah hubungan.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "kesepian",
                feeling: "Kesepian",
                nuance: "Pencapaian yang terasa kosong",
                song: "Sumpah Percuma",
                question: "Kapan terakhir kali kamu memiliki banyak hal, tetapi tetap merasa kosong?",
                choices: [
                    "Saat seluruh pencapaian terasa biasa saja",
                    "Saat dikelilingi banyak hal tetapi tetap kesepian",
                    "Saat berhasil memperoleh hal yang dahulu diinginkan",
                    "Saat menyadari bahwa kebahagiaan tidak selalu menyertai pencapaian"
                ],
                coordinate: "Ruang Trofi yang Kosong",
                barGradient: "linear-gradient(180deg,#7695FB 0%,#A29BFC 50%,#C69FF8 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#7695FB 0%,#A29BFC 48%,#C69FF8 100%)",
                artwork: "{{ asset('assets/artwork/sumpah-percuma.svg') }}",
                why: "Sumpah Percuma hadir untuk momen ketika pencapaian terlihat penuh dari luar, tetapi tidak menjawab ruang kosong di dalam diri.",
                affirmation: "Tidak semua yang dirayakan orang lain mampu mengisi bagian dalam dirimu.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "berduka",
                feeling: "Berduka",
                nuance: "Merindukan seseorang yang telah tiada",
                song: "Pesan Rindu",
                question: "Apabila dapat mengulang satu momen, apa yang paling ingin kamu lakukan?",
                choices: [
                    "Mengucapkan selamat tinggal dengan lebih baik",
                    "Mendengar suaranya sekali lagi",
                    "Memeluknya lebih lama",
                    "Mengatakan bahwa kerinduan itu masih ada"
                ],
                coordinate: "Pesan yang Tetap Tinggal",
                barGradient: "linear-gradient(180deg,#FFF0C9 0%,#FDD374 50%,#F7B94D 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#FFF0C9 0%,#FDD374 48%,#F7B94D 100%)",
                artwork: "{{ asset('assets/artwork/pesan-rindu.svg') }}",
                why: "Pesan Rindu menjadi ruang untuk rindu yang tidak lagi dapat disampaikan langsung, tetapi tetap hidup dalam ingatan.",
                affirmation: "Sebagian pesan tidak membutuhkan balasan. Ia tinggal karena rasa sayang masih mengingat jalan pulang.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "nyaman",
                feeling: "Nyaman",
                nuance: "Hubungan intim yang cukup diketahui berdua",
                song: "Yang Tau-Tau Aja",
                question: "Apa yang paling berharga dari hubungan yang cukup diketahui oleh kalian berdua?",
                choices: [
                    "Percakapan yang hanya dipahami berdua",
                    "Tatapan sederhana yang memiliki banyak arti",
                    "Momen pribadi yang terasa dekat dan intim",
                    "Kenyamanan tanpa perlu diketahui semua orang"
                ],
                coordinate: "Sudut yang Tersembunyi",
                barGradient: "linear-gradient(180deg,#9EC9AE 0%,#33CADB 50%,#FC8D80 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#9EC9AE 0%,#33CADB 48%,#FC8D80 100%)",
                artwork: "{{ asset('assets/artwork/yang-tau-tau-aja.svg') }}",
                why: "Yang Tau-Tau Aja merayakan hubungan yang intim, hangat, dan tidak membutuhkan pengumuman untuk terasa nyata.",
                affirmation: "Tidak semua perasaan harus diumumkan. Beberapa justru tumbuh paling jujur dalam ruang yang hanya dipahami berdua.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "terharu",
                feeling: "Terharu",
                nuance: "Belajar menerima perpisahan",
                song: "Sedih Harus Kau Buang",
                question: "Dalam proses melepaskan, apa yang paling ingin kamu pelajari?",
                choices: [
                    "Mengikhlaskan bahwa tidak semua hal dapat dipertahankan",
                    "Berdamai dengan kenangan yang tersisa",
                    "Menerima perpisahan sebagai bagian dari kehidupan",
                    "Tetap melangkah meskipun belum sepenuhnya pulih"
                ],
                coordinate: "Hari Terakhir di Suatu Tempat",
                barGradient: "linear-gradient(180deg,#A6E67A 0%,#7CE46A 50%,#62B158 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#A6E67A 0%,#7CE46A 48%,#62B158 100%)",
                artwork: "{{ asset('assets/artwork/sedih-harus-kau-buang.svg') }}",
                why: "Sedih Harus Kau Buang menemani proses melepaskan: bukan menghapus kenangan, melainkan belajar berjalan bersama apa yang pernah ada.",
                affirmation: "Sebagian kesedihan perlu dipeluk, diberi terima kasih, lalu perlahan dilepaskan.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "penuh-harap",
                feeling: "Penuh Harap",
                nuance: "Percaya bahwa cinta akan menemukan jalan",
                song: "Fatamorgana",
                question: "Apa yang masih membuatmu percaya bahwa cinta yang nyata akan datang?",
                choices: [
                    "Harapan yang terus dijaga",
                    "Seseorang yang masih didoakan",
                    "Keyakinan bahwa waktu yang tepat akan tiba",
                    "Kepercayaan bahwa ketulusan akan menemukan jalannya"
                ],
                coordinate: "Cahaya di Kejauhan",
                barGradient: "linear-gradient(180deg,#DE842D 0%,#EDAB49 50%,#A89C42 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#DE842D 0%,#EDAB49 48%,#A89C42 100%)",
                artwork: "{{ asset('assets/artwork/fatamorgana.svg') }}",
                why: "Fatamorgana adalah tentang harapan, doa, dan perjalanan mencari tempat pulang yang terasa nyata.",
                affirmation: "Harapan tidak selalu bersuara keras. Kadang ia hanya membuatmu tetap memandang ke arah cahaya.",
                spotify: "#",
                youtube: "#"
            },
            {
                id: "hampa",
                feeling: "Hampa",
                nuance: "Sepi di tengah keramaian",
                song: "Sorak Sepi",
                question: "Kapan kamu paling merasa sepi di tengah keramaian?",
                choices: [
                    "Saat banyak orang hadir tetapi tidak ada yang benar-benar memahami",
                    "Saat suasana ramai tetapi pikiran tetap kosong",
                    "Saat tertawa bersama tetapi hati terasa jauh",
                    "Saat kembali sendiri setelah keramaian berakhir"
                ],
                coordinate: "Panggung yang Sunyi",
                barGradient: "linear-gradient(180deg,#4CB69C 0%,#3DAA8C 50%,#2F776B 100%)",
                pageGradient: "radial-gradient(circle at 18% 22%,#4CB69C 0%,#3DAA8C 48%,#2F776B 100%)",
                artwork: "{{ asset('assets/artwork/sorak-sepi.svg') }}",
                why: "Sorak Sepi menggambarkan ruang kosong yang tetap terasa meski suara, tawa, dan banyak orang berada di sekelilingmu.",
                affirmation: "Ruangan paling ramai pun dapat menyisakan sunyi. Perasaanmu tetap nyata, bahkan ketika tidak terlihat.",
                spotify: "#",
                youtube: "#"
            }
        ];

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
            const liveCoordinate = document.getElementById('liveCoordinate');
            const atlasStatus = document.getElementById('atlasStatus');
            const mapShell = document.getElementById('mapShell');
            const questionFeeling = document.getElementById('questionFeeling');
            const questionTitle = document.getElementById('questionTitle');
            const questionChoices = document.getElementById('questionChoices');

            let selectedMood = null;
            let selectedAnswer = '';
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

            const weather = [
                'Waktu biru', 'Hujan statis', 'Senja elektrik', 'Hangat yang memudar', 'Kabut sunyi',
                'Cahaya sore', 'Angin rahasia', 'Cahaya hari terakhir', 'Matahari dari kejauhan', 'Sorak yang sunyi'
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
                        atlasStatus.textContent =
                            `AREA ${String(index + 1).padStart(2, '0')} \u00b7 ${mood.feeling.toUpperCase()}`;
                        setMoodTheme(mood);
                        applyMoodHover(mood);
                    };

                    button.addEventListener('mouseenter', handleHover);
                    button.addEventListener('focus', handleHover);
                    button.addEventListener('click', () => openQuestion(mood, index));

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
                document.getElementById('resultSong').textContent = mood.song;
                document.getElementById('resultMood').textContent = `${mood.feeling} \u2014 ${mood.nuance}`;
                document.getElementById('panelState').textContent = mood.nuance;
                document.getElementById('panelWeather').textContent = weather[mood.index];
                document.getElementById('resultWhy').textContent = selectedAnswer ?
                    `${mood.why} Jawabanmu: \u201c${selectedAnswer}\u201d.` : mood.why;
                document.getElementById('resultAffirmation').textContent = mood.affirmation;

                const artwork = document.getElementById('resultArtwork');
                artwork.src = mood.artwork;
                artwork.alt = `${mood.song} artwork`;

                document.getElementById('spotifyLink').href = mood.spotify || '#';
                document.getElementById('youtubeLink').href = mood.youtube || '#';
                liveCoordinate.textContent = coords[mood.index];
            }

            function openPanel() {
                panel.classList.add('open');
                panel.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function closePanel() {
                panel.classList.remove('open');
                panel.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
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
                atlasStatus.textContent = 'AREA 01 \u00b7 SIAGA';
                setScreen('landing');
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

            async function saveCoordinateCard() {
                if (!selectedMood) return;

                const nameInput = document.getElementById('visitorName');
                const instagramInput = document.getElementById('visitorInstagram');
                const errorText = document.getElementById('coordinateFormError');
                const saveButton = document.getElementById('saveCoordinate');
                const visitorName = nameInput.value.trim();
                const visitorInstagram = normalizeInstagram(instagramInput.value);

                if (!visitorName || !visitorInstagram) {
                    errorText.textContent = 'Isi Nama dan Nama Instagram terlebih dahulu.';
                    (!visitorName ? nameInput : instagramInput).focus();
                    return;
                }

                errorText.textContent = '';
                saveButton.disabled = true;
                saveButton.textContent = 'MENYIAPKAN PNG...';

                try {
                    const canvas = document.createElement('canvas');
                    canvas.width = 1080;
                    canvas.height = 1350;
                    const ctx = canvas.getContext('2d');

                    const colors = getHexMatches(selectedMood.pageGradient);
                    const bg = ctx.createLinearGradient(0, 0, 1080, 1350);
                    bg.addColorStop(0, colors[0] || '#ffffff');
                    bg.addColorStop(.55, colors[1] || getMoodPrimaryHex(selectedMood));
                    bg.addColorStop(1, colors[colors.length - 1] || getMoodSecondaryHex(selectedMood));
                    ctx.fillStyle = bg;
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    ctx.fillStyle = 'rgba(255,255,255,.92)';
                    roundedRect(ctx, 70, 70, 940, 1210, 50);
                    ctx.fill();

                    ctx.textAlign = 'center';
                    ctx.fillStyle = '#0c0d0f';
                    ctx.font = '24px monospace';
                    ctx.fillText('MAP OF FEELINGS', 540, 125);

                    try {
                        const artwork = await loadImage(selectedMood.artwork);
                        ctx.save();
                        roundedRect(ctx, 180, 170, 720, 720, 24);
                        ctx.clip();
                        ctx.drawImage(artwork, 180, 170, 720, 720);
                        ctx.restore();
                    } catch (error) {
                        ctx.strokeStyle = `rgba(${hexToRgb(getMoodPrimaryHex(selectedMood))}, .75)`;
                        ctx.lineWidth = 4;
                        ctx.beginPath();
                        ctx.arc(540, 530, 84, 0, Math.PI * 2);
                        ctx.stroke();
                        ctx.fillStyle = '#0c0d0f';
                        ctx.font = '600 42px Arial';
                        ctx.fillText(selectedMood.feeling, 540, 555);
                    }

                    ctx.font = '20px monospace';
                    ctx.fillText(selectedMood.coordinate.toUpperCase(), 540, 940);
                    ctx.font = '700 60px Arial';
                    wrapText(ctx, selectedMood.song, 540, 1020, 780, 66);
                    ctx.font = '25px Arial';
                    ctx.fillText(`${selectedMood.feeling} \u00b7 ${selectedMood.nuance}`, 540, 1122);
                    if (selectedAnswer) {
                        ctx.fillStyle = '#55585e';
                        ctx.font = '17px Arial';
                        wrapText(ctx, `\u201c${selectedAnswer}\u201d`, 540, 1152, 760, 22);
                    }

                    ctx.fillStyle = '#6d6d73';
                    ctx.font = '20px Arial';
                    ctx.fillText(visitorName, 540, 1194);
                    ctx.font = '18px monospace';
                    ctx.fillText(visitorInstagram, 540, 1224);

                    ctx.fillStyle = '#0c0d0f';
                    ctx.font = '18px monospace';
                    ctx.fillText('SETIAP PERASAAN PUNYA KOORDINAT.', 540, 1262);

                    const blob = await canvasToBlob(canvas);
                    const objectUrl = URL.createObjectURL(blob);
                    const safeName = visitorName.toLowerCase().replace(/[^a-z0-9]+/gi, '-').replace(/^-|-$/g, '') ||
                        'coordinate';
                    const link = document.createElement('a');
                    link.download = `map-of-feelings-${safeName}-${selectedMood.id}.png`;
                    link.href = objectUrl;
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    setTimeout(() => URL.revokeObjectURL(objectUrl), 1500);
                    showDownloadFeedback('KOORDINAT BERHASIL DISIMPAN');
                } catch (error) {
                    console.error(error);
                    errorText.textContent =
                    'Gagal menyimpan PNG. Coba buka melalui Chrome atau Safari lalu ulangi.';
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
                atlasStatus.textContent = 'AREA 01 \u00b7 SIAGA';
                liveCoordinate.textContent = 'LINTANG 00.0000 / BUJUR 00.0000';
                clearMoodHover();
            });

            document.getElementById('enterMap').addEventListener('click', () => setScreen('atlas'));
            document.getElementById('questionBack').addEventListener('click', () => setScreen('atlas'));
            document.getElementById('brandHome').addEventListener('click', reset);
            document.getElementById('coordinateButton').addEventListener('click', openPanel);
            document.getElementById('panelClose').addEventListener('click', closePanel);
            document.getElementById('restartButton').addEventListener('click', reset);
            document.getElementById('saveCoordinate').addEventListener('click', saveCoordinateCard);

            renderAtlas();
            setMoodTheme(MOODS[0]);
            clearMoodHover();
            startOrbitCycle();
            setScreen('landing');
        })();
    </script>
@endsection
