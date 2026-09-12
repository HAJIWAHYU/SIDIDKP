# -*- coding: utf-8 -*-
import os
import docx
from docx import Document
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT, WD_ALIGN_VERTICAL
from docx.oxml import OxmlElement, parse_xml
from docx.oxml.ns import nsdecls, qn

def set_cell_border(cell, **kwargs):
    """
    Set cell's border
    Usage:
    set_cell_border(
        cell,
        top={"sz": 12, "val": "single", "color": "FF0000", "space": "0"},
        bottom={"sz": 12, "color": "00FF00", "val": "single"},
        start={"sz": 24, "val": "dashed", "shadow": "true"},
        end={"sz": 12, "val": "dashed"},
    )
    """
    tc = cell._tc
    tcPr = tc.get_or_add_tcPr()
    tcBorders = tcPr.first_child_found_in("w:tcBorders")
    if tcBorders is None:
        tcBorders = OxmlElement('w:tcBorders')
        tcPr.append(tcBorders)
    
    for edge in ('top', 'left', 'bottom', 'right', 'insideH', 'insideV'):
        edge_data = kwargs.get(edge)
        if edge_data:
            tag = 'w:{}'.format(edge)
            element = tcBorders.find(qn(tag))
            if element is None:
                element = OxmlElement(tag)
                tcBorders.append(element)
            for key, val in edge_data.items():
                element.set(qn('w:{}'.format(key)), str(val))

def make_cell_borderless(cell):
    set_cell_border(
        cell,
        top={"val": "nil"},
        left={"val": "nil"},
        bottom={"val": "nil"},
        right={"val": "nil"}
    )

def add_heading_with_spacing(doc, text, level, before=12, after=6):
    heading = doc.add_heading(text, level=level)
    heading.paragraph_format.space_before = Pt(before)
    heading.paragraph_format.space_after = Pt(after)
    heading.paragraph_format.line_spacing = 1.15
    for run in heading.runs:
        run.font.name = 'Times New Roman'
        run.font.color.rgb = RGBColor(0, 0, 0)
        if level == 1:
            run.font.size = Pt(14)
            run.bold = True
        else:
            run.font.size = Pt(12)
            run.bold = True
    return heading

def add_paragraph_with_spacing(doc, text="", align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=6, line_spacing=1.5, bold=False, italic=False, font_size=12):
    p = doc.add_paragraph()
    p.alignment = align
    p.paragraph_format.space_after = Pt(space_after)
    p.paragraph_format.line_spacing = line_spacing
    if text:
        run = p.add_run(text)
        run.font.name = 'Times New Roman'
        run.font.size = Pt(font_size)
        run.bold = bold
        run.italic = italic
    return p

