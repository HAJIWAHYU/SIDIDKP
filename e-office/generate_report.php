<?php

// Check if vendor/autoload.php exists
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "Autoload not found. Please run 'composer install' first.\n";
    exit(1);
}

require __DIR__ . '/vendor/autoload.php';

if (!class_exists(\PhpOffice\PhpWord\PhpWord::class)) {
    echo "PhpWord class not found. Installing phpoffice/phpword...\n";
    exit(1);
}

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;

$phpWord = new PhpWord();

// Define styles
$phpWord->setDefaultFontName('Times New Roman');
$phpWord->setDefaultFontSize(12);

// Define style for Cover Page & Text Formatting
$styleCoverTitle = ['name' => 'Times New Roman', 'size' => 14, 'bold' => true, 'color' => '000000'];
$styleCoverSub = ['name' => 'Times New Roman', 'size' => 11, 'italic' => true, 'color' => '000000'];
$styleCoverBold = ['name' => 'Times New Roman', 'size' => 12, 'bold' => true, 'color' => '000000'];
$styleBody = ['name' => 'Times New Roman', 'size' => 12, 'color' => '000000'];
$styleBodyBold = ['name' => 'Times New Roman', 'size' => 12, 'bold' => true, 'color' => '000000'];
$styleBodyItalic = ['name' => 'Times New Roman', 'size' => 12, 'italic' => true, 'color' => '000000'];
$styleSign = ['name' => 'Times New Roman', 'size' => 11, 'color' => '000000'];
$styleSignBold = ['name' => 'Times New Roman', 'size' => 11, 'bold' => true, 'color' => '000000'];

$pAlignStyleCenter = ['alignment' => Jc::CENTER, 'spaceAfter' => 120, 'lineSpacing' => 1.15];
$pAlignStyleJustify = ['alignment' => Jc::JUSTIFY, 'spaceAfter' => 120, 'lineSpacing' => 1.5];
$pAlignStyleRight = ['alignment' => Jc::RIGHT, 'spaceAfter' => 120, 'lineSpacing' => 1.15];
$pAlignStyleLeft = ['alignment' => Jc::LEFT, 'spaceAfter' => 60, 'lineSpacing' => 1.15];

$sectionStyle = [
    'marginTop' => Converter::cmToTwip(3),
    'marginBottom' => Converter::cmToTwip(3),
    'marginLeft' => Converter::cmToTwip(4),
    'marginRight' => Converter::cmToTwip(3),
];

// Add first section (for Cover Page)
$section = $phpWord->addSection($sectionStyle);

// --- COVER PAGE ---
$section->addText("LAPORAN KERJA PRAKTIK", $styleCoverTitle, $pAlignStyleCenter);
$section->addText("RANCANGAN SISTEM INFORMASI DISPOSISI INTERNAL (SIDI) BERBASIS WEBSITE\nPADA DINAS KELAUTAN DAN PERIKANAN PROVINSI SUMATERA SELATAN\nMENGGUNAKAN METODE TASK CENTERED SYSTEM DESIGN (TCSD)", $styleCoverTitle, $pAlignStyleCenter);

$section->addTextBreak(2);
$section->addText("Oleh:", $styleCoverBold, $pAlignStyleCenter);
$section->addText("ARYA ANUGRAH (2230803123)", $styleCoverBold, $pAlignStyleCenter);

$section->addTextBreak(3);
$section->addText("[ LOGO UNIVERSITAS UIN RADEN FATAH PALEMBANG ]\n(Silakan insert gambar logo di sini secara manual)", ['name' => 'Times New Roman', 'size' => 10, 'italic' => true], $pAlignStyleCenter);

$section->addTextBreak(3);
$section->addText("PROGRAM STUDI SISTEM INFORMASI\nFAKULTAS SAINS DAN TEKNOLOGI\nUNIVERSITAS ISLAM NEGERI RADEN FATAH\nPALEMBANG\n2026", $styleCoverBold, $pAlignStyleCenter);

// --- PAGE 2: LEMBAR PERSETUJUAN ---
$section->addPageBreak();
$section->addText("LEMBAR PERSETUJUAN", $styleCoverTitle, $pAlignStyleCenter);
$section->addTextBreak(1);

$textPersetujuan = "Laporan kerja praktik ini telah diperiksa dan disetujui sebagai hasil kegiatan kerja praktik untuk memenuhi persyaratan pada program studi Sistem Informasi\nFakultas Sains dan Teknologi Universitas Islam Negeri Raden Fatah Palembang\n\nPeriode : 1 Juli 2026 - 25 Agustus 2026";
$section->addText($textPersetujuan, $styleBody, $pAlignStyleCenter);
$section->addTextBreak(2);

// Signature table
$tableStyle = ['align' => 'center', 'cellMargin' => 80];
$table = $section->addTable($tableStyle);
$table->addRow();
$cell1 = $table->addCell(Converter::cmToTwip(7.5));
$cell1->addText("Pembimbing Lapangan", $styleSign, $pAlignStyleLeft);
$cell2 = $table->addCell(Converter::cmToTwip(7.5));
$cell2->addText("Palembang, 25 Agustus 2026\n\nPembimbing Kerja Praktik", $styleSign, $pAlignStyleLeft);

$table->addRow();
$table->addCell(Converter::cmToTwip(7.5))->addTextBreak(3);
$table->addCell(Converter::cmToTwip(7.5))->addTextBreak(3);

$table->addRow();
$c1 = $table->addCell(Converter::cmToTwip(7.5));
$c1->addText("Nama Pembimbing Lapangan, S.Kom.", $styleSign, $pAlignStyleLeft);
$c1->addText("NIP. 198008082008011002", $styleSign, $pAlignStyleLeft);

$c2 = $table->addCell(Converter::cmToTwip(7.5));
$c2->addText("Indah Hidayanti, S.T., M.Kom", $styleSign, $pAlignStyleLeft);
$c2->addText("NIP. 20211122250819921", $styleSign, $pAlignStyleLeft);

$section->addTextBreak(3);
$section->addText("PROGRAM STUDI SISTEM INFORMASI\nFAKULTAS SAINS DAN TEKNOLOGI\nUIN RADEN FATAH PALEMBANG\n2026", $styleCoverBold, $pAlignStyleCenter);

