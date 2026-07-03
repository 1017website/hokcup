<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\AboutStat;
use App\Models\Category;
use App\Models\CtaSection;
use App\Models\Feature;
use App\Models\FooterLink;
use App\Models\HeroSection;
use App\Models\HeroTrustItem;
use App\Models\GoogleMapSection;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\SocialWidget;
use App\Models\SocialMediaLink;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HokCupSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@hokcup.test'],
            ['name' => 'Admin Hok Cup', 'password' => Hash::make('password123')]
        );
        $adminUser->forceFill(['role' => 'admin', 'is_active' => true])->save();

        $logo = 'https://res.cloudinary.com/dcpleyqfl/image/upload/q_auto/f_auto/v1778623665/logo_3_ow2uyr.png';
        SiteSetting::query()->updateOrCreate([], [
            'site_name' => 'Hok Cup',
            'brand_tagline' => 'Food Grade Packaging',
            'logo' => $logo,
            'favicon' => $logo,
            'whatsapp_number' => '6281234567890',
            'email' => 'sales@hokcup.co.id',
            'operational_hours' => 'Senin–Sabtu 08.00–17.00',
            'meta_title' => 'Hok Cup - Gelas Plastik Food Grade & Kemasan Minuman',
            'meta_description' => 'Landing page Hok Cup dengan katalog produk, kategori, pencarian produk, dan detail produk gelas plastik food grade.',
            'meta_keywords' => 'Hok Cup, gelas plastik, cup plastik, gelas minuman, food grade, BPA free, cup printing, lid cup',
            'seo_robots' => 'index, follow',
            'canonical_url' => null,
            'twitter_title' => 'Hok Cup - Gelas Plastik Food Grade',
            'twitter_description' => 'Katalog Hok Cup untuk gelas plastik food grade, lid, printing cup, dan paket grosir.',
            'twitter_image' => $logo,
            'schema_json_ld' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'Hok Cup',
                'url' => url('/'),
                'logo' => $logo,
                'contactPoint' => [[
                    '@type' => 'ContactPoint',
                    'telephone' => '+6281234567890',
                    'contactType' => 'customer service',
                    'areaServed' => 'ID',
                    'availableLanguage' => ['id'],
                ]],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'og_image' => $logo,
            'google_analytics_id' => null,
            'google_tag_manager_id' => null,
            'meta_pixel_id' => null,
            'google_ads_id' => null,
            'google_ads_conversion_label' => null,
            'head_scripts' => null,
            'body_start_scripts' => null,
            'body_end_scripts' => null,
        ]);

        HeroSection::query()->updateOrCreate([], [
            'eyebrow_icon' => 'fa-certificate',
            'eyebrow_text' => 'Gelas Plastik Food Grade',
            'title_before' => 'Kemasan',
            'pill_word' => 'Hok',
            'title_after' => 'untuk Bisnis Minuman Anda',
            'description' => 'Alternatif desain kedua untuk Hok Cup: lebih modern, cerah, dan berfokus pada katalog. Cocok untuk menampilkan varian cup natural, oval, square, printing, lid, sampai paket grosir.',
            'primary_button_text' => 'Cari Produk',
            'primary_button_icon' => 'fa-magnifying-glass',
            'secondary_button_text' => 'Lihat Kategori',
            'secondary_button_icon' => 'fa-layer-group',
            'image' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=1200&q=80',
            'card_a_number' => '12+', 'card_a_text' => 'Varian Produk', 'card_a_icon' => 'fa-cup-straw',
            'card_b_number' => 'UMKM', 'card_b_text' => 'Friendly Packaging', 'card_b_icon' => 'fa-store',
            'card_c_number' => 'Ready', 'card_c_text' => 'Siap Kirim', 'card_c_icon' => 'fa-truck-fast',
        ]);

        HeroTrustItem::query()->delete();
        foreach ([
            ['fa-check-circle','Food Grade'], ['fa-shield-heart','BPA Free'], ['fa-mug-hot','Banyak Ukuran'], ['fa-boxes-stacked','Grosir & Retail'],
        ] as $i => $item) {
            HeroTrustItem::create(['icon' => $item[0], 'text' => $item[1], 'sort_order' => $i + 1, 'is_active' => true]);
        }

        $categories = [
            ['natural','Natural Series','Natural','fa-cup-straw','Cup bening reguler'],
            ['oval','Oval Series','Oval','fa-circle-notch','Cup oval kekinian'],
            ['square','Square Series','Square','fa-square','Cup square modern'],
            ['printing','Printing & Motif','Printing','fa-palette','Cup motif siap jual'],
            ['lid','Lid & Seal','Lid','fa-circle','Tutup cup dan seal'],
            ['grosir','Paket Grosir','Grosir','fa-boxes-stacked','Paket reseller/outlet'],
        ];
        foreach ($categories as $i => $category) {
            Category::updateOrCreate(['slug' => $category[0]], [
                'name' => $category[1], 'short_name' => $category[2], 'icon' => $category[3], 'description' => $category[4], 'sort_order' => $i + 1, 'is_active' => true,
            ]);
        }

        $imgCup = 'https://images.unsplash.com/photo-1577805947697-89e18249d767?w=900&q=80';
        $imgDrink = 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=900&q=80';
        $imgCoffee = 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=900&q=80';
        $imgBoba = 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=900&q=80';
        $imgPackaging = 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=900&q=80';
        $imgCafe = 'https://images.unsplash.com/photo-1523906630133-f6934a1ab2b9?w=900&q=80';

        $products = [
            ['Hok Cup Natural 8oz','natural',8,$imgCup,'Best Seller','Cup bening ukuran kecil untuk sample drink, espresso based, dessert mini, atau minuman porsi ekonomis.',['Ukuran'=>'8 oz','Isi'=>'50 pcs / slop','Material'=>'PP bening food grade','Fitur'=>'BPA Free, ringan, rapi ditumpuk','Cocok'=>'Kopi, teh, dessert mini, tester produk']],
            ['Hok Cup Natural 10oz','natural',10,$imgDrink,'Ready Stock','Ukuran praktis untuk minuman harian dengan volume sedang dan tampilan bening.',['Ukuran'=>'10 oz','Isi'=>'50 pcs / slop','Material'=>'PP bening food grade','Fitur'=>'Bening, kuat, mudah disegel','Cocok'=>'Es teh, jus, kopi susu kecil']],
            ['Hok Cup Natural 12oz','natural',12,$imgCoffee,'Favorit UMKM','Cup serbaguna untuk outlet minuman, coffee shop, stand event, dan reseller.',['Ukuran'=>'12 oz','Isi'=>'50 pcs / slop','Material'=>'PP bening food grade','Fitur'=>'BPA Free, kompatibel lid sesuai ukuran','Cocok'=>'Kopi susu, boba regular, jus, thai tea']],
            ['Hok Cup Natural 14oz','natural',14,$imgBoba,'Populer','Volume lebih besar untuk menu signature dan minuman dingin porsi medium-large.',['Ukuran'=>'14 oz','Isi'=>'50 pcs / slop','Material'=>'PP bening food grade','Fitur'=>'Tampilan jernih, nyaman digenggam','Cocok'=>'Boba, smoothie, es kopi, minuman kekinian']],
            ['Hok Cup Natural 16oz','natural',16,$imgDrink,'Large Size','Ukuran besar untuk menu premium, minuman dingin, dan outlet dengan porsi jumbo.',['Ukuran'=>'16 oz','Isi'=>'50 pcs / slop','Material'=>'PP bening food grade','Fitur'=>'Kapasitas besar, cocok untuk topping','Cocok'=>'Boba large, jus, kopi large, es coklat']],
            ['Hok Cup Oval 12oz','oval',12,$imgCoffee,'Oval','Cup bentuk oval dengan tampilan berbeda untuk brand minuman yang ingin terlihat lebih premium.',['Ukuran'=>'12 oz','Isi'=>'Menyesuaikan kemasan','Material'=>'PP food grade','Fitur'=>'Bentuk oval, look premium','Cocok'=>'Coffee shop, mocktail, minuman signature']],
            ['Hok Cup Oval 16oz','oval',16,$imgBoba,'Premium Look','Cup oval ukuran besar untuk minuman kekinian dengan visual lebih menarik.',['Ukuran'=>'16 oz','Isi'=>'Menyesuaikan kemasan','Material'=>'PP food grade','Fitur'=>'Bentuk unik, volume besar','Cocok'=>'Boba, smoothie, fruit tea, kopi susu']],
            ['Hok Cup Oval 22oz','oval',22,$imgDrink,'Jumbo','Cup jumbo untuk menu besar, cocok sebagai varian upselling di outlet minuman.',['Ukuran'=>'22 oz','Isi'=>'Menyesuaikan kemasan','Material'=>'PP food grade','Fitur'=>'Jumbo size, tampilan modern','Cocok'=>'Minuman jumbo, promo large, sharing drink']],
            ['Hok Cup Square 8oz','square',8,$imgCafe,'Square','Cup square kecil untuk konsep dessert, pudding, atau minuman mini dengan tampilan modern.',['Ukuran'=>'8 oz','Isi'=>'Menyesuaikan kemasan','Material'=>'PP food grade','Fitur'=>'Bentuk kotak, simple modern','Cocok'=>'Dessert cup, tester, coffee mini']],
            ['Hok Cup Square 12oz','square',12,$imgCoffee,'Modern','Cup square medium untuk brand yang ingin tampil beda dari cup reguler.',['Ukuran'=>'12 oz','Isi'=>'Menyesuaikan kemasan','Material'=>'PP food grade','Fitur'=>'Square design, mudah dipajang','Cocok'=>'Kopi, jus, minuman signature']],
            ['Hok Cup Square 16oz','square',16,$imgBoba,'Signature','Cup square besar untuk menu andalan dengan visual lebih standout.',['Ukuran'=>'16 oz','Isi'=>'Menyesuaikan kemasan','Material'=>'PP food grade','Fitur'=>'Look premium, volume besar','Cocok'=>'Boba, fruit tea, smoothies']],
            ['Hok Cup Printing Motif','printing',12,$imgPackaging,'Motif','Cup dengan motif atau printing untuk kebutuhan brand, event, dan konsep outlet yang lebih kuat.',['Ukuran'=>'Custom / tersedia beberapa ukuran','Isi'=>'Menyesuaikan pesanan','Material'=>'PP food grade','Fitur'=>'Motif menarik, branding lebih kuat','Cocok'=>'Brand minuman, event, promo seasonal']],
            ['Hok Cup Lid Datar','lid',0,$imgPackaging,'Aksesoris','Tutup datar untuk cup minuman, membantu menjaga produk tetap higienis saat delivery.',['Ukuran'=>'Menyesuaikan diameter cup','Isi'=>'Menyesuaikan kemasan','Material'=>'PP food grade','Fitur'=>'Praktis, higienis, mudah dipasang','Cocok'=>'Takeaway, delivery, minuman dingin']],
            ['Hok Cup Dome Lid','lid',0,$imgBoba,'Topping','Tutup dome untuk minuman dengan topping, whipped cream, atau visual produk lebih tinggi.',['Ukuran'=>'Menyesuaikan diameter cup','Isi'=>'Menyesuaikan kemasan','Material'=>'PP food grade','Fitur'=>'Ruang topping lebih lega','Cocok'=>'Boba topping, smoothie, whipped cream']],
            ['Paket Grosir Outlet Minuman','grosir',0,$imgCafe,'Paket Hemat','Paket pembelian grosir untuk outlet, reseller, atau kebutuhan event dengan volume besar.',['Paket'=>'Bisa campur ukuran','Isi'=>'Menyesuaikan order','Material'=>'PP food grade','Fitur'=>'Harga grosir, stok fleksibel','Cocok'=>'Outlet minuman, reseller, event, catering']],
            ['Paket Starter UMKM','grosir',0,$imgDrink,'UMKM','Paket awal untuk usaha minuman yang baru mulai dan butuh beberapa ukuran cup sekaligus.',['Paket'=>'Starter mix','Isi'=>'Menyesuaikan kebutuhan','Material'=>'PP food grade','Fitur'=>'Praktis untuk mulai jualan','Cocok'=>'UMKM baru, booth bazar, trial menu']],
        ];

        foreach ($products as $i => $item) {
            $category = Category::where('slug', $item[1])->first();
            $product = Product::updateOrCreate(['slug' => Str::slug($item[0])], [
                'category_id' => $category->id,
                'name' => $item[0],
                'size' => $item[2],
                'image' => $item[3],
                'label' => $item[4],
                'description' => $item[5],
                'sort_order' => $i + 1,
                'is_featured' => false,
                'is_active' => true,
            ]);
            $product->specs()->delete();
            foreach (array_values(array_keys($item[6])) as $specIndex => $specKey) {
                $product->specs()->create(['spec_key' => $specKey, 'spec_value' => $item[6][$specKey], 'sort_order' => $specIndex + 1]);
            }
        }

        Feature::query()->delete();
        foreach ([
            ['fa-utensils','Food Grade','Cocok untuk kebutuhan minuman, dessert, kopi, jus, boba, dan berbagai produk F&B.'],
            ['fa-shield-alt','BPA Free','Mendukung kebutuhan kemasan yang aman dan nyaman digunakan oleh pelanggan.'],
            ['fa-box','Banyak Varian','Tersedia berbagai ukuran dan bentuk agar sesuai dengan konsep brand minuman Anda.'],
            ['fa-comments','Konsultasi Produk','Customer bisa bertanya langsung untuk memilih ukuran dan tipe cup yang paling sesuai.'],
        ] as $i => $feature) {
            Feature::create(['icon' => $feature[0], 'title' => $feature[1], 'description' => $feature[2], 'sort_order' => $i + 1, 'is_active' => true]);
        }

        AboutSection::query()->updateOrCreate([], [
            'eyebrow_icon' => 'fa-building',
            'eyebrow_text' => 'Tentang Hok Cup',
            'title' => 'Kemasan Lebih Rapi, Brand Lebih Siap Jual',
            'description' => 'Hok Cup dapat diposisikan sebagai solusi kemasan minuman untuk outlet, reseller, distributor, cafe, warung, dan UMKM. Desain website ini menonjolkan katalog produk agar pengunjung cepat paham pilihan yang tersedia.',
            'image' => $imgCafe,
        ]);
        AboutStat::query()->delete();
        foreach ([['6','Kategori'], ['12+','Produk Awal'], ['24/7','Katalog Online']] as $i => $stat) {
            AboutStat::create(['number' => $stat[0], 'label' => $stat[1], 'sort_order' => $i + 1, 'is_active' => true]);
        }

        SocialWidget::query()->delete();
        SocialWidget::create(['icon' => 'fab fa-instagram', 'title' => 'Instagram Feed', 'description' => 'Menampilkan posting terbaru melalui widget Elfsight Instagram Feed.', 'embed_code' => '<div class="elfsight-app-5aaee464-962a-4389-ad94-7799acd10bfb" data-elfsight-app-lazy></div>', 'sort_order' => 1, 'is_active' => true]);
        SocialWidget::create(['icon' => 'fas fa-star', 'title' => 'Google Reviews', 'description' => 'Menampilkan ulasan pelanggan melalui widget Elfsight Google Reviews.', 'embed_code' => '<div class="elfsight-app-49e99c43-0b02-4281-a2f5-13398dd5a82d" data-elfsight-app-lazy></div>', 'sort_order' => 2, 'is_active' => true]);



        SocialMediaLink::query()->delete();
        foreach ([
            ['Instagram', 'Follow Instagram', 'fab fa-instagram', 'https://instagram.com/', '@hokcup', 'Update produk, promo, dan inspirasi kemasan minuman.', 1],
            ['TikTok', 'Lihat TikTok', 'fab fa-tiktok', 'https://www.tiktok.com/', '@hokcup', 'Konten singkat seputar produk, packing, dan ide jualan.', 2],
            ['Facebook', 'Kunjungi Facebook', 'fab fa-facebook-f', 'https://facebook.com/', 'Hok Cup', 'Informasi brand dan update untuk pelanggan.', 3],
        ] as $social) {
            SocialMediaLink::create([
                'platform' => $social[0],
                'label' => $social[1],
                'icon' => $social[2],
                'url' => $social[3],
                'username' => $social[4],
                'description' => $social[5],
                'sort_order' => $social[6],
                'is_active' => true,
            ]);
        }

        GoogleMapSection::query()->updateOrCreate([], [
            'eyebrow_icon' => 'fa-location-dot',
            'eyebrow_text' => 'Lokasi Kami',
            'title' => 'Temukan Hok Cup di Google Maps',
            'description' => 'Gunakan Google Maps untuk melihat lokasi, rute, dan informasi kunjungan Hok Cup.',
            'address' => 'Alamat Hok Cup dapat disesuaikan dari CMS admin.',
            'embed_code' => '<iframe src="https://www.google.com/maps?q=Jakarta%2C%20Indonesia&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'button_text' => 'Buka Google Maps',
            'button_url' => 'https://www.google.com/maps/search/?api=1&query=Jakarta%2C%20Indonesia',
            'is_active' => true,
        ]);

        CtaSection::query()->updateOrCreate([], [
            'title' => 'Butuh Rekomendasi Ukuran Cup?',
            'description' => 'Kirim kebutuhan Anda lewat WhatsApp. Tim Hok Cup bisa bantu arahkan pilihan cup berdasarkan jenis minuman, volume, dan target harga.',
            'button_text' => 'Konsultasi WhatsApp',
            'button_icon' => 'fab fa-whatsapp',
            'whatsapp_message' => 'Halo Hok Cup, saya ingin konsultasi produk',
        ]);

        FooterLink::query()->delete();
        foreach ([
            ['Menu','Kategori','#kategori',null,1], ['Menu','Produk','#produk',null,2], ['Menu','Keunggulan','#keunggulan',null,3], ['Menu','Tentang','#tentang',null,4],
            ['Kategori','Natural Series','#produk',"setCategory('natural')",1], ['Kategori','Oval Series','#produk',"setCategory('oval')",2], ['Kategori','Square Series','#produk',"setCategory('square')",3], ['Kategori','Printing & Motif','#produk',"setCategory('printing')",4],
        ] as $link) {
            FooterLink::create(['group' => $link[0], 'label' => $link[1], 'url' => $link[2], 'onclick' => $link[3], 'sort_order' => $link[4], 'is_active' => true]);
        }
    }
}
