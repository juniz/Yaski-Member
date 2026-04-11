<?php

namespace App\Services;

use App\Models\Sertifikat;
use App\Models\WorkshopSetting;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Common\ErrorCorrectionLevel;

class CertificateGeneratorService
{
    /**
     * @param mixed $sertifikatId ID string or Sertifikat instance
     * @param bool $preview Jika true, kembalikan image resource dan jangan simpan file/db
     * @return mixed string filename (default) atau image resource (preview)
     */
    public function generate($sertifikatId, $preview = false)
    {
        if ($sertifikatId instanceof Sertifikat) {
            $sertifikat = $sertifikatId;
        } else {
            $sertifikat = Sertifikat::with(['workshop', 'peserta.transaction'])->find($sertifikatId);
        }

        if (!$sertifikat) {
            return null;
        }

        $setting = WorkshopSetting::where('workshop_id', $sertifikat->workshop_id)->first();
        if (!$setting || !$setting->file_template) {
            return null;
        }

        $templatePath = storage_path('app/public/workshop/template/' . $sertifikat->workshop_id . '/' . $setting->file_template);
        if (!file_exists($templatePath)) {
            return null;
        }

        // Determine image type
        $imageInfo = getimagesize($templatePath);
        if (!$imageInfo) {
            return null;
        }

        $mime = $imageInfo['mime'];

        // Create image from template
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($templatePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($templatePath);
                break;
            default:
                return null;
        }

        if (!$image) {
            return null;
        }

        // Use default font or TTF if available
        $fontPath = public_path('assets/fonts/arial.ttf');
        $useTTF = file_exists($fontPath);

        // Define search paths for fonts (Windows & Linux)
        if (!$useTTF) {
            $searchPaths = [
                // Project local
                public_path('assets/fonts/arial.ttf'),
                // Windows
                'C:/Windows/Fonts/arial.ttf',
                'C:/Windows/Fonts/calibri.ttf',
                'C:/Windows/Fonts/segoeui.ttf',
                // Linux (Ubuntu/Debian standard paths)
                '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
                '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
                '/usr/share/fonts/truetype/freefont/FreeSans.ttf',
                '/usr/share/fonts/truetype/noto/NotoSans-Regular.ttf',
            ];
            foreach ($searchPaths as $path) {
                if (file_exists($path)) {
                    $fontPath = $path;
                    $useTTF = true;
                    break;
                }
            }
        }

        // --- Perbaikan Skalasi Font ---
        // Editor sekarang menggunakan standar lebar referensi 1000px. 
        // 0.75 adalah faktor koreksi untuk menyamakan pixel browser dengan point GD (96 DPI vs 72 DPI).
        $imageWidth = $imageInfo[0];
        $fontSizeFactor = ($imageWidth / 1000) * 0.75;

        // Draw nama peserta
        $namaText = $sertifikat->nama ?? $sertifikat->peserta->nama ?? '';
        $namaEnabled = $setting->nama_enabled ?? true;
        if ($namaText && $namaEnabled) {
            $this->drawText(
                $image,
                $namaText,
                $setting->nama_x ?? 500,
                $setting->nama_y ?? 400,
                ($setting->nama_font_size ?? 40) * $fontSizeFactor,
                $setting->nama_color ?? '#000000',
                $fontPath,
                $useTTF,
                $imageInfo[0]
            );
        }

        // Draw no sertifikat
        $noSertifikatText = $sertifikat->no_sertifikat ?? '';
        $noSertifikatEnabled = $setting->no_sertifikat_enabled ?? true;
        if ($noSertifikatText && $noSertifikatEnabled) {
            $this->drawText(
                $image,
                $noSertifikatText,
                $setting->no_sertifikat_x ?? 500,
                $setting->no_sertifikat_y ?? 350,
                ($setting->no_sertifikat_font_size ?? 20) * $fontSizeFactor,
                $setting->no_sertifikat_color ?? '#333333',
                $fontPath,
                $useTTF,
                $imageInfo[0]
            );
        }

        // Draw instansi
        $instansiText = $sertifikat->instansi ?? $sertifikat->peserta->transaction->nama_rs ?? '';
        $instansiEnabled = $setting->instansi_enabled ?? true;
        if ($instansiText && $instansiEnabled) {
            $this->drawText(
                $image,
                $instansiText,
                $setting->instansi_x ?? 500,
                $setting->instansi_y ?? 460,
                ($setting->instansi_font_size ?? 24) * $fontSizeFactor,
                $setting->instansi_color ?? '#333333',
                $fontPath,
                $useTTF,
                $imageInfo[0]
            );
        }

        // Draw QR Code
        $qrEnabled = $setting->qr_enabled ?? true;
        if ($qrEnabled) {
            $validationUrl = url('sertifikat/' . $sertifikat->id . '/validasi');
            $this->drawQrCode(
                $image,
                $validationUrl,
                $setting->qr_x ?? 900,
                $setting->qr_y ?? 500,
                $setting->qr_size ?? 150
            );
        }

        // --- Handle Preview Mode ---
        if ($preview) {
            return $image;
        }

        // Output directory
        $outputDir = 'public/sertifikat/' . $sertifikat->workshop_id;
        if (!Storage::exists($outputDir)) {
            Storage::makeDirectory($outputDir);
        }

        $filename = 'sertifikat-' . $sertifikat->id . '.png';
        $outputPath = storage_path('app/' . $outputDir . '/' . $filename);

        // Save as PNG
        imagepng($image, $outputPath, 5);
        imagedestroy($image);

        // --- Handle Back Side ---
        $filenameBack = null;
        if ($setting->file_template_belakang) {
            $templateBackPath = storage_path('app/public/workshop/template/' . $sertifikat->workshop_id . '/' . $setting->file_template_belakang);
            if (file_exists($templateBackPath)) {
                $filenameBack = 'sertifikat-' . $sertifikat->id . '-back.png';
                $outputPathBack = storage_path('app/' . $outputDir . '/' . $filenameBack);
                
                // Since it's static, we can just copy it or re-save it via GD
                $backImageInfo = getimagesize($templateBackPath);
                if ($backImageInfo) {
                    $backMime = $backImageInfo['mime'];
                    $imageBack = null;
                    switch ($backMime) {
                        case 'image/jpeg': $imageBack = imagecreatefromjpeg($templateBackPath); break;
                        case 'image/png': $imageBack = imagecreatefrompng($templateBackPath); break;
                    }
                    if ($imageBack) {
                        imagepng($imageBack, $outputPathBack, 5);
                        imagedestroy($imageBack);
                    }
                }
            }
        }

        // Update sertifikat record
        $sertifikat->file_sertifikat = $filename;
        if ($filenameBack) {
            $sertifikat->file_sertifikat_belakang = $filenameBack;
        }
        
        if ($sertifikat->exists) {
            $sertifikat->save();
        }

        return $filename;
    }

