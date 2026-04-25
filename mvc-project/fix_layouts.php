<?php
$customer_file = 'c:\\xampp\\htdocs\\TINY-FLOWERS\\mvc-project\\resources\\views\\profile\\customer.blade.php';
$orders_file = 'c:\\xampp\\htdocs\\TINY-FLOWERS\\mvc-project\\resources\\views\\profile\\customer-orders.blade.php';
$favorites_file = 'c:\\xampp\\htdocs\\TINY-FLOWERS\\mvc-project\\resources\\views\\profile\\favorites.blade.php';

$customer_content = file_get_contents($customer_file);

// Extract top part (up to <main class="profile-layout">)
$top_pos = strpos($customer_content, '<section class="profile-content">');
if ($top_pos === false) die("Cannot find top part\n");
$top_html = substr($customer_content, 0, $top_pos);

// Extract bottom part (from </section>)
$bottom_pos = strpos($customer_content, '</section>');
if ($bottom_pos === false) die("Cannot find bottom part\n");
$bottom_html = substr($customer_content, $bottom_pos);

function fix_file($file, $top_html, $bottom_html, $title, $active_sidebar) {
    $content = file_get_contents($file);
    
    // Extract internal styles
    preg_match('/@section\(\'styles\'\)(.*?)@endsection/s', $content, $style_match);
    $styles = $style_match ? str_replace(['<style>', '</style>'], '', $style_match[1]) : '';
    
    // Extract scripts
    preg_match('/@section\(\'scripts\'\)(.*?)@endsection/s', $content, $script_match);
    $scripts = $script_match ? $script_match[1] : '';
    
    // Extract main content
    preg_match('/@section\(\'content\'\)(.*?)@endsection/s', $content, $content_match);
    $main_content = $content_match ? $content_match[1] : '';
    
    // Fix active sidebar in top_html
    $modified_top = str_replace('<a href="{{ route(\'profile.index\') }}" class="nav-item active">', '<a href="{{ route(\'profile.index\') }}" class="nav-item">', $top_html);
    
    if ($active_sidebar == 'orders') {
        $modified_top = str_replace('<a href="{{ route(\'profile.orders\') }}" class="nav-item">', '<a href="{{ route(\'profile.orders\') }}" class="nav-item active">', $modified_top);
    } else if ($active_sidebar == 'favorites') {
        $modified_top = str_replace('<a href="{{ route(\'profile.favorites\') }}" class="nav-item">', '<a href="{{ route(\'profile.favorites\') }}" class="nav-item active">', $modified_top);
    }
    
    // Replace title
    $modified_top = preg_replace('/<title>.*?<\/title>/', "<title>$title - Tiny Flowers</title>", $modified_top);
    
    // Inject styles
    $modified_top = preg_replace('/<\/style>/', $styles . "\n    </style>", $modified_top);
    
    // Extract only the inner part of main_content (remove profile-container and profile-sidebar)
    // Wait, the main_content in favorites and orders already has <div class="profile-container"> and <aside class="profile-sidebar">
    // We need to extract only <main class="profile-content">...</main> from main_content
    preg_match('/<h2 class="content-title">(.*?)<\/h2>/s', $main_content, $title_match);
    $header_title = $title_match ? $title_match[0] : '';
    
    preg_match('/<main class="profile-content">(.*?)<\/main>/s', $main_content, $inner_match);
    if($inner_match) {
        $final_content = '<section class="profile-content">' . $inner_match[1] . '</section>';
    } else {
        // For orders:
        preg_match('/<div class="content-header">(.*?)<\/div>.*?<div class="orders-list">/s', $main_content, $header_match);
        preg_match('/<div class="orders-list">.*$/s', $main_content, $list_match);
        if ($list_match) {
            $inner_content = '<div class="content-header">' . ($header_match[1] ?? '') . '</div>' . $list_match[0];
            // remove last </div> of profile-container and </main>
            $inner_content = preg_replace('/<\/main>\s*<\/div>\s*$/', '', $inner_content);
            $final_content = '<section class="profile-content">' . $inner_content . '</section>';
        } else {
            $final_content = '<section class="profile-content">Error extracting</section>';
        }
    }
    
    // Combine
    $new_file = $modified_top . "\n" . $final_content . "\n" . $bottom_html;
    
    // Inject scripts before </body>
    if ($scripts) {
        $new_file = str_replace('</body>', $scripts . "\n</body>", $new_file);
    }
    
    file_put_contents($file, $new_file);
    echo "Fixed $file\n";
}

fix_file($orders_file, $top_html, $bottom_html, 'Lịch sử đơn hàng', 'orders');
fix_file($favorites_file, $top_html, $bottom_html, 'Sản phẩm yêu thích', 'favorites');

?>
