<?php

namespace Database\Seeders;

use App\Services\Settings\SettingsService;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        /** @var SettingsService $settings */
        $settings = app(SettingsService::class);

        $settings->setMany([
            'site_name' => 'Trung tâm Học tập cộng đồng xã Cửa Tùng',
            'site_tagline' => 'Học tập suốt đời – Xây dựng xã hội học tập',
            'organization_line' => 'UBND xã Cửa Tùng',
            'organization_sub' => 'UBND XÃ CỬA TÙNG / TRUNG TÂM HỌC TẬP CỘNG ĐỒNG XÃ CỬA TÙNG',
            'topbar_phone' => '0233.123.456',
            'topbar_email' => 'htcd.cuatung@quangtri.gov.vn',
            'topbar_location' => 'Huyện Vĩnh Linh, Tỉnh Quảng Trị',
            'address' => 'Trụ sở UBND xã Cửa Tùng, Huyện Vĩnh Linh, Tỉnh Quảng Trị',
            'person_in_charge' => 'Lê Đức Kiêm',
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3720!2d107.0!3d17.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zQ-G7k2EgQ8O1YSBUw60gTMO9bmc!5e0!3m2!1svi!2s!4v1',
            'map_link' => 'https://maps.google.com',
            'copyright' => '© 2024 Trung tâm Học tập cộng đồng xã Cửa Tùng',
            'admin_path' => 'admin',
            'maintenance_mode' => false,
            'posts_per_page' => 10,
            'home_announcements' => 3,
            'home_events' => 3,
            'home_news' => 2,
            'home_documents' => 5,
            'home_gallery' => 6,
            'hero_title_1' => 'Học tập suốt đời,',
            'hero_title_2' => 'ngay tại cộng đồng của bạn',
            'hero_description' => 'Trung tâm Học tập cộng đồng xã Cửa Tùng tổ chức các lớp học, tập huấn và hoạt động học tập mở cho mọi người dân. Đăng ký nhu cầu để được sắp xếp lớp phù hợp.',
            'library_banner_text' => 'Tri thức là hành trang của mỗi người',
            'seo_default_title' => 'Trung tâm Học tập cộng đồng xã Cửa Tùng',
            'seo_default_description' => 'Cổng thông tin học tập cộng đồng xã Cửa Tùng, tỉnh Quảng Trị.',
        ], 'general');

        $settings->setMany([
            'permalink.tin-tuc' => 'tin-tuc',
            'permalink.thong-bao' => 'thong-bao',
            'permalink.su-kien' => 'su-kien',
            'permalink.chuong-trinh' => 'chuong-trinh-hoc-tap',
            'permalink.guong-hoc-tap' => 'guong-hoc-tap',
            'permalink.thu-vien-so' => 'thu-vien-so',
            'permalink.van-ban' => 'van-ban-tai-lieu',
            'permalink.mo-hinh' => 'mo-hinh',
        ], 'permalinks');

        $settings->setMany([
            'media_thumbnail' => 150,
            'media_medium' => 300,
            'media_large' => 1024,
            'media_quality' => 85,
            'media_max_upload_mb' => 10,
        ], 'media');
    }
}