    /**
     * Generate sertifikat untuk semua peserta dalam satu workshop
     */
    public function generateBulk($workshopId)
    {
        $sertifikats = Sertifikat::with('peserta')
            ->where('workshop_id', $workshopId)
            ->get();

        $result = ['success' => 0, 'failed' => 0, 'skipped' => 0];

        foreach ($sertifikats as $sertifikat) {
            if ($sertifikat->file_sertifikat) {
                $filePath = storage_path('app/public/sertifikat/' . $workshopId . '/' . $sertifikat->file_sertifikat);
                if (file_exists($filePath)) {
                    $result['skipped']++;
                    continue;
                }
            }

            $generated = $this->generate($sertifikat->id);
            if ($generated) {
                $result['success']++;
            } else {
                $result['failed']++;
            }
        }

        return $result;
    }

    /**
     * Regenerate semua sertifikat (termasuk yang sudah di-generate)
     */
    public function regenerateBulk($workshopId)
    {
        $sertifikats = Sertifikat::with('peserta')
            ->where('workshop_id', $workshopId)
            ->get();

        $result = ['success' => 0, 'failed' => 0];

        foreach ($sertifikats as $sertifikat) {
            $generated = $this->generate($sertifikat->id);
            if ($generated) {
                $result['success']++;
            } else {
                $result['failed']++;
            }
        }

        return $result;
    }

