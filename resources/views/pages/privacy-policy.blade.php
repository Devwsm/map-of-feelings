{{--
    Path: resources/views/pages/privacy-policy.blade.php
    Konten diambil apa adanya dari draft final tim ("NEW - ENGLISH" & "NEW - INDONESIA"),
    bukan versi draft lama. Ditaruh di array PHP biar gampang di-maintain/diedit
    ketimbang ngulang markup HTML 2x buat tiap bahasa.
--}}
@extends('template.layout')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@php
    $policy = [
        'en' => [
            'label' => 'PRIVACY POLICY',
            'title' => 'Privacy Policy',
            'subtitle' => 'Map of Feelings — English Version',
            'meta' => [
                'Effective date' => '14 August 2026',
                'Website' => 'https://mapoffeelings.com',
                'Data controller' => 'PT Whisnu Santika Musik (WSM)',
            ],
            'intro' => [
                'PT Whisnu Santika Musik ("WSM", "we", "us", or "our") operates the Map of Feelings website as a digital activation for the Map of Feelings album. This Privacy Policy explains how we obtain, use, retain, share, and protect personal data when you access the website or use its available features.',
                'This Policy is designed to accommodate the website\'s evolving features. A section using the words "if", "when", or "where available" applies only when you choose to use the relevant feature and that feature has been made available.',
            ],
            'sections' => [
                [
                    'heading' => '1. Personal Data We Process',
                    'blocks' => [
                        ['type' => 'subheading', 'text' => '1.1 Data you provide'],
                        [
                            'type' => 'list',
                            'items' => [
                                'Your name and Instagram username when you save an emotional coordinate.',
                                'The feelings, answers, selections, or interaction results you create through the Map of Feelings experience.',
                                'The contents of communications you send when contacting WSM about the website or your personal data.',
                            ],
                        ],
                        ['type' => 'subheading', 'text' => '1.2 Technical data'],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'When you access the website, our hosting or security systems may record limited technical data, such as your IP address, device and browser type, access time, pages used, referral source, and error or security logs. We use this data to operate, secure, and improve the website.',
                        ],
                        ['type' => 'subheading', 'text' => '1.3 Data from future or optional features'],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'If the following features become available and you choose to use them, we may process additional relevant data:',
                        ],
                        [
                            'type' => 'list',
                            'items' => [
                                'Pre-save or pre-order: connection status, selected music platform, and limited profile data that you authorize the platform or integration provider to disclose.',
                                'Newsletter or campaign updates: your name, email address, phone number, and communication preferences.',
                                'Contests or giveaways: registration information, age or date of birth, city of residence, social media account, entry answers, and evidence reasonably required to verify eligibility.',
                                'Prize winners: delivery address and other information genuinely required for verification, prize fulfilment, or tax compliance. We will request identity or payment details only where necessary and explain the requirement at the point of collection.',
                                'User-generated content (UGC): photos, videos, text, captions, hashtags, social media usernames, and other information contained in submitted content.',
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Before introducing a new feature that materially changes how personal data is processed, we will update this notice and obtain appropriate consent where required.',
                        ],
                    ],
                ],
                [
                    'heading' => '2. Purposes and Lawful Grounds',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'We process personal data only for relevant, limited, and disclosed purposes, including to:',
                        ],
                        [
                            'type' => 'list',
                            'items' => [
                                'Provide the Map of Feelings experience and generate or save your emotional coordinate.',
                                'Operate features you select, including pre-save, update registration, contests, giveaways, or UGC submission where available.',
                                'Contact participants or winners, deliver prizes, and respond to user questions or requests.',
                                'Measure campaign and website performance and improve the user experience.',
                                'Protect the website and prevent misuse, duplicate entries, or fraud.',
                                'Comply with legal, tax, accounting, or valid government requirements.',
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Our grounds for processing may include your consent, providing a service you request, compliance with a legal obligation, or another lawful ground recognized by applicable law. Consent for direct marketing will be requested separately and may be withdrawn.',
                        ],
                    ],
                ],
                [
                    'heading' => '3. Sharing and Service Providers',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' => 'We may provide access to or share data, only as necessary, with:',
                        ],
                        [
                            'type' => 'list',
                            'items' => [
                                'Hosting, web development, security, storage, email, analytics, and technical support providers;',
                                'Music platforms or pre-save/pre-order integration providers you select;',
                                'WSM staff, the artist, management, labels, or campaign partners who require access to operate the activation;',
                                'Logistics providers, event organizers, or prize vendors where necessary; and',
                                'Professional advisers and government or law-enforcement authorities where required or permitted by law.',
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'We do not sell your personal data. Service providers may process data only for defined purposes and subject to appropriate safeguards.',
                        ],
                    ],
                ],
                [
                    'heading' => '4. User-Generated Content',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'If a UGC submission feature becomes available, personal data contained in the content will be processed to receive, review, moderate, display, and—where you grant the necessary permission—promote that content. Ownership, content licences, eligibility, prizes, and judging rules will be governed by separate Campaign Terms and Conditions.',
                        ],
                    ],
                ],
                [
                    'heading' => '5. Cookies and Similar Technologies',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'The website may use essential cookies or local storage required for functionality, security, and user preferences. If we use non-essential analytics or marketing cookies, we will provide an appropriate choice before activating them where required. You may also control cookies through your browser, although disabling certain cookies may affect website functionality.',
                        ],
                    ],
                ],
                [
                    'heading' => '6. Transfers Outside Indonesia',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Some technology providers, music platforms, or campaign services may process data outside Indonesia. Where a cross-border transfer occurs, we will take the steps required by law to ensure an adequate level of data protection or another lawful safeguard.',
                        ],
                    ],
                ],
                [
                    'heading' => '7. Data Retention',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'We retain personal data only for as long as necessary for the purpose for which it was collected:',
                        ],
                        [
                            'type' => 'list',
                            'items' => [
                                'Emotional-coordinate data, names, and Instagram accounts: for the campaign period and up to 12 months after the campaign ends, unless deleted earlier following a valid request or retained longer to resolve a dispute.',
                                'Newsletter or update data: until you unsubscribe or withdraw consent.',
                                'Contest or giveaway participant data: for the program period and up to 12 months after it ends.',
                                'Winner data: for prize fulfilment and for any retention period required by tax or accounting laws.',
                                'UGC: for as long as needed for campaign purposes or as stated in the applicable Terms and Conditions; removal requests will be addressed in accordance with law and the context of any prior publication.',
                                'Technical and security logs: in line with operational, security, and system-provider retention requirements.',
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'When the applicable retention period ends, data will be deleted, destroyed, or anonymized as appropriate and subject to legal requirements.',
                        ],
                    ],
                ],
                [
                    'heading' => '8. Data Security',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'We apply reasonable technical and organizational safeguards, including encrypted connections, need-to-know access controls, vendor management, and security monitoring. However, no electronic system is completely risk-free.',
                        ],
                    ],
                ],
                [
                    'heading' => '9. Your Rights',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Subject to applicable law, you may request access, a copy, correction, updating, deletion or destruction of your data; withdraw consent; terminate or restrict certain processing; object to processing; request data portability where applicable; and submit a complaint. We may request reasonable information to verify your identity and request.',
                        ],
                    ],
                ],
                [
                    'heading' => '10. Children\'s Data',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'The website and campaign are not intended to collect children\'s data without the required grounds and consent. If an activation is open to children, we will apply age requirements and obtain parental or guardian consent as required by law. A parent or guardian who believes that a child\'s data was provided improperly may contact us to request appropriate action.',
                        ],
                    ],
                ],
                [
                    'heading' => '11. Third-Party Links and Platforms',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'The website may link to music platforms, social media, or other third-party services. Their processing is governed by their own privacy policies. We encourage you to review the relevant policy before providing data or connecting an account.',
                        ],
                    ],
                ],
                [
                    'heading' => '12. Contact Us',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' => 'For questions, rights requests, or complaints about personal data, contact:',
                        ],
                        [
                            'type' => 'contact',
                            'lines' => [
                                'PT Whisnu Santika Musik (WSM)',
                                'Email: office@whisnusantika.com',
                                'Suggested subject: "Privacy — Map of Feelings"',
                            ],
                        ],
                    ],
                ],
                [
                    'heading' => '13. Changes to This Policy',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'We may update this Privacy Policy when features, vendors, processing purposes, or legal requirements change. We will communicate material changes through the website or another reasonable channel. Where a change requires new consent, we will obtain it before the relevant processing begins. The effective date at the beginning identifies the latest version.',
                        ],
                    ],
                ],
            ],
        ],

        'id' => [
            'label' => 'KEBIJAKAN PRIVASI',
            'title' => 'Kebijakan Privasi',
            'subtitle' => 'Map of Feelings — Versi Bahasa Indonesia',
            'meta' => [
                'Tanggal berlaku' => '14 Agustus 2026',
                'Website' => 'https://mapoffeelings.com',
                'Pengendali data' => 'PT Whisnu Santika Musik (WSM)',
            ],
            'intro' => [
                'PT Whisnu Santika Musik ("WSM", "kami") mengoperasikan website Map of Feelings sebagai aktivasi digital untuk album Map of Feelings. Kebijakan Privasi ini menjelaskan bagaimana kami memperoleh, menggunakan, menyimpan, membagikan, dan melindungi data pribadi ketika Anda mengakses website atau menggunakan fitur yang tersedia.',
                'Kebijakan ini disusun agar dapat mengikuti perkembangan fitur website. Bagian yang menggunakan frasa "apabila", "jika", atau "ketika" hanya berlaku saat Anda memilih menggunakan fitur terkait dan fitur tersebut telah tersedia.',
            ],
            'sections' => [
                [
                    'heading' => '1. Data yang Kami Proses',
                    'blocks' => [
                        ['type' => 'subheading', 'text' => '1.1 Data yang Anda berikan'],
                        [
                            'type' => 'list',
                            'items' => [
                                'Nama dan nama pengguna Instagram yang Anda masukkan saat menyimpan koordinat perasaan.',
                                'Pilihan perasaan, jawaban, atau hasil interaksi yang Anda buat melalui pengalaman Map of Feelings.',
                                'Isi komunikasi yang Anda kirimkan apabila Anda menghubungi WSM mengenai website atau penggunaan data pribadi.',
                            ],
                        ],
                        ['type' => 'subheading', 'text' => '1.2 Data teknis'],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Saat Anda mengakses website, sistem hosting atau keamanan kami dapat mencatat data teknis terbatas, seperti alamat IP, jenis perangkat dan browser, waktu akses, halaman yang digunakan, sumber rujukan, serta log kesalahan atau keamanan. Data tersebut digunakan untuk menjalankan, mengamankan, dan memperbaiki website.',
                        ],
                        ['type' => 'subheading', 'text' => '1.3 Data dari fitur mendatang atau opsional'],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Apabila fitur berikut tersedia dan Anda memilih menggunakannya, kami dapat memproses data tambahan yang relevan:',
                        ],
                        [
                            'type' => 'list',
                            'items' => [
                                'Pre-save atau pre-order: status keberhasilan koneksi, platform musik yang dipilih, dan data profil terbatas yang Anda izinkan kepada platform atau penyedia integrasi.',
                                'Newsletter atau pembaruan kampanye: nama, alamat email, nomor telepon, serta preferensi komunikasi yang Anda berikan.',
                                'Kontes atau giveaway: data pendaftaran, usia atau tanggal lahir, kota domisili, akun media sosial, jawaban peserta, serta bukti kelayakan yang diperlukan.',
                                'Pemenang hadiah: alamat pengiriman dan data lain yang benar-benar diperlukan untuk verifikasi, pengiriman hadiah, atau pemenuhan kewajiban pajak. Kami hanya akan meminta data identitas atau pembayaran apabila diperlukan dan akan menjelaskan kebutuhannya pada saat pengumpulan.',
                                'Konten buatan pengguna (UGC): foto, video, teks, caption, tagar, nama pengguna media sosial, serta informasi lain yang terdapat dalam konten yang Anda kirimkan.',
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Sebelum fitur baru yang mengubah pemrosesan data secara material digunakan, kami akan memperbarui pemberitahuan ini dan, apabila diwajibkan, meminta persetujuan yang sesuai.',
                        ],
                    ],
                ],
                [
                    'heading' => '2. Tujuan dan Dasar Pemrosesan',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Kami memproses data pribadi hanya untuk tujuan yang relevan, terbatas, dan telah diberitahukan, antara lain:',
                        ],
                        [
                            'type' => 'list',
                            'items' => [
                                'Menyediakan pengalaman Map of Feelings dan menghasilkan atau menyimpan koordinat perasaan Anda.',
                                'Menjalankan fitur yang Anda pilih, termasuk pre-save, pendaftaran pembaruan, kontes, giveaway, atau pengiriman UGC apabila tersedia.',
                                'Menghubungi peserta atau pemenang, mengirim hadiah, dan menangani pertanyaan atau permintaan pengguna.',
                                'Mengukur penggunaan dan performa kampanye serta memperbaiki pengalaman website.',
                                'Menjaga keamanan website, mencegah penyalahgunaan, pendaftaran ganda, atau kecurangan.',
                                'Memenuhi kewajiban hukum, perpajakan, akuntansi, atau permintaan otoritas yang sah.',
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Dasar pemrosesan dapat berupa persetujuan Anda, pelaksanaan layanan yang Anda minta, pemenuhan kewajiban hukum, atau dasar pemrosesan lain yang diperbolehkan oleh peraturan perundang-undangan. Persetujuan untuk komunikasi pemasaran akan diminta secara terpisah dan dapat ditarik kembali.',
                        ],
                    ],
                ],
                [
                    'heading' => '3. Pembagian Data dan Penyedia Layanan',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Kami dapat memberikan akses atau membagikan data sebatas yang diperlukan kepada:',
                        ],
                        [
                            'type' => 'list',
                            'items' => [
                                'Penyedia hosting, pengembangan website, keamanan, penyimpanan, email, analitik, atau dukungan teknologi;',
                                'Platform musik atau penyedia integrasi pre-save/pre-order yang Anda pilih;',
                                'Tim WSM, artis, manajemen, label, atau mitra kampanye yang memerlukan akses untuk menjalankan aktivasi;',
                                'Penyedia logistik, penyelenggara acara, atau vendor hadiah apabila diperlukan;',
                                'Penasihat profesional dan otoritas pemerintah atau penegak hukum jika diwajibkan atau diperbolehkan oleh hukum.',
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Kami tidak menjual data pribadi Anda. Setiap penyedia layanan hanya boleh memproses data untuk tujuan yang telah ditentukan dan dengan perlindungan yang sesuai.',
                        ],
                    ],
                ],
                [
                    'heading' => '4. Konten Buatan Pengguna',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Jika fitur pengiriman UGC tersedia, data pribadi yang terdapat di dalam konten akan diproses untuk menerima, meninjau, memoderasi, menampilkan, dan—apabila Anda memberikan izin yang diperlukan—mempromosikan konten tersebut. Ketentuan mengenai kepemilikan, lisensi penggunaan konten, kelayakan peserta, hadiah, dan mekanisme penilaian akan diatur dalam Syarat dan Ketentuan kampanye yang terpisah.',
                        ],
                    ],
                ],
                [
                    'heading' => '5. Cookie dan Teknologi Serupa',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Website dapat menggunakan cookie esensial atau penyimpanan lokal yang diperlukan untuk fungsi, keamanan, dan preferensi pengguna. Apabila kami menggunakan cookie analitik atau pemasaran yang tidak esensial, kami akan menampilkan pilihan yang sesuai sebelum mengaktifkannya apabila diwajibkan. Anda juga dapat mengatur cookie melalui browser, tetapi penonaktifan cookie tertentu dapat memengaruhi fungsi website.',
                        ],
                    ],
                ],
                [
                    'heading' => '6. Transfer Data ke Luar Indonesia',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Sebagian penyedia teknologi, platform musik, atau layanan kampanye dapat memproses data di luar Indonesia. Jika terjadi transfer lintas negara, kami akan menerapkan langkah yang diwajibkan oleh hukum untuk memastikan tingkat pelindungan data yang memadai atau perlindungan lain yang sah.',
                        ],
                    ],
                ],
                [
                    'heading' => '7. Penyimpanan Data',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' => 'Kami menyimpan data hanya selama diperlukan untuk tujuan pengumpulannya:',
                        ],
                        [
                            'type' => 'list',
                            'items' => [
                                'Data koordinat perasaan, nama, dan akun Instagram: selama kampanye berlangsung dan paling lama 12 bulan setelah kampanye berakhir, kecuali data dihapus lebih awal atas permintaan yang sah atau diperlukan lebih lama untuk penyelesaian sengketa.',
                                'Data newsletter atau pembaruan: sampai Anda berhenti berlangganan atau menarik persetujuan.',
                                'Data peserta kontes/giveaway: selama proses berlangsung dan paling lama 12 bulan setelah program berakhir.',
                                'Data pemenang: selama diperlukan untuk pengiriman hadiah dan sesuai masa penyimpanan yang diwajibkan oleh hukum pajak atau akuntansi.',
                                'UGC: selama diperlukan untuk tujuan kampanye atau sesuai jangka waktu yang dijelaskan dalam Syarat dan Ketentuan; permintaan penghapusan akan ditangani sesuai hukum dan konteks publikasi yang telah terjadi.',
                                'Log teknis dan keamanan: sesuai kebutuhan operasional, keamanan, dan jadwal retensi penyedia sistem.',
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Setelah masa penyimpanan berakhir, data akan dihapus, dimusnahkan, atau dianonimkan sesuai kebutuhan dan kewajiban hukum.',
                        ],
                    ],
                ],
                [
                    'heading' => '8. Keamanan Data',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Kami menerapkan langkah teknis dan organisasi yang wajar, termasuk koneksi terenkripsi, pembatasan akses berdasarkan kebutuhan, pengelolaan vendor, dan pemantauan keamanan. Namun, tidak ada sistem elektronik yang sepenuhnya bebas risiko.',
                        ],
                    ],
                ],
                [
                    'heading' => '9. Hak Anda',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Sesuai ketentuan yang berlaku, Anda dapat meminta akses, salinan, perbaikan, pembaruan, penghapusan atau pemusnahan data; menarik persetujuan; mengakhiri atau membatasi pemrosesan tertentu; mengajukan keberatan; meminta portabilitas data jika berlaku; serta mengajukan keluhan. Kami dapat meminta informasi yang wajar untuk memverifikasi identitas dan permintaan Anda.',
                        ],
                    ],
                ],
                [
                    'heading' => '10. Data Anak',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Website dan kampanye ini tidak ditujukan untuk mengumpulkan data anak tanpa dasar dan persetujuan yang diperlukan. Apabila suatu aktivasi dapat diikuti anak, kami akan menerapkan ketentuan usia dan mekanisme persetujuan orang tua atau wali sesuai hukum. Orang tua atau wali yang mengetahui bahwa data anak telah diberikan secara tidak semestinya dapat menghubungi kami untuk meminta penanganan.',
                        ],
                    ],
                ],
                [
                    'heading' => '11. Tautan dan Platform Pihak Ketiga',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Website dapat memuat tautan menuju platform musik, media sosial, atau layanan pihak ketiga. Pemrosesan data oleh pihak tersebut tunduk pada kebijakan privasi mereka sendiri. Kami menyarankan Anda membaca kebijakan yang berlaku sebelum memberikan data atau menghubungkan akun.',
                        ],
                    ],
                ],
                [
                    'heading' => '12. Hubungi Kami',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' => 'Untuk pertanyaan, permintaan hak, atau keluhan mengenai data pribadi, hubungi:',
                        ],
                        [
                            'type' => 'contact',
                            'lines' => [
                                'PT Whisnu Santika Musik (WSM)',
                                'Email: office@whisnusantika.com',
                                'Subjek yang disarankan: "Privasi — Map of Feelings"',
                            ],
                        ],
                    ],
                ],
                [
                    'heading' => '13. Perubahan Kebijakan',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'text' =>
                                'Kami dapat memperbarui Kebijakan Privasi ini ketika fitur, vendor, tujuan pemrosesan, atau ketentuan hukum berubah. Perubahan material akan diberitahukan melalui website atau sarana lain yang wajar. Jika perubahan memerlukan persetujuan baru, kami akan memintanya sebelum pemrosesan terkait dilakukan. Tanggal berlaku di bagian awal menunjukkan versi terbaru.',
                        ],
                    ],
                ],
            ],
        ],
    ];