def main():
    doc = Document()
    
    # Configure page setup for standard academic report (Margins: Top 3cm, Bottom 3cm, Left 4cm, Right 3cm)
    # 3 cm = 1.18 inches, 4 cm = 1.57 inches
    for section in doc.sections:
        section.top_margin = Inches(1.18)
        section.bottom_margin = Inches(1.18)
        section.left_margin = Inches(1.57)
        section.right_margin = Inches(1.18)
        
    # --- PAGE 1: COVER ---
    add_paragraph_with_spacing(doc, "LAPORAN KERJA PRAKTIK", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=12, line_spacing=1.15, bold=True, font_size=14)
    add_paragraph_with_spacing(doc, "SISTEM INFORMASI DISPOSISI INTERNAL (SIDI) BERBASIS WEBSITE\nPADA DINAS KELAUTAN DAN PERIKANAN\nPROVINSI SUMATERA SELATAN", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=36, line_spacing=1.15, bold=True, font_size=14)
    
    add_paragraph_with_spacing(doc, "Diajukan Untuk Memenuhi Syarat Mata Kuliah Kerja Praktik\npada Program Studi Sistem Informasi Fakultas Sains dan Teknologi\nUIN Raden Fatah Palembang", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=48, line_spacing=1.15, italic=True, font_size=11)
    
    add_paragraph_with_spacing(doc, "Oleh:", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=6, line_spacing=1.15, bold=True, font_size=12)
    # Note: Using placeholders based on .env that the student can easily customize
    add_paragraph_with_spacing(doc, "ARYA ANUGRAH\nNIM. 2230803123", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=60, line_spacing=1.15, bold=True, font_size=12)
    
    # Place holder for Logo
    add_paragraph_with_spacing(doc, "[ LOGO UNIVERSITAS UIN RADEN FATAH PALEMBANG ]\n(Silakan insert gambar logo di sini)", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=60, line_spacing=1.15, italic=True, font_size=10)
    
    add_paragraph_with_spacing(doc, "PROGRAM STUDI SISTEM INFORMASI\nFAKULTAS SAINS DAN TEKNOLOGI\nUNIVERSITAS ISLAM NEGERI RADEN FATAH\nPALEMBANG\n2026", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=0, line_spacing=1.15, bold=True, font_size=12)
    
    doc.add_page_break()
    
    # --- PAGE 2: LEMBAR PERSETUJUAN ---
    add_paragraph_with_spacing(doc, "LEMBAR PERSETUJUAN", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=18, line_spacing=1.15, bold=True, font_size=14)
    
    text_persetujuan = (
        "Laporan Kerja Praktik ini telah diperiksa dan disetujui sebagai hasil kegiatan "
        "Kerja Praktik untuk memenuhi persyaratan pada Program Studi Sistem Informasi "
        "Fakultas Sains dan Teknologi Universitas Islam Negeri Raden Fatah Palembang "
        "Periode: Juli - Agustus 2026."
    )
    add_paragraph_with_spacing(doc, text_persetujuan, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=36, line_spacing=1.5, font_size=12)
    
    add_paragraph_with_spacing(doc, "Palembang, Agustus 2026", align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=18, font_size=12)
    
    # Table for signatures
    table_persetujuan = doc.add_table(rows=5, cols=2)
    table_persetujuan.alignment = WD_TABLE_ALIGNMENT.CENTER
    table_persetujuan.autofit = False
    
    # Set widths
    for row in table_persetujuan.rows:
        row.cells[0].width = Inches(3.0)
        row.cells[1].width = Inches(3.0)
        for cell in row.cells:
            make_cell_borderless(cell)
            
    table_persetujuan.cell(0, 0).paragraphs[0].text = "Pembimbing Lapangan,"
    table_persetujuan.cell(0, 0).paragraphs[0].alignment = WD_ALIGN_PARAGRAPH.LEFT
    table_persetujuan.cell(0, 1).paragraphs[0].text = "Pembimbing Kerja Praktik,"
    table_persetujuan.cell(0, 1).paragraphs[0].alignment = WD_ALIGN_PARAGRAPH.LEFT
    
    # Empty space for signatures
    table_persetujuan.cell(1, 0).paragraphs[0].text = "\n\n\n"
    table_persetujuan.cell(1, 1).paragraphs[0].text = "\n\n\n"
    
    table_persetujuan.cell(2, 0).paragraphs[0].text = "Nama Pembimbing Lapangan, S.Kom."
    table_persetujuan.cell(2, 0).paragraphs[0].runs[0].bold = True
    table_persetujuan.cell(2, 0).paragraphs[0].runs[0].font.name = 'Times New Roman'
    table_persetujuan.cell(2, 0).paragraphs[0].runs[0].font.size = Pt(12)
    
    table_persetujuan.cell(2, 1).paragraphs[0].text = "Indah Hidayanti, M.Kom."
    table_persetujuan.cell(2, 1).paragraphs[0].runs[0].bold = True
    table_persetujuan.cell(2, 1).paragraphs[0].runs[0].font.name = 'Times New Roman'
    table_persetujuan.cell(2, 1).paragraphs[0].runs[0].font.size = Pt(12)
    
    table_persetujuan.cell(3, 0).paragraphs[0].text = "NIP. 19800808XXXXXXXXXX"
    table_persetujuan.cell(3, 0).paragraphs[0].runs[0].font.name = 'Times New Roman'
    table_persetujuan.cell(3, 0).paragraphs[0].runs[0].font.size = Pt(11)
    
    table_persetujuan.cell(3, 1).paragraphs[0].text = "NIDN. 20211122250819921"
    table_persetujuan.cell(3, 1).paragraphs[0].runs[0].font.name = 'Times New Roman'
    table_persetujuan.cell(3, 1).paragraphs[0].runs[0].font.size = Pt(11)
    
    # Add Space and Program Studi Label at bottom
    add_paragraph_with_spacing(doc, "\n\n\n\n", space_after=12)
    add_paragraph_with_spacing(doc, "PROGRAM STUDI SISTEM INFORMASI\nFAKULTAS SAINS DAN TEKNOLOGI\nUNIVERSITAS ISLAM NEGERI RADEN FATAH\nPALEMBANG\n2026", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=0, line_spacing=1.15, bold=True, font_size=11)
    
    doc.add_page_break()
    
    # --- PAGE 3: LEMBAR PENGESAHAN ---
    add_paragraph_with_spacing(doc, "TANDA PENGESAHAN LAPORAN KERJA PRAKTIK", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=24, line_spacing=1.15, bold=True, font_size=12)
    
    # Metadata table
    table_meta = doc.add_table(rows=5, cols=3)
    table_meta.alignment = WD_TABLE_ALIGNMENT.CENTER
    table_meta.autofit = False
    
    meta_widths = [Inches(2.0), Inches(0.2), Inches(3.8)]
    for row in table_meta.rows:
        for i, w in enumerate(meta_widths):
            row.cells[i].width = w
            make_cell_borderless(row.cells[i])
            
    meta_labels = [
        ("NAMA", ": Arya Anugrah"),
        ("NIM", ": 2230803123"),
        ("PROGRAM STUDI", ": Sistem Informasi"),
        ("FAKULTAS", ": Sains dan Teknologi"),
        ("JUDUL LAPORAN", ": SISTEM INFORMASI DISPOSISI INTERNAL (SIDI) BERBASIS WEBSITE PADA DINAS KELAUTAN DAN PERIKANAN PROVINSI SUMATERA SELATAN")
    ]
    
    for idx, (label, value) in enumerate(meta_labels):
        row = table_meta.rows[idx]
        p1 = row.cells[0].paragraphs[0]
        p1.text = label
        p1.runs[0].bold = True
        p1.runs[0].font.name = 'Times New Roman'
        p1.runs[0].font.size = Pt(11)
        
        p2 = row.cells[1].paragraphs[0]
        p2.text = ":"
        p2.runs[0].font.name = 'Times New Roman'
        p2.runs[0].font.size = Pt(11)
        
        p3 = row.cells[2].paragraphs[0]
        p3.text = value.replace(": ", "")
        p3.runs[0].font.name = 'Times New Roman'
        p3.runs[0].font.size = Pt(11)
        if label == "JUDUL LAKORAN" or label == "JUDUL LAPORAN":
            p3.runs[0].bold = True
            
    add_paragraph_with_spacing(doc, "\nPANITIA PENGUJI HASIL KERJA PRAKTIK\n", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=12, bold=True, font_size=11)
    
    table_penguji = doc.add_table(rows=2, cols=3)
    table_penguji.alignment = WD_TABLE_ALIGNMENT.CENTER
    for row in table_penguji.rows:
        row.cells[0].width = Inches(2.0)
        row.cells[1].width = Inches(0.2)
        row.cells[2].width = Inches(3.8)
        for cell in row.cells:
            make_cell_borderless(cell)
            
    table_penguji.cell(0, 0).paragraphs[0].text = "Tanggal"
    table_penguji.cell(0, 1).paragraphs[0].text = ":"
    table_penguji.cell(0, 2).paragraphs[0].text = "Agustus 2026"
    table_penguji.cell(1, 0).paragraphs[0].text = "Pembimbing Kerja Praktik"
    table_penguji.cell(1, 1).paragraphs[0].text = ":"
    table_penguji.cell(1, 2).paragraphs[0].text = "Indah Hidayanti, M.Kom."
    
    for row in table_penguji.rows:
        for cell in row.cells:
            if cell.paragraphs[0].runs:
                cell.paragraphs[0].runs[0].font.name = 'Times New Roman'
                cell.paragraphs[0].runs[0].font.size = Pt(11)
                
    add_paragraph_with_spacing(doc, "\nTelah disetujui dan diterima untuk memenuhi sebagian persyaratan guna memperoleh gelar Sarjana Komputer (S.Kom) pada Program Studi Sistem Informasi.", align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=24, font_size=11)
    
    # Signature of Head of Program Study
    table_kajur = doc.add_table(rows=4, cols=1)
    table_kajur.alignment = WD_TABLE_ALIGNMENT.RIGHT
    table_kajur.rows[0].cells[0].width = Inches(3.0)
    for row in table_kajur.rows:
        make_cell_borderless(row.cells[0])
        
    table_kajur.cell(0, 0).paragraphs[0].text = "Palembang, Agustus 2026\nMengetahui,\nKetua Program Studi Sistem Informasi,"
    table_kajur.cell(0, 0).paragraphs[0].alignment = WD_ALIGN_PARAGRAPH.LEFT
    table_kajur.cell(1, 0).paragraphs[0].text = "\n\n\n" # space
    table_kajur.cell(2, 0).paragraphs[0].text = "Gusmelia Testiana, M.Kom."
    table_kajur.cell(2, 0).paragraphs[0].runs[0].bold = True
    table_kajur.cell(3, 0).paragraphs[0].text = "NIP. 197508012009122001"
    
    for row in table_kajur.rows:
        p = row.cells[0].paragraphs[0]
        if p.runs:
            p.runs[0].font.name = 'Times New Roman'
            p.runs[0].font.size = Pt(11)
            
    doc.add_page_break()
    
    # --- PAGE 4 & 5: KATA PENGANTAR ---
    add_heading_with_spacing(doc, "KATA PENGANTAR", level=1)
    
    p_kp1 = (
        "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\n"
        "Puji syukur kehadirat Allah SWT atas segala rahmat, hidayah, dan karunia-Nya yang melimpah, "
        "sehingga penulis dapat menyelesaikan penyusunan Laporan Kerja Praktik ini dengan baik dan tepat "
        "pada waktunya. Laporan Kerja Praktik ini disusun dengan judul \"Sistem Informasi Disposisi "
        "Internal (SIDI) Berbasis Website pada Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan\". "
        "Penyusunan laporan ini merupakan salah satu syarat akademik yang wajib dipenuhi untuk menyelesaikan "
        "mata kuliah Kerja Praktik pada Program Studi Sistem Informasi, Fakultas Sains dan Teknologi, "
        "Universitas Islam Negeri Raden Fatah Palembang."
    )
    add_paragraph_with_spacing(doc, p_kp1, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5, font_size=12)
    
    p_kp2 = (
        "Dalam proses pelaksanaan Kerja Praktik hingga penyusunan laporan ini, penulis mendapatkan "
        "banyak bimbingan, arahan, saran, serta dukungan moril maupun materil dari berbagai pihak. Oleh karena itu, "
        "pada kesempatan ini penulis ingin menyampaikan ucapan terima kasih yang sebesar-besarnya kepada:"
    )
    add_paragraph_with_spacing(doc, p_kp2, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5, font_size=12)
    
    acknowledgements = [
        "Allah SWT atas limpahan berkah, kesehatan, dan kelancaran yang senantiasa diberikan.",
        "Kedua Orang Tua dan keluarga tercinta yang selalu mendoakan, memberikan dukungan penuh, serta motivasi di setiap langkah kehidupan penulis.",
        "Prof. Dr. Nyayu Khodijah, S.Ag., M.Si. selaku Rektor UIN Raden Fatah Palembang.",
        "Dr. Ir. Hartono, M.A. selaku Dekan Fakultas Sains dan Teknologi UIN Raden Fatah Palembang.",
        "Ibu Gusmelia Testiana, M.Kom. selaku Ketua Program Studi Sistem Informasi Fakultas Sains dan Teknologi UIN Raden Fatah Palembang.",
        "Ibu Indah Hidayanti, M.Kom. selaku Dosen Pembimbing Kerja Praktik yang telah dengan sabar memberikan arahan, saran, dan bimbingan yang sangat berharga selama penyusunan laporan ini.",
        "Kepala Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan beserta jajaran yang telah memberikan izin dan memfasilitasi penulis selama melakukan Kerja Praktik.",
        "Pembimbing Lapangan dan seluruh staf Sub Bagian Umum Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan atas bimbingan praktis, keramahtamahan, dan kerja sama selama pelaksanaan Kerja Praktik.",
        "Teman-teman mahasiswa Program Studi Sistem Informasi angkatan 2023 dan semua pihak yang tidak dapat penulis sebutkan satu per satu, yang telah membantu serta memberikan semangat dalam penyelesaian laporan ini."
    ]
    
    for i, ack in enumerate(acknowledgements, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.25)
        p.paragraph_format.space_after = Pt(6)
        p.paragraph_format.line_spacing = 1.5
        run_num = p.add_run(f"{i}. ")
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(ack)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)
        
    p_kp3 = (
        "\nPenulis menyadari bahwa Laporan Kerja Praktik ini masih jauh dari sempurna. Oleh karena itu, "
        "penulis mengharapkan kritik dan saran yang bersifat membangun demi perbaikan di masa mendatang. "
        "Semoga laporan ini dapat bermanfaat bagi penulis khususnya, serta bagi pembaca dan perkembangan ilmu "
        "pengetahuan pada umumnya.\n\n"
        "Wassalamu'alaikum Warahmatullahi Wabarakatuh."
    )
    add_paragraph_with_spacing(doc, p_kp3, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=24, line_spacing=1.5, font_size=12)
    
    table_penulis = doc.add_table(rows=3, cols=1)
    table_penulis.alignment = WD_TABLE_ALIGNMENT.RIGHT
    make_cell_borderless(table_penulis.cell(0, 0))
    make_cell_borderless(table_penulis.cell(1, 0))
    make_cell_borderless(table_penulis.cell(2, 0))
    
    table_penulis.cell(0, 0).paragraphs[0].text = "Palembang, Agustus 2026"
    table_penulis.cell(1, 0).paragraphs[0].text = "\n\n"
    table_penulis.cell(2, 0).paragraphs[0].text = "Penulis"
    table_penulis.cell(2, 0).paragraphs[0].runs[0].bold = True
    
    for row in table_penulis.rows:
        p = row.cells[0].paragraphs[0]
        p.alignment = WD_ALIGN_PARAGRAPH.CENTER
        if p.runs:
            p.runs[0].font.name = 'Times New Roman'
            p.runs[0].font.size = Pt(12)
            
    doc.add_page_break()
    
    # --- PAGE 6: DAFTAR ISI ---
    add_heading_with_spacing(doc, "DAFTAR ISI", level=1)
    add_paragraph_with_spacing(doc, "[ DAFTAR ISI DARI MICROSOFT WORD DAPAT DIGENERATE OTOMATIS OLEH PENGGUNA ]", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=12, italic=True, font_size=11)
    doc.add_page_break()
    
    # --- PAGE 7: DAFTAR TABEL ---
    add_heading_with_spacing(doc, "DAFTAR TABEL", level=1)
    add_paragraph_with_spacing(doc, "[ DAFTAR TABEL DARI MICROSOFT WORD DAPAT DIGENERATE OTOMATIS OLEH PENGGUNA ]", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=12, italic=True, font_size=11)
    doc.add_page_break()
    
    # --- PAGE 8: DAFTAR GAMBAR ---
    add_heading_with_spacing(doc, "DAFTAR GAMBAR", level=1)
    add_paragraph_with_spacing(doc, "[ DAFTAR GAMBAR DARI MICROSOFT WORD DAPAT DIGENERATE OTOMATIS OLEH PENGGUNA ]", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=12, italic=True, font_size=11)
    doc.add_page_break()
    
    # --- BAB I: PENDAHULUAN ---
    add_heading_with_spacing(doc, "BAB I\nPENDAHULUAN", level=1)
    
    add_heading_with_spacing(doc, "1.1 Latar Belakang", level=2)
    p_latar1 = (
        "Di era transformasi digital saat ini, instansi pemerintahan dituntut untuk meningkatkan efisiensi dan transparansi "
        "dalam pelaksanaan administrasi perkantoran. Penggunaan sistem informasi berbasis web menjadi solusi utama dalam "
        "menggantikan proses manual yang lambat dan rentan terhadap kesalahan. Dinas Kelautan dan Perikanan (DKP) Provinsi "
        "Sumatera Selatan sebagai salah satu perangkat daerah di lingkungan Pemerintah Provinsi Sumatera Selatan, memiliki volume "
        "dokumen dinas dan disposisi yang sangat tinggi setiap harinya. Dokumen-dokumen ini meliputi surat masuk dari instansi lain, "
        "surat keluar untuk koordinasi, serta instruksi disposisi dari kepala dinas kepada masing-masing kepala bidang, kepala seksi, "
        "maupun staf pelaksana."
    )
    add_paragraph_with_spacing(doc, p_latar1, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5, font_size=12)
    
    p_latar2 = (
        "Sebelum dikembangkannya Sistem Informasi Disposisi Internal (SIDI), pengelolaan persuratan dan disposisi pada DKP Provinsi "
        "Sumatera Selatan masih dilakukan secara manual. Staf Sub Bagian Umum mencatat surat masuk secara manual pada buku agenda fisik, "
        "kemudian lembar disposisi cetak dilampirkan pada fisik surat untuk dimintakan instruksi dari Kepala Dinas. Proses ini "
        "memiliki kelemahan yang cukup signifikan, di antaranya risiko kerusakan atau hilangnya dokumen fisik, lambatnya proses "
        "pendistribusian instruksi disposisi kepada penerima, dan sulitnya melacak status tindak lanjut disposisi. Selain itu, pimpinan "
        "mengalami kesulitan untuk memantau beban kerja staf dan riwayat surat secara real-time."
    )
    add_paragraph_with_spacing(doc, p_latar2, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5, font_size=12)
    
    p_latar3 = (
        "Oleh karena itu, diperlukan sebuah solusi berbasis web untuk mengotomatisasi dan mendigitalisasi proses persuratan "
        "dan disposisi internal. Melalui Kerja Praktik ini, dikembangkan Sistem Informasi Disposisi Internal (SIDI) yang menggunakan "
        "framework Laravel untuk backend, Tailwind CSS untuk visual premium, dan database MySQL sebagai penyimpanan data. Sistem "
        "ini memungkinkan unggah file PDF surat masuk, pengisian formulir disposisi secara online, pengiriman notifikasi instan via email, "
        "serta monitoring status pembacaan surat. Dengan SIDI, diharapkan tata kelola persuratan di Dinas Kelautan dan Perikanan "
        "Provinsi Sumatera Selatan menjadi lebih cepat, akurat, aman, dan akuntabel."
    )
    add_paragraph_with_spacing(doc, p_latar3, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5, font_size=12)
    
    add_heading_with_spacing(doc, "1.2 Rumusan Masalah", level=2)
    p_rumus = "Berdasarkan latar belakang di atas, rumusan masalah dalam Kerja Praktik ini adalah:"
    add_paragraph_with_spacing(doc, p_rumus, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=6, line_spacing=1.5, font_size=12)
    
    p_r1 = doc.add_paragraph()
    p_r1.paragraph_format.left_indent = Inches(0.25)
    p_r1.paragraph_format.space_after = Pt(4)
    p_r1.add_run("1. ").bold = True
    p_r1.add_run("Bagaimana merancang dan membangun Sistem Informasi Disposisi Internal (SIDI) berbasis website yang aman dan responsif pada Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan?")
    
    p_r2 = doc.add_paragraph()
    p_r2.paragraph_format.left_indent = Inches(0.25)
    p_r2.paragraph_format.space_after = Pt(12)
    p_r2.add_run("2. ").bold = True
    p_r2.add_run("Bagaimana mengimplementasikan peran otorisasi multi-level (Admin, Kabid, Kasi, Staff) serta fitur notifikasi email otomatis dalam proses disposisi internal?")
    
    for p in (p_r1, p_r2):
        for run in p.runs:
            run.font.name = 'Times New Roman'
            run.font.size = Pt(12)
            
    add_heading_with_spacing(doc, "1.3 Batasan Masalah", level=2)
    add_paragraph_with_spacing(doc, "Batasan masalah dalam pengembangan SIDI ini adalah sebagai berikut:", space_after=6)
    
    limitations = [
        "Sistem hanya berfokus pada digitalisasi surat masuk, surat keluar, dan disposisi antar pengguna internal Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan.",
        "Otorisasi pengguna dibatasi pada empat tingkatan (role), yaitu: Admin, Kepala Bidang (Kabid), Kepala Seksi (Kasi), dan Staff.",
        "Sistem menggunakan framework Laravel versi terbaru dengan Tailwind CSS untuk tampilan antarmuka dan MySQL sebagai basis data.",
        "Notifikasi yang diimplementasikan terbatas pada notifikasi email otomatis menggunakan SMTP Gmail ketika ada disposisi baru."
    ]
    for i, lim in enumerate(limitations, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.25)
        p.paragraph_format.space_after = Pt(4)
        p.paragraph_format.line_spacing = 1.5
        run_num = p.add_run(f"{i}. ")
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(lim)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)
        
    add_heading_with_spacing(doc, "1.4 Tujuan Kerja Praktik", level=2)
    add_paragraph_with_spacing(doc, "Tujuan yang ingin dicapai dalam pelaksanaan Kerja Praktik ini adalah:", space_after=6)
    
    tujuan = [
        "Membangun aplikasi Sistem Informasi Disposisi Internal (SIDI) berbasis website yang dapat mempermudah tata kelola persuratan di Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan.",
        "Menghilangkan ketergantungan pada lembar disposisi kertas fisik untuk mempercepat distribusi disposisi dari atasan ke bawahan.",
        "Meminimalisir risiko kehilangan berkas surat penting dengan menyimpan dokumen pendukung dalam format PDF terenkripsi pada penyimpanan server lokal."
    ]
    for i, tuj in enumerate(tujuan, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.25)
        p.paragraph_format.space_after = Pt(4)
        p.paragraph_format.line_spacing = 1.5
        run_num = p.add_run(f"{i}. ")
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(tuj)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)
        
    add_heading_with_spacing(doc, "1.5 Manfaat Kerja Praktik", level=2)
    add_paragraph_with_spacing(doc, "Adapun manfaat yang diperoleh dari Kerja Praktik ini adalah:", space_after=6)
    
    add_paragraph_with_spacing(doc, "1. Bagi Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan:", bold=True, space_after=4)
    manfaat_dinas = [
        "Meningkatkan efisiensi waktu dalam pencatatan dan pencarian data arsip surat masuk dan keluar.",
        "Meningkatkan akurasi dan kecepatan distribusi instruksi disposisi dari pimpinan ke masing-masing bidang/seksi.",
        "Mempunyai arsip digital terpusat yang aman dari risiko kerusakan fisik."
    ]
    for i, md in enumerate(manfaat_dinas, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.5)
        p.paragraph_format.space_after = Pt(4)
        p.paragraph_format.line_spacing = 1.5
        run_num = p.add_run(f"a{i}. " if i==1 else f"b. " if i==2 else f"c. ") # simple representation
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(md)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)
        
    add_paragraph_with_spacing(doc, "2. Bagi Penulis (Mahasiswa):", bold=True, space_after=4)
    manfaat_mhs = [
        "Mendapatkan pengalaman nyata dalam merancang, membangun, dan menguji aplikasi web di lingkungan instansi pemerintahan.",
        "Memperdalam pemahaman tentang framework Laravel, database relational MySQL, dan integrasi mail server.",
        "Melatih kemampuan berkomunikasi, menganalisis kebutuhan sistem pengguna, serta menyelesaikan masalah secara taktis."
    ]
    for i, mm in enumerate(manfaat_mhs, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.5)
        p.paragraph_format.space_after = Pt(4)
        p.paragraph_format.line_spacing = 1.5
        run_num = p.add_run(f"a{i}. " if i==1 else f"b. " if i==2 else f"c. ")
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(mm)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)

    add_heading_with_spacing(doc, "1.6 Tempat dan Waktu Pelaksanaan", level=2)
    add_paragraph_with_spacing(doc, "1. Tempat Pelaksanaan Kerja Praktik:", bold=True, space_after=2)
    add_paragraph_with_spacing(doc, "Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan\nAlamat: Jalan Pangeran Ratu, 15 Ulu, Kecamatan Jakabaring, Kota Palembang, Sumatera Selatan (Kode Pos 30257).", align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=6)
    
    add_paragraph_with_spacing(doc, "2. Waktu Pelaksanaan Kerja Praktik:", bold=True, space_after=2)
    add_paragraph_with_spacing(doc, "Kerja Praktik dilaksanakan selama 40 hari kerja, terhitung mulai tanggal 1 Juli hingga 25 Agustus 2026, dengan jam kerja Senin-Jumat pukul 07.30 sampai 16.00 WIB.", align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    doc.add_page_break()
    
    # --- BAB II: ANALISIS SITUASI UMUM ---
    add_heading_with_spacing(doc, "BAB II\nANALISIS SITUASI UMUM", level=1)
    
    add_heading_with_spacing(doc, "2.1 Profil Instansi", level=2)
    p_profil = (
        "Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan merupakan instansi pemerintah daerah tingkat provinsi "
        "yang berwenang merumuskan dan melaksanakan kebijakan teknis di bidang kelautan dan perikanan. Berdasarkan "
        "letak geografis dan potensi sumber daya airnya, Sumatera Selatan memiliki wilayah perairan darat (sungai, "
        "rawa, danau) yang sangat luas mencapai lebih dari 2.5 juta hektar. Dinas Kelautan dan Perikanan mengemban tugas "
        "penting untuk membina nelayan, mengembangkan pembudidayaan ikan air tawar, melestarikan lingkungan perairan, "
        "serta mengatur tata niaga hasil perikanan guna mendukung ketahanan pangan nasional."
    )
    add_paragraph_with_spacing(doc, p_profil, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5, font_size=12)
    
    add_heading_with_spacing(doc, "2.2 Visi dan Misi", level=2)
    add_paragraph_with_spacing(doc, "Sebagai bagian dari perangkat daerah Provinsi Sumatera Selatan, visi dan misi Dinas Kelautan dan Perikanan diselaraskan dengan visi dan misi Gubernur Sumatera Selatan, yaitu:", space_after=6)
    
    add_paragraph_with_spacing(doc, "Visi:", bold=True, space_after=4)
    add_paragraph_with_spacing(doc, "\"Sumatera Selatan Maju untuk Semua Berbasis Pembangunan Berkelanjutan.\"", italic=True, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=12)
    
    add_paragraph_with_spacing(doc, "Misi:", bold=True, space_after=4)
    misi_items = [
        "Membangun ekonomi kerakyatan berbasis potensi lokal di sektor kelautan dan perikanan guna mengentaskan kemiskinan.",
        "Meningkatkan pengelolaan potensi perairan darat yang ramah lingkungan demi keberlanjutan sumber daya ikan.",
        "Mewujudkan pelayanan publik prima yang didukung oleh pemanfaatan teknologi informasi pada seluruh instansi daerah."
    ]
    for i, ms in enumerate(misi_items, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.25)
        p.paragraph_format.space_after = Pt(4)
        p.paragraph_format.line_spacing = 1.5
        run_num = p.add_run(f"{i}. ")
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(ms)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)
        
    add_heading_with_spacing(doc, "2.3 Logo Instansi", level=2)
    add_paragraph_with_spacing(doc, "[ LOGO DINAS KELAUTAN DAN PERIKANAN / PEMPROV SUMATERA SELATAN ]\n(Silakan insert gambar logo di sini)", align=WD_ALIGN_PARAGRAPH.CENTER, space_after=12, italic=True, font_size=10)
    
    add_heading_with_spacing(doc, "2.4 Struktur Organisasi", level=2)
    add_paragraph_with_spacing(doc, "Struktur organisasi Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan dipimpin oleh seorang Kepala Dinas yang dibantu oleh seorang Sekretaris. Sekretariat membawahi beberapa sub-bagian, salah satunya adalah Sub Bagian Umum dan Kepegawaian yang memiliki tugas penting mengelola persuratan. Selain itu terdapat beberapa bidang teknis seperti Bidang Perikanan Tangkap, Bidang Perikanan Budidaya, Bidang Pengawasan Sumber Daya Kelautan dan Perikanan, serta Bidang Pengolahan dan Pemasaran Hasil Perikanan.", align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    doc.add_page_break()
    
    # --- BAB III: ANALISIS SITUASI KHUSUS ---
    add_heading_with_spacing(doc, "BAB III\nANALISIS SITUASI KHUSUS", level=1)
    
    add_heading_with_spacing(doc, "3.1 Struktur Organisasi Sub Bagian Umum & Kepegawaian", level=2)
    p_struktur_khusus = (
        "Sub Bagian Umum dan Kepegawaian merupakan bagian dari Sekretariat Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan. "
        "Sub bagian ini dipimpin oleh seorang Kepala Sub Bagian (Kasubag) Umum dan Kepegawaian. Fungsi utamanya adalah "
        "menyelenggarakan pelayanan administrasi umum, rumah tangga, kearsipan, serta pengelolaan kepegawaian. "
        "Dalam hal pengelolaan surat menyurat, sub-bagian ini menugaskan staf khusus sebagai penerima surat masuk, "
        "pembuat agenda surat, pengetik surat keluar, dan pengarsip dokumen."
    )
    add_paragraph_with_spacing(doc, p_struktur_khusus, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    add_heading_with_spacing(doc, "3.2 Tugas dan Wewenang dalam Kearsipan Surat", level=2)
    add_paragraph_with_spacing(doc, "Tugas pokok staf kearsipan surat di Sub Bagian Umum meliputi:", space_after=6)
    tugas_arsip = [
        "Menerima dan memeriksa kelengkapan surat masuk dari instansi pemerintah, organisasi kemasyarakatan, maupun perorangan.",
        "Mencatat data surat masuk ke dalam buku agenda surat masuk meliputi nomor surat, tanggal surat, asal pengirim, dan perihal.",
        "Membuat Lembar Disposisi fisik dan meneruskan surat bersama lembar disposisi kepada Kepala Dinas melalui Sekretaris Dinas.",
        "Mendistribusikan surat masuk yang telah diberi catatan disposisi oleh Kepala Dinas kepada bidang/seksi tujuan.",
        "Mencatat dan memberikan nomor agenda untuk surat keluar yang telah ditandatangani oleh pejabat yang berwenang."
    ]
    for i, ta in enumerate(tugas_arsip, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.25)
        p.paragraph_format.space_after = Pt(4)
        p.paragraph_format.line_spacing = 1.5
        run_num = p.add_run(f"{i}. ")
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(ta)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)
        
    doc.add_page_break()
    
    # --- BAB IV: IDENTIFIKASI DAN PRIORITAS MASALAH ---
    add_heading_with_spacing(doc, "BAB IV\nIDENTIFIKASI DAN PRIORITAS MASALAH", level=1)
    
    add_heading_with_spacing(doc, "4.1 Identifikasi Masalah", level=2)
    p_identifikasi = (
        "Berdasarkan observasi langsung dan diskusi bersama staf Sub Bagian Umum Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan, "
        "ditemukan beberapa kendala utama dalam pengelolaan tata kearsipan surat masuk dan disposisi internal, yaitu:"
    )
    add_paragraph_with_spacing(doc, p_identifikasi, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=6)
    
    masalah_items = [
        "Pencatatan Surat Masuk Masih Manual: Staf harus menulis secara manual di buku agenda besar. Hal ini membutuhkan waktu lama dan rentan terhadap kesalahan penulisan.",
        "Risiko Kerusakan dan Kehilangan Dokumen Fisik Tinggi: Surat fisik sering kali dipinjam oleh bidang lain untuk ditindaklanjuti tanpa adanya sistem pencatatan peminjaman yang teratur, sehingga surat rawan hilang.",
        "Distribusi Disposisi Lambat: Lembar disposisi fisik harus diantarkan langsung ke ruangan masing-masing kepala bidang. Jika pejabat yang bersangkutan sedang dinas luar kota, disposisi akan tertunda.",
        "Pencarian Berkas Lama: Untuk mencari surat tertentu dari bulan-bulan sebelumnya, staf harus membuka lembar demi lembar buku agenda fisik dan mencari tumpukan lemari arsip secara manual."
    ]
    for i, mi in enumerate(masalah_items, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.25)
        p.paragraph_format.space_after = Pt(4)
        p.paragraph_format.line_spacing = 1.5
        run_num = p.add_run(f"{i}. ")
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(mi)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)
        
    add_heading_with_spacing(doc, "4.2 Prioritas Masalah", level=2)
    p_prioritas = (
        "Dari beberapa identifikasi masalah di atas, prioritas masalah utama yang harus segera diselesaikan adalah "
        "lambatnya distribusi disposisi internal serta rentannya berkas fisik hilang karena mobilitas surat fisik yang tinggi. "
        "Kedua masalah ini berdampak langsung pada kecepatan koordinasi kerja antar bidang di Dinas Kelautan dan Perikanan "
        "Provinsi Sumatera Selatan."
    )
    add_paragraph_with_spacing(doc, p_prioritas, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    add_heading_with_spacing(doc, "4.3 Solusi Masalah", level=2)
    p_solusi = (
        "Solusi yang ditawarkan untuk menyelesaikan prioritas masalah tersebut adalah pembangunan aplikasi web "
        "\"Sistem Informasi Disposisi Internal (SIDI)\". Melalui SIDI, dokumen fisik diunggah dalam format PDF, "
        "pimpinan memberikan disposisi secara digital, dan sistem secara otomatis mengirimkan notifikasi surat masuk "
        "melalui email kepada penerima disposisi. Dengan demikian, proses pengarsipan, pencarian, dan distribusi "
        "instruksi pimpinan dapat berjalan secara instan, aman, dan tercatat di database."
    )
    add_paragraph_with_spacing(doc, p_solusi, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    add_heading_with_spacing(doc, "4.4 Metode Penelitian", level=2)
    p_metode = (
        "Metode pengembangan perangkat lunak yang digunakan dalam penelitian Kerja Praktik ini adalah "
        "metode Rapid Application Development (RAD). Tahapan dalam metode RAD terdiri dari 4 fase utama, yaitu:\n"
        "1. Requirements Planning (Perencanaan Kebutuhan): Melakukan observasi dan wawancara untuk mendefinisikan kebutuhan fungsional sistem.\n"
        "2. User Design (Perancangan Pengguna): Merancang antarmuka sistem (mockup) serta membuat pemodelan Unified Modeling Language (UML) seperti Use Case Diagram, Class Diagram, dan Activity Diagram.\n"
        "3. Construction (Konstruksi/Pembuatan Sistem): Menerjemahkan rancangan ke dalam baris kode menggunakan bahasa PHP dengan framework Laravel dan database MySQL.\n"
        "4. Implementation (Implementasi): Melakukan pengujian sistem bersama staf instansi untuk memastikan seluruh fitur berjalan lancar sebelum digunakan sepenuhnya."
    )
    add_paragraph_with_spacing(doc, p_metode, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5)
    
    doc.add_page_break()
    
    # --- BAB V: HASIL DAN PEMBAHASAN ---
    add_heading_with_spacing(doc, "BAB V\nHASIL DAN PEMBAHASAN", level=1)
    
    add_heading_with_spacing(doc, "5.1 Hasil Perancangan Sistem", level=2)
    p_perancangan = (
        "Perancangan Sistem Informasi Disposisi Internal (SIDI) dimodelkan menggunakan Unified Modeling Language (UML) "
        "yang menggambarkan aspek fungsionalitas dan struktural dari sistem yang dibangun."
    )
    add_paragraph_with_spacing(doc, p_perancangan, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    add_heading_with_spacing(doc, "1. Use Case Diagram", level=3)
    p_usecase = (
        "Use Case Diagram menggambarkan interaksi antara pengguna (aktor) dengan fitur-fitur yang ada di dalam sistem. "
        "SIDI memiliki empat aktor utama, yaitu:\n"
        "- Admin: Mengelola data user, data bidang, dan melihat riwayat surat secara keseluruhan.\n"
        "- Kepala Bidang (Kabid): Menerima surat masuk dari Kepala Dinas, membuat disposisi baru untuk diteruskan ke Kepala Seksi (Kasi) atau langsung ke Staff.\n"
        "- Kepala Seksi (Kasi): Menerima disposisi dari Kabid, mengisi catatan instruksi disposisi lanjutan, dan meneruskannya ke Staff pelaksana.\n"
        "- Staff: Menerima surat disposisi dan mengunduh berkas lampiran surat PDF untuk dikerjakan."
    )
    add_paragraph_with_spacing(doc, p_usecase, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    add_heading_with_spacing(doc, "2. Class Diagram", level=3)
    p_class = (
        "Class Diagram menggambarkan struktur database relasional yang digunakan oleh SIDI. Database dirancang menggunakan "
        "tiga entitas utama, yaitu:\n"
        "- User: Menyimpan informasi pengguna (id, name, email, password, role, bidang_id).\n"
        "- Bidang: Menyimpan data bidang/divisi di DKP Sumsel (id, nama_bidang).\n"
        "- Surat: Menyimpan data surat dan disposisi (id, pengirim_id, penerima_id, perihal, isi, file, is_read, surat_dari, tanggal_surat, no_agenda, sifat)."
    )
    add_paragraph_with_spacing(doc, p_class, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    add_heading_with_spacing(doc, "5.2 Antarmuka Aplikasi (User Interface)", level=2)
    p_ui = (
        "Konstruksi antarmuka SIDI dibangun secara modern dengan layout dashboard responsif menggunakan Tailwind CSS. "
        "Berikut penjelasan halaman-halaman utama pada aplikasi:"
    )
    add_paragraph_with_spacing(doc, p_ui, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12)
    
    ui_pages = [
        ("1. Halaman Login:", "Halaman awal di mana pengguna memasukkan email dan password. Sistem membatasi akses agar hanya akun terdaftar yang dapat masuk."),
        ("2. Halaman Dashboard Admin:", "Menampilkan metrik jumlah pengguna terdaftar dan jumlah bidang di Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan. Admin juga memiliki menu pengelolaan (CRUD) User dan Bidang."),
        ("3. Halaman Dashboard Staff / Kabid / Kasi:", "Menampilkan jumlah surat masuk, surat keluar, dan jumlah disposisi yang belum dibaca secara grafis. Terdapat daftar surat terbaru yang masuk."),
        ("4. Halaman Kelola Surat & Disposisi:", "Menampilkan tabel surat masuk (surat yang diterima) dan surat keluar (surat yang dikirim). Dilengkapi tombol untuk membuat surat baru, mengunduh file lampiran PDF, dan menghapus berkas."),
        ("5. Halaman Tulis Surat / Buat Disposisi Baru:", "Berisi formulir input detail surat seperti Nomor Surat, Perihal, Surat Dari, Tanggal Surat, No. Agenda, Sifat Surat (Biasa, Penting, Segera, Amat Segera), file lampiran PDF, serta dropdown Bidang dan Staff tujuan. Formulir ini terintegrasi dengan PDF.js sehingga pengguna dapat melihat pratinjau PDF secara live saat diunggah."),
        ("6. Halaman Detail Surat (Disposisi):", "Menampilkan informasi surat secara lengkap, pembacaan live dokumen PDF, serta catatan disposisi pimpinan. Status surat otomatis berubah menjadi 'Sudah Dibaca' jika penerima membuka halaman ini.")
    ]
    for title, desc in ui_pages:
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.25)
        p.paragraph_format.space_after = Pt(4)
        p.paragraph_format.line_spacing = 1.5
        run_title = p.add_run(title + " ")
        run_title.font.name = 'Times New Roman'
        run_title.font.size = Pt(12)
        run_title.bold = True
        run_desc = p.add_run(desc)
        run_desc.font.name = 'Times New Roman'
        run_desc.font.size = Pt(12)
        
    add_heading_with_spacing(doc, "5.3 Pengujian Sistem (Testing)", level=2)
    add_paragraph_with_spacing(doc, "Pengujian aplikasi dilakukan menggunakan metode Black Box Testing untuk menguji fungsionalitas tombol, validasi formulir, dan hak akses otorisasi.", space_after=12)
    
    # Add testing table
    table_test = doc.add_table(rows=10, cols=5)
    table_test.alignment = WD_TABLE_ALIGNMENT.CENTER
    table_test.autofit = False
    
    # Set widths for columns
    col_widths = [Inches(0.4), Inches(2.2), Inches(1.8), Inches(1.8), Inches(0.8)]
    for row in table_test.rows:
        for idx, w in enumerate(col_widths):
            row.cells[idx].width = w
            
    # Set borders and header style
    headers = ["No", "Fitur yang Diuji", "Langkah Pengujian", "Hasil yang Diharapkan", "Kesimpulan"]
    hdr_row = table_test.rows[0]
    for idx, name in enumerate(headers):
        cell = hdr_row.cells[idx]
        cell.paragraphs[0].text = name
        cell.paragraphs[0].alignment = WD_ALIGN_PARAGRAPH.CENTER
        cell.paragraphs[0].runs[0].bold = True
        cell.paragraphs[0].runs[0].font.name = 'Times New Roman'
        cell.paragraphs[0].runs[0].font.size = Pt(10)
        # Add light gray background to header
        shading = parse_xml(r'<w:shd {} w:fill="E6E6E6"/>'.format(nsdecls('w')))
        cell._tc.get_or_add_tcPr().append(shading)
        
    tests_data = [
        ("1", "Login Sistem", "Memasukkan email dan password valid, klik Login", "Sistem memverifikasi akun dan masuk ke Dashboard Utama", "Berhasil"),
        ("2", "Validasi Login", "Memasukkan email/password salah, klik Login", "Menampilkan pesan error 'Username atau Password salah'", "Berhasil"),
        ("3", "Unggah Dokumen PDF", "Memilih file PDF berukuran 12MB", "Menampilkan validasi error 'Maksimal ukuran file: 10MB'", "Berhasil"),
        ("4", "Kirim Surat Baru", "Mengisi formulir surat masuk lengkap, klik Kirim", "Data tersimpan di database, lampiran tersimpan di storage", "Berhasil"),
        ("5", "Notifikasi Email", "Mengirim surat ke Penerima", "Email notifikasi dikirim otomatis melalui SMTP Gmail", "Berhasil"),
        ("6", "Detail Surat (Read Status)", "Penerima membuka surat masuk", "Status surat berubah dari 'Belum Dibaca' menjadi 'Sudah Dibaca'", "Berhasil"),
        ("7", "Hapus Surat", "Mengklik Hapus pada surat keluar oleh pengirim", "Data terhapus di database dan file lampiran terhapus di disk", "Berhasil"),
        ("8", "Manajemen User (Admin)", "Admin menambah user baru dengan role 'Kasi'", "User baru terbuat dengan role Kasi dan terhubung ke Bidang", "Berhasil"),
        ("9", "Logout Akun", "Mengklik tombol Logout", "Sesi berakhir dan dialihkan kembali ke halaman Login", "Berhasil")
    ]
    
    for row_idx, data in enumerate(tests_data, 1):
        row = table_test.rows[row_idx]
        for col_idx, text in enumerate(data):
            cell = row.cells[col_idx]
            cell.paragraphs[0].text = text
            cell.paragraphs[0].runs[0].font.name = 'Times New Roman'
            cell.paragraphs[0].runs[0].font.size = Pt(9.5)
            if col_idx == 0 or col_idx == 4:
                cell.paragraphs[0].alignment = WD_ALIGN_PARAGRAPH.CENTER
            else:
                cell.paragraphs[0].alignment = WD_ALIGN_PARAGRAPH.LEFT
                
    # Style table borders
    for row in table_test.rows:
        for cell in row.cells:
            set_cell_border(
                cell,
                top={"sz": 4, "val": "single", "color": "D0D0D0"},
                bottom={"sz": 4, "val": "single", "color": "D0D0D0"},
                left={"sz": 4, "val": "single", "color": "D0D0D0"},
                right={"sz": 4, "val": "single", "color": "D0D0D0"}
            )
            
    doc.add_page_break()
    
    # --- BAB VI: PENUTUP ---
    add_heading_with_spacing(doc, "BAB VI\nPENUTUP", level=1)
    
    add_heading_with_spacing(doc, "6.1 Kesimpulan", level=2)
    p_kesimpulan = (
        "Berdasarkan pelaksanaan Kerja Praktik dan pengembangan Sistem Informasi Disposisi Internal (SIDI) "
        "pada Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan, dapat ditarik beberapa kesimpulan sebagai berikut:\n"
        "1. Aplikasi SIDI berhasil dibangun secara responsif menggunakan framework Laravel, database MySQL, dan Tailwind CSS.\n"
        "2. Sistem ini berhasil mengotomatisasi proses disposisi surat masuk dari yang sebelumnya manual menggunakan kertas "
        "menjadi digital, sehingga mempercepat waktu penyampaian disposisi dari pimpinan ke masing-masing bidang/staf secara real-time.\n"
        "3. Fitur live preview PDF menggunakan PDF.js mempermudah pembacaan surat tanpa perlu mengunduh berkas terlebih dahulu.\n"
        "4. Otorisasi multi-level berhasil mengamankan akses data surat sesuai dengan jabatan dan wewenang kerja masing-masing pengguna."
    )
    add_paragraph_with_spacing(doc, p_kesimpulan, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5)
    
    add_heading_with_spacing(doc, "6.2 Saran", level=2)
    p_saran = (
        "Untuk pengembangan SIDI lebih lanjut di masa mendatang, disarankan beberapa hal sebagai berikut:\n"
        "1. Penambahan fitur push notification pada browser atau integrasi dengan API WhatsApp untuk notifikasi disposisi selain email.\n"
        "2. Penyediaan fitur tanda tangan elektronik (e-signature) yang tersertifikasi pada lembar disposisi digital untuk memperkuat keabsahan dokumen.\n"
        "3. Pembuatan backup basis data terjadwal secara otomatis di cloud server untuk meningkatkan keamanan data dari risiko bencana fisik."
    )
    add_paragraph_with_spacing(doc, p_saran, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=12, line_spacing=1.5)
    
    doc.add_page_break()
    
    # --- DAFTAR PUSTAKA ---
    add_heading_with_spacing(doc, "DAFTAR PUSTAKA", level=1)
    
    pustaka = [
        "Doni Riswanda, A. T. (2021). Analisis dan Perancangan Sistem Informasi Manajemen Pemesanan Barang Berbasis Online. Jurnal Informatika dan Rekayasa Perangkat Lunak (JATIKA), 2(1), 10-18.",
        "Dr. H. A. Rusdiana, M. (2014). Sistem Informasi Manajemen. Bandung: Pustaka Setia.",
        "Farahdiba, H. (2024). Analisis Pengelolaan Arsip Digital Pada PT Anugrah Alam Karunia Abadi. Journal of Administrative and Social Science (JASS), 5(2), 85-92.",
        "Hartono, B. (2022). Pengembangan Sistem Informasi. Yogyakarta: Andi Offset.",
        "Masan Abdi Wicaksono, C. R. (2021). Rancang Bangun Sistem Informasi Arsip Surat Menggunakan Metode Prototype. Jurnal Teknik Informatika dan Sistem Informasi, 8(3), 421-430.",
        "Ramen A Purba, J. S. (2020). Pengembangan Sistem Informasi, Analisis, Pemodalan. Jakarta: Yayasan Kita Menulis.",
        "Suryadi, A. (2019). Rancang Bangun Sistem Pengelolaan Arsip Surat Berbasis Web Menggunakan Metode Waterfall. Jurnal Khatulistiwa Informatika, 7(1), 13-20.",
        "Veri Ilhadi, S. R. (2024). Pendampingan Teknologi Informasi Berkelanjutan dalam Peningkatan Pengembangan Digitalisasi di Bidang Pelayanan Publik dan Kearsipan. Jurnal Malikussaleh Mengabdi, 3(1), 45-52.",
        "Widarti, E. (2024). Buku Ajar Sistem Informasi. Surabaya: CV. Global Aksara."
    ]
    
    for p_item in pustaka:
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.5)
        p.paragraph_format.first_line_indent = Inches(-0.5)
        p.paragraph_format.space_after = Pt(8)
        p.paragraph_format.line_spacing = 1.15
        run = p.add_run(p_item)
        run.font.name = 'Times New Roman'
        run.font.size = Pt(11.5)
        p.alignment = WD_ALIGN_PARAGRAPH.JUSTIFY
        
    doc.add_page_break()
    
    # --- LAMPIRAN ---
    add_heading_with_spacing(doc, "LAMPIRAN", level=1)
    
    lampiran_items = [
        "Lampiran 1: Surat Pengantar Kerja Praktik dari Fakultas Sains dan Teknologi UIN Raden Fatah Palembang.",
        "Lampiran 2: Surat Tugas Magang dari Dekan Fakultas Sains dan Teknologi.",
        "Lampiran 3: Kartu Bimbingan Kerja Praktik dengan Dosen Pembimbing Lapangan.",
        "Lampiran 4: Surat Keterangan Selesai Kerja Praktik (Magang) dari Dinas Kelautan dan Perikanan Provinsi Sumatera Selatan.",
        "Lampiran 5: Daftar Hadir Absensi Kerja Praktik.",
        "Lampiran 6: Lembar Penilaian Hasil Kerja Praktik dari Pembimbing Lapangan."
    ]
    for i, lam in enumerate(lampiran_items, 1):
        p = doc.add_paragraph()
        p.paragraph_format.left_indent = Inches(0.25)
        p.paragraph_format.space_after = Pt(6)
        p.paragraph_format.line_spacing = 1.3
        run_num = p.add_run(f"{i}. ")
        run_num.font.name = 'Times New Roman'
        run_num.font.size = Pt(12)
        run_num.bold = True
        run_text = p.add_run(lam)
        run_text.font.name = 'Times New Roman'
        run_text.font.size = Pt(12)
        
    # Save the document
    output_path = "Laporan_Kerja_Praktik_SIDI.docx"
    doc.save(output_path)
    print(f"Laporan berhasil dibuat di: {os.path.abspath(output_path)}")

if __name__ == "__main__":
    main()