    /**
     * Draw QR Code on the certificate image using BaconQrCode encoder + GD
     * No imagick needed — draws QR pixel by pixel using GD
     */
    private function drawQrCode($image, $content, $x, $y, $size)
    {
        try {
            // Encode QR data using BaconQrCode
            $ecLevel = ErrorCorrectionLevel::M();
            $qrCode = Encoder::encode($content, $ecLevel);
            $matrix = $qrCode->getMatrix();

            $matrixWidth = $matrix->getWidth();
            $matrixHeight = $matrix->getHeight();

            // Calculate pixel size for each QR module
            $moduleSize = (int) floor($size / $matrixWidth);
            $actualSize = $moduleSize * $matrixWidth;

            // Create QR image
            $qrImage = imagecreatetruecolor($actualSize, $actualSize);
            $white = imagecolorallocate($qrImage, 255, 255, 255);
            $black = imagecolorallocate($qrImage, 0, 0, 0);

            // Fill white background
            imagefill($qrImage, 0, 0, $white);

            // Draw QR modules
            for ($row = 0; $row < $matrixHeight; $row++) {
                for ($col = 0; $col < $matrixWidth; $col++) {
                    if ($matrix->get($col, $row) === 1) {
                        imagefilledrectangle(
                            $qrImage,
                            $col * $moduleSize,
                            $row * $moduleSize,
                            ($col + 1) * $moduleSize - 1,
                            ($row + 1) * $moduleSize - 1,
                            $black
                        );
                    }
                }
            }

            // Add white border (quiet zone)
            $border = $moduleSize * 2;
            $borderedSize = $actualSize + ($border * 2);
            $borderedImage = imagecreatetruecolor($borderedSize, $borderedSize);
            $white2 = imagecolorallocate($borderedImage, 255, 255, 255);
            imagefill($borderedImage, 0, 0, $white2);
            imagecopy($borderedImage, $qrImage, $border, $border, 0, 0, $actualSize, $actualSize);
            imagedestroy($qrImage);

            // Scale to desired size
            $scaledImage = imagecreatetruecolor($size, $size);
            imagecopyresampled($scaledImage, $borderedImage, 0, 0, 0, 0, $size, $size, $borderedSize, $borderedSize);
            imagedestroy($borderedImage);

            // Calculate destination position (x, y is center point)
            $destX = (int)($x - $size / 2);
            $destY = (int)($y - $size / 2);
            $destX = max(0, $destX);
            $destY = max(0, $destY);

            // Copy QR onto certificate
            imagecopy($image, $scaledImage, $destX, $destY, 0, 0, $size, $size);
            imagedestroy($scaledImage);

        } catch (\Exception $e) {
            \Log::warning('Gagal generate QR code: ' . $e->getMessage());
        }
    }

    /**
     * Draw centered text on image
     */
    private function drawText($image, $text, $x, $y, $fontSize, $hexColor, $fontPath, $useTTF, $imageWidth)
    {
        $r = hexdec(substr($hexColor, 1, 2));
        $g = hexdec(substr($hexColor, 3, 2));
        $b = hexdec(substr($hexColor, 5, 2));
        $color = imagecolorallocate($image, $r, $g, $b);

        if ($useTTF && $fontPath) {
            // Get bounding box
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            
            // Width calculation
            $textWidth = abs($bbox[2] - $bbox[0]);
            $textX = $x - ($textWidth / 2);
            
            // Height calculation for vertical centering (Middle Alignment)
            // In imagettftext, Y is the baseline. 
            // We need to offset the 'y' (which is the center) by half the font height.
            $textHeight = abs($bbox[7] - $bbox[1]);
            $textY = $y + ($textHeight / 2) - abs($bbox[1]); 

            imagettftext($image, $fontSize, 0, (int)$textX, (int)$textY, $color, $fontPath, $text);
        } else {
            $builtinFontSize = min(5, max(1, intval($fontSize / 10)));
            $charWidth = imagefontwidth($builtinFontSize);
            $charHeight = imagefontheight($builtinFontSize);
            $textWidth = strlen($text) * $charWidth;
            
            $textX = $x - ($textWidth / 2);
            $textY = $y - ($charHeight / 2);
            
            imagestring($image, $builtinFontSize, (int)$textX, (int)$textY, $text, $color);
        }
    }
}