@endphp

@section('content')
    <div class="w-full bg-white text-[#0c0d0f]" id="privacyRoot">

        {{-- Top bar: balik ke home + toggle bahasa --}}
        <header
            class="sticky top-0 z-20 flex items-center justify-between gap-4 border-b border-black/10 bg-white/90 px-5 py-4 backdrop-blur-md sm:px-8 sm:py-5">
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 font-mono text-xs tracking-widest text-black/60 transition hover:text-black">
                <i class="bi bi-arrow-left"></i>
                <span>MAP OF FEELINGS</span>
            </a>

            <div id="langToggle"
                class="flex items-center rounded-full border border-black/15 bg-white p-1 font-mono text-[11px] tracking-widest">
                <button type="button" data-lang="id"
                    class="lang-toggle-btn rounded-full px-3 py-1.5 transition">ID</button>
                <button type="button" data-lang="en"
                    class="lang-toggle-btn rounded-full px-3 py-1.5 transition">EN</button>
            </div>
        </header>

        <main class="mx-auto w-full max-w-3xl px-5 py-14 sm:px-8 sm:py-20">
            @foreach ($policy as $langCode => $lang)
                <article id="content-{{ $langCode }}" style="display: none;">
                    <p class="font-mono text-xs tracking-widest text-black/50">{{ $lang['label'] }}</p>
                    <h1 class="mt-3 font-bold text-3xl sm:text-4xl">{{ $lang['title'] }}</h1>
                    <p class="mt-2 text-black/60">{{ $lang['subtitle'] }}</p>

                    <dl class="mt-6 space-y-1 border-t border-black/10 pt-6 font-mono text-xs tracking-wide text-black/60">
                        @foreach ($lang['meta'] as $metaLabel => $metaValue)
                            <div class="flex flex-wrap gap-2">
                                <dt class="text-black/40">{{ $metaLabel }}:</dt>
                                <dd>{{ $metaValue }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <div class="mt-8 space-y-4 leading-relaxed text-black/75">
                        @foreach ($lang['intro'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>

                    @foreach ($lang['sections'] as $section)
                        <section class="mt-11">
                            <h2 class="font-bold text-lg sm:text-xl">{{ $section['heading'] }}</h2>

                            @foreach ($section['blocks'] as $block)
                                @if ($block['type'] === 'paragraph')
                                    <p class="mt-3 leading-relaxed text-black/75">{{ $block['text'] }}</p>
                                @elseif ($block['type'] === 'subheading')
                                    <h3 class="mt-5 font-bold text-sm tracking-wide text-black/85">{{ $block['text'] }}
                                    </h3>
                                @elseif ($block['type'] === 'list')
                                    <ul class="mt-3 list-disc space-y-2 pl-5 leading-relaxed text-black/75">
                                        @foreach ($block['items'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @elseif ($block['type'] === 'contact')
                                    <div
                                        class="mt-3 rounded-2xl border border-black/10 bg-black/5 px-5 py-4 leading-relaxed text-black/75">
                                        @foreach ($block['lines'] as $line)
                                            <p>{{ $line }}</p>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </section>
                    @endforeach
                </article>
            @endforeach
        </main>

        <footer
            class="border-t border-black/10 px-5 py-8 text-center font-mono text-[11px] tracking-widest text-black/40 sm:px-8">
            <span>MAP OF FEELINGS &middot; FROM WHISNU'S STORY TO EVERYONE'S STORY</span>
        </footer>
    </div>

    <style>
        .lang-toggle-btn.active {
            background: #0c0d0f;
            color: #fff;
        }
    </style>

    <script>
        (function() {
            const STORAGE_KEY = 'mofPrivacyLang';
            const buttons = document.querySelectorAll('.lang-toggle-btn');
            const contentEn = document.getElementById('content-en');
            const contentId = document.getElementById('content-id');

            function setLang(lang) {
                contentEn.style.display = lang === 'en' ? 'block' : 'none';
                contentId.style.display = lang === 'id' ? 'block' : 'none';
                buttons.forEach((btn) => btn.classList.toggle('active', btn.dataset.lang === lang));
                try {
                    localStorage.setItem(STORAGE_KEY, lang);
                } catch (error) {
                    // localStorage bisa diblokir (mode private/incognito) — gak fatal, cuma
                    // preferensi bahasa gak ke-remember lain kali.
                }
            }

            buttons.forEach((btn) => {
                btn.addEventListener('click', () => setLang(btn.dataset.lang));
            });

            let savedLang = 'id';
            try {
                savedLang = localStorage.getItem(STORAGE_KEY) || 'id';
            } catch (error) {
                // sama seperti di atas, abaikan aja kalau localStorage gak bisa diakses.
            }
            setLang(savedLang === 'en' ? 'en' : 'id');
        })();
    </script>
@endsection
