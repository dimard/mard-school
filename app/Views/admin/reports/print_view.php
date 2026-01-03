<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Rapor - <?= esc($student['full_name']) ?></title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 210mm;
            /* A4 width */
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .no-border {
            border: none !important;
        }

        .header {
            margin-bottom: 30px;
        }

        .student-info td {
            border: none;
            padding: 5px 0;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }

            .container {
                width: 100%;
                max-width: none;
            }

            @page {
                margin: 1cm;
            }
        }
    </style>
</head>

<body>

    <div class="no-print"
        style="position: fixed; top: 20px; right: 20px; background: #eee; padding: 10px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <button onclick="window.print()"
            style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #0d6efd; color: white; border: none; border-radius: 4px;">Unduh
            PDF / Cetak</button>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <?= $settings['header_content'] ?>
        </div>
        <hr style="border: 2px solid #000;">

        <!-- Student Info -->
        <table class="student-info" style="border: none; margin-bottom: 20px;">
            <tr>
                <td width="150" class="fw-bold">Nama</td>
                <td width="10">:</td>
                <td><?= esc($student['full_name']) ?></td>
                <td width="150" class="fw-bold">Kelas</td>
                <td width="10">:</td>
                <td><?= esc($class['name']) ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Nomor Induk Siswa (NIS)</td>
                <td>:</td>
                <td><?= esc($student['id']) ?></td> <!-- Assuming ID is NIS for simplicity -->
                <td class="fw-bold">Tahun Ajaran</td>
                <td>:</td>
                <td><?= $academic_year ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Semester</td>
                <td>:</td>
                <td><?= $semester ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <!-- Grades -->
        <h4 class="text-center" style="text-transform: uppercase; margin-bottom: 15px;">Laporan Capaian Kompetensi</h4>

        <table>
            <thead>
                <tr>
                    <th class="text-center" width="50">No</th>
                    <th>Komponen</th>
                    <th class="text-center" width="100">Nilai</th>
                    <th class="text-center" width="100">Predikat</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Tugas Kelas (Rata-rata)</td>
                    <td class="text-center fw-bold"><?= $assignment_avg ?></td>
                    <td class="text-center"><?= getGradeLetter($assignment_avg) ?></td>
                    <td>Kinerja dalam tugas harian dan pekerjaan rumah</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Ujian (CBT/UTS/UAS)</td>
                    <td class="text-center fw-bold"><?= $cbt_avg ?></td>
                    <td class="text-center"><?= getGradeLetter($cbt_avg) ?></td>
                    <td>Rata-rata dari semua Ujian Berbasis Komputer</td>
                </tr>
                <tr>
                    <td colspan="5" style="background-color: #f9f9f9; padding: 0;"></td>
                </tr>
                <tr style="background-color: #f0f0f0;">
                    <td colspan="2" class="text-right fw-bold">NILAI AKHIR</td>
                    <td class="text-center fw-bold"><?= $overall_avg ?></td>
                    <td class="text-center fw-bold"><?= getGradeLetter($overall_avg) ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Conduct -->
        <h4 style="margin-top: 30px; margin-bottom: 10px;">Perilaku Siswa (Kelakuan)</h4>
        <table>
            <thead>
                <tr>
                    <th class="text-center" width="100">Predikat</th>
                    <th>Deskripsi / Catatan dari Wali Kelas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center fw-bold" style="font-size: 1.2em;">
                        <?= $conduct['grade'] ?? '-' ?>
                    </td>
                    <td style="height: 60px;">
                        <?= esc($conduct['description'] ?? 'Tidak ada catatan perilaku ditemukan.') ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div style="margin-top: 50px;">
            <?= $settings['footer_content'] ?>
        </div>
    </div>

</body>

</html>

<?php
function getGradeLetter($score)
{
    if ($score >= 90)
        return 'A';
    if ($score >= 80)
        return 'B';
    if ($score >= 70)
        return 'C';
    if ($score >= 60)
        return 'D';
    return 'E';
}
?>