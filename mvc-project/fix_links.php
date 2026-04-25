<?php

$dir = new RecursiveDirectoryIterator('c:\\xampp\\htdocs\\TINY-FLOWERS\\mvc-project\\resources\\views');
$iter = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($iter, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$search1 = '<a href="#" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-shopping-bag" style="width: 20px; text-align: center; color: #64748b;"></i> Đơn hàng</a>';
$search2 = '<a href="{{ route(\'profile.orders\') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-shopping-bag" style="width: 20px; text-align: center; color: #64748b;"></i> Đơn hàng</a>';

$replace = '<a href="{{ route(\'profile.orders\') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-shopping-bag" style="width: 20px; text-align: center; color: #64748b;"></i> Đơn hàng</a>
                                <a href="{{ route(\'profile.favorites\') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-heart" style="width: 20px; text-align: center; color: #ef4444;"></i> Yêu thích</a>';

$count = 0;
foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    
    $modified = false;
    if (strpos($content, $search1) !== false) {
        $content = str_replace($search1, $replace, $content);
        $modified = true;
    } else if (strpos($content, $search2) !== false && strpos($content, 'Yêu thích') === false) {
        $content = str_replace($search2, $replace, $content);
        $modified = true;
    }
    
    if ($modified) {
        file_put_contents($path, $content);
        echo "Updated $path\n";
        $count++;
    }
}

echo "Total files updated: $count\n";