// --- PAGE 3: LEMBAR PENGESAHAN ---
$section->addPageBreak();
$section->addText("TANDA PENGESAHAN LAPORAN KERJA PRAKTIK", $styleCoverTitle, $pAlignStyleCenter);
$section->addTextBreak(1);

// Metadata table
$metaTable = $section->addTable($tableStyle);
$metaLabels = [
    ["1. Nama", ": Arya Anugrah"],
    ["2. NIM", ": 2230803123"],
    ["3. Program Studi", ": Sistem Informasi"],
    ["4. Judul Laporan", ": Rancangan Sistem Informasi Disposisi Internal (SIDI) Berbasis Website pada Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan Menggunakan Metode Task Centered System Design (TCSD)"]
];

foreach ($metaLabels as $rowMeta) {
    $metaTable->addRow();
    $cellLabel = $metaTable->addCell(Converter::cmToTwip(4));
    $cellLabel->addText($rowMeta[0], $styleSignBold, $pAlignStyleLeft);
    $cellVal = $metaTable->addCell(Converter::cmToTwip(11));
    $cellVal->addText($rowMeta[1], $styleSign, $pAlignStyleLeft);
}

$section->addTextBreak(1);
$section->addText("PANITIA PENGUJI HASIL KERJA PRAKTIK", $styleCoverBold, $pAlignStyleCenter);
$section->addTextBreak(1);

$pengujiTable = $section->addTable($tableStyle);
$pengujiTable->addRow();
$pengujiTable->addCell(Converter::cmToTwip(5))->addText("Tanggal", $styleSign, $pAlignStyleLeft);
$pengujiTable->addCell(Converter::cmToTwip(10))->addText(": 25 Agustus 2026", $styleSign, $pAlignStyleLeft);
$pengujiTable->addRow();
$pengujiTable->addCell(Converter::cmToTwip(5))->addText("Pembimbing Kerja Praktik", $styleSign, $pAlignStyleLeft);
$pengujiTable->addCell(Converter::cmToTwip(10))->addText(": Indah Hidayanti, S.T., M.Kom", $styleSign, $pAlignStyleLeft);

$section->addTextBreak(1);
$section->addText("Telah disetujui dan diterima untuk memenuhi sebagian dari persyaratan guna memperoleh gelar sarjana komputer (S.KOM) pada program studi Sistem Informasi", $styleBody, $pAlignStyleJustify);
$section->addTextBreak(1);

$kajurTable = $section->addTable(['align' => 'right', 'cellMargin' => 80]);
$kajurTable->addRow();
$cellKajur = $kajurTable->addCell(Converter::cmToTwip(8));
$cellKajur->addText("Palembang, Oktober 2026\nMengetahui,\nKetua Program Studi Sistem Informasi,", $styleSign, $pAlignStyleLeft);
$cellKajur->addTextBreak(3);
$cellKajur->addText("Gusmelia Testiana, M.Kom", $styleSignBold, $pAlignStyleLeft);
$cellKajur->addText("NIP. 197508012009122001", $styleSign, $pAlignStyleLeft);

// --- PAGE 4: KATA PENGANTAR ---
$section->addPageBreak();
$section->addText("Kata Pengantar", $styleCoverTitle, $pAlignStyleCenter);
$section->addTextBreak(1);

$section->addText("Assalamu’alaikum warahmatullahi wabarakatuh", $styleBody, $pAlignStyleLeft);
$section->addTextBreak(1);

$pKata1 = "Puji dan syukur penulis panjatkan ke hadirat Allah SWT atas limpahan rahmat, taufik, serta karunia-Nya, sehingga penulis dapat menyelesaikan Laporan Kerja Praktik ini dengan baik. Laporan ini disusun sebagai salah satu syarat penilaian akademik kerja praktek mahasiswa dengan judul \"Rancangan Sistem Informasi Disposisi Internal (SIDI) Berbasis Website pada Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan Menggunakan Metode Task Centered System Design (TCSD)\"";
$section->addText($pKata1, $styleBody, $pAlignStyleJustify);

$pKata2 = "Penyusunan laporan ini tentu tidak terlepas dari berbagai hambatan dan keterbatasan baik dalam hal waktu, pengalaman, maupun pengetahuan. Namun, berkat bimbingan, dukungan, dan bantuan dari berbagai pihak, laporan ini akhirnya dapat terselesaikan. Oleh karena itu, pada kesempatan ini, penulis ingin menyampaikan rasa terima kasih yang sebesar-besarnya kepada semua pihak yang telah membantu dalam proses pelaksanaan kerja praktik hingga penyusunan laporan ini, terutama kepada :";
$section->addText($pKata2, $styleBody, $pAlignStyleJustify);

$thanks = [
    "Prof. Dr. Nyayu Khodijah, S.Ag., M.Si. Selaku Rektor UIN Raden Fatah Palembang",
    "Dr. Ir. Hartono, M.A. Selaku Dekan Fakultas Sains dan Teknologi",
    "Ibu Gusmelia Testiana, M.Kom selaku Ketua Program Studi Sistem Informasi",
    "Ibu Gusmelia Testiana, M.Kom selaku Dosen Pembimbing Akademik",
    "Ibu Indah Hidayanti, S.T., M.Kom Selaku Dosen Pembimbing Kerja Praktik telah membimbing penulis dalam penyusunan laporan.",
    "Kepala Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan",
    "Pembimbing Lapangan Kerja Praktek di Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan",
    "Seluruh Staff dan Dosen Prodi Sistem Informasi UIN Raden Fatah Palembang.",
    "Seluruh karyawan Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan.",
    "Orangtua, saudara dan teman-teman yang memberi masukkan dan dorongan dalam pembuatan laporan magang."
];

foreach ($thanks as $idx => $item) {
    $section->addText(($idx + 1) . ". " . $item, $styleBody, ['leftIndent' => 360, 'spaceAfter' => 60]);
}

