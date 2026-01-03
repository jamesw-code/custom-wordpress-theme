<?php

add_action('wp_enqueue_scripts', function () {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    $manifest_path = $theme_dir . '/build/manifest.json';
    if (!file_exists($manifest_path)) {
        return;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);

    // Support both possible keys
    $entry = $manifest['src/main.js'] ?? $manifest['./src/main.js'] ?? null;
    if (!$entry) return;

    // Enqueue CSS files for this entry
    if (!empty($entry['css'])) {
        foreach ($entry['css'] as $i => $css_file) {
            $css_abs = $theme_dir . '/build/' . $css_file;
            wp_enqueue_style(
                'theme_vite_css_' . $i,
                $theme_uri . '/build/' . $css_file,
                [],
                file_exists($css_abs) ? filemtime($css_abs) : null
            );
        }
    }

    // Enqueue JS entry
    $js_abs = $theme_dir . '/build/' . $entry['file'];
    wp_enqueue_script(
        'theme_vite_js',
        $theme_uri . '/build/' . $entry['file'],
        [],
        file_exists($js_abs) ? filemtime($js_abs) : null,
        true
    );

    wp_script_add_data('theme_vite_js', 'type', 'module');
});
