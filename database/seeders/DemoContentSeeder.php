<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\DocumentLevel;
use App\Models\Event;
use App\Models\LearningModel;
use App\Models\LibraryType;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\News;
use App\Models\Program;
use App\Models\Slide;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->first();

        $programs = [
            ['title' => 'Giáo dục – học tập, phổ cập, xóa mù chữ', 'color' => '#0b57c9', 'icon' => 'fas fa-book-reader'],
            ['title' => 'Chuyển đổi số và kỹ năng số', 'color' => '#28a745', 'icon' => 'fas fa-laptop'],
            ['title' => 'Kinh tế – sản xuất, nghề nghiệp, khởi nghiệp', 'color' => '#fd7e14', 'icon' => 'fas fa-seedling'],
            ['title' => 'Sức khỏe – đời sống', 'color' => '#e83e8c', 'icon' => 'fas fa-heartbeat'],
            ['title' => 'Phổ biến, giáo dục pháp luật', 'color' => '#6f42c1', 'icon' => 'fas fa-balance-scale'],
            ['title' => 'Khuyến học, khuyến tài, xây dựng xã hội học tập', 'color' => '#20c997', 'icon' => 'fas fa-graduation-cap'],
        ];
        foreach ($programs as $i => $p) {
            Program::query()->updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'title' => $p['title'],
                    'excerpt' => $p['title'],
                    'content' => '<p>Chương trình đang triển khai tại Trung tâm.</p>',
                    'color' => $p['color'],
                    'icon' => $p['icon'],
                    'status' => ContentStatus::Published,
                    'published_at' => now()->subDays(30),
                    'author_id' => $author?->id,
                    'sort_order' => $i,
                ]
            );
        }

        $libraryTypes = [
            ['name' => 'Sách điện tử', 'icon' => 'fas fa-book', 'color' => '#0b57c9'],
            ['name' => 'Video bài giảng', 'icon' => 'fas fa-video', 'color' => '#28a745'],
            ['name' => 'Audio / podcast', 'icon' => 'fas fa-headphones', 'color' => '#fd7e14'],
            ['name' => 'Tài liệu hướng dẫn', 'icon' => 'fas fa-file-alt', 'color' => '#6f42c1'],
            ['name' => 'Infographic', 'icon' => 'fas fa-chart-pie', 'color' => '#20c997'],
        ];
        foreach ($libraryTypes as $i => $t) {
            LibraryType::query()->updateOrCreate(
                ['slug' => Str::slug($t['name'])],
                array_merge($t, ['sort_order' => $i])
            );
        }

        $learning = [
            ['title' => 'Gia đình học tập', 'icon' => 'fas fa-home', 'color' => '#0b57c9'],
            ['title' => 'Dòng họ học tập', 'icon' => 'fas fa-book-open', 'color' => '#fd7e14'],
            ['title' => 'Cộng đồng học tập', 'icon' => 'fas fa-map-marker-alt', 'color' => '#28a745'],
            ['title' => 'Công dân học tập', 'icon' => 'fas fa-user-graduate', 'color' => '#6f42c1'],
        ];
        foreach ($learning as $i => $m) {
            LearningModel::query()->updateOrCreate(
                ['slug' => Str::slug($m['title'])],
                [
                    'title' => $m['title'],
                    'excerpt' => 'Mô hình học tập suốt đời tại địa phương.',
                    'content' => '<p>'.e($m['title']).'</p>',
                    'criteria' => '<p>Tiêu chí mô hình '.$m['title'].'.</p>',
                    'icon' => $m['icon'],
                    'color' => $m['color'],
                    'status' => ContentStatus::Published,
                    'published_at' => now(),
                    'author_id' => $author?->id,
                    'sort_order' => $i,
                ]
            );
        }

        $levels = [
            ['name' => 'Trung ương', 'color' => '#dc3545'],
            ['name' => 'Tỉnh', 'color' => '#0b57c9'],
            ['name' => 'Xã', 'color' => '#28a745'],
            ['name' => 'Trung tâm', 'color' => '#6f42c1'],
            ['name' => 'Tài liệu', 'color' => '#6c757d'],
        ];
        foreach ($levels as $i => $l) {
            DocumentLevel::query()->updateOrCreate(
                ['slug' => Str::slug($l['name'])],
                array_merge($l, ['sort_order' => $i])
            );
        }

        $docs = [
            ['number' => '387/QĐ-TTg', 'title' => 'Quyết định phê duyệt Đề án "Đẩy mạnh xã hội học tập"', 'level' => 'Trung ương', 'date' => '2023-05-15'],
            ['number' => '112/KH-UBND-QT', 'title' => 'Kế hoạch triển khai xã hội học tập trên địa bàn tỉnh Quảng Trị', 'level' => 'Tỉnh', 'date' => '2024-01-20'],
            ['number' => '45/QD-HTĐC-CT', 'title' => 'Quyết định thành lập Trung tâm Học tập cộng đồng xã Cửa Tùng', 'level' => 'Trung tâm', 'date' => '2022-08-10'],
        ];
        foreach ($docs as $d) {
            Document::query()->updateOrCreate(
                ['slug' => Str::slug($d['number'])],
                [
                    'title' => $d['title'],
                    'document_number' => $d['number'],
                    'document_level_id' => DocumentLevel::where('name', $d['level'])->value('id'),
                    'issued_at' => $d['date'],
                    'issuing_agency' => 'UBND',
                    'status' => ContentStatus::Published,
                    'published_at' => now(),
                    'author_id' => $author?->id,
                ]
            );
        }

        $announcements = [
            ['date' => '2026-09-05', 'title' => 'Khai giảng lớp học kỹ năng số cho người dân', 'excerpt' => 'Trung tâm HTCĐ xã Cửa Tùng thông báo khai giảng lớp bồi dưỡng kỹ năng số cơ bản...'],
            ['date' => '2026-09-02', 'title' => 'Lịch hoạt động tháng 9/2026', 'excerpt' => 'Cập nhật lịch các lớp học, hoạt động cộng đồng và chuyên đề học tập tháng 9...'],
            ['date' => '2026-08-28', 'title' => 'Tuyển sinh lớp tin học cơ bản', 'excerpt' => 'Đăng ký tham gia lớp tin học cơ bản và soạn thảo văn bản dành cho mọi lứa tuổi...'],
        ];
        foreach ($announcements as $a) {
            Announcement::query()->updateOrCreate(
                ['slug' => Str::slug($a['title'])],
                [
                    'title' => $a['title'],
                    'excerpt' => $a['excerpt'],
                    'content' => '<p>'.$a['excerpt'].'</p>',
                    'published_at' => $a['date'],
                    'status' => ContentStatus::Published,
                    'author_id' => $author?->id,
                ]
            );
        }

        $events = [
            ['start' => '2026-09-10 08:00', 'title' => 'Lớp kỹ năng số cơ bản', 'location' => 'Nhà văn hóa xã Cửa Tùng', 'end' => '2026-09-10 10:00'],
            ['start' => '2026-09-15 14:00', 'title' => 'Tập huấn kỹ năng sản xuất nông nghiệp', 'location' => 'Hội trường UBND xã Cửa Tùng', 'end' => '2026-09-15 16:00'],
            ['start' => '2026-09-20 19:00', 'title' => 'Lớp tiếng Anh giao tiếp du lịch', 'location' => 'Trung tâm HTCĐ (Tầng 2 Nhà VH xã)', 'end' => '2026-09-20 21:00'],
        ];
        foreach ($events as $e) {
            Event::query()->updateOrCreate(
                ['slug' => Str::slug($e['title'])],
                [
                    'title' => $e['title'],
                    'excerpt' => $e['location'],
                    'content' => '<p>'.$e['title'].'</p>',
                    'start_at' => $e['start'],
                    'end_at' => $e['end'],
                    'location' => $e['location'],
                    'status' => ContentStatus::Published,
                    'published_at' => now(),
                    'author_id' => $author?->id,
                ]
            );
        }

        News::query()->updateOrCreate(
            ['slug' => 'khai-giang-lop-hoc-tap-huan-tuan-le-hoc-tap-suot-doi'],
            [
                'title' => 'Khai giảng lớp học, tập huấn, Tuần lễ học tập suốt đời',
                'excerpt' => 'Hoạt động khai giảng và triển khai Tuần lễ học tập suốt đời tại xã.',
                'content' => '<p>Nội dung tin tức.</p>',
                'published_at' => '2026-09-03',
                'status' => ContentStatus::Published,
                'author_id' => $author?->id,
            ]
        );

        News::query()->updateOrCreate(
            ['slug' => 'ngay-sach-va-van-hoa-doc-2026'],
            [
                'title' => 'Ngày Sách và Văn hóa đọc năm 2026 tại xã Cửa Tùng',
                'excerpt' => 'Hoạt động hưởng ứng Ngày Sách và Văn hóa đọc.',
                'content' => '<p>Nội dung tin tức.</p>',
                'published_at' => '2026-08-25',
                'status' => ContentStatus::Published,
                'author_id' => $author?->id,
            ]
        );

        $slider = Slider::query()->updateOrCreate(['location' => 'hero'], ['name' => 'Hero trang chủ', 'is_active' => true]);
        Slide::query()->updateOrCreate(
            ['slider_id' => $slider->id, 'sort_order' => 0],
            [
                'title' => 'Học tập suốt đời',
                'subtitle' => 'HỌC ĐỂ PHÁT TRIỂN BẢN THÂN VÀ XÂY DỰNG QUÊ HƯƠNG',
                'badge_text' => 'HỌC ĐỂ PHÁT TRIỂN BẢN THÂN VÀ XÂY DỰNG QUÊ HƯƠNG',
                'is_active' => true,
            ]
        );

        $menu = Menu::query()->updateOrCreate(['location' => 'primary'], ['name' => 'Menu chính']);
        $items = [
            ['label' => 'Trang chủ', 'url' => '/', 'icon' => 'fas fa-home'],
            ['label' => 'Giới thiệu', 'url' => '/gioi-thieu', 'icon' => 'fas fa-info-circle'],
            ['label' => 'Hoạt động', 'url' => '/tin-tuc', 'icon' => 'fas fa-bullhorn'],
            ['label' => 'Lịch học', 'url' => '/lich-hoat-dong', 'icon' => 'fas fa-calendar-alt'],
            ['label' => 'Tài liệu', 'url' => '/van-ban-tai-lieu', 'icon' => 'fas fa-file-download'],
            ['label' => 'Thư viện số', 'url' => '/thu-vien-so', 'icon' => 'fas fa-book'],
            ['label' => 'Học tập suốt đời', 'url' => '/hoc-tap-suot-doi', 'icon' => 'fas fa-infinity'],
            ['label' => 'Liên hệ', 'url' => '/lien-he', 'icon' => 'fas fa-envelope'],
        ];
        foreach ($items as $i => $item) {
            MenuItem::query()->updateOrCreate(
                ['menu_id' => $menu->id, 'label' => $item['label']],
                array_merge($item, ['sort_order' => $i])
            );
        }
    }
}