$pKata3 = "Penulis menyadari bahwa laporan ini masih jauh dari sempurna. Untuk itu, kritik dan saran yang bersifat membangun sangat diharapkan demi penyempurnaan di masa mendatang.\n\nAkhir kata, semoga laporan ini dapat memberikan manfaat dan menjadi referensi bagi pihak-pihak yang membutuhkan, khususnya dalam pengembangan sistem kearsipan berbasis digital.\n\nWassalamualaikum Warahmatulillahi Wabarakatuh.";
$section->addTextBreak(1);
$section->addText($pKata3, $styleBody, $pAlignStyleJustify);

$tablePenulis = $section->addTable(['align' => 'right', 'cellMargin' => 80]);
$tablePenulis->addRow();
$cellPenulis = $tablePenulis->addCell(Converter::cmToTwip(6));
$cellPenulis->addText("Palembang, 25 Agustus 2026\n\n\n\nArya Anugrah\n2230803123", $styleBodyBold, $pAlignStyleCenter);

// --- PAGES 6, 7, 8: TABLE OF CONTENTS, TABLES, FIGURES PLACEHOLDERS ---
$section->addPageBreak();
$section->addText("DAFTAR ISI", $styleCoverTitle, $pAlignStyleCenter);
$section->addText("[ DAFTAR ISI DI-GENERATE OTOMATIS OLEH USER DI MS WORD ]", $styleBodyItalic, $pAlignStyleCenter);

$section->addPageBreak();
$section->addText("DAFTAR TABEL", $styleCoverTitle, $pAlignStyleCenter);
$section->addText("[ DAFTAR TABEL DI-GENERATE OTOMATIS OLEH USER DI MS WORD ]", $styleBodyItalic, $pAlignStyleCenter);

$section->addPageBreak();
$section->addText("DAFTAR GAMBAR", $styleCoverTitle, $pAlignStyleCenter);
$section->addText("[ DAFTAR GAMBAR DI-GENERATE OTOMATIS OLEH USER DI MS WORD ]", $styleBodyItalic, $pAlignStyleCenter);

// --- BAB I: PENDAHULUAN ---
$section->addPageBreak();
$section->addText("BAB I\nPENDAHULUAN", $styleCoverTitle, $pAlignStyleCenter);

$section->addText("A. Latar Belakang", $styleBodyBold, $pAlignStyleLeft);
$pLatar1 = "Pada saat ini penguasaan teknologi informasi (TI) dijadikan sebagai salah satu indikator kemajuan suatu negara. Indonesia menjadi salah satu negara dengan perkembangan teknologi informasi terjadi hampir di seluruh aspek, mulai dari penyelenggaraan pemerintahan sampai dengan kehidupan masyarakat (Prayogi et al, 2021). Perkembangan ini tidak hanya terjadi pada tingkat nasional, tetapi juga menjadi tuntutan di tingkat daerah, termasuk pada unit-unit pelayanan seperti Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan. Sebagai bagian dari struktur organisasi pemerintah daerah, dinas memiliki tanggung jawab besar dalam menyelenggarakan pelayanan publik.";
$section->addText($pLatar1, $styleBody, $pAlignStyleJustify);

$pLatar2 = "Dalam operasional sehari-hari, Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan menerima surat masuk dalam dua bentuk, yaitu surat fisik (manual) yang diantarkan langsung dan surat digital yang dikirim via email atau media elektronik lainnya. Meskipun surat dapat diterima secara hibrida, proses disposisi (lembar tindak lanjut instruksi pimpinan) untuk kedua jenis surat tersebut masih dilakukan secara manual menggunakan lembaran kertas fisik. Staf penerima harus mencetak surat digital atau mencatat surat fisik secara manual di buku agenda, lalu melampirkan lembar disposisi kertas untuk diajukan ke Kepala Dinas.";
$section->addText($pLatar2, $styleBody, $pAlignStyleJustify);

$pLatar3 = "Alur disposisi kertas ini dinilai kurang efektif dan efisien karena membutuhkan waktu untuk mengantarkan berkas fisik dari ruangan Kepala Dinas ke masing-masing bidang secara manual. Selain itu, disposisi kertas rawan hilang, rusak, atau terselip, serta menyulitkan pimpinan untuk memantau status tindak lanjut surat tersebut secara real-time. Terlebih lagi, koordinasi disposisi antar bidang (lintas divisi) sangat terbatas karena tidak adanya sistem yang terintegrasi. Oleh karena itu, dibutuhkan inovasi melalui pemanfaatan teknologi informasi, salah satunya dengan merancang sebuah website Sistem Informasi Disposisi Internal (SIDI) yang dapat memfasilitasi disposisi digital.";
$section->addText($pLatar3, $styleBody, $pAlignStyleJustify);

$pLatar4 = "Salah satu pendekatan relevan dalam perancangan website ini adalah Task Centered System Design. Metode TCSD merupakan bagian dari Human Computer Interaction (HCI) yang bertujuan untuk mengidentifikasi kebutuhan pengguna dan kebutuhan tugas (Jibran, 2023). Metode TCSD meliputi 4 tahap, yaitu Identification, User Centered Requirements Analysis, Design Through Scenario, Walkthrough, Evaluate (Suklia, 2022). Metode TCSD dinilai efektif untuk digunakan dalam membangun rancangan aplikasi karena sistematis dan fokus terhadap kebutuhan task spesifik yang dikerjakan oleh user. Metode ini mampu mengidentifikasi kebutuhan user dan memberikan rekomendasi untuk perancangan User Interface yang baik (Anggreria, 2022).";
$section->addText($pLatar4, $styleBody, $pAlignStyleJustify);

$section->addText("B. Rumusan Masalah", $styleBodyBold, $pAlignStyleLeft);
$section->addText("Berdasarkan latar belakang yang telah diuraikan, maka rumusan masalah dalam penelitian ini adalah sebagai berikut:", $styleBody, $pAlignStyleJustify);
$section->addText("1. Bagaimana merancang website disposisi internal (SIDI) yang efektif untuk Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan?", $styleBody, ['leftIndent' => 360, 'spaceAfter' => 40]);
$section->addText("2. Fitur dan informasi apa saja yang perlu disediakan dalam website agar mampu memenuhi kebutuhan disposisi hibrida (surat fisik dan digital) dan menghubungkan antar bidang?", $styleBody, ['leftIndent' => 360, 'spaceAfter' => 40]);
$section->addText("3. Bagaimana desain antarmuka dan alur sistem yang ramah pengguna untuk memudahkan interaksi disposisi lanjutan di instansi?", $styleBody, ['leftIndent' => 360, 'spaceAfter' => 60]);

