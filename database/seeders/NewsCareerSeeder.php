<?php

namespace Database\Seeders;

use App\Models\CareerPosition;
use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

class NewsCareerSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedNewsArticles();
        $this->seedCareerPositions();
    }

    protected function seedNewsArticles(): void
    {
        $articles = [
            [
                'title' => 'Tips Memilih Ukuran Cup Plastik untuk Bisnis Minuman',
                'slug' => 'tips-memilih-ukuran-cup-plastik-untuk-bisnis-minuman',
                'image' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=1200&q=80',
                'author' => 'Tim Hok Cup',
                'excerpt' => 'Panduan singkat memilih ukuran cup 8oz, 10oz, 12oz, 14oz, 16oz, hingga 22oz agar sesuai dengan menu dan target harga outlet Anda.',
                'content' => $this->paragraphs([
                    'Memilih ukuran cup tidak hanya soal volume, tetapi juga soal positioning menu, harga jual, dan kenyamanan pelanggan saat membawa minuman.',
                    'Untuk menu tester, dessert mini, atau kopi ukuran kecil, cup 8oz sampai 10oz biasanya lebih praktis. Untuk menu reguler seperti es kopi susu, thai tea, jus, dan fruit tea, ukuran 12oz sampai 14oz dapat menjadi pilihan utama.',
                    'Jika outlet Anda menjual menu premium, boba, smoothie, atau minuman dengan topping, ukuran 16oz sampai 22oz dapat membantu meningkatkan value produk dan membuka peluang upselling.',
                    'Pastikan juga lid atau seal yang digunakan sesuai dengan diameter cup agar minuman lebih aman saat takeaway maupun delivery.',
                ]),
                'published_at' => now()->subDays(8),
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Kenapa Kemasan Food Grade Penting untuk Produk F&B?',
                'slug' => 'kenapa-kemasan-food-grade-penting-untuk-produk-fnb',
                'image' => 'https://images.unsplash.com/photo-1577805947697-89e18249d767?w=1200&q=80',
                'author' => 'Tim Hok Cup',
                'excerpt' => 'Kemasan food grade membantu menjaga kualitas produk, memperkuat kepercayaan pelanggan, dan membuat brand terlihat lebih profesional.',
                'content' => $this->paragraphs([
                    'Untuk bisnis makanan dan minuman, kemasan menjadi bagian penting dari pengalaman pelanggan. Kemasan yang aman dan rapi dapat meningkatkan kepercayaan terhadap brand.',
                    'Material food grade dirancang agar sesuai untuk kontak dengan makanan atau minuman. Hal ini penting terutama untuk produk dingin, minuman manis, kopi susu, dessert, hingga boba.',
                    'Selain faktor keamanan, kemasan yang jernih, kuat, dan konsisten juga membantu produk terlihat lebih menarik saat difoto, dipajang, atau dikirim ke pelanggan.',
                    'Dengan pilihan kemasan yang tepat, outlet bisa menjaga kualitas layanan sekaligus memperkuat citra profesional di mata customer.',
                ]),
                'published_at' => now()->subDays(5),
                'sort_order' => 2,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Cup Printing untuk Branding Minuman: Kapan Perlu Digunakan?',
                'slug' => 'cup-printing-untuk-branding-minuman-kapan-perlu-digunakan',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1200&q=80',
                'author' => 'Tim Hok Cup',
                'excerpt' => 'Cup printing dapat membuat brand lebih mudah diingat, terutama untuk outlet yang sudah memiliki identitas visual dan volume penjualan stabil.',
                'content' => $this->paragraphs([
                    'Cup printing bisa menjadi media branding yang sangat efektif karena produk akan dibawa langsung oleh customer dan terlihat oleh orang lain.',
                    'Brand yang sudah memiliki logo, warna, dan konsep visual yang jelas dapat menggunakan cup printing untuk meningkatkan kesan profesional.',
                    'Untuk bisnis yang masih tahap awal, bisa memulai dari cup polos berkualitas lalu menambahkan stiker atau label. Setelah volume mulai stabil, cup printing dapat menjadi langkah berikutnya.',
                    'Desain cup yang baik sebaiknya tetap sederhana, mudah dibaca, dan sesuai dengan karakter menu yang dijual.',
                ]),
                'published_at' => now()->subDays(3),
                'sort_order' => 3,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Strategi Kemasan untuk Takeaway dan Delivery',
                'slug' => 'strategi-kemasan-untuk-takeaway-dan-delivery',
                'image' => 'https://images.unsplash.com/photo-1523906630133-f6934a1ab2b9?w=1200&q=80',
                'author' => 'Tim Hok Cup',
                'excerpt' => 'Kombinasi cup, lid, seal, dan packing yang tepat membantu produk tetap aman saat dikirim ke pelanggan.',
                'content' => $this->paragraphs([
                    'Takeaway dan delivery membutuhkan perhatian ekstra pada kemasan. Produk yang bocor atau rusak saat dikirim dapat menurunkan pengalaman customer.',
                    'Gunakan cup dengan struktur yang sesuai, tutup yang rapat, dan seal bila diperlukan. Untuk minuman dengan topping tinggi, dome lid bisa menjadi pilihan yang lebih aman.',
                    'Selain itu, pastikan ukuran cup sesuai dengan volume minuman agar tidak terlalu penuh dan tetap nyaman dibawa.',
                    'Kemasan yang rapi tidak hanya menjaga produk, tetapi juga membuat customer merasa brand Anda lebih serius dalam memberikan layanan.',
                ]),
                'published_at' => now()->subDay(),
                'sort_order' => 4,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($articles as $article) {
            NewsArticle::query()->updateOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }

    protected function seedCareerPositions(): void
    {
        $careers = [
            [
                'title' => 'Sales B2B Packaging',
                'slug' => 'sales-b2b-packaging',
                'department' => 'Sales',
                'location' => 'Surabaya / Sidoarjo',
                'employment_type' => 'Full Time',
                'work_type' => 'On Site',
                'salary_range' => 'Negosiasi',
                'summary' => 'Mencari dan mengelola customer B2B seperti outlet minuman, reseller, distributor, cafe, dan kebutuhan event.',
                'description' => $this->bullets([
                    'Mencari prospek customer baru untuk produk cup dan kemasan minuman.',
                    'Melakukan follow up kebutuhan customer melalui WhatsApp, telepon, dan kunjungan bila diperlukan.',
                    'Membantu customer memilih ukuran, tipe cup, dan kebutuhan lid atau aksesoris yang sesuai.',
                    'Mencatat pipeline penjualan dan membuat laporan aktivitas sales secara berkala.',
                ]),
                'requirements' => $this->bullets([
                    'Berpengalaman di bidang sales B2B, packaging, F&B, atau distribusi menjadi nilai tambah.',
                    'Komunikatif, rapi dalam follow up, dan terbiasa menggunakan WhatsApp untuk penjualan.',
                    'Mampu bekerja dengan target dan menjaga hubungan baik dengan customer.',
                    'Memiliki kendaraan pribadi menjadi nilai tambah.',
                ]),
                'apply_url' => null,
                'apply_email' => 'hrd@hokcup.co.id',
                'closes_at' => now()->addMonths(2)->toDateString(),
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Admin Marketplace & Customer Service',
                'slug' => 'admin-marketplace-customer-service',
                'department' => 'Operational',
                'location' => 'Surabaya / Sidoarjo',
                'employment_type' => 'Full Time',
                'work_type' => 'On Site',
                'salary_range' => 'Negosiasi',
                'summary' => 'Mengelola chat customer, pesanan marketplace, data produk, dan koordinasi order dengan tim gudang.',
                'description' => $this->bullets([
                    'Membalas chat customer dengan cepat, ramah, dan akurat.',
                    'Menginput dan memproses order dari marketplace maupun WhatsApp.',
                    'Memastikan data stok, harga, dan deskripsi produk tetap rapi.',
                    'Berkoordinasi dengan gudang terkait packing dan pengiriman.',
                ]),
                'requirements' => $this->bullets([
                    'Teliti, sabar, dan memiliki komunikasi tertulis yang baik.',
                    'Terbiasa menggunakan marketplace, spreadsheet, dan WhatsApp Web.',
                    'Mampu bekerja cepat saat order sedang ramai.',
                    'Pengalaman sebagai admin online shop menjadi nilai tambah.',
                ]),
                'apply_url' => null,
                'apply_email' => 'hrd@hokcup.co.id',
                'closes_at' => now()->addMonths(2)->toDateString(),
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Staff Gudang & Packing',
                'slug' => 'staff-gudang-packing',
                'department' => 'Warehouse',
                'location' => 'Surabaya / Sidoarjo',
                'employment_type' => 'Full Time',
                'work_type' => 'On Site',
                'salary_range' => 'Negosiasi',
                'summary' => 'Bertanggung jawab pada pengecekan stok, pengambilan barang, packing order, dan kerapian area gudang.',
                'description' => $this->bullets([
                    'Menyiapkan produk sesuai pesanan customer.',
                    'Melakukan packing produk agar aman saat dikirim.',
                    'Membantu pengecekan stok masuk dan keluar.',
                    'Menjaga kebersihan dan kerapian area gudang.',
                ]),
                'requirements' => $this->bullets([
                    'Jujur, disiplin, teliti, dan mampu bekerja secara fisik.',
                    'Mampu bekerja dalam tim dan mengikuti SOP gudang.',
                    'Pengalaman gudang atau packing menjadi nilai tambah.',
                    'Bersedia bekerja sesuai jam operasional perusahaan.',
                ]),
                'apply_url' => null,
                'apply_email' => 'hrd@hokcup.co.id',
                'closes_at' => now()->addMonths(2)->toDateString(),
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Content Creator Produk F&B',
                'slug' => 'content-creator-produk-fnb',
                'department' => 'Marketing',
                'location' => 'Remote / Hybrid',
                'employment_type' => 'Part Time / Freelance',
                'work_type' => 'Hybrid',
                'salary_range' => 'Project Based',
                'summary' => 'Membuat konten edukasi, foto produk, video pendek, dan materi promosi untuk katalog kemasan minuman.',
                'description' => $this->bullets([
                    'Membuat ide konten untuk produk cup, lid, dan kebutuhan packaging F&B.',
                    'Mengambil foto atau video pendek yang menarik untuk Instagram, TikTok, dan website.',
                    'Menulis caption singkat dan edukatif sesuai tone brand.',
                    'Berkoordinasi dengan tim untuk kalender konten bulanan.',
                ]),
                'requirements' => $this->bullets([
                    'Memiliki sense visual yang baik dan mengikuti tren konten F&B.',
                    'Mampu menggunakan tools editing foto/video dasar.',
                    'Memiliki portofolio konten menjadi nilai tambah.',
                    'Bisa bekerja mandiri dan tepat deadline.',
                ]),
                'apply_url' => null,
                'apply_email' => 'hrd@hokcup.co.id',
                'closes_at' => now()->addMonths(2)->toDateString(),
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($careers as $career) {
            CareerPosition::query()->updateOrCreate(
                ['slug' => $career['slug']],
                $career
            );
        }
    }

    protected function paragraphs(array $items): string
    {
        return collect($items)
            ->map(fn (string $item): string => '<p>' . e($item) . '</p>')
            ->implode("\n");
    }

    protected function bullets(array $items): string
    {
        return '<ul>' . collect($items)
            ->map(fn (string $item): string => '<li>' . e($item) . '</li>')
            ->implode('') . '</ul>';
    }
}
