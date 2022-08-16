<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($posts as $post)
        <url>
            <loc>{{  route('frontend.single-product', ['slug'=>$post->slug]) }}</loc>
            <lastmod>{{ $post->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
        <url>
            <loc>{{  route('frontend.gifts') }}</loc>
            <lastmod>2022-02-03T12:08:26+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{  route('frontend.reesh') }}</loc>
            <lastmod>2022-02-03T12:08:26+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{  route('frontend.cart') }}</loc>
            <lastmod>2022-02-03T12:08:26+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{  route('frontend.altaawus-vip') }}</loc>
            <lastmod>2022-02-03T12:08:26+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @foreach ($pages as $post)
            <url>
                <loc>{{  route('frontend.pages', ['slug'=>$post->slug]) }}</loc>
                <lastmod>{{ $post->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
</urlset>