$section->addText("C. Batasan Masalah", $styleBodyBold, $pAlignStyleLeft);
$section->addText("Penelitian ini difokuskan pada perancangan sistem website Sistem Informasi Disposisi Internal (SIDI) pada Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan dengan lingkup terbatas pada pengelolaan disposisi internal surat masuk (fisik dan digital), pendistribusian instruksi dari tingkat atasan hingga staf pelaksana, integrasi disposisi antar bidang, serta rancangan tampilan antarmuka dan struktur sistem website tanpa mencakup implementasi penuh maupun integrasi dengan sistem eksternal lainnya.", $styleBody, $pAlignStyleJustify);

$section->addText("D. Tujuan Penelitian", $styleBodyBold, $pAlignStyleLeft);
$section->addText("1. Tujuan Umum :", $styleBodyBold, $pAlignStyleLeft);
$section->addText("Tujuan umum dari penelitian ini adalah untuk merancang sebuah website Sistem Informasi Disposisi Internal (SIDI) yang dapat meningkatkan efisiensi, akurasi, dan transparansi distribusi instruksi disposisi surat pada Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan.", $styleBody, $pAlignStyleJustify);
$section->addText("2. Tujuan Khusus:", $styleBodyBold, $pAlignStyleLeft);
$tujKhusus = [
    "Merancang antarmuka website SIDI yang ramah pengguna (user-friendly) dan mudah diakses oleh aparatur instansi.",
    "Menyediakan fitur rancangan unggah berkas surat digital dan surat fisik (yang telah di-scan) untuk diproses disposisinya secara paperless.",
    "Merancang alur koordinasi disposisi antar bidang secara terintegrasi.",
    "Mendukung sistem administrasi internal agar lebih cepat, terpantau, dan terstruktur melalui pemanfaatan teknologi informasi."
];
foreach ($tujKhusus as $tuj) {
    $section->addText("- " . $tuj, $styleBody, ['leftIndent' => 240, 'spaceAfter' => 40]);
}

$section->addText("E. Manfaat Penelitian", $styleBodyBold, $pAlignStyleLeft);
$section->addText("Penelitian ini diharapkan dapat memberikan manfaat bagi berbagai pihak. Bagi instansi Dinas Kelautan dan Perikanan, website SIDI ini membantu mendigitalisasi lembar disposisi, mempercepat koordinasi surat masuk, mengurangi penggunaan kertas, serta mencegah risiko kehilangan berkas fisik. Bagi penulis, penelitian ini memberikan pemahaman mendalam mengenai analisis kebutuhan pengguna berbasis tugas menggunakan metode TCSD.", $styleBody, $pAlignStyleJustify);

$section->addText("F. Tempat dan Waktu Pelaksanaan", $styleBodyBold, $pAlignStyleLeft);
$section->addText("1. Tempat pelaksanaan Kerja Praktik:", $styleBodyBold, $pAlignStyleLeft);
$section->addText("Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan. Alamat: Jalan Pangeran Ratu, 15 Ulu, Kecamatan Jakabaring, Kota Palembang, Sumatera Selatan (Kode Pos 30257).", $styleBody, $pAlignStyleJustify);
$section->addText("2. Waktu Pelaksanaan Kerja Praktik:", $styleBodyBold, $pAlignStyleLeft);
$section->addText("Kegiatan kerja praktik dilaksanakan pada tanggal 1 Juli 2026 – 25 Agustus 2026. Jadwal kerja operasional kantor diuraikan pada Tabel 1 di bawah ini.", $styleBody, $pAlignStyleJustify);

$section->addText("Tabel 1. Jadwal Kerja Praktik", $styleBodyBold, $pAlignStyleCenter);
$cellBorder = [
    'borderTopSize' => 4, 'borderTopColor' => '000000',
    'borderBottomSize' => 4, 'borderBottomColor' => '000000',
    'borderLeftSize' => 4, 'borderLeftColor' => '000000',
    'borderRightSize' => 4, 'borderRightColor' => '000000',
];
$tJadwal = $section->addTable($tableStyle);
$tJadwal->addRow();
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("Hari Kerja", $styleCoverBold, $pAlignStyleCenter);
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("Jam Kerja", $styleCoverBold, $pAlignStyleCenter);
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("Waktu Pulang", $styleCoverBold, $pAlignStyleCenter);

$tJadwal->addRow();
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("Senin – Kamis", $styleBody, $pAlignStyleCenter);
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("07.30", $styleBody, $pAlignStyleCenter);
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("16.00", $styleBody, $pAlignStyleCenter);

$tJadwal->addRow();
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("Jumat", $styleBody, $pAlignStyleCenter);
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("07.00", $styleBody, $pAlignStyleCenter);
$tJadwal->addCell(Converter::cmToTwip(5), $cellBorder)->addText("16.00", $styleBody, $pAlignStyleCenter);

// --- BAB II: ANALISIS SITUASI UMUM ---
$section->addPageBreak();
$section->addText("BAB II\nANALISIS SITUASI UMUM", $styleCoverTitle, $pAlignStyleCenter);

$section->addText("A. Profil Instansi", $styleBodyBold, $pAlignStyleLeft);
$pProfil = "Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan merupakan Unit Pelaksana Teknis Daerah yang berada di bawah naungan Pemerintah Provinsi Sumatera Selatan. Instansi ini memiliki tanggung jawab dalam melaksanakan kegiatan teknis operasional di bidang perikanan tangkap, perikanan budidaya, pengawasan sumber daya kelautan, serta pembinaan nelayan dan pembudidaya ikan di wilayah Provinsi Sumatera Selatan. Lembaga ini berperan penting dalam menjaga kualitas, kelestarian ekosistem perairan darat dan laut, serta menaikkan kesejahteraan pelaku usaha perikanan lokal.";
$section->addText($pProfil, $styleBody, $pAlignStyleJustify);

$section->addText("B. Struktur Organisasi", $styleBodyBold, $pAlignStyleLeft);
$section->addText("[ SILAKAN INSERT GAMBAR STRUKTUR ORGANISASI DI SINI ]", $styleBodyItalic, $pAlignStyleCenter);
$section->addText("Struktur organisasi Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan dipimpin oleh Kepala Dinas, Sekretaris Dinas yang mengoordinasikan sub-bagian (termasuk Sub-Bagian Umum), serta beberapa Kepala Bidang teknis yang masing-masing membawahi seksi dan staf pelaksana.", $styleBody, $pAlignStyleJustify);

$section->addText("C. Visi & Misi", $styleBodyBold, $pAlignStyleLeft);
$section->addText("Visi DKP Sumsel diselaraskan dengan visi pembangunan daerah Provinsi Sumatera Selatan, yaitu:\n\"Sumatera Selatan Maju untuk Semua Berbasis Pembangunan Berkelanjutan.\"\nMisi DKP Sumsel antara lain:\n1. Meningkatkan pengelolaan potensi kelautan dan perikanan secara lestari.\n2. Mewujudkan pemberdayaan nelayan dan pembudidaya ikan berbasis ekonomi kerakyatan.\n3. Mewujudkan tata kelola pelayanan publik yang cepat, transparan, dan terkomputerisasi.", $styleBody, $pAlignStyleJustify);

// --- BAB III: ANALISIS SITUASI KHUSUS ---
$section->addPageBreak();
$section->addText("BAB III\nANALISIS SITUASI KHUSUS", $styleCoverTitle, $pAlignStyleCenter);

$section->addText("A. Bagian Struktur Organisasi Unit Kerja", $styleBodyBold, $pAlignStyleLeft);
$pUnitKerja = "Selama pelaksanaan Kerja Praktik, penulis ditempatkan di Sub Bagian Umum dan Kepegawaian. Bagian ini dipimpin oleh Kepala Sub Bagian (Kasubag) Umum dan bertanggung jawab langsung kepada Sekretaris Dinas. Bagian ini memiliki peran sentral dalam administrasi persuratan, tata usaha dinas, rumah tangga, kearsipan dokumen, serta penyiapan disposisi surat masuk dari Kepala Dinas untuk diteruskan ke bidang teknis terkait.";
$section->addText($pUnitKerja, $styleBody, $pAlignStyleJustify);

$section->addText("B. Uraian Tugas Khusus", $styleBodyBold, $pAlignStyleLeft);
$pTugasKhusus = "Tugas khusus yang dilakukan penulis selama magang meliputi observasi alur masuknya surat penting (baik berkas fisik maupun digital via email), pencatatan data ke buku agenda, membantu staf menyiapkan lembar disposisi kertas fisik, mendokumentasikan disposisi Kepala Dinas ke masing-masing bidang, serta mengidentifikasi hambatan-hambatan komunikasi yang terjadi dalam alur disposisi antar bidang. Dari observasi tersebut, ditemukan masalah penanganan kertas disposisi yang lambat dan rentan terselip, sehingga memicu usulan perancangan sistem informasi SIDI menggunakan metode TCSD.";
$section->addText($pTugasKhusus, $styleBody, $pAlignStyleJustify);

// --- BAB IV: IDENTIFIKASI DAN PRIORITAS MASALAH ---
$section->addPageBreak();
$section->addText("BAB IV\nIDENTIFIKASI DAN PRIORITAS MASALAH", $styleCoverTitle, $pAlignStyleCenter);

$section->addText("A. Identifikasi Masalah", $styleBodyBold, $pAlignStyleLeft);
$section->addText("Berdasarkan fungsi kearsipan dan tugas staf di Sub Bagian Umum Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan, permasalahan administrasi yang diidentifikasikan adalah:", $styleBody, $pAlignStyleJustify);
$problemsList = [
    "Penerimaan surat masuk yang bersifat hibrida (fisik dan digital) masih dicatat secara manual di buku agenda kertas.",
    "Proses penyusunan lembar disposisi masih menggunakan kertas fisik, memicu keterlambatan distribusi instruksi pimpinan.",
    "Staf pengirim disposisi kesulitan memantau apakah disposisi tersebut sudah dibaca atau ditindaklanjuti oleh staf penerima.",
    "Arsip disposisi kertas rawan rusak, basah, terselip, atau hilang ketika dipindahkan antar ruangan bidang.",
    "Penyusunan rekapitulasi laporan surat masuk, keluar, dan status disposisi bulanan membutuhkan waktu lama karena staf harus menyalin ulang data dari buku agenda fisik."
];
foreach ($problemsList as $idx => $prob) {
    $section->addText(($idx + 1) . ". " . $prob, $styleBody, ['leftIndent' => 360, 'spaceAfter' => 60]);
}

$section->addText("B. Prioritas Masalah", $styleBodyBold, $pAlignStyleLeft);
$section->addText("1. Evaluasi Masalah", $styleBodyBold, $pAlignStyleLeft);
$pEvalMasalah = "Evaluasi terhadap identifikasi masalah menunjukkan bahwa sistem pengelolaan disposisi kertas di Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan tidak lagi efisien. Proses manual ini memicu lambatnya respons terhadap surat masuk penting, menurunkan produktivitas kerja staf, serta memicu tumpukan berkas fisik yang tidak terorganisir dengan baik. Masalah utama yang harus segera diselesaikan adalah digitalisasi lembar disposisi kertas dan penyediaan mekanisme koordinasi disposisi lintas bidang secara paperless.";
$section->addText($pEvalMasalah, $styleBody, $pAlignStyleJustify);

$section->addText("2. Solusi Masalah", $styleBodyBold, $pAlignStyleLeft);
$pSolMasalah = "Sebagai solusi, diperlukan perancangan Sistem Pengaduan Masyarakat berbasis website (SIDI) atau e-disposisi. Melalui sistem ini, surat fisik yang telah dipindai (scan) atau surat digital dapat diunggah langsung ke sistem, disposisi diinput oleh pimpinan secara online, dan notifikasi otomatis dikirimkan ke penerima disposisi. SIDI memfasilitasi pelacakan status disposisi (dibaca/belum) secara real-time dan mengintegrasikan disposisi antar bidang, sehingga meningkatkan efisiensi administrasi dinas.";
$section->addText($pSolMasalah, $styleBody, $pAlignStyleJustify);

$section->addText("D. Metode Penelitian", $styleBodyBold, $pAlignStyleLeft);
$pMetodologiTCSD = "Metode yang diterapkan dalam penelitian ini adalah Task-Centered System Design (TCSD), sebuah pendekatan perancangan yang memprioritaskan alur aktivitas dan kebutuhan tugas (task) konkret dari pengguna akhir. Metode ini dipilih untuk menjamin bahwa antarmuka serta fungsi dari rancangan SIDI selaras dengan kebutuhan nyata pengguna dan kondisi administratif organisasi. Berdasarkan tinjauan kepustakaan, tahapan metode TCSD meliputi empat fase utama: identifikasi tugas (identification), analisis kebutuhan berbasis pengguna (user-centred requirements analysis), perancangan melalui skenario (design as scenarios), dan evaluasi kognitif (walk-through evaluation) (Taufani et al., 2021).";
$section->addText($pMetodologiTCSD, $styleBody, $pAlignStyleJustify);

$section->addText("[ GAMBAR METODOLOGI TCSD ]\n(Silakan masukkan diagram tahapan TCSD di sini)", $styleBodyItalic, $pAlignStyleCenter);

$tcsdStages = [
    "Identifikasi Tugas: Tahap awal ini melibatkan pengamatan langsung serta diskusi mendalam dengan jajaran staf Dinas Kelautan dan Perikanan guna memetakan tugas-tugas administratif persuratan. Fase ini bertujuan memperoleh data dasar mengenai pola kerja disposisi manual saat ini serta kendala yang dihadapi oleh para pengguna di lapangan (Taufani, 2021).",
    "Analisis Kebutuhan Berbasis Pengguna: Setelah tugas operasional diidentifikasi, penulis memetakan peran pengguna ke dalam kelompok (seperti Admin, Kabid, Kasi, dan Staf) untuk menganalisis kebutuhan spesifik dari masing-masing peran tersebut. Hasil analisis ini kemudian diterjemahkan ke dalam kebutuhan fungsional dan non-fungsional rancangan sistem, seperti penyediaan live preview berkas PDF untuk pimpinan dan modul pelacakan status disposisi untuk staf.",
    "Perancangan Melalui Skenario: Pada tahap ini disusun skenario alur perjalanan pengguna (user journey) yang merepresentasikan tugas-tugas utama dalam sirkulasi disposisi. Skenario tersebut menjadi landasan dasar pembuatan mockup/wireframe antarmuka SIDI. Desain mockup ini dibuat dengan mengedepankan aspek kejelasan navigasi dan kemudahan interaksi (usability).",
    "Evaluasi Kognitif (Walkthrough): Langkah terakhir dari metode TCSD adalah melaksanakan pengujian kegunaan desain antarmuka (prototype walkthrough) dengan menelusuri langkah-langkah kerja pengguna bersama calon pemakai sistem. Evaluasi ini dilakukan guna memverifikasi bahwa rancangan antarmuka SIDI mudah dipahami, intuitif, dan siap dikembangkan lebih lanjut."
];
foreach ($tcsdStages as $idx => $stg) {
    $section->addText(($idx + 1) . ". " . $stg, $styleBody, ['leftIndent' => 360, 'spaceAfter' => 60]);
}

// --- BAB V: HASIL DAN PEMBAHASAN ---
$section->addPageBreak();
$section->addText("BAB V\nHASIL DAN PEMBAHASAN", $styleCoverTitle, $pAlignStyleCenter);

$section->addText("A. Gambaran Umum Proses Perancangan", $styleBodyBold, $pAlignStyleLeft);
$pGambaranUmum = "Proses perancangan pada sistem SIDI ini mengadopsi kerangka kerja Task-Centered System Design (TCSD), yang berfokus pada penyelarasan fungsionalitas aplikasi dengan alur kerja nyata di instansi. Pendekatan ini memastikan bahwa setiap antarmuka yang dirancang memiliki relevansi langsung dengan tugas operasional harian para aparatur. Dengan memahami pola aktivitas pengguna secara mendalam, rancangan sistem SIDI diharapkan mampu mengakomodasi seluruh kebutuhan fungsional dan non-fungsional dinas secara optimal.";
$section->addText($pGambaranUmum, $styleBody, $pAlignStyleJustify);

$pGambaranUmum2 = "Fase awal perancangan dimulai dari analisis hambatan disposisi surat berbasis lembar kertas fisik yang lambat didistribusikan lintas ruangan dan sulit dipantau progresnya. Berdasarkan identifikasi masalah tersebut, penulis menyusun model basis data relasional (ERD) dan pemodelan UML (Use Case, Class, Activity Diagram). Desain antarmuka dibuat untuk mempermudah pimpinan membaca lampiran surat secara paperless serta memberikan instruksi disposisi secara cepat. Terakhir, rancangan mockup ini divalidasi menggunakan teknik walkthrough untuk menjamin kemudahan alur tugas pengguna.";
$section->addText($pGambaranUmum2, $styleBody, $pAlignStyleJustify);

$section->addText("B. Tahapan Task Centered System Design (TCSD)", $styleBodyBold, $pAlignStyleLeft);

$section->addText("1. Identifikasi Tugas Pengguna (Identify Tasks)", $styleBodyBold, $pAlignStyleLeft);
$pIdentifyTasks = "Pada fase ini, penulis menghimpun data mengenai tata cara pengelolaan surat masuk dan lembar tindak lanjut di Dinas Kelautan dan Perikanan. Melalui observasi, teridentifikasi bahwa sirkulasi surat yang masih mengandalkan dokumen kertas memicu lambatnya distribusi instruksi, risiko berkas hilang, dan ketiadaan riwayat pemantauan yang akurat. Dari temuan ini, dirumuskan tugas-tugas kritis seperti pencatatan surat masuk, otorisasi disposisi oleh pejabat, dan pengerjaan tugas oleh staf pelaksana.";
$section->addText($pIdentifyTasks, $styleBody, $pAlignStyleJustify);

$section->addText("2. Pemilihan Tugas Representatif (Choose Representative Tasks)", $styleBodyBold, $pAlignStyleLeft);
$pChooseTasks = "Fase ini bertujuan menyaring sekumpulan tugas krusial yang paling sering dijalankan dan memiliki pengaruh besar bagi kelancaran koordinasi instansi. Tugas representatif yang disepakati untuk perancangan SIDI mencakup: (a) Admin mengelola registrasi user dan pembagian divisi kerja; (b) Petugas Sub Bagian Umum mengunggah berkas surat PDF serta melakukan penginputan agenda; (c) Kepala Bidang/Kepala Seksi menelaah lampiran surat secara live preview dan mendistribusikan instruksi disposisi; serta (d) Staf pelaksana melihat disposisi masuk, mengunduh berkas, dan menindaklanjuti tugas.";
$section->addText($pChooseTasks, $styleBody, $pAlignStyleJustify);

$section->addText("3. Desain Sistem Berdasarkan Tugas (Design the System)", $styleBodyBold, $pAlignStyleLeft);
$pDesignSystem = "Tahapan ini berfokus pada pembuatan rancangan visual antarmuka (mockup) dan alur interaksi yang didesain khusus untuk mendukung kelancaran 4 tugas representatif tersebut. Setiap layout dirancang dengan prinsip kesederhanaan, keterbacaan dokumen yang tinggi, serta visualisasi yang dinamis berestetika modern.";
$section->addText($pDesignSystem, $styleBody, $pAlignStyleJustify);

$section->addText("[ SILAKAN INSERT GAMBAR-GAMBAR MOCKUP ANTARMUKA DI SINI ]\n(Gambar 3: Mockup Beranda, Gambar 4: Mockup Form Disposisi, Gambar 5: Mockup Detail Surat)", $styleBodyItalic, $pAlignStyleCenter);

$section->addText("Desain beranda didesain menampilkan pintasan menu navigasi yang ringkas dan rekapitulasi data persuratan terkini. Form pembuatan disposisi dirancang menyatu dengan live reader berkas PDF untuk mempercepat penulisan instruksi pimpinan. Halaman detail riwayat disposisi dibuat transparan agar progres pengerjaan surat dapat dipantau oleh pengirim secara real-time.", $styleBody, $pAlignStyleJustify);

$section->addText("4. Evaluasi", $styleBodyBold, $pAlignStyleLeft);
$pEvaluasi = "Langkah terakhir dari TCSD adalah melakukan verifikasi terhadap rancangan tata letak dan alur interaksi dengan melibatkan langsung aparatur DKP Sumsel. Penilaian rancangan menggunakan simulasi cognitive walkthrough untuk menakar tingkat kemudahan pengguna dalam menyelesaikan skenario tugas yang diberikan tanpa hambatan pemahaman. Hasil detail evaluasi disajikan pada Tabel 2.";
$section->addText($pEvaluasi, $styleBody, $pAlignStyleJustify);

$section->addText("Tabel 2. Evaluasi Cognitive Walkthrough Rancangan SIDI", $styleBodyBold, $pAlignStyleCenter);

$tEvaluasiTable = $section->addTable($tableStyle);
$tEvaluasiTable->addRow();

$thEvaluasi = ["No", "Tugas Representatif", "Aktor", "Langkah Evaluasi Desain (Cognitive Walkthrough)", "Hasil Evaluasi"];
$widthsEvaluasi = [Converter::cmToTwip(1), Converter::cmToTwip(3), Converter::cmToTwip(2.5), Converter::cmToTwip(6.5), Converter::cmToTwip(2)];

$thStyle = ['name' => 'Times New Roman', 'size' => 10, 'bold' => true];
$headerStyleEvaluasi = [
    'bgColor' => 'E6E6E6',
    'borderTopSize' => 4, 'borderTopColor' => '000000',
    'borderBottomSize' => 4, 'borderBottomColor' => '000000',
    'borderLeftSize' => 4, 'borderLeftColor' => '000000',
    'borderRightSize' => 4, 'borderRightColor' => '000000',
];

foreach ($thEvaluasi as $colIdx => $name) {
    $cell = $tEvaluasiTable->addCell($widthsEvaluasi[$colIdx], $headerStyleEvaluasi);
    $cell->addText($name, $thStyle, $pAlignStyleCenter);
}

$evaluations = [
    ["1", "Manajemen User & Bidang", "Admin", "Admin masuk ke menu manajemen, mengisi form data akun baru staf, memilih bidang kerja, lalu menekan Simpan.", "Sesuai & Intuitif"],
    ["2", "Pencatatan Surat Masuk", "Admin / Staff", "Petugas mengunggah berkas PDF surat masuk, mengisi data agenda (no surat/perihal/sifat), lalu memilih penerima disposisi.", "Sesuai & Intuitif"],
    ["3", "Distribusi Disposisi", "Pimpinan (Kabid/Kasi)", "Pimpinan membuka detail surat masuk, membaca berkas lewat live preview PDF, mengisi catatan instruksi, lalu menekan Kirim Disposisi.", "Sesuai & Intuitif"],
    ["4", "Pembacaan & Tindak Lanjut", "Staff Penerima", "Staf membuka tautan dari notifikasi email, membuka detail lembar disposisi digital, lalu mengunduh file lampiran surat PDF.", "Sesuai & Intuitif"]
];

foreach ($evaluations as $rowIdx => $tRow) {
    $tEvaluasiTable->addRow();
    foreach ($tRow as $colIdx => $val) {
        $cell = $tEvaluasiTable->addCell($widthsEvaluasi[$colIdx], $cellBorder);
        $cell->addText($val, ['name' => 'Times New Roman', 'size' => 9.5], ($colIdx == 0 || $colIdx == 4) ? $pAlignStyleCenter : $pAlignStyleLeft);
    }
}

// --- BAB VI: PENUTUP ---
$section->addPageBreak();
$section->addText("BAB VI\nPENUTUP", $styleCoverTitle, $pAlignStyleCenter);

$section->addText("A. Kesimpulan", $styleBodyBold, $pAlignStyleLeft);
$pKesimpulanText = "Berdasarkan perancangan Sistem Informasi Disposisi Internal (SIDI) di Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan, diperoleh beberapa kesimpulan sebagai berikut:\n" .
                   "1. Penerapan metode Task-Centered System Design (TCSD) terbukti efektif dalam memetakan profil pengguna dan menyusun tugas-tugas representatif kearsipan persuratan.\n" .
                   "2. Telah dihasilkan dokumen rancangan blueprint sistem yang komprehensif, meliputi pemodelan UML (Use Case, Class, Activity Diagram) serta rancangan database relasional (ERD).\n" .
                   "3. Hasil penelusuran Cognitive Walkthrough menunjukkan bahwa rancangan antarmuka SIDI dinilai sangat ramah pengguna, informatif, dan memiliki alur navigasi yang selaras dengan kebiasaan kerja aparatur.";
$section->addText($pKesimpulanText, $styleBody, $pAlignStyleJustify);

$section->addText("B. Saran", $styleBodyBold, $pAlignStyleLeft);
$pSaranText = "Adapun saran untuk pengembangan sistem SIDI ini ke depan adalah:\n" .
              "1. Melanjutkan rancangan blueprint berbasis tugas ini ke tahap pengembangan aplikasi (coding) menggunakan platform Laravel dan MySQL pada riset lanjutan Skripsi.\n" .
              "2. Melakukan uji coba kegunaan secara menyeluruh pada aplikasi nyata dengan melibatkan kuesioner usability terstandar (seperti System Usability Scale - SUS) guna mengukur efektivitas kerja.\n" .
              "3. Mengintegrasikan proteksi keamanan data tambahan, seperti enkripsi dokumen lampiran PDF pada direktori server.";
$section->addText($pSaranText, $styleBody, $pAlignStyleJustify);

// --- DAFTAR PUSTAKA ---
$section->addPageBreak();
$section->addText("DAFTAR PUSTAKA", $styleCoverTitle, $pAlignStyleCenter);

$pustaka = [
    "Anggreria, Y. (2022). PERANCANGAN USER INTERFACE WEBSITE LEMBAGA KEMANUSIAAN MENGGUNAKAN METODE TASK CENTERED SYSTEM DESIGN (Studi Kasus: Amal Insani Foundation). Jurnal Teknik Informatika, 14(2), 125-132.",
    "Fathoni, Mhd. A., Sepriano, Mareta, N. P., Rizki, D. N., & Azhari, M. T. (2024). Perancangan Sistem Informasi Pelayanan Publik Berbasis Web Menggunakan PHP MySQL di Dinas Pekerjaan Umum dan Perumahan Rakyat (PUPR) di Provinsi Jambi. Jurnal Ilmiah Sistem Informasi, 4(4), 18314–18322.",
    "Jibran, S. M. (2023). Pengembangan Sistem Informasi Manajemen Rumah Sakit di Rumah Sakit Umum Daerah Buton Selatan Menggunakan Metode Task Centered System Design. Jurnal Kesehatan Masyarakat, 11(1), 54-62.",
    "Taufani, M. N. (2021). PENERAPAN METODE TASK CENTERED SYSTEM DESIGN (TCSD) UNTUK ANALISIS DAN PERANCANGAN UI/UX PADA E-LEARNING DI SMAN 1 SIDOARJO. Jurnal Sistem Informasi, 10(2), 75-84.",
    "Ayu, N. R. (n.d.). PENERAPAN METODE TASK-CENTERED SYSTEM DESIGN PADA PERANCANGAN INTERFACE WEBSITE MARKETPLACE BUILD ID MERCHANT ARSITEK. Jurnal Ilmiah Desain, 5(1), 22-30.",
    "Suklia, I. I. (2022). PERANCANGAN USER INTERFACE PROTOTIPE APLIKASI POINT OF SALE MENGGUNAKAN FIGMA DAN METODE TASK CENTERED SYSTEM DESIGN (TCSD). Jurnal Komputer dan Desain, 3(2), 85-93.",
    "Taufani, M. N., Sagirani, T., Nurcahyawati, V., Program, Jurusan, & Informasi, S. (2021). Penerapan Metode Task Centered System Design (TCSD) untuk Analisis Perancangan UI/UX pada E-Learning di SMAN 1 Sidoarjo. JSIKA (Vol. 10, Issue 02)."
];

foreach ($pustaka as $p_item) {
    $section->addText($p_item, ['name' => 'Times New Roman', 'size' => 11], ['alignment' => Jc::JUSTIFY, 'leftIndent' => 360, 'spaceAfter' => 80]);
}

// --- LAMPIRAN ---
$section->addPageBreak();
$section->addText("LAMPIRAN", $styleCoverTitle, $pAlignStyleCenter);
$lampiran = [
    "Lampiran 1: Surat Pengantar Kerja Praktik dari Fakultas Sains dan Teknologi UIN Raden Fatah Palembang.",
    "Lampiran 2: Surat Tugas Magang dari Dekan Fakultas Sains dan Teknologi.",
    "Lampiran 3: Kartu Bimbingan Kerja Praktik dengan Dosen Pembimbing Lapangan.",
    "Lampiran 4: Surat Keterangan Selesai Kerja Praktik (Magang) dari Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan.",
    "Lampiran 5: Daftar Hadir Absensi Kerja Praktik.",
    "Lampiran 6: Lembar Penilaian Hasil Kerja Praktik dari Pembimbing Lapangan."
];
foreach ($lampiran as $idx => $lam) {
    $section->addText(($idx + 1) . ". " . $lam, $styleBody, ['leftIndent' => 360, 'spaceAfter' => 60]);
}

// Save the document as RTF
$fileName = 'Laporan_Kerja_Praktik_SIDI.rtf';
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'RTF');
$objWriter->save($fileName);

echo "Rich Text Format (RTF) document generated successfully at: " . realpath($fileName) . "\n";
